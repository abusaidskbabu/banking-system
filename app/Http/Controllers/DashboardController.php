<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $transactions = Transaction::where('user_id', auth()->user()->id)->orderBy('date', 'desc')->get();

        $balance = auth()->user()->balance;

        return view('dashboard', compact('transactions', 'balance'));
    }
}
