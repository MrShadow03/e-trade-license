<?php

namespace App\Helpers;

class Helpers
{
    public static function convertFileSize($sizeInKB = 0)
    {
        if ($sizeInKB < 1024) {
            return $sizeInKB . ' KB';
        } elseif ($sizeInKB < 1048576) {
            // Convert to MB
            $sizeInMB = $sizeInKB / 1024;
            return round($sizeInMB, 2) . ' MB';
        } elseif ($sizeInKB < 1073741824) {
            // Convert to GB
            $sizeInGB = $sizeInKB / 1048576;
            return round($sizeInGB, 2) . ' GB';
        }
    }

    public static function convertToBanglaDigits($number = '0')
    {
        $number = (string)$number;
        $banglaDigits = [
            '0' => '০',
            '1' => '১',
            '2' => '২',
            '3' => '৩',
            '4' => '৪',
            '5' => '৫',
            '6' => '৬',
            '7' => '৭',
            '8' => '৮',
            '9' => '৯',
        ];

        $banglaNumber = '';

        foreach (mb_str_split($number) as $digit) {
            if (array_key_exists($digit, $banglaDigits)) {
                $banglaNumber .= $banglaDigits[$digit];
                continue;
            }
            $banglaNumber .= $digit;
        }

        return $banglaNumber;
    }

    public static function translateActivity($activity)
    {
        $activity = strtolower($activity);
        $activity = str_replace('-', ' ', $activity);

        switch ($activity) {
            case 'created':
                return 'নতুন তৈরি';
                break;
            case 'updated':
                return 'পরিবর্তন';
                break;
            case 'deleted':
                return 'ডিলিট';
                break;
            case 'logged in':
                return 'লগইন';
                break;
            case 'logged out':
                return 'লগ আউট';
                break;
            default:
                return $activity;
                break;
        }
    }

    public static function areaFinder($ward): array
    {
        $areas = [
            1 => [
                'কাউনিয়া (অংশ)',
                'পশ্চিম বিসিক রোড',
                'পশ্চিম কাউনিয়া',
                'পশ্চিম কাউনিয়া মেইন রোড',
                'পূর্ব পশ্চিম কাউনিয়া জাংশন রোড',
                'পূর্ব উত্তর কাউনিয়া প্রথম লেন',
                'উত্তর কাউনিয়া',
                'উত্তর কাউনিয়া প্রথম লেন',
            ],
            2 => [
                'কাউনিয়া অংশ',
                'কাউনিয়া প্রথম লেন',
                'কাউনিয়া ক্লাব রোড',
                'কাউনিয়া মেইন রোড দক্ষিণ',
                'কাউনিয়া মনসাবাড়ী গলি',
                'পশ্চিম কাউনিয়া ব্রাঞ্চ রোড',
                'পূর্ব বিসিক রোড',
                'পূর্ব-পশ্চিম কাউনিয়া জংশন রোড',
                'উত্তর কাউনিয়া মেইনরোড',
            ]
        ];

        if (array_key_exists($ward, $areas)) {
            return $areas[$ward];
        }

        return [];
    }

    public static function translateBusinessNature($nature)
    {
        $nature = strtolower($nature);

        switch ($nature) {
            case 'একক':
                return 'Individual';
                break;
            case 'যৌথ':
                return 'Joint';
                break;
            case 'অন্যান্য':
                return 'Others';
                break;
            default:
                return $nature;
                break;
        }
    }

    public static function translateDivisionToEnglish($division)
    {
        $division = strtolower($division);

        switch ($division) {
            case 'ঢাকা':
                return 'Dhaka';
                break;
            case 'চট্টগ্রাম':
                return 'Chattogram';
                break;
            case 'খুলনা':
                return 'Khulna';
                break;
            case 'রাজশাহী':
                return 'Rajshahi';
                break;
            case 'বরিশাল':
                return 'Barishal';
                break;
            case 'সিলেট':
                return 'Sylhet';
                break;
            case 'রংপুর':
                return 'Rangpur';
                break;
            case 'ময়মনসিংহ':
                return 'Mymensingh';
                break;
            default:
                return $division;
                break;
        }
    }

