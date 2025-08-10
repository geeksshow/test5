<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset OTP</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            background: linear-gradient(135deg, #ffc107 0%, #ffb400 100%);
            color: #000;
            padding: 30px;
            text-align: center;
            border-radius: 10px 10px 0 0;
        }
        .content {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 0 0 10px 10px;
        }
        .otp-code {
            background: #fff;
            border: 2px solid #ffc107;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin: 20px 0;
            font-size: 32px;
            font-weight: bold;
            letter-spacing: 5px;
            color: #000;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>DND COMPUTERS</h1>
        <p>Password Reset OTP</p>
    </div>
    
    <div class="content">
        <h2>Hello!</h2>
        <p>You have requested to reset your password. Please use the following OTP code to complete the process:</p>
        
        <div class="otp-code">
            {{ $otp }}
        </div>
        
        <p><strong>Important:</strong></p>
        <ul>
            <li>This OTP is valid for 15 minutes only</li>
            <li>Do not share this code with anyone</li>
            <li>If you didn't request this, please ignore this email</li>
        </ul>
        
        <p>If you have any questions, please contact our support team.</p>
        
        <p>Best regards,<br>DND COMPUTERS Team</p>
    </div>
    
    <div class="footer">
        <p>This is an automated email. Please do not reply to this message.</p>
    </div>
</body>
</html> 