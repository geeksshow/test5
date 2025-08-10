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

            $credentials = $request->only('email', 'password');
            
            // First check if user exists
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                Log::warning('Login attempt with non-existent email: ' . $credentials['email']);
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }

            // Check password manually first
            if (!Hash::check($credentials['password'], $user->password)) {
                Log::warning('Failed login attempt for email: ' . $credentials['email'] . ' - Wrong password');
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password'
                ], 401);
            }

            try {
                // Try to authenticate and generate JWT token
                if (!$token = JWTAuth::attempt($credentials)) {
                    Log::warning('JWT authentication failed for email: ' . $credentials['email']);
                    return response()->json([
                        'success' => false,
                        'message' => 'Authentication failed'
                    ], 401);
                }
            } catch (JWTException $e) {
                Log::error('JWT Token creation failed: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'Could not create token'
                ], 500);
            }

            // Get the authenticated user
            $authenticatedUser = Auth::user();
            
            if (!$authenticatedUser) {
                $authenticatedUser = $user;
            }
            
            Log::info('Successful login for user: ' . $authenticatedUser->email);

            return response()->json([
                'success' => true,
                'message' => 'Login successful',
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
                'user' => [
                    'id' => $authenticatedUser->id,
                    'name' => $authenticatedUser->name,
                    'email' => $authenticatedUser->email,
                    'email_verified_at' => $authenticatedUser->email_verified_at,
                    'avatar' => $authenticatedUser->avatar,
                    'provider' => $authenticatedUser->provider
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Login error: ' . $e->getMessage());
            Log::error('Login error trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during login: ' . $e->getMessage()
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

            // Create user with proper password hashing
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'email_verified_at' => now(), // Auto-verify for JWT users
                'provider' => null,
                'provider_id' => null,
                'avatar' => null,
            ]);

            if (!$user) {
                Log::error('Failed to create user for email: ' . $request->email);
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to create user account'
                ], 500);
            }

            // Verify user was created and password is correct
            $createdUser = User::where('email', $request->email)->first();
            if (!$createdUser || !Hash::check($request->password, $createdUser->password)) {
                Log::error('User creation verification failed for email: ' . $request->email);
                return response()->json([
                    'success' => false,
                    'message' => 'User account creation verification failed'
                ], 500);
            }

            try {
                // Generate JWT token for the new user
                $credentials = [
                    'email' => $request->email,
                    'password' => $request->password
                ];
                
                $token = JWTAuth::attempt($credentials);
                
                if (!$token) {
                    // Fallback: generate token directly from user
                    $token = JWTAuth::fromUser($user);
                }
                
            } catch (JWTException $e) {
                Log::error('JWT Token creation failed during registration: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'User created but could not create authentication token. Please try logging in.'
                ], 500);
            }

            Log::info('New user registered successfully: ' . $user->email);

            return response()->json([
                'success' => true,
                'message' => 'User registered successfully',
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60,
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
            Log::error('Registration error trace: ' . $e->getTraceAsString());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred during registration: ' . $e->getMessage()
            ], 500);
        }
    }

    public function logout(Request $request)
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
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => JWTAuth::factory()->getTTL() * 60
            ]);
        } catch (JWTException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Token cannot be refreshed'
            ], 401);
        }
    }

    // Debug method to check user credentials (remove in production)
    public function debugUser(Request $request)
    {
        if (app()->environment('production')) {
            return response()->json(['error' => 'Not available in production'], 403);
        }

        $email = $request->get('email');
        $password = $request->get('password');

        if (!$email) {
            return response()->json(['error' => 'Email required'], 400);
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $passwordCheck = $password ? Hash::check($password, $user->password) : null;

        return response()->json([
            'user_exists' => true,
            'user_id' => $user->id,
            'email' => $user->email,
            'name' => $user->name,
            'email_verified' => !is_null($user->email_verified_at),
            'password_check' => $passwordCheck,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);
    }
}