<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f9fafb; color: #0a1128; line-height: 1.6; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 40px; border-top: 4px solid #d4af37; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 1px solid #f3f4f6; padding-bottom: 20px; }
        .header h2 { color: #0a1128; margin: 0; font-size: 24px; letter-spacing: 2px; }
        .header p { color: #d4af37; text-transform: uppercase; font-size: 12px; letter-spacing: 3px; margin-top: 5px; }
        .details { background: #f8fafc; padding: 25px; border-left: 3px solid #d4af37; margin-bottom: 25px; }
        .details p { margin: 10px 0; font-size: 15px; }
        .details strong { color: #0a1128; display: inline-block; width: 130px; }
        .message-box { background: #ffffff; padding: 20px; border: 1px solid #e2e8f0; border-radius: 4px; font-style: italic; color: #475569; }
        .footer { text-align: center; color: #94a3b8; font-size: 12px; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>ROXEL INVEST</h2>
            <p>New Consultation Request</p>
        </div>
        
        <p>You have received a new inquiry from the website. Here are the client's details:</p>
        
        <div class="details">
            <p><strong>Client Name:</strong> {{ $inquiryData['first_name'] }} {{ $inquiryData['last_name'] }}</p>
            <p><strong>Email Address:</strong> <a href="mailto:{{ $inquiryData['email'] }}" style="color: #d4af37; text-decoration: none;">{{ $inquiryData['email'] }}</a></p>
            <p><strong>Phone Number:</strong> {{ $inquiryData['phone'] ?? 'Not provided' }}</p>
            <p><strong>Area of Interest:</strong> <span style="background: #0a1128; color: #fff; padding: 3px 8px; font-size: 12px; border-radius: 3px;">{{ $inquiryData['interest'] }}</span></p>
        </div>

        <h3 style="color: #0a1128; font-size: 16px;">Message Content:</h3>
        <div class="message-box">
            "{{ $inquiryData['message'] }}"
        </div>

        <div class="footer">
            <p>This email was generated automatically from your website's contact form.</p>
        </div>
    </div>
</body>
</html>