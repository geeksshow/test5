<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JWTAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.jwt-login');
    }

    public function showRegisterForm()
    {
        return view('auth.jwt-register');
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|string|min:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            // Try to authenticate with Laravel's built-in auth
            if (Auth::attempt($request->only('email', 'password'))) {
                $user = Auth::user();
                
                try {
                    // Generate JWT token
                    $token = JWTAuth::fromUser($user);
                } catch (JWTException $e) {
                    Log::error('JWT Token creation failed: ' . $e->getMessage());
                    return response()->json([
                        'success' => false,
                        'message' => 'Could not create token'
                    ], 500);
                }

                Log::info('Successful login for user: ' . $user->email);

                return response()->json([
                    'success' => true,
                    'message' => 'Login successful',
                    'access_token' => $token,
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'email_verified_at' => $user->email_verified_at,
                        'avatar' => $user->avatar,
                        'provider' => $user->provider
                    ]
                ]);
            } else {
                Log::warning('Failed login attempt for email: ' . $request->email);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login'
            ], 500);
        }
    }

    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(), // Auto-verify for now
            ]);

            try {
                // Generate JWT token
                $token = JWTAuth::fromUser($user);
            } catch (JWTException $e) {
                Log::error('JWT Token creation failed: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Could not create token'
                ], 500);
            }

            Log::info('New user registered: ' . $user->email);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'access_token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'avatar' => $user->avatar,
                    'provider' => $user->provider
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Registration error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration'
            ], 500);
        }
    }

    public function logout()
    {
        try {
            $token = JWTAuth::getToken();
            if ($token) {
                JWTAuth::invalidate($token);
            } else {
                return response()->json(['success' => false, 'message' => 'No token provided'], 400);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Successfully logged out'
            ]);
        } catch (\Exception $e) {
            Log::error('Logout error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to logout'
            ], 500);
        }
    }

    public function me()
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'avatar' => $user->avatar,
                    'provider' => $user->provider
                ]
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token invalid'
            ], 401);
        }
    }

    public function refresh()
    {
        try {
            $token = JWTAuth::refresh(JWTAuth::getToken());
            
            return response()->json([
                'success' => true,
                'access_token' => $token
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token cannot be refreshed'
            ], 401);
        }
    }
}