    public static function translateDistrictToEnglish($district){
        $district = strtolower($district);

        switch ($district) {
                // Dhaka Division
            case 'নরসিংদী':
                return 'Narsingdi';
                break;
            case 'গাজীপুর':
                return 'Gazipur';
                break;
            case 'শরীয়তপুর':
                return 'Sherpur';
                break;
            case 'নারায়ণগঞ্জ':
                return 'Narayanganj';
                break;
            case 'টাঙ্গাইল':
                return 'Tangail';
                break;
            case 'কিশোরগঞ্জ':
                return 'Kishoreganj';
                break;
            case 'মানিকগঞ্জ':
                return 'Manikganj';
                break;
            case 'ঢাকা':
                return 'Dhaka';
                break;
            case 'মুন্সিগঞ্জ':
                return 'Munshiganj';
                break;
            case 'রাজবাড়ী':
                return 'Rajbari';
                break;
            case 'মাদারীপুর':
                return 'Madaripur';
                break;
            case 'গোপালগঞ্জ':
                return 'Gopalganj';
                break;
            case 'ফরিদপুর':
                return 'Faridpur';
                break;

                // Chattogram Division
            case 'কুমিল্লা':
                return 'Comilla';
                break;
            case 'ফেনী':
                return 'Feni';
                break;
            case 'ব্রাহ্মণবাড়িয়া':
                return 'Brahmanbaria';
                break;
            case 'রাঙ্গামাটি':
                return 'Rangamati';
                break;
            case 'নোয়াখালী':
                return 'Noakhali';
                break;
            case 'চাঁদপুর':
                return 'Chandpur';
                break;
            case 'লক্ষ্মীপুর':
                return 'Lakshmipur';
                break;
            case 'চট্টগ্রাম':
                return 'Chattogram';
                break;
            case 'কক্সবাজার':
                return 'Coxsbazar';
                break;
            case 'খাগড়াছড়ি':
                return 'Khagrachari';
                break;
            case 'বান্দরবান':
                return 'Bandarban';
                break;

                // Rajshahi Division
            case 'সিরাজগঞ্জ':
                return 'Sirajganj';
                break;
            case 'পাবনা':
                return 'Pabna';
                break;
            case 'বগুড়া':
                return 'Bogura';
                break;
            case 'রাজশাহী':
                return 'Rajshahi';
                break;
            case 'নাটোর':
                return 'Natore';
                break;
            case 'জয়পুরহাট':
                return 'Joypurhat';
                break;
            case 'চাঁপাইনবাবগঞ্জ':
                return 'Chapainawabganj';
                break;
            case 'নওগাঁ':
                return 'Naogaon';
                break;

                // Khulna Division
            case 'যশোর':
                return 'Jessore';
                break;
            case 'সাতক্ষীরা':
                return 'Satkhira';
                break;
            case 'মেহেরপুর':
                return 'Meherpur';
                break;
            case 'নড়াইল':
                return 'Narail';
                break;
            case 'চুয়াডাঙ্গা':
                return 'Chuadanga';
                break;
            case 'কুষ্টিয়া':
                return 'Kushtia';
                break;
            case 'মাগুরা':
                return 'Magura';
                break;
            case 'খুলনা':
                return 'Khulna';
                break;
            case 'বাগেরহাট':
                return 'Bagerhat';
                break;
            case 'ঝিনাইদহ':
                return 'Jhenaidah';
                break;

                // Barishal Division
            case 'ঝালকাঠি':
                return 'Jhalokathi';
                break;
            case 'পটুয়াখালী':
                return 'Potuakhali';
                break;
            case 'পিরোজপুর':
                return 'Pirojpur';
                break;
            case 'বরিশাল':
                return 'Barishal';
                break;
            case 'ভোলা':
                return 'Bhola';
                break;
            case 'বরগুনা':
                return 'Barguna';
                break;

                // Sylhet Division
            case 'সিলেট':
                return 'Sylhet';
                break;
            case 'মৌলভীবাজার':
                return 'Moulvibazar';
                break;
            case 'হবিগঞ্জ':
                return 'Habiganj';
                break;
            case 'সুনামগঞ্জ':
                return 'Sunamganj';
                break;

                // Rangpur Division
            case 'পঞ্চগড়':
                return 'Panchagarh';
                break;
            case 'দিনাজপুর':
                return 'Dinajpur';
                break;
            case 'লালমনিরহাট':
                return 'Lalmonirhat';
                break;
            case 'নীলফামারী':
                return 'Nilphamari';
                break;
            case 'গাইবান্ধা':
                return 'Gaibandha';
                break;
            case 'ঠাকুরগাঁও':
                return 'Thakurgaon';
                break;
            case 'রংপুর':
                return 'Rangpur';
                break;
            case 'কুড়িগ্রাম':
                return 'Kurigram';
                break;

                // Mymensingh Division
            case 'শেরপুর':
                return 'Sherpur';
                break;
            case 'ময়মনসিংহ':
                return 'Mymensingh';
                break;
            case 'জামালপুর':
                return 'Jamalpur';
                break;
            case 'নেত্রকোনা':
                return 'Netrokona';
                break;
            default:
                return $district;
                break;
        }
    }

