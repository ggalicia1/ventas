<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PersonController extends Controller
{
    public function index()
    {
        $persons = Person::paginate(5);
        return view('person.index', compact('persons'));
    }

    public function create()
    {
        return view('person.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required'
        ]);

        $person = Person::create($request->all());

        return response()->json([
                                        'status' => true,
                                        'data' => $person,
                                        ], 200);
    }

    public function edit($id)
    {
        $person = Person::find($id);
        return view('person.edit', compact('person'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
        ]);

        $person = Person::findOrFail($id);
        $person->update($validated);

        return redirect()->route('persons.index')->with('success', 'Persona actualizado exitosamente.');
    }

    public function show(Request $request, $id)
    {
        $person = Person::findOrFail($id);
        //dd($request);
        // Leer filtros del request
        $month = request('month') ?? Carbon::now()->month;
        $year = request('year') ?? Carbon::now()->year;

        // Aplicar filtros si existen
        $query = $person->payments();

        if ($month && $year) {
            $query->whereMonth('created_at', $month)
                ->whereYear('created_at', $year);
        }

        $payments = $query->paginate(5);

        $monthly_totals = $person->payments()
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

        return view('person.show', compact('person', 'payments', 'monthly_totals', 'total_month', 'total_amount', 'month', 'year'));
    }
    public function paymentPerson(Request $request, $id)
    {
        $payment = $request->validate([
            'amount' => 'required|integer',
            'description' => 'required|string',
        ]);

        $person = Person::find($id);
        $person->payments()->create($payment);
    
        return response()->json([
            'status' => true,
            'message' => 'Creado correctamente.'
        ], 200);

    }

    public function paymentPersonCreate($id)
    {
        $objet = Person::find($id);
        
        return view('payment.create_person', compact('objet'));
    }   
}
