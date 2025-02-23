<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Contracts\ProductRepositoryInterface;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Models\Product;
use App\Models\ProductStockHistory;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $product_repository;
    private $category_repository;

    public function __construct(ProductRepositoryInterface $product_repository, CategoryRepositoryInterface $category_repository)
    {
        $this->product_repository = $product_repository;
        $this->category_repository = $category_repository;
    }
    public function index(Request $request)
    {
        $search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('products.name', 'like', "%{$search}%")
                        ->orWhere('products.description', 'like', "%{$search}%");
        })
        ->paginate(5);

        
        return view('products.index', compact('products', 'search'));
        /* 
        $products = Product::with('category')->paginate(6); // 10 productos por página
        return view('products.index', compact('products')); */
    }


    public function create()
    {
        $categories = $this->category_repository->all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
		    'barcode' => 'nullable|string'
        ]);
        //dd($validated_data);
        $this->product_repository->create($validated_data);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        $product = $this->product_repository->find($id);
        $categories = $this->category_repository->all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $validated_data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            //'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer',
            'barcode' => 'nullable|integer',
            'category_id' => 'required|exists:categories,id',
        ]);

        $this->product_repository->update($id, $validated_data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $this->product_repository->delete($id);
        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
    public function show($id)
    {
        $product = $this->product_repository->find($id);
        

        return view('products.show', compact('product'));

        //return redirect()->route('products.index')->with('success', 'Producto encontrado exitosamente.');
    }

    public function search($search)
    {
        //$search = $request->input('search');

        $products = Product::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
        })->get();
        
        return response()->json($products);
    }

    public function findByBarcode($barcode)
    {
        $product = Product::where('barcode', $barcode)->first();

        if (!$product) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }

        return response()->json($product);
    }

    public function showAddStockForm($id)
    {
        $product = Product::findOrFail($id);
        $stockHistories = ProductStockHistory::where('product_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(3);
        
        return view('products.add_stock', compact('stockHistories', 'product'));
    }


    public function addProductStock(Request $request, $id)
    {
/*        $request->validate([
            'quantity' => 'required|integer|min:1',
            'expiration_date' => 'required|date|after:today',
            'purchase_price' => 'required|integer|min:1',
            'sale_price' => 'required|integer|min:1',
        ]);
*/
        $product = Product::findOrFail($id);
        $product->addStock(
            $request->input('quantity'),
            $request->input('quantity'),
            $request->input('purchase_price'),
            $request->input('sale_price'),
            $request->input('expiration_date')
        );
        
        return $this->showAddStockForm($id);
    }

    public function storeMassiveProducts(Request $request)
    {
        // Validar el archivo
        $request->validate([
            'products_file' => 'required|mimes:xlsx,xls'
        ]);
        //dd($request);

        try {
            // Leer el archivo Excel
            $file = $request->file('products_file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $worksheet = $spreadsheet->getActiveSheet();
            $highestRow = $worksheet->getHighestRow();

            // Iniciar transacción
            DB::beginTransaction();

            // Recorrer las filas del archivo (asumiendo encabezados en la fila 1)
            for ($row = 2; $row <= $highestRow; $row++) {
                $name = trim($worksheet->getCell("B$row")->getValue());
                $description = trim($worksheet->getCell("C$row")->getValue());
                $categoryId = intval($worksheet->getCell("D$row")->getValue());
                $distributor = trim($worksheet->getCell("E$row")->getValue());
                $stockQuantity = trim($worksheet->getCell("F$row")->getValue());
                $purchase_price = floatval($worksheet->getCell("G$row")->getValue());
                $sale_price = floatval($worksheet->getCell("H$row")->getValue() ?? 0);
                //$stockQuantity = intval($worksheet->getCell("G$row")->getValue() ?? 0);
                $expirationDate = $worksheet->getCell("I$row")->getValue();
                $barcode = $worksheet->getCell("J$row")->getValue();

                // Verificar valores obligatorios
                /* if (empty($name) || empty($categoryId)) {
                    continue; // Saltar filas con datos incompletos
                } */
              

                // Crear o actualizar el producto
                $product = Product::updateOrCreate(
                    ['name' => $name],
                    [
                        'description' => $description,
                        'price' => $sale_price,
                        'stock' => $stockQuantity, // Incrementar el stock
                        'category_id' => $categoryId,
                        'supplier' => $distributor,
                        'barcode' => $barcode,
                    ]
                );
                //dd($product);
                // Registrar en el historial de stock
                if ($stockQuantity > 0) {
                    $product->stockHistory()->create([
                        'quantity' => $stockQuantity,
                        'remaining_quantity' => $product->stock,
                        'date_added' => now(),
                        'purchase_price' => $purchase_price,
                        'sale_price' => $sale_price,
                        'expiration_date' => $expirationDate ? \Carbon\Carbon::parse($expirationDate) : null,
                    ]);
                }
            }

            // Confirmar transacción
            DB::commit();

            return redirect()->back()->with('success', 'Productos importados exitosamente');
        } catch (\Exception $e) {
            // Revertir transacción en caso de error
            DB::rollBack();

            return redirect()->back()->with('error', 'Error al importar productos: ' . $e->getMessage());
        }
    }

    public function edit_stock($id)
    {
        $productStock = ProductStockHistory::findOrFail($id);

        return view('products.edit_stock', compact('productStock'));
    }

    public function update_stock(Request $request, $id)
    {
       /*  $request->validate([
            'quantity' => 'required|integer|min:1',
            'purchase_price' => 'required|numeric|min:0',
            'sale_price' => 'required|numeric|min:0',
            'expiration_date' => 'required|date|after:today',
        ]);
        dd($request->all()); */
        $productStock = ProductStockHistory::findOrFail($id);
        $productStock->update([
            'quantity' => $request->quantity,
            'purchase_price' => $request->purchase_price,
            'sale_price' => $request->sale_price,
            'expiration_date' => $request->expiration_date,
        ]);

        return redirect()->route('products.index')->with('success', 'Stock actualizado correctamente.');
    }


    public function deleteStockHistory($id)
    {
        try {
            DB::beginTransaction();
    
            $stockHistory = ProductStockHistory::find($id);
            if (!$stockHistory) {
                return response()->json([
                    'success' => false,
                    'message' => 'Historial de stock no encontrado.'
                ], 404);
            }
    
            $product = Product::findOrFail($stockHistory->product_id);
    
            // Actualizar el stock del producto
            $product->stock = $product->stock - $stockHistory->quantity;
            $product->save();
    
            // Eliminar el historial de stock
            $stockHistory->delete();
    
            DB::commit();
    
            return response()->json([
                'success' => true,
                'message' => 'Historial de stock eliminado exitosamente.'
            ], 200);
    
        } catch (\Exception $e) {
            DB::rollBack();
    
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al intentar eliminar el historial de stock.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    
}