    const DISTRICTS = [
        'বরিশাল',
        'ঝালকাঠি',
        'পটুয়াখালী',
        'পিরোজপুর',
        'ভোলা',
        'বরগুনা',
        'নরসিংদী',
        'গাজীপুর',
        'শরীয়তপুর',
        'নারায়ণগঞ্জ',
        'টাঙ্গাইল',
        'কিশোরগঞ্জ',
        'মানিকগঞ্জ',
        'ঢাকা',
        'মুন্সিগঞ্জ',
        'রাজবাড়ী',
        'মাদারীপুর',
        'গোপালগঞ্জ',
        'ফরিদপুর',
        'কুমিল্লা',
        'ফেনী',
        'ব্রাহ্মণবাড়িয়া',
        'রাঙ্গামাটি',
        'নোয়াখালী',
        'চাঁদপুর',
        'লক্ষ্মীপুর',
        'চট্টগ্রাম',
        'কক্সবাজার',
        'খাগড়াছড়ি',
        'বান্দরবান',
        'সিরাজগঞ্জ',
        'পাবনা',
        'বগুড়া',
        'রাজশাহী',
        'নাটোর',
        'জয়পুরহাট',
        'চাঁপাইনবাবগঞ্জ',
        'নওগাঁ',
        'যশোর',
        'সাতক্ষীরা',
        'মেহেরপুর',
        'নড়াইল',
        'চুয়াডাঙ্গা',
        'কুষ্টিয়া',
        'মাগুরা',
        'খুলনা',
        'বাগেরহাট',
        'ঝিনাইদহ',
        'সিলেট',
        'মৌলভীবাজার',
        'হবিগঞ্জ',
        'সুনামগঞ্জ',
        'পঞ্চগড়',
        'দিনাজপুর',
        'লালমনিরহাট',
        'নীলফামারী',
        'গাইবান্ধা',
        'ঠাকুরগাঁও',
        'রংপুর',
        'কুড়িগ্রাম',
        'শেরপুর',
        'ময়মনসিংহ',
        'জামালপুর',
        'নেত্রকোনা',
    ];

    // Status
    const PENDING_FORM_FEE_PAYMENT = 'pending_form_fee_payment';
    const PENDING_FORM_FEE_VERIFICATION = 'pending_form_fee_verification';
    const PENDING_ASSISTANT_APPROVAL = 'pending_assistant_approval';
    const DENIED_ASSISTANT_APPROVAL = 'denied_assistant_approval';
    const PENDING_INSPECTOR_APPROVAL = 'pending_inspector_approval';
    const DENIED_INSPECTOR_APPROVAL = 'denied_inspector_approval';
    const PENDING_LICENSE_FEE_PAYMENT = 'pending_license_fee_payment';
    const PENDING_LICENSE_FEE_VERIFICATION = 'pending_license_fee_verification';
    const PENDING_SUPT_APPROVAL = 'pending_supt_approval';
    const DENIED_SUPT_APPROVAL = 'denied_supt_approval';
    const PENDING_RO_APPROVAL = 'pending_ro_approval';
    const DENIED_RO_APPROVAL = 'denied_ro_approval';
    const PENDING_CRO_APPROVAL = 'pending_cro_approval';
    const DENIED_CRO_APPROVAL = 'denied_cro_approval';
    const PENDING_CEO_APPROVAL = 'pending_ceo_approval';
    const DENIED_CEO_APPROVAL = 'denied_ceo_approval';

