<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $application->owner_name }}'s Trade License</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}" type="image/x-icon">
    <style>
        .container-custom {
            width: 900px;
            margin: 0 auto;
            padding: 20px;
        }
        @media print {
            .container-custom {
                width: 100% !important;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container-custom border border-danger bg-white p-4">
        <div class="row text-center">
            <div class="title font-ador fs-3">বরিশাল সিটি কর্পোরেশন</div>
            <div class="subtitle font-bn">www.barishalcity.gov.bd</div>
        </div>
        <div class="row row-cols-3">
            <div class="col">
                <div class="text-start">
                    {!! $qrcode !!}
                </div>
            </div>
            <div class="col">
                <div class="text-center">
                    <img class="pb-3" width="100px" src="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}" alt="BCC logo">
                    <h4 class="font-ador">ই-ট্রেড লাইসেন্স</h4>
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <img width="100px" src="{{ Helpers::getImageUrl($application, 'owner_image') }}" alt="logo" class="logo">
                </div>
            </div>
        </div>
        <div class="row text-center">
            <h5 class="font-ador" style="color: #008738;">TRAD/BCC/121605/2022 </h5>
        </div>
        <div class="row text-center">
            <span class="notice">স্থানীয় সরকার (সিটি কর্পোরেশন) আইন, ২০০৯ (২০০৯ সনের ৬০ নং আইন) এর ধারা ৮৪- তে প্রদত্ত ক্ষমতাবলে সরকার প্রণীত আদর্শ কর তফসিল, ২০১৬ এর ১০ অনুচ্ছেদ অনুযায়ী ব্যবসা, বৃত্তি, পেশা বা শিল্প প্রতিষ্ঠানের উপর আরোপিত কর আদায়ের লক্ষ্যে নিন্মে বর্ণিত ব্যক্তি/ প্রতিষ্ঠানের আনুকূলে অত্র ট্রেড লাইসেন্সটি ইস্যু করা হলো।</span>
        </div>
    </div>
</body>
</html>
