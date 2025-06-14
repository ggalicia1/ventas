<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Provider;
use App\Models\Product;
use App\Models\ProductStockHistory;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    public function index()
    {
        $month = request('month') ?? Carbon::now()->month;
        $year = request('year') ?? Carbon::now()->year;

        $query = Purchase::query(); // always initialize a query

        if ($month && $year) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }

        // Paginated purchases
        $purchases = $query->orderBy('created_at', 'desc')->paginate(5);

        // Separate query for monthly totals (don't use $purchases here)
        $monthly_totals = Purchase::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(total) as total')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get()
            ->map(function ($item) {
                $item->month_name = Carbon::create($item->year, $item->month)->format('F Y');
                return $item;
            });

        $total_amount = $monthly_totals->sum('total');

        // Valor total del mes consultado
        $total_month = 0; // valor por defecto
        foreach ($monthly_totals as $month_data) {
            if ($month_data->year == $year && $month_data->month == $month) {
                $total_month = $month_data->total;
                break;
            }
        }

        return view('purchases.index', compact('purchases', 'monthly_totals', 'total_amount', 'total_month', 'month', 'year'));
    }

    public function create()
    {
        $providers = Provider::all();
        $products = Product::all();
        return view('purchases.create', compact('providers', 'products'));
    }

    public function show($id)
    {
        $purchase = Purchase::with(['provider', 'user', 'productStockHistories.product'])->findOrFail($id);

        return view('purchases.show', compact('purchase'));
    }
    public function purchasesByDate($date)
    {
        // Convertir fecha a formato YYYY-MM-DD si es necesario
        $parsedDate = Carbon::parse($date)->format('Y-m-d');

        // Buscar todos los detalles de productos comprados ese día
        $stockDetails = DB::table('product_stock_histories')
            ->join('products', 'product_stock_histories.product_id', '=', 'products.id')
            ->join('purchases', 'product_stock_histories.purchase_id', '=', 'purchases.id')
            ->select(
                'product_stock_histories.*',
                'products.name as product_name'
            )
            ->whereDate('purchases.date', $parsedDate)
            ->get()
            ->map(function ($item) {
                $item->product = (object)[ 'name' => $item->product_name ];
                return $item;
            });

        // Calcular total de la compra y cantidad total
        $totalPurchaseAmount = $stockDetails->sum(function ($detail) {
            return $detail->purchase_price * $detail->quantity;
        });

        $totalQuantity = $stockDetails->sum('quantity');

        return view('purchases.show', [  // cambia 'tu-vista-de-detalle' por el nombre real del archivo Blade
            'date' => $parsedDate,
            'stockDetails' => $stockDetails,
            'totalPurchaseAmount' => $totalPurchaseAmount,
            'totalQuantity' => $totalQuantity,
        ]);
    }

    public function store(Request $request)
    {

       // dd($request->all());
        try {
            DB::beginTransaction();
        
            // Validate the purchase data
            $validated = $request->validate([
                'provider_id' => 'required',
                'date' => 'required|date',
                //'user_id' => 'required|integer',
                'receipt_type' => 'required|string',
                'receipt_number' => 'required|string',
                'receipt_series' => 'required|string',
                'total_amount' => 'required|numeric',
                //'status' => 'required|string',
                'products' => 'required|array',
                'products.*.id' => 'required|integer',
                'products.*.quantity' => 'required|integer',
                //'products.*.remaining_quantity' => 'required|integer',
                'products.*.purchasePrice' => 'required|numeric',
                'products.*.salePrice' => 'required|numeric',
                'products.*.expirationDate' => 'required|date',
            ]);

            // Create the purchase
            $purchase = Purchase::create([
                'provider_id' => $validated['provider_id'],
                'date' => $validated['date'],
                'user_id' => \Auth::user()->id,
                'receipt_type' => $validated['receipt_type'],
                'receipt_number' => $validated['receipt_number'],
                'receipt_series' => $validated['receipt_series'],
                'total' => $validated['total_amount'],
                //'status' => 1,
            ]);

            // Save the products associated with the purchase
            foreach ($validated['products'] as $product_stock) {
                $product = Product::find($product_stock['id']);
                ProductStockHistory::create([
                    'product_id' => $product->id,
                    'quantity' => $product_stock['quantity'],
                    'remaining_quantity' => $product->stock + $product_stock['quantity'],
                    'purchase_price' => $product_stock['purchasePrice'],
                    'sale_price' => $product_stock['salePrice'],
                    'expiration_date' => $product_stock['expirationDate'],
                    'date_added' => $product_stock['expirationDate'],
                    'purchase_id' => $purchase->id,
                ]);

                $product->stock = $product->stock + $product_stock['quantity'];
                $product->price = $product_stock['salePrice'];
                $product->save();
            }
            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['success' => false]);
        }
  }


    public function edit($id)
    {
        $purchase = Purchase::findOrFail($id);
        $providers = Provider::all();
        return view('purchases.edit', compact('purchase', 'providers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'provider_id' => 'required|exists:providers,id',
            'date' => 'required|date',
            'user_id' => 'required|exists:users,id',
            'receipt_type' => 'required|string',
            'receipt_number' => 'required|string',
            'receipt_series' => 'required|string',
            'total' => 'required|numeric',
            'status' => 'required|in:pending,completed,canceled',
        ]);

        $purchase = Purchase::findOrFail($id);
        $purchase->update($validated);

        return redirect()->route('purchases.index')->with('success', 'Compra actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $purchase = Purchase::findOrFail($id);
        $purchase->delete();

        return redirect()->route('purchases.index')->with('success', 'Compra eliminada exitosamente.');
    }
}
