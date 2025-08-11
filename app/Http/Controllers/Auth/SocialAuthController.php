<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class SocialAuthController extends Controller
{
    /**
     * Handle Google OAuth login
     */
    public function googleLogin(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'email' => 'required|email',
                'name' => 'required|string',
                'google_id' => 'required|string',
                'avatar' => 'nullable|string'
            ]);

            // For demo purposes, we'll skip token verification
            // In production, you should verify the Google token
            
            $user = $this->findOrCreateUser([
                'email' => $request->email,
                'name' => $request->name,
                'provider' => 'google',
                'provider_id' => $request->google_id,
                'avatar' => $request->avatar
            ]);

            try {
                $token = JWTAuth::fromUser($user);
            } catch (JWTException $e) {
                Log::error('JWT Token creation failed for Google login: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Could not create token'
                ], 500);
            }

            Log::info("Google login successful for: {$request->email}");

            return response()->json([
                'success' => true,
                'message' => 'Google login successful',
                'access_token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'provider' => $user->provider
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Google login error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Google login failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle Facebook OAuth login
     */
    public function facebookLogin(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'email' => 'required|email',
                'name' => 'required|string',
                'facebook_id' => 'required|string',
                'avatar' => 'nullable|string'
            ]);

            // For demo purposes, we'll skip token verification
            // In production, you should verify the Facebook token
            
            $user = $this->findOrCreateUser([
                'email' => $request->email,
                'name' => $request->name,
                'provider' => 'facebook',
                'provider_id' => $request->facebook_id,
                'avatar' => $request->avatar
            ]);

            try {
                $token = JWTAuth::fromUser($user);
            } catch (JWTException $e) {
                Log::error('JWT Token creation failed for Facebook login: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Could not create token'
                ], 500);
            }

            Log::info("Facebook login successful for: {$request->email}");

            return response()->json([
                'success' => true,
                'message' => 'Facebook login successful',
                'access_token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'provider' => $user->provider
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Facebook login error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Facebook login failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Handle Apple OAuth login
     */
    public function appleLogin(Request $request)
    {
        try {
            $request->validate([
                'token' => 'required|string',
                'email' => 'nullable|email',
                'name' => 'nullable|string',
                'apple_id' => 'required|string'
            ]);

            // For demo purposes, we'll skip token verification
            // In production, you should verify the Apple token
            
            // Apple might not provide email/name on subsequent logins
            $email = $request->email ?: $this->getAppleEmail($request->apple_id);
            $name = $request->name ?: 'Apple User';

            $user = $this->findOrCreateUser([
                'email' => $email,
                'name' => $name,
                'provider' => 'apple',
                'provider_id' => $request->apple_id,
                'avatar' => null
            ]);

            try {
                $token = JWTAuth::fromUser($user);
            } catch (JWTException $e) {
                Log::error('JWT Token creation failed for Apple login: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Could not create token'
                ], 500);
            }

            Log::info("Apple login successful for: {$email}");

            return response()->json([
                'success' => true,
                'message' => 'Apple login successful',
                'access_token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'avatar' => $user->avatar,
                    'provider' => $user->provider
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Apple login error: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Apple login failed. Please try again.'
            ], 500);
        }
    }

    /**
     * Find or create user from social provider data
     */
    private function findOrCreateUser($data)
    {
        // First, try to find user by provider ID
        $user = User::where('provider', $data['provider'])
                   ->where('provider_id', $data['provider_id'])
                   ->first();

        if ($user) {
            // Update user info if needed
            $user->update([
                'name' => $data['name'],
                'avatar' => $data['avatar'] ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now()
            ]);
            return $user;
        }

        // Try to find user by email
        $user = User::where('email', $data['email'])->first();

        if ($user) {
            // Link existing account with social provider
            $user->update([
                'provider' => $data['provider'],
                'provider_id' => $data['provider_id'],
                'avatar' => $data['avatar'] ?? $user->avatar,
                'email_verified_at' => $user->email_verified_at ?? now()
            ]);
            return $user;
        }

        // Create new user
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Str::random(32), // Random password for social users (will be auto-hashed)
            'provider' => $data['provider'],
            'provider_id' => $data['provider_id'],
            'avatar' => $data['avatar'],
            'email_verified_at' => now() // Social accounts are pre-verified
        ]);
    }

    /**
     * Get Apple email from stored data
     */
    private function getAppleEmail($appleId)
    {
        $user = User::where('provider', 'apple')
                   ->where('provider_id', $appleId)
                   ->first();
        
        return $user ? $user->email : "apple_user_{$appleId}@dndcomputers.com";
    }
}