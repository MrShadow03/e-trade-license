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
            .bg-dark {
                background-color: #fff !important;
            }
        }
        .fs-10{
            font-size: 10px;
        }
        .fs-12{
            font-size: 12px;
        }
        .fs-14{
            font-size: 14px;
        }
        .fs-16{
            font-size: 16px;
        }
        .fs-18{
            font-size: 18px;
        }
        .fs-20{
            font-size: 20px;
        }
        .fs-24{
            font-size: 24px;
        }
        .ls-1{
            letter-spacing: 1px;
        }
        .ls-2{
            letter-spacing: 2px;
        }
        .label{
            font-weight: bold;
            font-size: 12px;
        }
        .value{
            font-size: 12px;
        }
        .custom_border{
            border-bottom: 1px solid #a3a3a3;
        }
        .slogan{
            padding: 3px 7px;
        }
        .photo{
            width: 130px;
            aspect-ratio: 1;
            object-fit: contain;
            border-radius: 3px;
            border: 1px solid #000000;
        }
        .container-custom{
            padding-top: 40px;
        }
        .watermark{
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            opacity: 0.1;
        }
    </style>
</head>
<body class="bg-dark">
    <div class="container-custom bg-white px-4">
        <div class="row row-cols-3 px-4">
            <div class="col px-0">
                <div class="slogan border border-dark border-2 font-noto fw-bold fs-12 d-inline-block text-center">
                    শেখ হাসিনার মূলনীতি<br>
                    গ্রাম শহরের উন্নতি
                </div>
            </div>
            <div class="col px-0 text-center">
                <div class="title font-bn fw-semibold fs-24 pb-1">বরিশাল সিটি কর্পোরেশন</div>
                <div class="subtitle font-kohinoor fs-12 ls-1 pb-2">www.barishalcity.gov.bd</div>
            </div>
            <div class="col px-0"></div>
        </div>
        <div class="row row-cols-3 px-4">
            <div class="col ps-0">
                {!! $qrcode !!}
                <table class="mt-1">
                    <tr>
                        <td class="py-0 fs-12 fw-semibold font-noto">ইস্যুর তারিখ</td>
                        <td class="py-0 fs-12 fw-semibold font-noto">: {{ Helpers::convertToBanglaDigits($application->issued_at->format('d-m-Y')) }}</td>
                    </tr>
                    <tr>
                        <td class="py-0 fs-12 fw-semibold font-noto">ইস্যুর সময়</td>
                        <td class="py-0 fs-12 fw-semibold font-noto">: {{ Helpers::convertToBanglaDigits($application->issued_at->locale('bn-BD')->translatedFormat('A h:i')) }}</td>
                    </tr>
                </table>
            </div>
            <div class="col">
                <div class="text-center">
                    <img class="pb-2 logo" width="120px" src="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}" alt="BCC logo">
                    <h4 class="font-ador font-semibold fs-18">ই-ট্রেড লাইসেন্স</h4>
                </div>
            </div>
            <div class="col">
                <div class="text-end">
                    <img class="photo" src="{{ Helpers::getImageUrl($application, 'owner_image') }}" alt="logo" class="logo">
                </div>
            </div>
        </div>
        <div class="row text-center pb-2">
            <h5 class="font-roboto fw-semibold fs-16" style="color: #008738;">TRAD/BCC/{{ $application->trade_license_no }}/{{ $application->issued_at->format('Y') }} </h5>
        </div>
        <div class="row text-start">
            <span class="notice font-noto px-4 fs-12">স্থানীয় সরকার (সিটি কর্পোরেশন) আইন, ২০০৯ (২০০৯ সনের ৬০ নং আইন) এর ধারা ৮৪- তে প্রদত্ত ক্ষমতাবলে সরকার প্রণীত আদর্শ কর তফসিল, ২০১৬ এর ১০ অনুচ্ছেদ অনুযায়ী ব্যবসা, বৃত্তি, পেশা বা শিল্প প্রতিষ্ঠানের উপর আরোপিত কর আদায়ের লক্ষ্যে নিন্মে বর্ণিত ব্যক্তি/ প্রতিষ্ঠানের আনুকূলে অত্র ট্রেড লাইসেন্সটি ইস্যু করা হলো।</span>
        </div>

        <div class="row info_wrapper font-noto py-2 px-4">
            <table id="table">
                <tr>
                    <td class=" fs-14 fw-semibold font-bn pb-1" colspan="" id="dynamicColSpan"><u>স্বত্বাধিকারীর তথ্য</u></td>
                </tr>
                <tr>
                    <td class="label">ব্যবসা প্রতিষ্ঠানের নাম</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->business_organization_name_bn }}</td>
                </tr>
                <tr>
                    <td class="label">স্বত্বাধিকারীর নাম</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->owner_name_bn }}</td>
                </tr>
                <tr>
                    <td class="label">মাতার নাম</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->mother_name_bn }}</td>
                </tr>
                <tr>
                    <td class="label">পিতার নাম</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->father_name_bn }}</td>
                </tr>
                @if($application->spouse_name_bn)
                    <tr>
                        <td class="label">স্বামী/স্ত্রীর নাম</td>
                        <td class="value">:&nbsp;&nbsp; {{ $application->spouse_name_bn }}</td>
                    </tr>
                @endif
                <tr>
                    <td class="label">ব্যবসার প্রকৃতি</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->nature_of_business_bn }}</td>
                </tr>
                <tr>
                    <td class="label">ব্যবসার ধরন</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->type_of_business_bn }}</td>
                </tr>
                <tr>
                    <td class="label">ব্যবসা প্রতিষ্ঠানের ঠিকানা</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->address_of_business_organization_bn }}</td>
                </tr>
                <tr>
                    <td class="label">ওয়ার্ড নং</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->ward_no) }}</td>
                    <td class="label">অঞ্চল</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->zone_bn) }}</td>
                </tr>
                @if($application->national_id_no)
                    <tr>
                        <td class="label">জাতীয় পরিচয় পত্র নম্বর</td>
                        <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(implode(' ', str_split($application->national_id_no, 5))) }}</td>
                    </tr>
                @endif
                @if($application->birth_registration_no || $application->passport_no)
                    <tr>
                        @if($application->birth_registration_no)
                        <td class="label">জন্ম নিবন্ধন নম্বর</td>
                        <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(implode(' ', str_split($application->birth_registration_no, 5))) }}</td>
                        @endif
                        @if($application->passport_no)
                        <td class="label">পাসপোর্ট নম্বর</td>
                        <td class="value">:&nbsp;&nbsp; {{ $application->passport_no }}</td>
                        @endif
                    </tr>
                @endif
                <tr>
                    <td class="label">মোবাইল নম্বর</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(substr($application->phone_no, 0, 5).' '.substr($application->phone_no, 6, 11)) }}</td>
                    @if($application->email)
                    <td class="label">ই-মেইল</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->email }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="label">অর্থ বছর</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application-> fiscal_year) }}</td>
                    <td class="label">ব্যবসা শুরুর তারিখ</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(date('d-m-Y', strtotime($application->business_starting_date))) }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-start text-underlined fs-14 fw-semibold font-bn pt-2 pb-1"><u class="separator">স্বত্বাধিকারীর বর্তমান ঠিকানা</u></td>
                    <td colspan="2" class="text-start fs-14 fw-semibold font-bn pt-2 pb-1"><u class="separator">স্বত্বাধিকারীর স্থায়ী ঠিকানা</u></td>
                </tr>
                @if($application->ca_holding_no)
                <tr>
                    <td class="label">হোল্ডিং নং</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->ca_holding_no) }}</td>
                    <td class="label">হোল্ডিং নং</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->pa_holding_no) }}</td>
                </tr>
                @endif
                @if($application->ca_road_no)
                <tr>
                    <td class="label">রোড নং</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->ca_road_no) }}</td>
                    <td class="label">রোড নং</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->pa_road_no) }}</td>
                </tr>
                @endif
                @if($application->ca_village_bn)
                <tr>
                    <td class="label">গ্রাম/মহল্লা</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->ca_village_bn }}</td>
                    <td class="label">গ্রাম/মহল্লা</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->pa_village_bn }}</td>
                </tr>
                @endif
                @if($application->ca_post_office_bn)
                <tr>
                    <td class="label">ডাকঘর</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->ca_post_office_bn }}</td>
                    <td class="label">ডাকঘর</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->pa_post_office_bn }}</td>
                </tr>
                @endif
                @if($application->ca_post_code)
                <tr>
                    <td class="label">পোস্ট কোড</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->ca_post_code) }}</td>
                    <td class="label">পোস্ট কোড</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->pa_post_code) }}</td>
                </tr>
                @endif
                @if($application->ca_upazilla_bn)
                <tr>
                    <td class="label">উপজেলা</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->ca_upazilla_bn }}</td>
                    <td class="label">উপজেলা</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->pa_upazilla_bn }}</td>
                </tr>
                @endif
                @if($application->ca_division_bn)
                <tr>
                    <td class="label">বিভাগ</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->ca_division_bn }}</td>
                    <td class="label">বিভাগ</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->pa_division_bn }}</td>
                </tr>
                @endif
                @if($application->ca_country_bn)
                <tr>
                    <td class="label">দেশ</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->ca_country_bn }}</td>
                    <td class="label">দেশ</td>
                    <td class="value">:&nbsp;&nbsp; {{ $application->pa_country_bn }}</td>
                </tr>
                @endif
                @if($application->ccmts_2016_serial_no)
                <tr>
                    <td class="label">আদর্শ কর তফসিল, ২০১৬ এর ক্রমিক নং</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits($application->ccmts_2016_serial_no) }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="2" class="text-start text-underlined fs-14 fw-semibold font-bn pt-2 pb-1"><u class="separator">ট্রেড লাইসেন্স ফি</u></td>
                </tr>
                @if($application->status === Helpers::ISSUED)
                <tr>
                    <td class="label">
                        @if($application->application_type === 'renewed')
                            নবায়ন ফি
                        @else
                            নতুন ফি
                        @endif
                    </td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($application->new_application_fee, 0)) }} টাকা</td>
                    <td class="label">সাইনবোর্ড ফি</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($application->signboard_fee, 0)) }} টাকা</td>
                </tr>
                @endif
                <tr>
                    <td class="label">আয় কর</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($application->income_tax, 0)) }} টাকা</td>
                    <td class="label">ভ্যাট</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($application->vat, 0)) }} টাকা</td>
                </tr>

                @if($application->application_type === 'renewed' && ($application->arrear || $application->surcharge))
                <tr>
                    @if ($application->arrear)
                    <td class="label">বকেয়া</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($application->arrear, 0)) }} টাকা</td>
                    @endif
                    @if ($application->surcharge)
                    <td class="label">সারচার্জ</td>
                    <td class="value">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($application->surcharge, 0)) }} টাকা</td>
                    @endif
                </tr>
                @elseif($application->application_type === 'new')
                <tr>
                    <td class="label pb-2">আবেদন ফি</td>
                    <td class="value pb-2">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($application->form_fee, 0)) }} টাকা</td>
                    <td class="label"></td>
                    <td class="value"></td>
                </tr>
                @endif

                <tr>
                    <td class="font-noto fw-semibold fs-14">সর্বমোট (৳)</td>
                    @php
                        $totalFee = 0;
                        if($application->application_type === 'renewed'){
                            $totalFee = $application->renewal_application_fee + $application->arrear + $application->surcharge + $application->signboard_fee + $application->income_tax + $application->vat;
                        }elseif($application->application_type === 'new'){
                            $totalFee = $application->total_new_license_fee + Helpers::TRADE_LICENSE_FORM_FEE;
                        }
                    @endphp
                    <td class="font-noto fw-bold fs-14">:&nbsp;&nbsp; {{ Helpers::convertToBanglaDigits(number_format($totalFee, 0)) }} ({{ Helpers::numToBanglaWords($totalFee).' টাকা মাত্র'}})</td>
                    <td class="label"></td>
                    <td class="value"></td>
                </tr>
            </table>
        </div>
        <div class="text-center font-noto pb-5 pt-4 fs-12" style="color: #008738;">অত্র ট্রেড লাইসেন্স এর মেয়াদ <span class="fw-bold fs-14">{{ Helpers::convertToBanglaDigits(Carbon\Carbon::parse($application->expiry_date)->locale('bn-BD')->translatedFormat('d F, Y'))}}</span> পর্যন্ত।</div>
        <div class="row text-center align-items-end">
            <div class="col">
                <img height="40px" src="{{ asset('assets/img/signature.jpg') }}" alt="signature" class="signature">
                <div class="font-noto fs-12 pt-2">ট্রেড লাইসেন্স ইন্সপেক্টর</div>
            </div>
            <div class="col">
                <img height="40px" src="{{ asset('assets/img/signature (1).png') }}" alt="signature" class="signature">
                <div class="font-noto fs-12 pt-2">ট্রেড লাইসেন্স সুপারিনটেনডেন্ট</div>
            </div>
            <div class="col">
                <img height="40px" src="{{ asset('assets/img/signature (2).png') }}" alt="signature" class="signature">
                <div class="font-noto fs-12 pt-2">রাজস্ব কর্মকর্তা</div>
            </div>
            <div class="col">
                <img height="40px" src="{{ asset('assets/img/signature (3).png') }}" alt="signature" class="signature">
                <div class="font-noto fs-12 pt-2">প্রধান রাজস্ব কর্মকর্তা</div>
            </div>
        </div>

        <div class="watermark">
            <img src="{{ asset('assets/img/Barisal_City_Corporation_logo.png') }}" width="350px" alt="logo" class="logo">
        </div>
    </div>
    <script>
        window.print();
        const getMaxNumberOfColumns = () => {
            const table = document.getElementById('table');
            let maxNumberOfColumns = 0;
            for (let i = 0; i < table.rows.length; i++) {
                if (table.rows[i].cells.length > maxNumberOfColumns) {
                    maxNumberOfColumns = table.rows[i].cells.length;
                }
            }
            return maxNumberOfColumns;
        };

        const dynamicColSpan = document.getElementById('dynamicColSpan');
        dynamicColSpan.setAttribute('colspan', getMaxNumberOfColumns());
    </script>
</body>
</html>
