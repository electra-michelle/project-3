<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    public function store($referralUrl)
    {
        $upline = User::where('ref_url', $referralUrl)->first();
        if($upline && auth()->guest()) {
            session(['ref' => $upline->id]);
        }

        return redirect('/');
    }
}
