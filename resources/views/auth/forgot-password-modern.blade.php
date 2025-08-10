<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Reset Password - DND COMPUTERS</title>
    
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #000 0%, #1a1a1a 100%);
            min-height: 100vh;
            position: relative;
            overflow-x: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><defs><radialGradient id="a" cx="50%" cy="50%"><stop offset="0%" stop-color="%23ffc107" stop-opacity="0.1"/><stop offset="100%" stop-color="%23000" stop-opacity="0"/></radialGradient></defs><circle cx="200" cy="200" r="100" fill="url(%23a)"/><circle cx="800" cy="300" r="150" fill="url(%23a)"/><circle cx="400" cy="700" r="120" fill="url(%23a)"/></svg>');
            animation: float 20s ease-in-out infinite;
            z-index: 0;
        }
        
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            z-index: 2;
        }
        
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
            border-color: #ffc107;
        }
        
        .btn-gradient {
            background: linear-gradient(135deg, #ffc107 0%, #ffb400 100%);
            transition: all 0.3s ease;
            color: #000;
        }
        
        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(255, 193, 7, 0.3);
            color: #000;
        }
        
        .btn-gradient:disabled {
            opacity: 0.6;
            transform: none;
            box-shadow: none;
            cursor: not-allowed;
        }
        
        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }
        
        .slide-in {
            animation: slideIn 0.8s ease-out;
            position: relative;
            z-index: 2;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .step-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
        }

        .step {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 10px;
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .step.active {
            background: #ffc107;
            color: #000;
            transform: scale(1.1);
        }

        .step.completed {
            background: #28a745;
            color: #fff;
        }

        .step-line {
            width: 50px;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            margin-top: 19px;
            transition: all 0.3s ease;
        }

        .step-line.completed {
            background: #28a745;
        }

        .otp-input {
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 600;
            border-radius: 10px;
            margin: 0 5px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }

        .otp-input:focus {
            border-color: #ffc107;
            box-shadow: 0 0 0 3px rgba(255, 193, 7, 0.1);
            outline: none;
        }

        .timer {
            color: #ffc107;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .success-animation {
            animation: successPulse 0.6s ease-in-out;
        }

        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        /* Input styling */
        input[type="email"],
        input[type="password"] {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 2px solid rgba(255, 255, 255, 0.2) !important;
            color: #fff !important;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            background: rgba(255, 255, 255, 0.15) !important;
            border-color: #ffc107 !important;
        }

        input::placeholder {
            color: rgba(255, 255, 255, 0.6) !important;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">
    <!-- Background Decorations -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white opacity-10 rounded-full floating-animation"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white opacity-5 rounded-full floating-animation" style="animation-delay: -3s;"></div>
        <div class="absolute top-1/2 left-1/4 w-32 h-32 bg-white opacity-10 rounded-full floating-animation" style="animation-delay: -1s;"></div>
    </div>

    <div class="w-full max-w-md relative z-10">
        <!-- Logo Section -->
        <div class="text-center mb-8 slide-in">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-white bg-opacity-20 rounded-full mb-4">
                <i class="fas fa-key text-2xl text-white"></i>
            </div>
            <h1 class="text-3xl font-bold text-white mb-2">DND COMPUTERS</h1>
            <p class="text-white text-opacity-80">Reset your password securely</p>
        </div>

        <!-- Main Form Container -->
        <div class="glass-effect rounded-2xl p-8 slide-in" style="animation-delay: 0.2s;">
            <!-- Step Indicator -->
            <div class="step-indicator">
                <div class="step active" id="step1">1</div>
                <div class="step-line" id="line1"></div>
                <div class="step" id="step2">2</div>
                <div class="step-line" id="line2"></div>
                <div class="step" id="step3">3</div>
            </div>

            <!-- Step 1: Email Input -->
            <div id="emailStep" class="step-content">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Forgot Password?</h2>
                    <p class="text-white text-opacity-70">Enter your email address and we'll send you a verification code</p>
                </div>

                <form id="emailForm" class="space-y-6">
                    <div>
                        <label for="email" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-envelope mr-2"></i>Email Address
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               required
                               class="w-full px-4 py-3 rounded-lg input-focus transition-all duration-300"
                               placeholder="Enter your email address">
                        <div id="emailError" class="text-red-300 text-sm mt-1 hidden"></div>
                    </div>

                    <button type="submit" 
                            id="sendOtpBtn"
                            class="w-full btn-gradient text-white font-semibold py-3 px-4 rounded-lg">
                        <span id="sendOtpText">
                            <i class="fas fa-paper-plane mr-2"></i>Send Verification Code
                        </span>
                        <span id="sendOtpLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Sending...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Step 2: OTP Verification -->
            <div id="otpStep" class="step-content hidden">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Verify Your Email</h2>
                    <p class="text-white text-opacity-70">We've sent a 6-digit code to <span id="emailDisplay" class="text-yellow-400 font-semibold"></span></p>
                </div>

                <form id="otpForm" class="space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-white mb-4 text-center">Enter Verification Code</label>
                        <div class="flex justify-center">
                            <input type="text" class="otp-input" maxlength="1" id="otp1">
                            <input type="text" class="otp-input" maxlength="1" id="otp2">
                            <input type="text" class="otp-input" maxlength="1" id="otp3">
                            <input type="text" class="otp-input" maxlength="1" id="otp4">
                            <input type="text" class="otp-input" maxlength="1" id="otp5">
                            <input type="text" class="otp-input" maxlength="1" id="otp6">
                        </div>
                        <div id="otpError" class="text-red-300 text-sm mt-2 text-center hidden"></div>
                    </div>

                    <div class="text-center">
                        <p class="text-white text-opacity-70 mb-2">Code expires in</p>
                        <div class="timer" id="timer">15:00</div>
                    </div>

                    <button type="submit" 
                            id="verifyOtpBtn"
                            class="w-full btn-gradient text-white font-semibold py-3 px-4 rounded-lg">
                        <span id="verifyOtpText">
                            <i class="fas fa-check-circle mr-2"></i>Verify Code
                        </span>
                        <span id="verifyOtpLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Verifying...
                        </span>
                    </button>

                    <div class="text-center">
                        <button type="button" 
                                id="resendOtpBtn"
                                class="text-white text-opacity-70 hover:text-yellow-400 transition-colors duration-300">
                            <i class="fas fa-redo mr-2"></i>Resend Code
                        </button>
                    </div>
                </form>
            </div>

            <!-- Step 3: Password Reset -->
            <div id="passwordStep" class="step-content hidden">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Create New Password</h2>
                    <p class="text-white text-opacity-70">Choose a strong password for your account</p>
                </div>

                <form id="passwordForm" class="space-y-6">
                    <div>
                        <label for="newPassword" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>New Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="newPassword" 
                                   name="password" 
                                   required
                                   class="w-full px-4 py-3 rounded-lg input-focus transition-all duration-300 pr-12"
                                   placeholder="Enter new password">
                            <button type="button" 
                                    id="toggleNewPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="passwordError" class="text-red-300 text-sm mt-1 hidden"></div>
                    </div>

                    <div>
                        <label for="confirmPassword" class="block text-sm font-medium text-white mb-2">
                            <i class="fas fa-lock mr-2"></i>Confirm Password
                        </label>
                        <div class="relative">
                            <input type="password" 
                                   id="confirmPassword" 
                                   name="password_confirmation" 
                                   required
                                   class="w-full px-4 py-3 rounded-lg input-focus transition-all duration-300 pr-12"
                                   placeholder="Confirm new password">
                            <button type="button" 
                                    id="toggleConfirmPassword"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        <div id="confirmPasswordError" class="text-red-300 text-sm mt-1 hidden"></div>
                    </div>

                    <button type="submit" 
                            id="resetPasswordBtn"
                            class="w-full btn-gradient text-white font-semibold py-3 px-4 rounded-lg">
                        <span id="resetPasswordText">
                            <i class="fas fa-key mr-2"></i>Reset Password
                        </span>
                        <span id="resetPasswordLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Resetting...
                        </span>
                    </button>
                </form>
            </div>

            <!-- Success Step -->
            <div id="successStep" class="step-content hidden text-center">
                <div class="success-animation">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-6">
                        <i class="fas fa-check text-3xl text-white"></i>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-4">Password Reset Successful!</h2>
                    <p class="text-white text-opacity-70 mb-6">Your password has been successfully reset. You can now login with your new password.</p>
                    
                    <a href="/jwt/login" class="btn-gradient text-white font-semibold py-3 px-6 rounded-lg inline-block text-decoration-none">
                        <i class="fas fa-sign-in-alt mr-2"></i>Go to Login
                    </a>
                </div>
            </div>

            <!-- Back to Login -->
            <div class="mt-6 text-center">
                <a href="/jwt/login" class="inline-flex items-center text-white text-opacity-60 hover:text-opacity-100 transition-all duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>Back to Login
                </a>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;
        let userEmail = '';
        let otpTimer;
        let timeLeft = 900; // 15 minutes

        document.addEventListener('DOMContentLoaded', function() {
            setupEventListeners();
        });

        function setupEventListeners() {
            // Email form submission
            document.getElementById('emailForm').addEventListener('submit', handleEmailSubmit);
            
            // OTP form submission
            document.getElementById('otpForm').addEventListener('submit', handleOtpSubmit);
            
            // Password form submission
            document.getElementById('passwordForm').addEventListener('submit', handlePasswordSubmit);
            
            // Resend OTP
            document.getElementById('resendOtpBtn').addEventListener('click', resendOtp);
            
            // Password visibility toggles
            document.getElementById('toggleNewPassword').addEventListener('click', () => togglePasswordVisibility('newPassword', 'toggleNewPassword'));
            document.getElementById('toggleConfirmPassword').addEventListener('click', () => togglePasswordVisibility('confirmPassword', 'toggleConfirmPassword'));
            
            // OTP input handling
            setupOtpInputs();
        }

        function setupOtpInputs() {
            const otpInputs = document.querySelectorAll('.otp-input');
            
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', function(e) {
                    if (e.target.value.length === 1) {
                        if (index < otpInputs.length - 1) {
                            otpInputs[index + 1].focus();
                        }
                    }
                });
                
                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
                
                // Only allow numbers
                input.addEventListener('input', function(e) {
                    e.target.value = e.target.value.replace(/[^0-9]/g, '');
                });
            });
        }

        async function handleEmailSubmit(e) {
            e.preventDefault();
            
            const email = document.getElementById('email').value.trim();
            const sendBtn = document.getElementById('sendOtpBtn');
            const sendText = document.getElementById('sendOtpText');
            const sendLoading = document.getElementById('sendOtpLoading');
            
            if (!email) {
                showFieldError('email', 'Please enter your email address');
                return;
            }
            
            if (!isValidEmail(email)) {
                showFieldError('email', 'Please enter a valid email address');
                return;
            }
            
            // Show loading
            sendBtn.disabled = true;
            sendText.classList.add('hidden');
            sendLoading.classList.remove('hidden');
            
            try {
                const response = await fetch('/api/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: email })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    userEmail = email;
                    document.getElementById('emailDisplay').textContent = email;
                    goToStep(2);
                    startTimer();
                    showNotification('Verification code sent successfully!', 'success');
                } else {
                    showFieldError('email', data.message || 'Failed to send verification code');
                }
            } catch (error) {
                console.error('Error:', error);
                showFieldError('email', 'Network error. Please try again.');
            } finally {
                sendBtn.disabled = false;
                sendText.classList.remove('hidden');
                sendLoading.classList.add('hidden');
            }
        }

        async function handleOtpSubmit(e) {
            e.preventDefault();
            
            const otp = getOtpValue();
            const verifyBtn = document.getElementById('verifyOtpBtn');
            const verifyText = document.getElementById('verifyOtpText');
            const verifyLoading = document.getElementById('verifyOtpLoading');
            
            if (otp.length !== 6) {
                showFieldError('otp', 'Please enter the complete 6-digit code');
                return;
            }
            
            // Show loading
            verifyBtn.disabled = true;
            verifyText.classList.add('hidden');
            verifyLoading.classList.remove('hidden');
            
            try {
                const response = await fetch('/api/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        email: userEmail,
                        otp: otp 
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    clearInterval(otpTimer);
                    goToStep(3);
                    showNotification('Code verified successfully!', 'success');
                } else {
                    showFieldError('otp', data.message || 'Invalid verification code');
                    clearOtpInputs();
                }
            } catch (error) {
                console.error('Error:', error);
                showFieldError('otp', 'Network error. Please try again.');
            } finally {
                verifyBtn.disabled = false;
                verifyText.classList.remove('hidden');
                verifyLoading.classList.add('hidden');
            }
        }

        async function handlePasswordSubmit(e) {
            e.preventDefault();
            
            const password = document.getElementById('newPassword').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const resetBtn = document.getElementById('resetPasswordBtn');
            const resetText = document.getElementById('resetPasswordText');
            const resetLoading = document.getElementById('resetPasswordLoading');
            
            // Validation
            if (password.length < 8) {
                showFieldError('newPassword', 'Password must be at least 8 characters long');
                return;
            }
            
            if (password !== confirmPassword) {
                showFieldError('confirmPassword', 'Passwords do not match');
                return;
            }
            
            // Show loading
            resetBtn.disabled = true;
            resetText.classList.add('hidden');
            resetLoading.classList.remove('hidden');
            
            try {
                const response = await fetch('/api/reset-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        email: userEmail,
                        password: password,
                        password_confirmation: confirmPassword
                    })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    goToStep(4);
                    showNotification('Password reset successfully!', 'success');
                } else {
                    if (data.errors) {
                        if (data.errors.password) {
                            showFieldError('newPassword', data.errors.password[0]);
                        }
                    } else {
                        showFieldError('newPassword', data.message || 'Failed to reset password');
                    }
                }
            } catch (error) {
                console.error('Error:', error);
                showFieldError('newPassword', 'Network error. Please try again.');
            } finally {
                resetBtn.disabled = false;
                resetText.classList.remove('hidden');
                resetLoading.classList.add('hidden');
            }
        }

        async function resendOtp() {
            const resendBtn = document.getElementById('resendOtpBtn');
            resendBtn.disabled = true;
            resendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Resending...';
            
            try {
                const response = await fetch('/api/forgot-password', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: userEmail })
                });
                
                const data = await response.json();
                
                if (data.success) {
                    clearOtpInputs();
                    timeLeft = 900;
                    startTimer();
                    showNotification('New verification code sent!', 'success');
                } else {
                    showNotification('Failed to resend code. Please try again.', 'error');
                }
            } catch (error) {
                showNotification('Network error. Please try again.', 'error');
            } finally {
                resendBtn.disabled = false;
                resendBtn.innerHTML = '<i class="fas fa-redo mr-2"></i>Resend Code';
            }
        }

        function goToStep(step) {
            // Hide all steps
            document.querySelectorAll('.step-content').forEach(el => el.classList.add('hidden'));
            
            // Update step indicators
            for (let i = 1; i <= 3; i++) {
                const stepEl = document.getElementById(`step${i}`);
                const lineEl = document.getElementById(`line${i}`);
                
                if (i < step) {
                    stepEl.classList.remove('active');
                    stepEl.classList.add('completed');
                    stepEl.innerHTML = '<i class="fas fa-check"></i>';
                    if (lineEl) lineEl.classList.add('completed');
                } else if (i === step) {
                    stepEl.classList.add('active');
                    stepEl.classList.remove('completed');
                    stepEl.textContent = i;
                } else {
                    stepEl.classList.remove('active', 'completed');
                    stepEl.textContent = i;
                    if (lineEl) lineEl.classList.remove('completed');
                }
            }
            
            // Show current step
            if (step === 1) {
                document.getElementById('emailStep').classList.remove('hidden');
            } else if (step === 2) {
                document.getElementById('otpStep').classList.remove('hidden');
            } else if (step === 3) {
                document.getElementById('passwordStep').classList.remove('hidden');
            } else if (step === 4) {
                document.getElementById('successStep').classList.remove('hidden');
            }
            
            currentStep = step;
        }

        function startTimer() {
            const timerEl = document.getElementById('timer');
            
            otpTimer = setInterval(() => {
                const minutes = Math.floor(timeLeft / 60);
                const seconds = timeLeft % 60;
                timerEl.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
                
                if (timeLeft <= 0) {
                    clearInterval(otpTimer);
                    timerEl.textContent = 'Expired';
                    timerEl.style.color = '#dc3545';
                    showNotification('Verification code has expired. Please request a new one.', 'error');
                }
                
                timeLeft--;
            }, 1000);
        }

        function getOtpValue() {
            let otp = '';
            for (let i = 1; i <= 6; i++) {
                otp += document.getElementById(`otp${i}`).value;
            }
            return otp;
        }

        function clearOtpInputs() {
            for (let i = 1; i <= 6; i++) {
                document.getElementById(`otp${i}`).value = '';
            }
            document.getElementById('otp1').focus();
        }

        function togglePasswordVisibility(inputId, buttonId) {
            const input = document.getElementById(inputId);
            const button = document.getElementById(buttonId);
            const icon = button.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        function showFieldError(fieldId, message) {
            const errorEl = document.getElementById(fieldId + 'Error');
            if (fieldId === 'otp') {
                errorEl = document.getElementById('otpError');
            }
            
            if (errorEl) {
                errorEl.textContent = message;
                errorEl.classList.remove('hidden');
                
                setTimeout(() => {
                    errorEl.classList.add('hidden');
                }, 5000);
            }
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function showNotification(message, type = 'info') {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 'bg-blue-500'
            } text-white`;
            
            notification.innerHTML = `
                <div class="flex items-center">
                    <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} mr-2"></i>
                    <span>${message}</span>
                    <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                if (notification.parentElement) {
                    notification.remove();
                }
            }, 5000);
        }
    </script>
</body>
</html>