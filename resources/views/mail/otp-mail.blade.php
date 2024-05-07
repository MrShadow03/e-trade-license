{{-- mail templadet for OTP --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <title>
        Barishal City Corporation - Varification Email
    </title>
    <style>
        body {
            font-family: 'Hind Siliguri', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .card {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            padding: 20px;
            text-align: center;
            background-color: #f5f5f5;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }
        .title {
            font-size: 24px;
            font-weight: 600;
            margin: 0;
            color: #333;
        }
        .card-body {
            padding: 20px;
            text-align: center;
        }
        .subtitle {
            font-size: 18px;
            font-weight: 500;
            margin: 0;
            color: #333;
        }
        .otp {
            font-size: 36px;
            font-weight: 600;
            margin: 20px 0;
            color: #008637;
        }
        .card-footer {
            padding: 20px;
            text-align: center;
            background-color: #f5f5f5;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }
        .footer-text {
            font-size: 14px;
            font-weight: 400;
            margin: 0;
            color: #fd0002;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <img alt="Logo" src="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}" style="width: 100px; aspect-ratio: 1; object-fit:contain">
            <h1 class="title">
                বরিশাল সিটি কর্পোরেশন
            </h1>
        </div>
        <div class="card-body">
            <p class="subtitle">
                {{ $name ?? '' }} আপনার বরিশাল সিটি কর্পোরেশন একাউন্ট ভেরিফিকেশন কোড
            </p>
            <p class="otp">
                {{ $otp }}
            </p>
        </div>
        <div class="card-footer">
            <p class="footer-text">
                এই ইমেইল টি আপনার বরিশাল সিটি কর্পোরেশন একাউন্ট ভেরিফাই করার জন্য প্রয়োজন। এই কোডটি কাউকে দেওয়া যাবে না। কোডটি অবশ্যই পরবর্তী ৫ মিনিটের মধ্যে ব্যবহার করতে হবে। ধন্যবাদ।
            </p>
        </div>
    </div>
</body>
</html>