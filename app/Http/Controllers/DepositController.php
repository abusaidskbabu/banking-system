<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DepositController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $deposits = Transaction::where('transaction_type', 'deposit')->where('user_id', auth()->user()->id)->orderBy('date', 'desc')->get();
        return view('deposit-list', compact('deposits'));
    }

    public function create()
    {
        return view('deposit');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0',
        ]);

        $user = auth()->user();

        if ($validatedData['user_id'] != $user->id) {
            return redirect()->back()->with('error', 'You are not authorized to deposit into this account.');
        }
        $user->balance += $validatedData['amount'];
        $user->save();

        Transaction::create([
            'user_id' => $user->id,
            'transaction_type' => 'deposit',
            'amount' => $validatedData['amount'],
            'fee' => 0,
            'date' => now(),
        ]);

        return redirect()->route('deposit.create')->with('success', 'Deposit successful.');
    }
}
