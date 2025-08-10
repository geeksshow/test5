<!-- Email Verification Modal -->
<div class="modal fade" id="emailVerificationModal" tabindex="-1" aria-labelledby="emailVerificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background: rgba(20, 20, 20, 0.95); border: 1px solid rgba(255, 193, 7, 0.3); border-radius: 20px;">
            <div class="modal-header border-0">
                <h5 class="modal-title text-warning" id="emailVerificationModalLabel">
                    <i class="fas fa-shield-alt me-2"></i>Email Verification Required
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-4">
                    <i class="fas fa-envelope-open-text fa-3x text-warning mb-3"></i>
                    <p class="text-white">For your security, we need to verify your email address.</p>
                    <p class="text-muted">We'll send a 6-digit OTP to your email.</p>
                </div>

                <!-- Step 1: Send OTP -->
                <div id="sendOtpStep">
                    <div class="mb-3">
                        <label class="form-label text-white">Email Address</label>
                        <input type="email" class="form-control" id="verificationEmail" 
                               style="background: rgba(40, 40, 40, 0.8); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff;"
                               placeholder="Enter your email">
                        <div class="invalid-feedback" id="emailError"></div>
                    </div>
                    <button class="btn btn-warning w-100" onclick="sendOTP()">
                        <span id="sendOtpText">
                            <i class="fas fa-paper-plane me-2"></i>Send OTP
                        </span>
                        <span id="sendOtpLoading" class="d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>Sending...
                        </span>
                    </button>
                </div>

                <!-- Step 2: Verify OTP -->
                <div id="verifyOtpStep" class="d-none">
                    <div class="mb-3">
                        <label class="form-label text-white">Enter 6-digit OTP</label>
                        <input type="text" class="form-control text-center" id="otpInput" 
                               style="background: rgba(40, 40, 40, 0.8); border: 1px solid rgba(255, 255, 255, 0.2); color: #fff; font-size: 1.5rem; letter-spacing: 0.5rem;"
                               placeholder="000000" maxlength="6">
                        <div class="invalid-feedback" id="otpError"></div>
                        <small class="text-muted">OTP expires in <span id="otpTimer">10:00</span></small>
                    </div>
                    <button class="btn btn-warning w-100 mb-2" onclick="verifyOTP()">
                        <span id="verifyOtpText">
                            <i class="fas fa-check-circle me-2"></i>Verify OTP
                        </span>
                        <span id="verifyOtpLoading" class="d-none">
                            <i class="fas fa-spinner fa-spin me-2"></i>Verifying...
                        </span>
                    </button>
                    <button class="btn btn-outline-light w-100" onclick="resendOTP()">
                        <i class="fas fa-redo me-2"></i>Resend OTP
                    </button>
                </div>

                <!-- Success Step -->
                <div id="verificationSuccess" class="d-none text-center">
                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                    <h5 class="text-success">Email Verified Successfully!</h5>
                    <p class="text-white">Your email has been verified. You can now continue.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let otpTimer;
let timeLeft = 600; // 10 minutes in seconds

function sendOTP() {
    const email = document.getElementById('verificationEmail').value;
    const sendBtn = document.querySelector('#sendOtpStep button');
    const sendText = document.getElementById('sendOtpText');
    const sendLoading = document.getElementById('sendOtpLoading');
    
    if (!email) {
        showFieldError('verificationEmail', 'Please enter your email address');
        return;
    }
    
    // Show loading
    sendText.classList.add('d-none');
    sendLoading.classList.remove('d-none');
    sendBtn.disabled = true;
    
    fetch('/email/send-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Switch to OTP verification step
            document.getElementById('sendOtpStep').classList.add('d-none');
            document.getElementById('verifyOtpStep').classList.remove('d-none');
            startOtpTimer();
            showNotification('OTP sent successfully!', 'success');
        } else {
            showFieldError('verificationEmail', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to send OTP. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button
        sendText.classList.remove('d-none');
        sendLoading.classList.add('d-none');
        sendBtn.disabled = false;
    });
}

function verifyOTP() {
    const email = document.getElementById('verificationEmail').value;
    const otp = document.getElementById('otpInput').value;
    const verifyBtn = document.querySelector('#verifyOtpStep button');
    const verifyText = document.getElementById('verifyOtpText');
    const verifyLoading = document.getElementById('verifyOtpLoading');
    
    if (!otp || otp.length !== 6) {
        showFieldError('otpInput', 'Please enter a valid 6-digit OTP');
        return;
    }
    
    // Show loading
    verifyText.classList.add('d-none');
    verifyLoading.classList.remove('d-none');
    verifyBtn.disabled = true;
    
    fetch('/email/verify-otp', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ email: email, otp: otp })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success
            document.getElementById('verifyOtpStep').classList.add('d-none');
            document.getElementById('verificationSuccess').classList.remove('d-none');
            clearInterval(otpTimer);
            showNotification('Email verified successfully!', 'success');
            
            // Auto close modal after 2 seconds
            setTimeout(() => {
                bootstrap.Modal.getInstance(document.getElementById('emailVerificationModal')).hide();
            }, 2000);
        } else {
            showFieldError('otpInput', data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Failed to verify OTP. Please try again.', 'error');
    })
    .finally(() => {
        // Reset button
        verifyText.classList.remove('d-none');
        verifyLoading.classList.add('d-none');
        verifyBtn.disabled = false;
    });
}

function resendOTP() {
    // Reset to send OTP step
    document.getElementById('verifyOtpStep').classList.add('d-none');
    document.getElementById('sendOtpStep').classList.remove('d-none');
    document.getElementById('otpInput').value = '';
    clearInterval(otpTimer);
    timeLeft = 600;
}

function startOtpTimer() {
    const timerElement = document.getElementById('otpTimer');
    
    otpTimer = setInterval(() => {
        const minutes = Math.floor(timeLeft / 60);
        const seconds = timeLeft % 60;
        timerElement.textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;
        
        if (timeLeft <= 0) {
            clearInterval(otpTimer);
            timerElement.textContent = 'Expired';
            showNotification('OTP has expired. Please request a new one.', 'error');
        }
        
        timeLeft--;
    }, 1000);
}

function showFieldError(fieldId, message) {
    const field = document.getElementById(fieldId);
    const errorDiv = document.getElementById(fieldId === 'verificationEmail' ? 'emailError' : 'otpError');
    
    field.classList.add('is-invalid');
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    
    // Clear error after 5 seconds
    setTimeout(() => {
        field.classList.remove('is-invalid');
        errorDiv.style.display = 'none';
    }, 5000);
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : type === 'error' ? 'danger' : 'info'} position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'} me-2"></i>
        ${message}
        <button type="button" class="btn-close" onclick="this.parentElement.remove()"></button>
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        if (notification.parentElement) {
            notification.remove();
        }
    }, 5000);
}

// Auto-format OTP input
document.getElementById('otpInput').addEventListener('input', function(e) {
    this.value = this.value.replace(/\D/g, '').substring(0, 6);
});
</script>