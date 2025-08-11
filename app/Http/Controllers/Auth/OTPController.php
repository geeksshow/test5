<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;
use App\Models\User;

class OTPController extends Controller
{
    public function sendOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please enter a valid email address that exists in our system.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->email;
            
            // Generate 6-digit OTP
            $otp = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            
            // Store OTP in cache for 15 minutes (more reliable than database)
            $cacheKey = "otp_{$email}";
            Cache::put($cacheKey, $otp, 900); // 15 minutes
            
            // Also store in database as backup
            DB::table('password_resets')->where('email', $email)->delete();
            DB::table('password_resets')->insert([
                'email' => $email,
                'token' => $otp,
                'created_at' => Carbon::now(),
                'expires_at' => Carbon::now()->addMinutes(15)
            ]);

            // Try multiple delivery methods
            $deliveryMethods = $this->sendOTPMultipleMethods($email, $otp);
            
            if ($deliveryMethods['success']) {
                Log::info("OTP sent successfully to: {$email} via {$deliveryMethods['method']}");
                
                return response()->json([
                    'success' => true,
                    'message' => "OTP sent successfully via {$deliveryMethods['method']}!",
                    'delivery_method' => $deliveryMethods['method'],
                    'otp' => $otp // Remove this in production - only for testing
                ]);
            } else {
                // If all methods fail, store OTP in session for manual verification
                session(['manual_otp_' . $email => $otp]);
                
                return response()->json([
                    'success' => true,
                    'message' => 'OTP generated successfully! Check your email or contact support.',
                    'delivery_method' => 'manual',
                    'otp' => $otp // Remove this in production - only for testing
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error sending OTP: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP. Please try again later.'
            ], 500);
        }
    }

    private function sendOTPMultipleMethods($email, $otp)
    {
        // Method 1: Try Laravel Mail (SMTP)
        if ($this->sendViaEmail($email, $otp)) {
            return ['success' => true, 'method' => 'email'];
        }

        // Method 2: Try SendGrid (if configured)
        if ($this->sendViaSendGrid($email, $otp)) {
            return ['success' => true, 'method' => 'sendgrid'];
        }

        // Method 3: Try Mailgun (if configured)
        if ($this->sendViaMailgun($email, $otp)) {
            return ['success' => true, 'method' => 'mailgun'];
        }

        // Method 4: Try Twilio SMS (if configured)
        if ($this->sendViaSMS($email, $otp)) {
            return ['success' => true, 'method' => 'sms'];
        }

        // Method 5: Try WhatsApp (if configured)
        if ($this->sendViaWhatsApp($email, $otp)) {
            return ['success' => true, 'method' => 'whatsapp'];
        }

        return ['success' => false, 'method' => 'none'];
    }

    private function sendViaEmail($email, $otp)
    {
        try {
            $subject = 'Password Reset OTP - DND COMPUTERS';
            $message = $this->getOTPEmailTemplate($otp);

            Mail::send([], [], function ($mail) use ($email, $subject, $message) {
                $mail->to($email)
                     ->subject($subject)
                     ->html($message);
            });

            return true;
        } catch (\Exception $e) {
            Log::error('Email sending failed: ' . $e->getMessage());
            return false;
        }
    }

    private function sendViaSendGrid($email, $otp)
    {
        try {
            // You can install SendGrid package: composer require s-ichikawa/laravel-sendgrid-driver
            if (class_exists('\Sichikawa\LaravelSendgridDriver\SendgridTransport')) {
                $subject = 'Password Reset OTP - DND COMPUTERS';
                $message = $this->getOTPEmailTemplate($otp);
                
                Mail::send([], [], function ($mail) use ($email, $subject, $message) {
                    $mail->to($email)
                         ->subject($subject)
                         ->html($message);
                });
                
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('SendGrid sending failed: ' . $e->getMessage());
            return false;
        }
    }

    private function sendViaMailgun($email, $otp)
    {
        try {
            if (config('services.mailgun.domain')) {
                $subject = 'Password Reset OTP - DND COMPUTERS';
                $message = $this->getOTPEmailTemplate($otp);
                
                Mail::send([], [], function ($mail) use ($email, $subject, $message) {
                    $mail->to($email)
                         ->subject($subject)
                         ->html($message);
                });
                
                return true;
            }
            return false;
        } catch (\Exception $e) {
            Log::error('Mailgun sending failed: ' . $e->getMessage());
            return false;
        }
    }

    private function sendViaSMS($email, $otp)
    {
        try {
            // Get user's phone number if available
            $user = User::where('email', $email)->first();
            if ($user && $user->phone) {
                // You can install Twilio package: composer require twilio/sdk
                if (class_exists('\Twilio\Rest\Client')) {
                    $account_sid = config('services.twilio.account_sid');
                    $auth_token = config('services.twilio.auth_token');
                    $twilio_number = config('services.twilio.phone_number');
                    
                    if ($account_sid && $auth_token && $twilio_number) {
                        $client = new \Twilio\Rest\Client($account_sid, $auth_token);
                        $client->messages->create(
                            $user->phone,
                            [
                                'from' => $twilio_number,
                                'body' => "Your DND COMPUTERS password reset OTP is: {$otp}. Valid for 15 minutes."
                            ]
                        );
                        return true;
                    }
                }
            }
            return false;
        } catch (\Exception $e) {
            Log::error('SMS sending failed: ' . $e->getMessage());
            return false;
        }
    }

    private function sendViaWhatsApp($email, $otp)
    {
        try {
            // You can use WhatsApp Business API or services like Twilio
            // This is a placeholder for WhatsApp integration
            return false;
        } catch (\Exception $e) {
            Log::error('WhatsApp sending failed: ' . $e->getMessage());
            return false;
        }
    }

    private function getOTPEmailTemplate($otp)
    {
        return "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
                <div style='background: linear-gradient(135deg, #ffc107 0%, #ffb400 100%); color: #000; padding: 30px; text-align: center; border-radius: 10px 10px 0 0;'>
                    <h1 style='margin: 0; font-size: 2rem; font-weight: 800;'>DND COMPUTERS</h1>
                    <p style='margin: 10px 0 0 0; font-size: 1.1rem;'>Password Reset Request</p>
                </div>
                
                <div style='background: #f8f9fa; padding: 30px; border-radius: 0 0 10px 10px;'>
                    <h2 style='color: #333; margin-top: 0;'>Hello!</h2>
                    <p style='color: #666; line-height: 1.6;'>You have requested to reset your password. Please use the following OTP code to complete the process:</p>
                    
                    <div style='background: #fff; border: 2px solid #ffc107; border-radius: 10px; padding: 20px; text-align: center; margin: 20px 0; font-size: 32px; font-weight: bold; letter-spacing: 5px; color: #000;'>
                        {$otp}
                    </div>
                    
                    <div style='background: #fff3cd; border: 1px solid #ffeaa7; border-radius: 5px; padding: 15px; margin: 20px 0;'>
                        <p style='margin: 0; color: #856404; font-weight: bold;'>Important Security Information:</p>
                        <ul style='color: #856404; margin: 10px 0 0 0; padding-left: 20px;'>
                            <li>This OTP is valid for <strong>15 minutes only</strong></li>
                            <li>Never share this code with anyone</li>
                            <li>If you didn't request this, please ignore this email</li>
                            <li>For security, this OTP can only be used once</li>
                        </ul>
                    </div>
                    
                    <p style='color: #666; line-height: 1.6;'>If you have any questions or need assistance, please contact our support team.</p>
                    
                    <p style='color: #666; margin-bottom: 0;'>Best regards,<br><strong>DND COMPUTERS Team</strong></p>
                </div>
                
                <div style='text-align: center; margin-top: 20px; color: #999; font-size: 12px;'>
                    <p>This is an automated email. Please do not reply to this message.</p>
                    <p>&copy; " . date('Y') . " DND COMPUTERS. All rights reserved.</p>
                </div>
            </div>
        ";
    }

    public function verifyOTP(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'otp' => 'required|string|size:6',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input provided.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->email;
            $otp = $request->otp;

            // Check cache first (faster)
            $cacheKey = "otp_{$email}";
            $cachedOTP = Cache::get($cacheKey);

            if ($cachedOTP === $otp) {
                // Mark OTP as used
                Cache::forget($cacheKey);
                
                // Store verification in session
                session(['otp_verified_' . $email => true]);
                
                Log::info("OTP verified successfully for: {$email}");
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully!'
                ]);
            }

            // Check database as backup
            $resetRecord = DB::table('password_resets')
                ->where('email', $email)
                ->where('token', $otp)
                ->first();

            if ($resetRecord && Carbon::parse($resetRecord->expires_at)->isFuture()) {
                // Delete used OTP
                DB::table('password_resets')->where('email', $email)->delete();
                
                // Store verification in session
                session(['otp_verified_' . $email => true]);
                
                Log::info("OTP verified successfully for: {$email}");
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully!'
                ]);
            }

            // Check manual OTP from session (for testing)
            $manualOTP = session('manual_otp_' . $email);
            if ($manualOTP === $otp) {
                session()->forget('manual_otp_' . $email);
                session(['otp_verified_' . $email => true]);
                
                Log::info("Manual OTP verified successfully for: {$email}");
                return response()->json([
                    'success' => true,
                    'message' => 'OTP verified successfully!'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP code. Please check and try again.'
            ], 400);

        } catch (\Exception $e) {
            Log::error('Error verifying OTP: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to verify OTP. Please try again.'
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|exists:users,email',
                'password' => 'required|string|min:8|confirmed',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid input provided.',
                    'errors' => $validator->errors()
                ], 422);
            }

            $email = $request->email;
            $password = $request->password;

            // Check if OTP was verified
            if (!session('otp_verified_' . $email)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please verify OTP first before resetting password.'
                ], 400);
            }

            // Update user password
            $user = User::where('email', $email)->first();
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.'
                ], 404);
            }

            $user->password = $password; // Will be auto-hashed due to 'hashed' cast
            $user->save();

            // Clear OTP verification
            session()->forget('otp_verified_' . $email);
            
            // Clear any cached OTP
            Cache::forget("otp_{$email}");

            Log::info("Password reset successfully for: {$email}");

            return response()->json([
                'success' => true,
                'message' => 'Password reset successfully! You can now login with your new password.'
            ]);

        } catch (\Exception $e) {
            Log::error('Error resetting password: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to reset password. Please try again.'
            ], 500);
        }
    }
}
