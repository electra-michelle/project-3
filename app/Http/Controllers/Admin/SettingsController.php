<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\StoreSettingsRequest;
use App\Models\PaymentSystem;
use App\Http\Controllers\Controller;

class SettingsController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $paymentSystems = PaymentSystem::active()
            ->get(['name', 'value', 'payouts_enabled']);

        return view('admin.settings', compact('paymentSystems'));
    }

    public function store(StoreSettingsRequest $request)
    {
        foreach($request->validated() as $key => $value)
        {
            PaymentSystem::where('value', $key)
                ->update(['payouts_enabled' => $value]);
        }

        return redirect()->back()->with(['success' => 'Settings has been successfully updated.']);
    }
}
