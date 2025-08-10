<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Test OTP System - DND COMPUTERS</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl p-8 max-w-md w-full">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-500 rounded-full mb-4">
                <i class="fas fa-key text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Test OTP System</h1>
            <p class="text-gray-600">Testing OTP functionality</p>
        </div>

        <div class="space-y-6">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <input type="email" id="testEmail" placeholder="Enter email" 
                       class="w-full px-4 py-3 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500">
            </div>

            <button onclick="sendTestOTP()" id="sendBtn"
                    class="w-full bg-yellow-500 text-white font-bold py-3 px-4 rounded-lg hover:bg-yellow-600 transition-all duration-300">
                Send Test OTP
            </button>

            <div id="result" class="hidden p-4 rounded-lg"></div>
        </div>
    </div>

    <script>
        async function sendTestOTP() {
            const email = document.getElementById('testEmail').value.trim();
            const sendBtn = document.getElementById('sendBtn');
            const result = document.getElementById('result');
            
            if (!email) {
                showResult('Please enter an email address', 'error');
                return;
            }

            sendBtn.disabled = true;
            sendBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Sending...';

            try {
                const response = await fetch('/api/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ email: email })
                });

                const data = await response.json();
                
                if (data.success) {
                    showResult(`OTP sent successfully via ${data.delivery_method}! OTP: ${data.otp}`, 'success');
                } else {
                    showResult(data.message, 'error');
                }
            } catch (error) {
                showResult('Network error: ' + error.message, 'error');
            } finally {
                sendBtn.disabled = false;
                sendBtn.innerHTML = 'Send Test OTP';
            }
        }

        function showResult(message, type) {
            const result = document.getElementById('result');
            const bgColor = type === 'success' ? 'bg-green-100 border-green-200' : 'bg-red-100 border-red-200';
            const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
            
            result.innerHTML = `<div class="${bgColor} border-2 rounded-lg p-4"><p class="${textColor}">${message}</p></div>`;
            result.classList.remove('hidden');
        }
    </script>
</body>
</html>