    const PENDING_INSPECTOR_RENEWAL_APPROVAL = 'pending_inspector_renewal_approval';
    const DENIED_INSPECTOR_RENEWAL_APPROVAL = 'denied_inspector_renewal_approval';
    const PENDING_LICENSE_RENEWAL_FEE_PAYMENT = 'pending_license_renewal_fee_payment';
    const PENDING_LICENSE_RENEWAL_FEE_VERIFICATION = 'pending_license_renewal_fee_verification';
    const PENDING_SUPT_RENEWAL_APPROVAL = 'pending_supt_renewal_approval';
    const DENIED_SUPT_RENEWAL_APPROVAL = 'denied_supt_renewal_approval';
    const PENDING_RO_RENEWAL_APPROVAL = 'pending_ro_renewal_approval';
    const DENIED_RO_RENEWAL_APPROVAL = 'denied_ro_renewal_approval';

    //Status
    const ISSUED = 'issued';
    const RENEWED = 'renewed';
    const CANCELLED = 'cancelled';
    const EXPIRED = 'expired';

    //Activity
    const FORM_CREATED = 'form created';
    const FORM_FEE_SUBMITTED = 'form fee submitted';
    const FORM_FEE_REJECTED = 'form fee rejected';
    const FORM_FEE_VERIFIED = 'form fee verified';
    const ASSISTANT_REJECTED = 'assistant rejected';
    const USER_CORRECTION = 'user correction';
    const ASSISTANT_APPROVED = 'assistant approved';
    const INSPECTOR_REJECTED = 'inspector rejected';
    const INSPECTOR_APPROVED = 'inspector approved';
    const LICENSE_FEE_SUBMITTED = 'license fee submitted';
    const LICENSE_FEE_REJECTED = 'license fee rejected';
    const LICENSE_FEE_VERIFIED = 'license fee verified';
    const SUPT_REJECTED = 'supt rejected';
    const SUPT_APPROVED = 'supt approved';
    const RO_REJECTED = 'ro rejected';
    const RO_APPROVED = 'ro approved';
    const CRO_REJECTED = 'cro rejected';
    const CRO_APPROVED = 'cro approved';
    const CEO_REJECTED = 'ceo rejected';
    const CEO_APPROVED = 'ceo approved';
    const UNKNOWN_ACTIVITY = 'unknown activity';

    //Payment Types
    const FORM_FEE = 'form_fee';
    const LICENSE_FEE = 'license_fee';
    const LICENSE_RENEWAL_FEE = 'license_renewal_fee';
    const LICENSE_AMENDMENT_FEE = 'license_amendment_fee';

