<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CreditTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminCreditController extends Controller
{
    public function index()
    {
        $users = User::all();
        // optionally load recent transactions or anything else
        return view('admin.credits', compact('users'));
    }

    public function showUser(User $user)
    {
        $transactions = $user->creditTransactions()->latest()->get();
        $totalSpent = $user->creditTransactions()->where('type', 'subtract')->sum('amount');
        $totalAdded = $user->creditTransactions()->where('type', 'add')->sum('amount');

        return view('admin.credits_user', compact('user', 'transactions', 'totalSpent', 'totalAdded'));
    }

    public function manage(Request $request, User $user)
    {
        $request->validate([
            'amount' => 'required|integer|min:1',
            'type' => 'required|in:add,subtract',
            'description' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            if ($request->type === 'add') {
                $user->increment('credits', $request->amount);
            } else {
                // Check if user has enough credits to subtract
                if ($user->credits < $request->amount) {
                    return back()->with('error', 'User does not have enough credits to subtract.');
                }
                $user->decrement('credits', $request->amount);
            }

            CreditTransaction::create([
                'user_id' => $user->id,
                'amount' => $request->amount,
                'type' => $request->type,
                'description' => $request->description,
            ]);

            DB::commit();

            return back()->with('success', 'Credits updated successfully for ' . $user->name);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Something went wrong while updating credits.');
        }
    }
}
