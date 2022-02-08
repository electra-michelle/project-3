<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Deposit;
use App\Models\PaymentSystem;
use App\Models\User;
use App\Services\StatisticsService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $users = User::with('referredBy')
            ->latest()
            ->paginate(15);

        return view('admin.users.list', compact('users'));
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(StatisticsService $statisticsService, User $user)
    {

        $user->load([
            'histories' => fn($subQuery) => (
                $subQuery->latest()
            ),
            'deposits' => fn($subQuery) => (
                $subQuery->withMax('planPeriod', 'period_end')
            ),
            'referrals' => fn($subQuery) => (
                $subQuery->withSum(['deposits' => fn($query) => (
                $query->where('status', 'finished')
                    ->orWhere('status', 'active')
                )], 'amount')
            ),
            'deposits.paymentSystem',
            'deposits.plan',
            'payouts.paymentSystem',
        ]);


        $data['user'] = $user;
        $data['paymentSystems'] = PaymentSystem::active()->get();
        $data['wallets'] = $user->wallets->pluck('wallet', 'payment_system_id')->toArray();
        $data['referralCount'] = $user->referrals()->count();

        $data['totalDeposit'] = $statisticsService->convertedDepositSum($user->id);
        $data['totalPayout'] = $statisticsService->convertedPayoutSum($user->id);
        $data['availableBalance'] = $statisticsService->convertedAvailableBalance($user->id);


        return view('admin.users.details', $data);
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $paymentSystems = PaymentSystem::active()->get();
        foreach ($paymentSystems as $paymentSystem){
            if($request->input($paymentSystem->value)) {
                $user->wallets()->updateOrCreate([
                    'payment_system_id' => $paymentSystem->id
                ], [
                    'wallet' => $request->input($paymentSystem->value)
                ]);
            }
        }

        return redirect()->back()->with(['wallets_success' => 'Wallet settings has been successfully updated.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function loginWithUser(User $user)
    {
        Auth::loginUsingId($user->id);

        return redirect()->route('account.dashboard');
    }
}