    public static function convertTlStatusToBangla($status){
        switch ($status) {
            case self::PENDING_FORM_FEE_PAYMENT:
                return [
                    'msg_bn' => 'ফরম ফি পরিশোধ করুন',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::PENDING_FORM_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'ফরম ফি যাচাই করার জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::PENDING_ASSISTANT_APPROVAL:
                return [
                    'msg_bn' => 'সহকারী কর্মকর্তার অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_ASSISTANT_APPROVAL:
                return [
                    'msg_bn' => 'সহকারী কর্মকর্তা অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_INSPECTOR_APPROVAL:
                return [
                    'msg_bn' => 'পরিদর্শকের অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_INSPECTOR_APPROVAL:
                return [
                    'msg_bn' => 'পরিদর্শক অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_LICENSE_FEE_PAYMENT:
                return [
                    'msg_bn' => 'লাইসেন্স ফি পরিশোধ করুন',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::PENDING_LICENSE_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'লাইসেন্স ফি যাচাইয়ের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::PENDING_SUPT_APPROVAL:
                return [
                    'msg_bn' => 'SUPT অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_SUPT_APPROVAL:
                return [
                    'msg_bn' => 'SUPT অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_RO_APPROVAL:
                return [
                    'msg_bn' => 'রাজস্ব কর্মকর্তার অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_RO_APPROVAL:
                return [
                    'msg_bn' => 'রাজস্ব কর্মকর্তা অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_INSPECTOR_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'পরিদর্শকের অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_INSPECTOR_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'পরিদর্শক অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_LICENSE_RENEWAL_FEE_PAYMENT:
                return [
                    'msg_bn' => 'লাইসেন্স ফি পরিশোধের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'লাইসেন্স ফি যাচাই করার জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::PENDING_SUPT_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'SUPT অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_SUPT_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'SUPT অনুমোদন প্রত্যাখ্যান',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_RO_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'রাজস্ব কর্মকর্তার অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_RO_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'রাজস্ব কর্মকর্তার অনুমোদন প্রত্যাখ্যান',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::ISSUED:
                return [
                    'msg_bn' => 'লাইসেন্স প্রদান করা হয়েছে',
                    'msg_en' => '',
                    'theme' => 'success',
                    'icon' => 'fa-memo-circle-check'
                ];
                break;
            case self::RENEWED:
                return [
                    'msg_bn' => 'পুনর্নবীকরণ করা হয়েছে',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::CANCELLED:
                return [
                    'msg_bn' => 'বাতিল করা হয়েছে',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::EXPIRED:
                return [
                    'msg_bn' => 'মেয়াদ উত্তীর্ণ হয়েছে',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            default:
                return $status;
                break;
        }
    }

    public static function resizeImage($inputFileName = 'image', $width = 300, $applyCrop = true) {
        // Get the uploaded file
        $uploadedFile = request()->file($inputFileName);

        // Load the uploaded image
        $originalImage = imagecreatefromstring(file_get_contents($uploadedFile->getPathname()));

        // Get the original image dimensions
        $originalWidth = imagesx($originalImage);
        $originalHeight = imagesy($originalImage);

        if($applyCrop){
            $minDimension = min($originalWidth, $originalHeight);
    
            // Calculate the new dimensions for the square image
            $newWidth = $newHeight = $width;

            // Calculate the cropping coordinates
            $cropX = ($originalWidth - $minDimension) / 2;
            $cropY = 0; // Top the cropping area

            // Create a new blank image with the new dimensions (Cropped to square)
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Crop and resize the original image to fit the new dimensions
            imagecopyresampled(
                $resizedImage, // Destination image resource
                $originalImage, // Source image resource
                0, // Destination x-coordinate
                0, // Destination y-coordinate
                $cropX, // Source x-coordinate (cropping)
                $cropY, // Source y-coordinate (cropping)
                $newWidth, // Destination width
                $newHeight, // Destination height
                $minDimension, // Source width (cropping)
                $minDimension // Source height (cropping)
            );
        }else {
            $aspectRatio = $originalWidth / $originalHeight;
            $newWidth = $width;
            $newHeight = $width / $aspectRatio;

            // Create a new blank image with the new dimensions (Cropped to square)
            $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

            // Crop and resize the original image to fit the new dimensions
            imagecopyresampled(
                $resizedImage, // Destination image resource
                $originalImage, // Source image resource
                0, // Destination x-coordinate
                0, // Destination y-coordinate
                0, // Source x-coordinate (cropping)
                0, // Source y-coordinate (cropping)
                $newWidth, // Destination width
                $newHeight, // Destination height
                $originalWidth, // Source width (cropping)
                $originalHeight // Source height (cropping)
            );
        }

        // Save the resized image to a new file
        $resizedImagePath = $uploadedFile->store('images', 'public');
        imagejpeg($resizedImage, storage_path('app/public/' . $resizedImagePath));

        // Free up memory by destroying the image resources
        imagedestroy($originalImage);
        imagedestroy($resizedImage);

        return storage_path('app/public/' . $resizedImagePath);
    }
}
