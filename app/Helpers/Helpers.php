<?php

namespace App\Helpers;

use Carbon\Carbon;

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
            '1' => [
                'কাউনিয়া',
                'পশ্চিম বিসিক রোড',
                'পশ্চিম কাউনিয়া',
                'পশ্চিম কাউনিয়া মেইন রোড',
                'পূর্ব পশ্চিম কাউনিয়া জাংশন রোড',
                'পূর্ব উত্তর কাউনিয়া প্রথম লেন',
                'উত্তর কাউনিয়া',
                'উত্তর কাউনিয়া প্রথম লেন',
            ],
            '2' => [
                'কাউনিয়া',
                'কাউনিয়া প্রথম লেন',
                'কাউনিয়া ক্লাব রোড',
                'কাউনিয়া মেইন রোড দক্ষিণ',
                'কাউনিয়া মনসাবাড়ী গলি',
                'পশ্চিম কাউনিয়া ব্রাঞ্চ রোড',
                'পূর্ব বিসিক রোড',
                'পূর্ব-পশ্চিম কাউনিয়া জংশন রোড',
                'উত্তর কাউনিয়া মেইনরোড',
            ],
            '3' => [
                'পুরানপাড়া',
                'পুরানপাড়া সিটি ওয়ার্ড',
                'গাউয়াসার',
                'মতাসার',
            ],
            '4' => [
                'আমানতগঞ্জ',
                'ভাটিখানা চৌধুরী সড়ক',
                'ভাটিখানা সড়ক',
                'ভাটিখানা সড়ক-২',
                'ভাটিখানা উত্তর পূর্ব-১',
                'ভাটিখানা উত্তর পূর্ব-২',
                'ভাটিখানা উত্তর পূর্ব-৩',
                'পূর্ব টাউন স্কুল',
                'স্ব রোড নতুন বাকলা',
                'উত্তর আমানতগঞ্জ রোকেয়া আজিম রোড',
                'উত্তর আমানতগঞ্জ উত্তর',
                'উলানঘুনি',
                'উলানঘুনি সিটি',
            ],
            '5' => [
                'আমানতগঞ্জ',
                'চর উপেন দক্ষিণ পলাশপুর',
                'চর উপেন উত্তর পলাশপুর',
                'চর বদনা',
                'চর বদনা সিটি',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-১',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-২',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-৩',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-৪',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-৫',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-৬',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-৭',
                'চর উপেন পলাশপুর গুচ্ছগ্রাম-৮',
                'পলাশপুর ডকইয়ার্ড',
                'পলাশপুর মঠবাড়ি',
                'পলাশপুর রোড-৭',
            ],
            '6' => [
                'আমানতগঞ্জ',
                'চর হাটখোলা',
                'দপ্তরখানা',
                '৬ নং জালেরখাল',
                'এনায়েত উল্লা স্কুল এলাকা',
                'গগনগলি',
                'হযরত মাওলানা ইয়াছিন সড়ক',
                'মরিচপট্টি',
                'পীরসাহেব সড়ক',
                'পুরান হাটখোলা',
                'পূর্ব হাটখোলাচর এলাকা',
                'পূর্ব পুরান কয়লাঘাট',
                'শায়েস্তাবাদ সড়ক পাওয়ার হাউজ',
                'উত্তর আমানতগঞ্জ পূর্ব জালেরখাল',
                'হাটখোলা',
            ],
            '7' => [
                'কাউনিয়া',
                'বর্মণ রোড',
                'পশ্চিম ভাটিখানা সড়ক',
                'পূর্ব কাউনিয়া ব্রাঞ্চ রোড',
                'উত্তর কাউনিয়া',
            ],
            '8' => [
                'আমানতগঞ্জ',
                'উত্তর কাটপট্টি',
                'পূর্ব ইটখোলা',
                'বাজার রোড',
                'জেলখানা',
                'পশ্চিম দপ্তরখানা',
                'পশ্চিম পুরাতন কয়লাঘাট',
                'স্ব রোড দক্ষিণ',
                'উত্তর লাইন রোড',
            ],
            '9' => [
                'বগুড়া আলেকান্দা (অংশ)',
                'গীর্জা মহল্লা',
                'কাটপট্টি দক্ষিণ',
                'পূর্ব সদর রোড',
                'উত্তর চকবাজার',
                'বরিশাল',
                'দক্ষিণ পূর্ব চক বাজার',
                'এনায়েতুর রহমান সড়ক',
                'ফড়িয়াপট্টি',
                'পদ্মাবতী',
                'উত্তর চকবাজার',
                'পোর্টরোড/বাঁধরোড',
                'চর বদনা',
                'রসুলপুর',
            ],
            '10' => [
                'বগুড়া আলেকান্দা',
                'বেলসপার্ক',
                'খেয়াঘাট',
                'রাজাবাহাদুর সড়ক',
                'চকবাজার',
                'পোর্টরোড',
                'ক্লাব রোড',
                'দক্ষিণ পূর্ব সদর রোড',
                'জব্বার মিয়ার গলি',
                'জর্ডন রোড',
                'পিডব্লিউডি ষ্টাফ কোয়ার্টার',
                'টিএন্ডটি কলোনি',
                'ফজলুল হক এভিনিউ',
            ],
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

    public static function getImageUrl($model, $collection = 'default', $conversion = 'default', $defaultImgDir = 'default')
    {
        if ($model && $model->getFirstMedia($collection)) {
            return str_replace('localhost', 'localhost:'.env('LOCAL_PORT'), $model->getFirstMediaUrl($collection, $conversion));
        }
        return asset('storage/'.$defaultImgDir.'/default.png');
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
    const DENIED_FORM_FEE_VERIFICATION = 'denied_form_fee_verification';

    const PENDING_ASSISTANT_APPROVAL = 'pending_assistant_approval';
    const DENIED_ASSISTANT_APPROVAL = 'denied_assistant_approval';

    const PENDING_INSPECTOR_APPROVAL = 'pending_inspector_approval';
    const DENIED_INSPECTOR_APPROVAL = 'denied_inspector_approval';

    const PENDING_LICENSE_FEE_PAYMENT = 'pending_license_fee_payment';
    const PENDING_LICENSE_FEE_VERIFICATION = 'pending_license_fee_verification';
    const DENIED_LICENSE_FEE_VERIFICATION = 'denied_license_fee_verification';

    const PENDING_SUPT_APPROVAL = 'pending_supt_approval';
    const DENIED_SUPT_APPROVAL = 'denied_supt_approval';

    const PENDING_RO_APPROVAL = 'pending_ro_approval';
    const DENIED_RO_APPROVAL = 'denied_ro_approval';

    const PENDING_CRO_APPROVAL = 'pending_cro_approval';
    const DENIED_CRO_APPROVAL = 'denied_cro_approval';

    const PENDING_CEO_APPROVAL = 'pending_ceo_approval';
    const DENIED_CEO_APPROVAL = 'denied_ceo_approval';

    const ISSUED = 'issued';
    const EXPIRED = 'expired';

    // Renewal status

    const PENDING_ASSISTANT_RENEWAL_APPROVAL = 'pending_assistant_renewal_approval';
    const DENIED_ASSISTANT_RENEWAL_APPROVAL = 'denied_assistant_renewal_approval';

    const PENDING_INSPECTOR_RENEWAL_APPROVAL = 'pending_inspector_renewal_approval';
    const DENIED_INSPECTOR_RENEWAL_APPROVAL = 'denied_inspector_renewal_approval';

    const PENDING_LICENSE_RENEWAL_FEE_PAYMENT = 'pending_license_renewal_fee_payment';
    const PENDING_LICENSE_RENEWAL_FEE_VERIFICATION = 'pending_license_renewal_fee_verification';
    const DENIED_LICENSE_RENEWAL_FEE_VERIFICATION = 'denied_license_renewal_fee_verification';

    const PENDING_SUPT_RENEWAL_APPROVAL = 'pending_supt_renewal_approval';
    const DENIED_SUPT_RENEWAL_APPROVAL = 'denied_supt_renewal_approval';

    const PENDING_RO_RENEWAL_APPROVAL = 'pending_ro_renewal_approval';
    const DENIED_RO_RENEWAL_APPROVAL = 'denied_ro_renewal_approval';

    const RENEWED = 'renewed';
    const CANCELLED = 'cancelled';


    // Amendment status
    const PENDING_AMENDMENT_FEE_PAYMENT = 'pending_amendment_fee_payment';
    const PENDING_AMENDMENT_FEE_VERIFICATION = 'pending_amendment_fee_verification';
    const DENIED_AMENDMENT_FEE_VERIFICATION = 'denied_amendment_fee_verification';
    const PENDING_AMENDMENT_APPROVAL = 'pending_amendment_approval';
    const DENIED_AMENDMENT_APPROVAL = 'denied_amendment_approval';
    
    // Amendment activities
    const RELOCATION_AMENDMENT_CREATED = 'relocation amendment created';
    const OWNERSHIP_TRANSFER_AMENDMENT_CREATED = 'ownership transfer amendment created';
    const AMENDMENT_FEE_SUBMITTED = 'amendment fee submitted';
    const AMENDMENT_FEE_DENIED = 'amendment fee denied';
    const AMENDMENT_FEE_RESUBMITTED = 'amendment fee resubmitted';
    const AMENDMENT_FEE_VERIFIED = 'amendment fee verified';
    const AMENDMENT_DENIED = 'amendment denied';
    const AMENDMENT_RESUBMITTED = 'amendment resubmitted';
    const AMENDMENT_APPROVED = 'amendment approved';

    const AMENDMENT_STATUS_ACTIVITY_MAP = [
        [ self::PENDING_AMENDMENT_FEE_PAYMENT, self::PENDING_AMENDMENT_FEE_VERIFICATION, self::AMENDMENT_FEE_SUBMITTED],
        [ self::PENDING_AMENDMENT_FEE_VERIFICATION, self::DENIED_AMENDMENT_FEE_VERIFICATION, self::AMENDMENT_FEE_DENIED],
        [ self::DENIED_AMENDMENT_FEE_VERIFICATION, self::PENDING_AMENDMENT_FEE_VERIFICATION, self::AMENDMENT_FEE_RESUBMITTED],
        [ self::PENDING_AMENDMENT_FEE_VERIFICATION, self::PENDING_AMENDMENT_APPROVAL, self::AMENDMENT_FEE_VERIFIED],
        [ self::PENDING_AMENDMENT_APPROVAL, self::DENIED_AMENDMENT_APPROVAL, self::AMENDMENT_DENIED],
        [ self::DENIED_AMENDMENT_APPROVAL, self::PENDING_AMENDMENT_APPROVAL, self::AMENDMENT_RESUBMITTED],
        [ self::PENDING_AMENDMENT_APPROVAL, self::AMENDMENT_APPROVED, self::AMENDMENT_APPROVED],
    ];

    public static function getAmendmentActivity($prev, $current) {
        foreach (self::AMENDMENT_STATUS_ACTIVITY_MAP as $map) {
            [$prevStatus, $currentStatus, $activity] = $map;
            if ($prev === $prevStatus && $current === $currentStatus) {
                return $activity;
            }
        }
        return self::UNKNOWN_ACTIVITY;
    }

    //Activity
    const DENIED_STATES = [
        self::PENDING_FORM_FEE_VERIFICATION => self::DENIED_FORM_FEE_VERIFICATION,
        self::PENDING_ASSISTANT_APPROVAL => self::DENIED_ASSISTANT_APPROVAL,
        self::PENDING_INSPECTOR_APPROVAL => self::DENIED_INSPECTOR_APPROVAL,
        self::PENDING_LICENSE_FEE_VERIFICATION => self::DENIED_LICENSE_FEE_VERIFICATION,
        self::PENDING_SUPT_APPROVAL => self::DENIED_SUPT_APPROVAL,
        self::PENDING_RO_APPROVAL => self::DENIED_RO_APPROVAL,
        self::PENDING_CRO_APPROVAL => self::DENIED_CRO_APPROVAL,
        self::PENDING_CEO_APPROVAL => self::DENIED_CEO_APPROVAL,

        //! Renewal
        self::PENDING_ASSISTANT_RENEWAL_APPROVAL => self::DENIED_ASSISTANT_RENEWAL_APPROVAL,
        self::PENDING_INSPECTOR_RENEWAL_APPROVAL => self::DENIED_INSPECTOR_RENEWAL_APPROVAL,
        self::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION => self::DENIED_LICENSE_RENEWAL_FEE_VERIFICATION,
        self::PENDING_SUPT_RENEWAL_APPROVAL => self::DENIED_SUPT_RENEWAL_APPROVAL,
        self::PENDING_RO_RENEWAL_APPROVAL => self::DENIED_RO_RENEWAL_APPROVAL,
    ];

    const APPROVED_STATES = [
        self::PENDING_FORM_FEE_VERIFICATION => self::PENDING_ASSISTANT_APPROVAL,
        self::PENDING_ASSISTANT_APPROVAL => self::PENDING_INSPECTOR_APPROVAL,
        self::PENDING_INSPECTOR_APPROVAL => self::PENDING_LICENSE_FEE_PAYMENT,
        self::PENDING_LICENSE_FEE_VERIFICATION => self::PENDING_SUPT_APPROVAL,
        self::PENDING_SUPT_APPROVAL => self::PENDING_RO_APPROVAL,
        self::PENDING_RO_APPROVAL => self::PENDING_CRO_APPROVAL,
        self::PENDING_CRO_APPROVAL => self::PENDING_CEO_APPROVAL,
        self::PENDING_CEO_APPROVAL => self::ISSUED,

        //! Renewal
        self::PENDING_ASSISTANT_RENEWAL_APPROVAL => self::PENDING_INSPECTOR_RENEWAL_APPROVAL,
        self::PENDING_INSPECTOR_RENEWAL_APPROVAL => self::PENDING_LICENSE_RENEWAL_FEE_PAYMENT,
        self::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION => self::PENDING_SUPT_RENEWAL_APPROVAL,
        self::PENDING_SUPT_RENEWAL_APPROVAL => self::PENDING_RO_RENEWAL_APPROVAL,
        self::PENDING_RO_RENEWAL_APPROVAL => self::RENEWED,
    ];

    const CORRECTED_STATES = [
        self::DENIED_FORM_FEE_VERIFICATION => self::PENDING_FORM_FEE_VERIFICATION,
        self::DENIED_ASSISTANT_APPROVAL => self::PENDING_ASSISTANT_APPROVAL,
        self::DENIED_INSPECTOR_APPROVAL => self::PENDING_INSPECTOR_APPROVAL,
        self::DENIED_LICENSE_FEE_VERIFICATION => self::PENDING_LICENSE_FEE_VERIFICATION,
        self::DENIED_SUPT_APPROVAL => self::PENDING_SUPT_APPROVAL,
        self::DENIED_RO_APPROVAL => self::PENDING_RO_APPROVAL,
        self::DENIED_CRO_APPROVAL => self::PENDING_CRO_APPROVAL,
        self::DENIED_CEO_APPROVAL => self::PENDING_CEO_APPROVAL,

        //! Renewal
        self::DENIED_ASSISTANT_RENEWAL_APPROVAL => self::PENDING_ASSISTANT_RENEWAL_APPROVAL,
        self::DENIED_INSPECTOR_RENEWAL_APPROVAL => self::PENDING_INSPECTOR_RENEWAL_APPROVAL,
        self::DENIED_LICENSE_RENEWAL_FEE_VERIFICATION => self::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION,
        self::DENIED_SUPT_RENEWAL_APPROVAL => self::PENDING_SUPT_RENEWAL_APPROVAL,
        self::DENIED_RO_RENEWAL_APPROVAL => self::PENDING_RO_RENEWAL_APPROVAL,
    ];

    //Activity
    const FORM_CREATED = 'form created';
    const FORM_FEE_SUBMITTED = 'form fee submitted';
    const FORM_FEE_RESUBMITTED = 'form fee resubmitted';
    const FORM_FEE_REJECTED = 'form fee rejected';
    const FORM_FEE_VERIFIED = 'form fee verified';
    const ASSISTANT_REJECTED = 'assistant rejected';
    const USER_CORRECTION = 'user correction';
    const ASSISTANT_APPROVED = 'assistant approved';
    const INSPECTOR_REJECTED = 'inspector rejected';
    const INSPECTOR_APPROVED = 'inspector approved';
    const LICENSE_FEE_SUBMITTED = 'license fee submitted';
    const LICENSE_FEE_RESUBMITTED = 'license fee resubmitted';
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
    const LICENSE_ISSUED = 'license issued';
    const LICENSE_EXPIRED = 'license expired';
    
    //! Renewal
    const RENEWAL_REQUESTED = 'renewal requested';
    const ASSISTANT_RENEWAL_REJECTED = 'assistant renewal rejected';
    const ASSISTANT_RENEWAL_APPROVED = 'assistant renewal approved';
    const INSPECTOR_RENEWAL_REJECTED = 'inspector renewal rejected';
    const INSPECTOR_RENEWAL_APPROVED = 'inspector renewal approved';
    const LICENSE_RENEWAL_FEE_SUBMITTED = 'license renewal fee submitted';
    const LICENSE_RENEWAL_FEE_RESUBMITTED = 'license renewal fee resubmitted';
    const LICENSE_RENEWAL_FEE_REJECTED = 'license renewal fee rejected';
    const LICENSE_RENEWAL_FEE_VERIFIED = 'license renewal fee verified';
    const SUPT_RENEWAL_REJECTED = 'supt renewal rejected';
    const SUPT_RENEWAL_APPROVED = 'supt renewal approved';
    const RO_RENEWAL_REJECTED = 'ro renewal rejected';
    const RO_RENEWAL_APPROVED = 'ro renewal approved';
    const LICENSE_RENEWED = 'license renewed';

    const UNKNOWN_ACTIVITY = 'unknown activity';

    //Payment Types
    const FORM_FEE = 'form fee';
    const LICENSE_FEE = 'license fee';
    const AMENDMENT_FEE = 'amendment fee';
    const LICENSE_RENEWAL_FEE = 'license renewal fee';
    const LICENSE_AMENDMENT_FEE = 'license amendment fee';


    // Amendment Types
    const AMENDMENT_TYPE_RELOCATION = 'relocation';
    const AMENDMENT_TYPE_TRANSFER_OWNERSHIP = 'transfer ownership';

    //payment Methods
    const BANK_PAYMENT = 'bank payment';
    const ONLINE_PAYMENT = 'online payment';

    // 

    public static function needsApplicationCorrection($status): bool {
        return in_array($status, [
            self::DENIED_ASSISTANT_APPROVAL,
            self::DENIED_INSPECTOR_APPROVAL,
            self::DENIED_SUPT_APPROVAL,
            self::DENIED_RO_APPROVAL,
            self::DENIED_CRO_APPROVAL,
            self::DENIED_CEO_APPROVAL,

            //! Renewal
            self::DENIED_ASSISTANT_RENEWAL_APPROVAL,
            self::DENIED_INSPECTOR_RENEWAL_APPROVAL,
            self::DENIED_SUPT_RENEWAL_APPROVAL,
            self::DENIED_RO_RENEWAL_APPROVAL,
        ]);
    }

    public static function formatTableField($field, $lan='bn'){
        $attrMap = [
            'name_bn' => 'মালিকের নাম (বাংলা)',
            'name' => 'মালিকের নাম (ইংরেজি)',
            'father_name_bn' => 'পিতার নাম (বাংলা)',
            'father_name' => 'পিতার নাম (ইংরেজি)',
            'mother_name_bn' => 'মাতার নাম (বাংলা)',
            'mother_name' => 'মাতার নাম (ইংরেজি)',
            'spouse_name_bn' => 'স্বামী/স্ত্রীর নাম (বাংলা)',
            'spouse_name' => 'স্বামী/স্ত্রীর নাম (ইংরেজি)',
            'national_id_no' => 'জাতীয় পরিচয়পত্র নং',
            'birth_registration_no' => 'জন্ম নিবন্ধন নং',
            'passport_no' => 'পাসপোর্ট নং',
            'business_organization_name_bn' => 'প্রতিষ্ঠানের নাম (বাংলা)',
            'business_organization_name' => 'প্রতিষ্ঠানের নাম (ইংরেজি)',
            'nature_of_business_bn' => 'ব্যবসার প্রকৃতি (বাংলা)',
            'business_category_id' => 'ব্যবসার ধরণ (বাংলা)',
            'address_of_business_organization_bn' => 'প্রতিষ্ঠানের ঠিকানা (বাংলা)',
            'address_of_business_organization' => 'প্রতিষ্ঠানের ঠিকানা (ইংরেজি)',
            'zone_bn' => 'এলাকা',
            'ward_no' => 'ওয়ার্ড নং',
            'tin_no' => 'টিন নং',
            'bin_no' => 'বিআইএন নং',
            'phone_no' => 'ফোন নং',
            'email' => 'ইমেইল',
            'fiscal_year' => 'অর্থবছর',
            'business_starting_date' => 'ব্যবসা শুরুর তারিখ',
            'ca_holding_no' => 'স্থায়ী ঠিকানা হোল্ডিং নং',
            'ca_road_no' => 'স্থায়ী ঠিকানা রোড নং',
            'ca_post_code' => 'স্থায়ী ঠিকানা পোস্ট কোড',
            'ca_village_bn' => 'স্থায়ী ঠিকানা গ্রাম (বাংলা)',
            'ca_village' => 'স্থায়ী ঠিকানা গ্রাম (ইংরেজি)',
            'ca_post_office_bn' => 'স্থায়ী ঠিকানা পোস্ট অফিস (বাংলা)',
            'ca_post_office' => 'স্থায়ী ঠিকানা পোস্ট অফিস (ইংরেজি)',
            'ca_division_bn' => 'স্থায়ী ঠিকানা বিভাগ (বাংলা)',
            'ca_district_bn' => 'স্থায়ী ঠিকানা জেলা (বাংলা)',
            'ca_upazilla_bn' => 'স্থায়ী ঠিকানা উপজেলা (বাংলা)',
            'ca_upazilla' => 'স্থায়ী ঠিকানা উপজেলা (ইংরেজি)',
            'pa_holding_no' => 'বর্তমান ঠিকানা হোল্ডিং নং',
            'pa_road_no' => 'বর্তমান ঠিকানা রোড নং',
            'pa_post_code' => 'বর্তমান ঠিকানা পোস্ট কোড',
            'pa_village_bn' => 'বর্তমান ঠিকানা গ্রাম (বাংলা)',
            'pa_village' => 'বর্তমান ঠিকানা গ্রাম (ইংরেজি)',
            'pa_post_office_bn' => 'বর্তমান ঠিকানা পোস্ট অফিস (বাংলা)',
            'pa_post_office' => 'বর্তমান ঠিকানা পোস্ট অফিস (ইংরেজি)',
            'pa_division_bn' => 'বর্তমান ঠিকানা বিভাগ (বাংলা)',
            'pa_district_bn' => 'বর্তমান ঠিকানা জেলা (বাংলা)',
            'pa_upazilla_bn' => 'বর্তমান ঠিকানা উপজেলা (বাংলা)',
            'pa_upazilla' => 'বর্তমান ঠিকানা উপজেলা (ইংরেজি)',
        ];

        if($lan == 'bn'){
            return $attrMap[$field];
        }else{
            return ucwords(str_replace('_', ' ', $field));
        }
    }

    public static function convertTlStatusToBangla($status){
        switch ($status) {
            case self::PENDING_FORM_FEE_PAYMENT:
                return [
                    'msg_bn' => 'ফর্ম ফি পরিশোধ করুন',
                    'msg_en' => '',
                    'theme' => 'primary',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::PENDING_FORM_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'ফর্ম ফি যাচাই করার জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::DENIED_FORM_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'ফর্ম ফি প্রত্যাখ্যান করা হয়েছে। <br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::PENDING_ASSISTANT_APPROVAL:
                return [
                    'msg_bn' => 'সহকারী কর্মকর্তার অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
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
                    'theme' => 'warning',
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
                    'theme' => 'primary',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::PENDING_LICENSE_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'লাইসেন্স ফি যাচাইয়ের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::DENIED_LICENSE_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'লাইসেন্স ফি প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::PENDING_SUPT_APPROVAL:
                return [
                    'msg_bn' => 'SUPT অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
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
                    'theme' => 'warning',
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
            case self::PENDING_CRO_APPROVAL:
                return [
                    'msg_bn' => 'CRO অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_CRO_APPROVAL:
                return [
                    'msg_bn' => 'CRO অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_CEO_APPROVAL:
                return [
                    'msg_bn' => 'CEO অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_CEO_APPROVAL:
                return [
                    'msg_bn' => 'CEO অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_INSPECTOR_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'পরিদর্শকের অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
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
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
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
                    'theme' => 'danger',
                    'icon' => 'fa-clock'
                ];
                break;
            
            //! Renewals
            case self::PENDING_ASSISTANT_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'সহকারী কর্মকর্তার নবায়ন অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_ASSISTANT_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'সহকারী কর্মকর্তা নবায়ন অনুমোদন প্রত্যাখ্যান করেছে<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_INSPECTOR_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'পরিদর্শকের নবায়ন অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_INSPECTOR_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'পরিদর্শক নবায়ন অনুমোদন প্রত্যাখ্যান করেছে<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_LICENSE_RENEWAL_FEE_PAYMENT:
                return [
                    'msg_bn' => 'লাইসেন্স নবায়ন ফি পরিশোধের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::PENDING_LICENSE_RENEWAL_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'নবায়ন ফি যাচাইয়ের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_LICENSE_RENEWAL_FEE_VERIFICATION:
                return [
                    'msg_bn' => 'নবায়ন ফি প্রত্যাখ্যান করা হয়েছে<br>পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_SUPT_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'SUPT নবায়ন অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_SUPT_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'SUPT নবায়ন অনুমোদন প্রত্যাখ্যান করেছেন<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            case self::PENDING_RO_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'রাজস্ব কর্মকর্তার নবায়ন অনুমোদনের জন্য অপেক্ষমাণ',
                    'msg_en' => '',
                    'theme' => 'warning',
                    'icon' => 'fa-clock'
                ];
                break;
            case self::DENIED_RO_RENEWAL_APPROVAL:
                return [
                    'msg_bn' => 'রাজস্ব কর্মকর্তা নবায়ন অনুমোদন প্রত্যাখ্যান করেছে<br>সংশোধন করে পুনরায় প্রেরণ করুন',
                    'msg_en' => '',
                    'theme' => 'danger',
                    'icon' => 'fa-exclamation-triangle'
                ];
                break;
            default:
                return [
                    'msg_bn' => 'অজানা অবস্থা',
                    'msg_en' => '',
                    'theme' => 'info',
                    'icon' => 'fa-question-circle'
                ];
                break;
        }
    }

    public static function convertAmendmentStatusToBangla($status){
        switch ($status) {
            case self::PENDING_AMENDMENT_FEE_PAYMENT:
                return [
                    'msg_bn_applicant' => 'সংশোধন ফি প্রদান করুন',
                    'msg_en_applicant' => 'Please pay the amendment fee',
                    'msg_bn_admin' => 'সংশোধন ফি প্রদান করা হয়নি',
                    'msg_en_admin' => 'Amendment fee not paid',
                    'theme' => 'danger',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::PENDING_AMENDMENT_FEE_VERIFICATION:
                return [
                    'msg_bn_applicant' => 'সংশোধন ফি যাচাই করা হচ্ছে',
                    'msg_en_applicant' => 'Amendment fee is being verified',
                    'msg_bn_admin' => 'সংশোধন ফি যাচাই করুন',
                    'msg_en_admin' => 'Please verify the amendment fee',
                    'theme' => 'info',
                    'icon' => 'fa-bangladeshi-taka-sign'
                ];
                break;
            case self::DENIED_AMENDMENT_FEE_VERIFICATION:
                return [
                    'msg_bn_applicant' => 'সংশোধন ফি পুনরায় প্রেরণ করুন',
                    'msg_en_applicant' => 'Please resubmit the amendment fee',
                    'msg_bn_admin' => 'সংশোধন ফি যাচাই করা হয়নি',
                    'msg_en_admin' => 'Amendment fee not verified',
                    'theme' => 'danger',
                    'icon' => 'fa-times-circle'
                ];
                break;
            case self::PENDING_AMENDMENT_APPROVAL:
                return [
                    'msg_bn_applicant' => 'সংশোধন যাচাই করা হচ্ছে',
                    'msg_en_applicant' => 'Amendment is being verified',
                    'msg_bn_admin' => 'সংশোধন যাচাই করুন',
                    'msg_en_admin' => 'Please verify the amendment',
                    'theme' => 'info',
                    'icon' => 'fa-file-search'
                ];
                break;
            case self::DENIED_AMENDMENT_APPROVAL:
                return [
                    'msg_bn_applicant' => 'সংশোধন পুনরায় প্রেরণ করুন',
                    'msg_en_applicant' => 'Please resubmit the amendment',
                    'msg_bn_admin' => 'সংশোধন যাচাই করা হয়নি',
                    'msg_en_admin' => 'Amendment not verified',
                    'theme' => 'danger',
                    'icon' => 'fa-times-circle'
                ];
                break;
            case self::AMENDMENT_APPROVED:
                return [
                    'msg_bn_applicant' => 'সংশোধন অনুমোদিত',
                    'msg_en_applicant' => 'Amendment approved',
                    'msg_bn_admin' => 'সংশোধন অনুমোদিত',
                    'msg_en_admin' => 'Amendment approved',
                    'theme' => 'success',
                    'icon' => 'fa-check-circle'
                ];
                break;
            default:
                return [
                    'msg_bn_applicant' => '',
                    'msg_en_applicant' => '',
                    'msg_bn_admin' => '',
                    'msg_en_admin' => '',
                    'theme' => 'success',
                    'icon' => 'fa-check-circle'
                ];
                break;
        }
    }

    public static function resizeImage($inputFileName = 'image', $width = 300, $applyCrop = true, $filters =  []) {
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

        if(count($filters) > 0){
            // Apply filters - Brightness
            if (array_key_exists('brightness', $filters)) {
                imagefilter($resizedImage, IMG_FILTER_BRIGHTNESS, $filters['brightness']);
            }

            // Apply filters - Contrast
            if (array_key_exists('contrast', $filters)) {
                imagefilter($resizedImage, IMG_FILTER_CONTRAST, $filters['contrast']);
            }

            // Apply filters - Grayscale
            if (array_key_exists('grayscale', $filters)) {
                imagefilter($resizedImage, IMG_FILTER_GRAYSCALE);
            }
        }

        // Free up memory by destroying the image resources
        imagedestroy($originalImage);
        imagedestroy($resizedImage);

        return storage_path('app/public/' . $resizedImagePath);
    }

    const STEPS_TO_COMPLETE_FORM_FEE_PAYMENT = [
        self::PENDING_FORM_FEE_PAYMENT,
        self::PENDING_FORM_FEE_VERIFICATION,
        self::DENIED_FORM_FEE_VERIFICATION,
    ];

    const STEPS_TO_COMPLETE_ASSISTANT_APPROVAL = [
        ...self::STEPS_TO_COMPLETE_FORM_FEE_PAYMENT,
        self::PENDING_ASSISTANT_APPROVAL,
        self::DENIED_ASSISTANT_APPROVAL,
    ];

    const STEPS_TO_COMPLETE_INSPECTOR_APPROVAL = [
        ...self::STEPS_TO_COMPLETE_ASSISTANT_APPROVAL,
        self::PENDING_INSPECTOR_APPROVAL,
        self::DENIED_INSPECTOR_APPROVAL,
    ];

    const STEPS_TO_COMPLETE_LICENSE_FEE_PAYMENT = [
        ...self::STEPS_TO_COMPLETE_INSPECTOR_APPROVAL,
        self::PENDING_LICENSE_FEE_PAYMENT,
        self::PENDING_LICENSE_FEE_VERIFICATION,
        self::DENIED_LICENSE_FEE_VERIFICATION,
    ];

    const STEPS_TO_COMPLETE_SUPT_APPROVAL = [
        ...self::STEPS_TO_COMPLETE_LICENSE_FEE_PAYMENT,
        self::PENDING_SUPT_APPROVAL,
        self::DENIED_SUPT_APPROVAL,
    ];

    const STEPS_TO_COMPLETE_RO_APPROVAL = [
        ...self::STEPS_TO_COMPLETE_SUPT_APPROVAL,
        self::PENDING_RO_APPROVAL,
        self::DENIED_RO_APPROVAL,
    ];

    const STEPS_TO_COMPLETE_CRO_APPROVAL = [
        ...self::STEPS_TO_COMPLETE_RO_APPROVAL,
        self::PENDING_CRO_APPROVAL,
        self::DENIED_CRO_APPROVAL,
    ];

    const STEPS_TO_COMPLETE_CEO_APPROVAL = [
        ...self::STEPS_TO_COMPLETE_CRO_APPROVAL,
        self::PENDING_CEO_APPROVAL,
        self::DENIED_CEO_APPROVAL,
    ];

    public static function hasCompletedFormFeePayment($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_FORM_FEE_PAYMENT));
    }

    public static function hasAssistantApproval($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_ASSISTANT_APPROVAL));
    }

    public static function hasInspectorApproval($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_INSPECTOR_APPROVAL));
    }

    public static function hasCompletedLicenseFeePayment($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_LICENSE_FEE_PAYMENT));
    }

    public static function hasSuptApproval($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_SUPT_APPROVAL));
    }

    public static function hasROApproval($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_RO_APPROVAL));
    }

    public static function hasCROApproval($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_CRO_APPROVAL));
    }

    public static function hasCEOApproval($status): bool {
        return !(in_array($status, self::STEPS_TO_COMPLETE_CEO_APPROVAL));
    }

    //form fee
    const TRADE_LICENSE_FORM_FEE = 200.00;
    const TRADE_LICENSE_AMENDMENT_FEE = 500.00;

    //license fee
    const SURCHARGE = 100.00;
    const INCOME_TAX_PERCENTAGE = 3.00;
    const VAT_PERCENTAGE = 15.00;
    const SURCHARGE_PERCENTAGE = 2.00;
    

    public static function numToBanglaWords($number): string {
        $number = (int) $number;

        if($number == 0){
            return '';
        }

        if($number < 0){
            return 'ঋণাত্মক সংখ্যা';
        }

        $multiplier = [
            "", "শত", "হাজার", "লক্ষ", "কোটি"
        ];

        $numbersTo99 = [
            0 => '',
            1 => 'এক',
            2 => 'দুই',
            3 => 'তিন',  
            4 => 'চার',
            5 => 'পাঁচ',
            6 => 'ছয়',
            7 => 'সাত',
            8 => 'আট',
            9 => 'নয়',
            10 => 'দশ',
            11 => 'এগারো',
            12 => 'বারো',
            13 => 'তেরো',
            14 => 'চৌদ্দ',
            15 => 'পনেরো',
            16 => 'ষোল',
            17 => 'সতেরো',
            18 => 'আঠারো',
            19 => 'ঊনিশ',
            20 => 'বিশ',
            21 => 'একুশ',
            22 => 'বাইশ',
            23 => 'তেইশ',
            24 => 'চব্বিশ',
            25 => 'পঁচিশ',
            26 => 'ছাব্বিশ',
            27 => 'সাতাশ',
            28 => 'আটাশ',
            29 => 'ঊনত্রিশ',
            30 => 'ত্রিশ',
            31 => 'একত্রিশ',
            32 => 'বত্রিশ',
            33 => 'তেত্রিশ',
            34 => 'চৌত্রিশ',
            35 => 'পঁয়ত্রিশ',
            36 => 'ছত্রিশ',
            37 => 'সাঁইত্রিশ',
            38 => 'আটত্রিশ',
            39 => 'ঊনচল্লিশ',
            40 => 'চল্লিশ',
            41 => 'একচল্লিশ',
            42 => 'বিয়াল্লিশ',
            43 => 'তেতাল্লিশ',
            44 => 'চুয়াল্লিশ',
            45 => 'পঁয়তাল্লিশ',
            46 => 'ছেচল্লিশ',
            47 => 'সাতচল্লিশ',
            48 => 'আটচল্লিশ',
            49 => 'ঊনপঞ্চাশ',
            50 => 'পঞ্চাশ',
            51 => 'একান্ন',
            52 => 'বায়ান্ন',
            53 => 'তিপ্পান্ন',
            54 => 'চুয়ান্ন',
            55 => 'পঞ্চান্ন',
            56 => 'ছাপ্পান্ন',
            57 => 'সাতান্ন',
            58 => 'আটান্ন',
            59 => 'ঊনষাট',
            60 => 'ষাট',
            61 => 'একষট্টি',
            62 => 'বাষট্টি',
            63 => 'তেষট্টি',
            64 => 'চৌষট্টি',
            65 => 'পঁয়ষট্টি',
            66 => 'ছেষট্টি',
            67 => 'সাতষট্টি',
            68 => 'আটষট্টি',
            69 => 'ঊনসত্তর',
            70 => 'সত্তর',
            71 => 'একাত্তর',
            72 => 'বাহাত্তর',
            73 => 'তিয়াত্তর',
            74 => 'চুয়াত্তর',
            75 => 'পঁচাত্তর',
            76 => 'ছিয়াত্তর',
            77 => 'সাতাত্তর',
            78 => 'আটাত্তর',
            79 => 'ঊনআশি',
            80 => 'আশি',
            81 => 'একাশি',
            82 => 'বিরাশি',
            83 => 'তিরাশি',
            84 => 'চুরাশি',
            85 => 'পঁচাশি',
            86 => 'ছিয়াশি',
            87 => 'সাতাশি',
            88 => 'আটাশি',
            89 => 'ঊননব্বই',
            90 => 'নব্বই',
            91 => 'একানব্বই',
            92 => 'বিরানব্বই',
            93 => 'তিরানব্বই',
            94 => 'চুরানব্বই',
            95 => 'পঁচানব্বই',
            96 => 'ছিয়ানব্বই',
            97 => 'সাতানব্বই',
            98 => 'আটানব্বই',
            99 => 'নিরানব্বই',
        ];

        //for 0 to 99
        if($number < 100){
            return $numbersTo99[$number];
        }

        //for 100 to 999
        if($number < 1000){
            $t = floor($number / 100);
            $r = $number % 100;
            return $numbersTo99[$t] . ' শত ' . self::numToBanglaWords($r);
        }

        //for 1000 to 99999
        if($number < 100000){
            $t = floor($number / 1000);
            $r = $number % 1000;
            return $numbersTo99[$t] . ' হাজার ' . self::numToBanglaWords($r);
        }

        //for 100000 to 9999999
        if($number < 10000000){
            $t = floor($number / 100000);
            $r = $number % 100000;
            return $numbersTo99[$t] . ' লক্ষ ' . self::numToBanglaWords($r);
        }

        //for 10000000 to 999999999
        if($number < 1000000000){
            $t = floor($number / 10000000);
            $r = $number % 10000000;
            return $numbersTo99[$t] . ' কোটি ' . self::numToBanglaWords($r);
        }


        //if number is too big split it into 2 parts and convert them separately
        $t = floor($number / 10000000);
        $r = $number % 10000000;
        return self::numToBanglaWords($t) . ' কোটি ' . self::numToBanglaWords($r);
    }

    public static function generateUuid($prefix = '', $split = true): string {
        $uuid = $prefix.bin2hex(random_bytes(8));
        return $split ? substr($uuid, 0, 4) . '-' . substr($uuid, 4, 4) . '-' . substr($uuid, 8, 4) . '-' . substr($uuid, 12, 4) : $uuid;
    }

    public static function getFiscalYear($date) {
        $date = new Carbon($date);
        $year = $date->year;
        $month = $date->month;
        
        return $month >= 7 ? $year+1 : $year;
    }
}
