<?php

/**
 * Summary of namespace App\Http\Controllers\ReferralController
 * @author Fxc Jahid <fxcjahid3@gmail.com>
 */

namespace App\Http\Controllers;

use App\Models\Referral;
use App\Models\User;
use Illuminate\Http\Request;

class ReferralController extends Controller
{

    /**
     * Summary of index
     * @return \Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index()
    {
        $data = Referral::with(['referrer', 'referred'])->get();

        return view('admin.referral.index', compact('data'));
    }

    /**
     * Create Unique Referral Code for User     
     * @return int
     */
    public static function generateUniqueCode() : int
    {
        $randomNumber = mt_rand(100000, 999999);

        /** Check if the number exists in the database */
        while (User::where('referral_code', $randomNumber)->exists()) {
            $randomNumber = mt_rand(100000, 999999);
        }

        return $randomNumber;
    }

    /**
     * Summary of get user referral history
     * @var User $user
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function userReferralHistory(Request $request)
    {
        $user = $request->user();

        return response()->json($user->referrals);
    }
}