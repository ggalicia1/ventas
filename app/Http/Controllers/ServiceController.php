<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::paginate(5);
        return view('service.index', compact('services'));
    }

    public function create()
    {
        return view('service.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $service = Service::create($data);

        return response()->json([
                                    'status' => true,
                                    'data' => $data
                                ], 200);
    }

    public function edit($id)
    {
        $service = Service::find($id);
        return view('service.edit', compact('service'));

    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $service = Service::findOrFail($id);
        $service->update($validated);
        return redirect()->route('service.index')->with('success','Servicio Actualizado exitosamente.');
    }

    public function show(Request $request, $id)
    {
        $service = Service::findOrFail($id);
        // Leer filtros del request
        $month = request('month') ?? Carbon::now()->month;
        $year = request('year') ?? Carbon::now()->year;

        // Aplicar filtros si existen
        $query = $service->payments();

        if ($month && $year) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }

        $payments = $query->paginate(5);

        $monthly_totals = $service->payments()
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(amount) as total')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get()
            ->map(function ($item) {
                $item->month_name = Carbon::create($item->year, $item->month)->format('F Y');
                return $item;
            });

        // Sumatoria total de todos los meses
        $total_amount = $monthly_totals->sum('total');

        // Valor total del mes consultado
        $total_month = 0; // valor por defecto
        foreach ($monthly_totals as $month_data) {
            if ($month_data->year == $year && $month_data->month == $month) {
                $total_month = $month_data->total;
                break;
            }
        }

        return view('service.show', compact('service', 'payments', 'monthly_totals', 'total_month', 'total_amount', 'month', 'year'));
    }
    public function paymentService(Request $request, $id)
    {
        $payment = $request->validate([
            'amount' => 'required|integer',
            'description' => 'required|string',
        ]);

        $person = Service::find($id);
        $person->payments()->create($payment);
    
        return response()->json([
            'status' => true,
            'message' => 'Creado correctamente.'
        ], 200);

    }

    public function paymentServiceCreate($id)
    {
        $objet = Service::find($id);
        
        return view('payment.create_service', compact('objet'));
    }  
}
