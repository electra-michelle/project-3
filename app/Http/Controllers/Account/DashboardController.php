<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $user->load(['deposits' => fn($query) => (
            $query->where('status', '<>', 'cancelled')
        )]);
        return view('account.dashboard', compact('user'));
    }
}
