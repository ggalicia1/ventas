<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('date', 'desc')->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        return view('transactions.create');
    }

    public function store(Request $request)
    { 
       /*  $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string|max:255',
            'debit_balance' => 'required|numeric|min:0',
            'change_amount' => 'required|numeric|min:0',
            'changed_balance' => 'required|numeric|min:0',
            'cleared' => 'boolean'
        ]); */
        $validated = $request->all();
        // Calculate balance
        $lastTransaction = Transaction::latest()->first();
        $previousBalance = $lastTransaction ? $lastTransaction->balance : 0;
        $validated['balance'] = $previousBalance + $validated['debit_balance'] - $validated['change_amount'];

        Transaction::create($validated);

        return redirect()->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }
}
