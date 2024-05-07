<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WithdrawalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $withdrawals = Transaction::where('transaction_type', 'withdrawal')->where('user_id', auth()->user()->id)->orderBy('date', 'desc')->get();
        return view('withdrawal-list', compact('withdrawals'));
    }

    public function create()
    {
        return view('withdraw');
    }

    public function store(Request $request)
    {
        try {
            $user = auth()->user();

            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:200|max:' . $user->balance,
            ]);

            if ($validatedData['user_id'] != $user->id) {
                throw new \Exception('You are not authorized to withdraw from this account.');
            }

            $accountType = $user->account_type;

            $currentDate = now();

            $withdrawalFee = 0;

            if ($accountType == 'Individual') {
                if ($currentDate->isFriday()) {
                    $withdrawalFee = 0;
                } else {
                    $withdrawalFee = $validatedData['amount'] * 0.00015;
                }

                // Check if the withdrawal amount exceeds 1K, if so, apply fee for the remaining amount
                if ($validatedData['amount'] > 1000) {
                    $withdrawalFee += ($validatedData['amount'] - 1000) * 0.00015; // Apply fee for the remaining amount
                }

                // Check if the withdrawal amount exceeds the free monthly limit (5K)
                // If the amount exceeds the limit, apply fee for the excess amount
                if ($user->total_withdrawals_month + $validatedData['amount'] > 5000) {
                    $excessWithdrawalAmount = ($user->total_withdrawals_month + $validatedData['amount']) - 5000;
                    $withdrawalFee += $excessWithdrawalAmount * 0.00015; 
                }

            } elseif ($accountType == 'Business') {
                // Check if the total withdrawals exceed 50K, if so, decrease withdrawal fee to 0.015%
                if ($user->total_withdrawals > 50000) {
                    $withdrawalFee = $validatedData['amount'] * 0.00015; 
                } else {
                    // Apply withdrawal fee rate for Business accounts
                    $withdrawalFee = $validatedData['amount'] * 0.00025; 
                }
            }

            // Check if the user has sufficient balance for withdrawal
            if ($user->balance < ($validatedData['amount'] + $withdrawalFee)) {
                throw new \Exception('Insufficient balance for withdrawal.');
            }

            // Deduct the withdrawal amount and fee from the user's balance
            $user->balance -= ($validatedData['amount'] + $withdrawalFee);
            $user->save();

            Transaction::create([
                'user_id' => $user->id,
                'transaction_type' => 'withdrawal',
                'amount' => $validatedData['amount'],
                'fee' => $withdrawalFee,
                'date' => $currentDate,
            ]);

            return redirect()->back()->with('success', 'Withdrawal successful.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
