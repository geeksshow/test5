<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\EmailVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmailVerificationController extends Controller
{
    public function sendOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address',
                'errors' => $validator->errors()
            ], 422);
        }

        $email = $request->email;
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete any existing OTP for this email
        EmailVerification::where('email', $email)->delete();

        // Create new OTP
        EmailVerification::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => now()->addMinutes(10) // OTP expires in 10 minutes
        ]);

        // Send OTP via email (you can implement this based on your mail configuration)
        try {
            Mail::raw("Your OTP for DND COMPUTERS is: {$otp}. This OTP will expire in 10 minutes.", function ($message) use ($email) {
                $message->to($email)
                        ->subject('Email Verification OTP - DND COMPUTERS');
            });

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully to your email'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again.'
            ], 500);
        }
    }

    public function verifyOTP(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|string|size:6'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 422);
        }

        $verification = EmailVerification::where('email', $request->email)
                                       ->where('otp', $request->otp)
                                       ->first();

        if (!$verification) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid OTP'
            ], 400);
        }

        if ($verification->isExpired()) {
            $verification->delete();
            return response()->json([
                'success' => false,
                'message' => 'OTP has expired. Please request a new one.'
            ], 400);
        }

        if ($verification->isVerified()) {
            return response()->json([
                'success' => false,
                'message' => 'OTP has already been used'
            ], 400);
        }

        // Mark as verified
        $verification->update(['verified_at' => now()]);

        // Mark user email as verified
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $user->email_verified_at = now();
            $user->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Email verified successfully'
        ]);
    }

    public function checkVerificationStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid email address'
            ], 422);
        }

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'verified' => !is_null($user->email_verified_at),
            'email_verified_at' => $user->email_verified_at
        ]);
    }
}