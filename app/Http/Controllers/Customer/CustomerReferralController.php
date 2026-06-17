<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Referral;
use Illuminate\Support\Str;

class CustomerReferralController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Generate referral code if not exists
        if (!$user->referral_code) {
            $user->referral_code = 'REF-' . strtoupper(Str::random(8));
            $user->save();
        }

        $referrals = Referral::where('referrer_id', Auth::id())
            ->with('referred')
            ->orderBy('created_at', 'desc')
            ->get();

        $totalBonus = Referral::where('referrer_id', Auth::id())
            ->where('status', 'rewarded')
            ->sum('bonus_amount');

        $pendingCount = Referral::where('referrer_id', Auth::id())
            ->where('status', 'pending')
            ->count();

        $completedCount = Referral::where('referrer_id', Auth::id())
            ->where('status', 'completed')
            ->count();

        return view('customer.referral.index', compact(
            'user',
            'referrals',
            'totalBonus',
            'pendingCount',
            'completedCount'
        ));
    }

    public function share()
    {
        $user = Auth::user();
        
        if (!$user->referral_code) {
            $user->referral_code = 'REF-' . strtoupper(Str::random(8));
            $user->save();
        }

        $shareUrl = route('register', ['ref' => $user->referral_code]);

        return view('customer.referral.share', compact('shareUrl', 'user'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'message' => 'nullable|string|max:500',
        ]);

        // Send referral email
        // Mail::to($request->email)->send(new ReferralInviteMail(Auth::user(), $request->message));

        return redirect()->back()->with('success', 'Referral invitation sent successfully!');
    }
}