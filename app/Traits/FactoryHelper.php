<?php
namespace App\Traits;

trait FactoryHelper
{
    protected static $banglaDivisions = [
        'ঢাকা', 'চট্টগ্রাম', 'খুলনা', 'বরিশাল', 'সিলেট', 'রাজশাহী', 'রংপুর', 'ময়মনসিংহ'
    ];

    protected static $englishDivisions = [
        'Dhaka', 'Chattogram', 'Khulna', 'Barishal', 'Sylhet', 'Rajshahi', 'Rangpur', 'Mymensingh'
    ];
    public static function banglaDivisionNameGenerator(){
        $divisionIndex = array_rand(self::$banglaDivisions);

        return [
            'bn' => self::$banglaDivisions[$divisionIndex],
            'en' => self::$englishDivisions[$divisionIndex]
        ];
    }


    protected static $banglaDistricts = [
        'ঢাকা' => ['ঢাকা', 'গাজীপুর', 'মাদারীপুর', 'মানিকগঞ্জ', 'মুন্সিগঞ্জ', 'নারায়ণগঞ্জ', 'নরসিংদী', 'রাজবাড়ী', 'শরীয়তপুর'],
        'চট্টগ্রাম' => ['চট্টগ্রাম', 'বান্দরবান', 'ব্রাহ্মণবাড়িয়া', 'চাঁদপুর', 'কুমিল্লা', 'কক্সবাজার', 'ফেনী', 'খাগড়াছড়ি', 'লক্ষ্মীপুর', 'নোয়াখালী', 'রাঙ্গামাটি'],
        'খুলনা' => ['খুলনা', 'বাগেরহাট', 'চুয়াডাঙ্গা', 'যশোর', 'ঝিনাইদহ', 'কুষ্টিয়া', 'মাগুরা', 'মেহেরপুর', 'নড়াইল', 'সাতক্ষীরা'],
        'বরিশাল' => ['বরিশাল', 'বরগুনা', 'ভোলা', 'ঝালকাঠি', 'পটুয়াখালী', 'পিরোজপুর'],
        'সিলেট' => ['সিলেট', 'হবিগঞ্জ', 'মৌলভীবাজার', 'সুনামগঞ্জ'],
        'রাজশাহী' => ['বগুড়া', 'জয়পুরহাট', 'নওগাঁ', 'নাটোর', 'পাবনা', 'রাজশাহী', 'সিরাজগঞ্জ'],
        'রংপুর' => ['দিনাজপুর', 'গাইবান্ধা', 'কুড়িগ্রাম', 'লালমনিরহাট', 'নীলফামারী', 'পঞ্চগড়', 'রংপুর', 'ঠাকুরগাঁও'],
        'ময়মনসিংহ' => ['জামালপুর', 'নেত্রকোনা', 'শেরপুর', 'ময়মনসিংহ']
    ];

    protected static $englishDistricts = [
        'ঢাকা' => ['Dhaka', 'Gazipur', 'Madaripur', 'Manikganj', 'Munshiganj', 'Narayanganj', 'Narsingdi', 'Rajbari', 'Shariatpur'],
        'চট্টগ্রাম' => ['Chattogram', 'Bandarban', 'Brahmanbaria', 'Chandpur', 'Cumilla', 'Cox\'s Bazar', 'Feni', 'Khagrachhari', 'Lakshmipur', 'Noakhali', 'Rangamati'],
        'খুলনা' => ['Khulna', 'Bagerhat', 'Chuadanga', 'Jessore', 'Jhenaidah', 'Kushtia', 'Magura', 'Meherpur', 'Narail', 'Satkhira'],
        'বরিশাল' => ['Barishal', 'Barguna', 'Bhola', 'Jhalokathi', 'Patuakhali', 'Pirojpur'],
        'সিলেট' => ['Sylhet', 'Habiganj', 'Moulvibazar', 'Sunamganj'],
        'রাজশাহী' => ['Bogura', 'Joypurhat', 'Naogaon', 'Natore', 'Pabna', 'Rajshahi', 'Sirajganj'],
        'রংপুর' => ['Dinajpur', 'Gaibandha', 'Kurigram', 'Lalmonirhat', 'Nilphamari', 'Panchagarh', 'Rangpur', 'Thakurgaon'],
        'ময়মনসিংহ' => ['Jamalpur', 'Netrokona', 'Sherpur', 'Mymensingh']
    ];

    public static function banglaDistrictNameGenerator($division){
        $districtIndex = array_rand(self::$banglaDistricts[$division]);

        return [
            'bn' => self::$banglaDistricts[$division][$districtIndex],
            'en' => self::$englishDistricts[$division][$districtIndex]
        ];
    }

    protected static $banglaUpazilas = [
        'আগৈলঝাড়া', 'বানারীপাড়া', 'বাকেরগঞ্জ', 'বাবুগঞ্জ', 'বরিশাল সদর', 'বেতাগী', 'বরগুনা সদর', 'বামনা', 'বরিশাল সদর', 'চরফ্যাশন',
        'দৌলতখান', 'দশমিনা', 'দুমকি', 'গলাচিপা', 'গৌরনদী', 'হিজলা', 'ইন্দুরকানি', 'ঝালকাঠি সদর', 'কাজিরহাট', 'কাউখালী',
        'লালমোহন', 'মেহেন্দিগঞ্জ', 'মনপুরা', 'মুলাদী', 'নাজিরপুর', 'নলছিটি', 'পাথরঘাটা', 'পটুয়াখালী সদর', 'পিরোজপুর সদর', 'রাজাপুর',
        'রাঙ্গাবালী', 'সদর', 'স্বরূপকাঠি', 'তালতলী', 'উজিরপুর', 'ভাণ্ডারিয়া', 'ভোলা সদর', 'বাউফল', 'বেতাগী', 'ভোলা সদর',
        'দশমিনা', 'মঠবাড়িয়া', 'তাজুমুদ্দিন', 'গলাচিপা', 'বেতাগী', 'কাউখালী', 'বরগুনা সদর', 'বরিশাল সদর', 'ঝালকাঠি সদর', 'কলাপাড়া',
        'ভোলা সদর', 'স্বরূপকাঠি', 'বানারীপাড়া', 'বাবুগঞ্জ', 'চরফ্যাশন', 'পটুয়াখালী সদর', 'বরগুনা সদর', 'বরিশাল সদর', 'ভোলা সদর', 'হিজলা',
        'পিরোজপুর সদর', 'কাউখালী', 'পাথরঘাটা', 'বেতাগী', 'উজির'
    ];
    
    protected static $englishUpazilas = [
        'Agailjhara', 'Banaripara', 'Bakerganj', 'Babuganj', 'Barishal Sadar', 'Betagi', 'Barguna Sadar', 'Bamna', 'Barishal Sadar', 'Char Fasson',
        'Daulat Khan', 'Dashmina', 'Dumki', 'Galachipa', 'Gournadi', 'Hizla', 'Indurkani', 'Jhalokathi Sadar', 'Kazirhat', 'Kaokhali',
        'Lalmohan', 'Mehendiganj', 'Monpura', 'Muladi', 'Nazirpur', 'Nolchiti', 'Patharghata', 'Patuakhali Sadar', 'Pirojpur Sadar', 'Rajapur',
        'Rangabali', 'Sadar', 'Swarupkathi', 'Taltali', 'Uzirpur', 'Vandaria', 'Bhola Sadar', 'Bauphal', 'Betagi', 'Bhola Sadar',
        'Dashmina', 'Mathbaria', 'Tazumuddin', 'Galachipa', 'Betagi', 'Kaokhali', 'Barguna Sadar', 'Barishal Sadar', 'Jhalokathi Sadar', 'Kolapara',
        'Bhola Sadar', 'Swarupkathi', 'Banaripara', 'Babuganj', 'Char Fasson', 'Patuakhali Sadar', 'Barguna Sadar', 'Barishal Sadar', 'Bhola Sadar', 'Hizla',
        'Pirojpur Sadar', 'Kaokhali', 'Patharghata', 'Betagi', 'Uzir'
    ];

    public static function banglaUpazillaNameGenerator(){
        $upazilaIndex = array_rand(self::$banglaUpazilas);

        return [
            'bn' => self::$banglaUpazilas[$upazilaIndex],
            'en' => self::$englishUpazilas[$upazilaIndex]
        ];
    }

    protected static $banglaVillageNames = [
        'আশুগঞ্জ', 'বাঁশখালী', 'বানারীপাড়া', 'বরিশাল', 'বেলাবো', 'বালিয়াকান্দি', 'বেনাপোল', 'বিভিন্ন', 'বড়লেখা', 'বকশীগঞ্জ',
        'চকরিয়া', 'চাঁদপুর', 'চাঁপাইনবাবগঞ্জ', 'চট্টগ্রাম', 'ছাতক', 'চুয়াডাঙ্গা', 'দাউদকান্দি', 'দামুরহুদা', 'দেবীগঞ্জ', 'দৌলতখান',
        'ঢাকা', 'ধামরাই', 'ধরলা', 'দিনাজপুর', 'দোহাজারী', 'ফটিকছড়ি', 'ফরিদগঞ্জ', 'ফুলবাড়িয়া', 'ফেনী', 'গাইবান্ধা',
        'গাজীপুর', 'গোপালগঞ্জ', 'গোলাপগঞ্জ', 'ঘোড়াশাল', 'হাজীগঞ্জ', 'হাটহাজারী', 'হবিগঞ্জ', 'হালুয়াঘাট', 'ইলিয়াসগঞ্জ', 'ইশ্বরদী',
        'জগন্নাথপুর', 'জলসা', 'জামালপুর', 'জয়পুরহাট', 'ঝালকাঠি', 'ঝিনাইদহ', 'ঝিকরগাছা', 'জুরাই', 'কালীগঞ্জ', 'কালিয়াকৈর',
        'কামরাঙ্গীরচর', 'কানাইঘাট', 'কুমিল্লা', 'কুষ্টিয়া', 'কুলাউড়া', 'কাঁঠালবাড়ি', 'খুলনা', 'খানসামা', 'খানপুর', 'খুলনা',
        'লক্ষ্মীপুর', 'লালমনিরহাট', 'লালমোহন', 'মাদারীপুর', 'মাগুরা', 'মালঞ্চ', 'মেহেরপুর', 'মিলনপুর', 'মিরপুর', 'মোহাম্মদপুর',
        'মুন্সীগঞ্জ', 'মীরসরাই', 'নবাবগঞ্জ', 'নবীনগর', 'নরসিংদী', 'নওগাঁ', 'নান্দাইল', 'নারায়ণগঞ্জ', 'নড়াইল', 'নেত্রকোনা',
        'নোয়াখালী', 'পঞ্চগড়', 'পাবনা', 'পাংশা', 'পাথরঘাটা', 'পতেঙ্গা', 'পীরগাছা', 'পিরোজপুর', 'পটুয়াখালী', 'রামগড়',
        'রাঙ্গামাটি', 'রাঙ্গুনিয়া', 'রাজবাড়ী', 'রাজশাহী', 'রায়গঞ্জ', 'রূপগঞ্জ', 'সাভার', 'সাতক্ষীরা', 'শ্রীপুর', 'শেরপুর'
    ];

    protected static $englishVillageNames = [
        'Ashuganj', 'Banshkhali', 'Banaripara', 'Barishal', 'Belabo', 'Baliaakandi', 'Benapole', 'Bibhinnya', 'Barlekha', 'Bakshiganj',
        'Chakaria', 'Chandpur', 'Chapainawabganj', 'Chattogram', 'Chatak', 'Chuadanga', 'Daudkandi', 'Damurhuda', 'Debiganj', 'Doulatkhan',
        'Dhaka', 'Dhamrai', 'Dhorla', 'Dinajpur', 'Dohajari', 'Fatikchhari', 'Faridganj', 'Fulbaria', 'Feni', 'Gaibandha',
        'Gazipur', 'Gopalganj', 'Golapganj', 'Ghorashal', 'Hajiganj', 'Hathazari', 'Habiganj', 'Haluaghat', 'Iliasganj', 'Ishwardi',
        'Jagannathpur', 'Jalsa', 'Jamalpur', 'Joypurhat', 'Jhalakathi', 'Jhenaidah', 'Jhikargacha', 'Jurai', 'Kaliaganj', 'Kaliakoir',
        'Kamrangirchar', 'Kanaighat', 'Cumilla', 'Kushtia', 'Kulaura', 'Kathalbari', 'Khulna', 'Khansama', 'Khanpur', 'Khulna',
        'Lakshmipur', 'Lalmonirhat', 'Lalmohan', 'Madaripur', 'Magura', 'Malancha', 'Meherpur', 'Milonpur', 'Mirpur', 'Mohammadpur',
        'Munshiganj', 'Mirsharai', 'Nawabganj', 'Nabinagar', 'Narsingdi', 'Naogaon', 'Nandail', 'Narayanganj', 'Narail', 'Netrakona',
        'Noakhali', 'Panchagarh', 'Pabna', 'Pangsha', 'Patharghata', 'Patenga', 'Pirganj', 'Pirojpur', 'Patuakhali', 'Ramgarh',
        'Rangamati', 'Rangunia', 'Rajbari', 'Rajshahi', 'Raiganj', 'Rupganj', 'Savar', 'Satkhira', 'Sreepur', 'Sherpur'
    ];

    public static function banglaVillageNameGenerator(){
        $villageIndex = array_rand(self::$banglaVillageNames);

        return [
            'bn' => self::$banglaVillageNames[$villageIndex],
            'en' => self::$englishVillageNames[$villageIndex]
        ];
        
    }

    public static function addressGenerator(): array {
        $divisionIndex = array_rand(self::$banglaDivisions);
        $districtIndex = array_rand(self::$banglaDistricts[self::$banglaDivisions[$divisionIndex]]);
        $upazilaIndex = array_rand(self::$banglaUpazilas);
        $villageIndex = array_rand(self::$banglaVillageNames);

        $divisionBn = self::$banglaDivisions[$divisionIndex];
        $divisionEn = self::$englishDivisions[$divisionIndex];

        $districtBn = self::$banglaDistricts[$divisionBn][$districtIndex];
        $districtEn = self::$englishDistricts[$divisionBn][$districtIndex];

        $upazilaBn = self::$banglaUpazilas[$upazilaIndex];
        $upazilaEn = self::$englishUpazilas[$upazilaIndex];

        $villageBn = self::$banglaVillageNames[$villageIndex];
        $villageEn = self::$englishVillageNames[$villageIndex];

        return [
            'bn' => $villageBn . ', ' . $upazilaBn . ', ' . $districtBn . ', ' . $divisionBn,
            'en' => $villageEn . ', ' . $upazilaEn . ', ' . $districtEn . ', ' . $divisionEn
        ];
    }

    public static function banglaNameGenerator(){

        $firstNamesBn = [
            'আবুল', 'আজিজ', 'আফরোজ', 'আশরাফুল', 'আব্দুল্লাহ', 'আদনান', 'আমিন', 'আরিফ', 'ইকবাল', 'ইমরান',
            'ইফতেখার', 'উজ্জ্বল', 'উমর', 'ঊর্মি', 'এনায়েত', 'এলিনা', 'ঐশী', 'কামরুল', 'কবির', 'কলিম',
            'খালেদ', 'গোলাম', 'জাফর', 'জাকির', 'জসিম', 'জুবায়ের', 'তারেক', 'তাহমিনা', 'তানভীর', 'তাহসিন',
            'দিলরুবা', 'নাজমা', 'নাজমুল', 'নাঈম', 'নাসরিন', 'নাসিম', 'নিহাল', 'নুসরাত', 'নূর', 'নুহা',
            'পার্থ', 'পিয়াল', 'পলাশ', 'প্রীতি', 'ফাহিম', 'ফারহানা', 'ফারুক', 'ফারহান', 'ফেরদৌস', 'বকুল',
            'বাবুল', 'বিজয়', 'বিলকিস', 'বিপুল', 'বর্ণালী', 'বদরুল', 'বরকত', 'বিনয়', 'মাহবুব', 'মাহফুজ',
            'মালেক', 'মালিহা', 'মানিক', 'মিজান', 'মুমিন', 'মুসা', 'মুমিনুল', 'মুক্তি', 'মেহেদী', 'মেহের',
            'মোজাম্মেল', 'মুহসিন', 'যুবায়ের', 'রফিক', 'রাশেদ', 'রাকিব', 'রিজভী', 'রিয়াজ', 'রুবেল',
            'রুমানা', 'রুবিনা', 'লিপি', 'লায়লা', 'শাহীন', 'শাহানা', 'শাকিল', 'শামীম', 'শামীমা', 'সাবরিনা',
            'সালাম', 'সালেহ', 'সালেহা', 'সানজিদা', 'সোহেল', 'সুমন', 'হাবিব', 'হুমায়ুন', 'হাসান', 'হোসেন'
        ];

        $lastNamesBn = [
            'আহমেদ', 'আলী', 'আখতার', 'আকন্দ', 'আনসারী', 'আজাদ', 'আফ্রিদি', 'ইমাম', 'ইসলাম', 'ইকবাল', 'উদ্দিন', 'উলহাস', 'উল্লাহ', 'উষা', 'একরাম', 'এমদাদ', 'ঐশিক', 'কামাল', 'কাবির', 'কারিম', 'খান', 'খন্দকার', 'গণি', 'গাজী', 'জাহিদ', 'জামান', 'জহির', 'জুবায়ের', 'তালুকদার', 'তাহের', 'দাশ', 'দত্ত', 'নাহিদ', 'নাসির', 'নায়ার', 'নাহিয়ান', 'নূর', 'নূরুল্লাহ', 'পাটোয়ারী', 'পাল', 'ফারুক', 'ফরিদ', 'ফারুকী', 'বেগম', 'বাশার', 'বকশ', 'বকশী', 'বারী', 'বাবু', 'বিল্লাহ', 'মাহমুদ', 'মাহমুদুল', 'মহসিন', 'মামুন', 'মোরশেদ', 'মুকুল', 'মোস্তফা', 'মুজিব', 'মুন্সী', 'মুর্শিদ', 'মুনির', 'মুহাম্মদ', 'মুন্না', 'মাহফুজ', 'মীর', 'রহমান', 'রহিম', 'রায়হান', 'রকিব', 'রেজা', 'লতিফ', 'লাল', 'শাহ', 'শাহরিয়ার', 'শামস', 'শাহীন', 'শাহাবুদ্দিন', 'শাহজাহান', 'শফিক', 'শফিউল্লাহ', 'সালাম', 'সালেহ', 'সুলতান', 'সুমন', 'সানাউল্লাহ', 'সোহেল', 'সোহান', 'সাইফুল্লাহ', 'হাবিব', 'হাসান', 'হোসেন', 'হায়দার', 'হাফিজ', 'হাকিম', 'হানিফ', 'হাফিজুর', 'হক', 'হেদায়েত', 'হুমায়ুন', 'হেলাল'
        ];

        $firstNamesEn = [
            'Abul', 'Aziz', 'Afrooz', 'Ashraful', 'Abdullah', 'Adnan', 'Amin', 'Arif', 'Iqbal', 'Imran',
            'Iftekhar', 'Ujjwal', 'Umar', 'Urmi', 'Enayet', 'Elina', 'Aishi', 'Kamrul', 'Kabir', 'Kalim',
            'Khaled', 'Golam', 'Jafar', 'Jakir', 'Jasim', 'Zubair', 'Tarek', 'Tahmina', 'Tanvir', 'Tahsin',
            'Dilruba', 'Najma', 'Najmul', 'Naeem', 'Nasrin', 'Nasim', 'Nihal', 'Nusrat', 'Nur', 'Nuha',
            'Partha', 'Pial', 'Palash', 'Preeti', 'Fahim', 'Farhana', 'Faruk', 'Farhan', 'Ferdous', 'Bokul',
            'Babul', 'Bijoy', 'Bilquis', 'Bipul', 'Barnali', 'Badarul', 'Barkat', 'Binoy', 'Mahbub', 'Mahfuz',
            'Malek', 'Maliha', 'Manik', 'Mizan', 'Mumin', 'Musa', 'Muminul', 'Mukti', 'Mehedi', 'Meher',
            'Mozammel', 'Muhsin', 'Zubair', 'Rafik', 'Rashed', 'Rakib', 'Rizvi', 'Riyaz', 'Rubel', 'Rumana',
            'Rubina', 'Lipi', 'Laila', 'Shaheen', 'Shahana', 'Shakil', 'Shamim', 'Shamima', 'Sabrina',
            'Salam', 'Saleh', 'Saleha', 'Sanjida', 'Sohel', 'Sumon', 'Habib', 'Humayun', 'Hasan', 'Hossain'
        ];

        $lastNamesEn = [
            'Ahmed', 'Ali', 'Akhtar', 'Akand', 'Ansari', 'Azad', 'Afridi', 'Imam', 'Islam', 'Iqbal',
            'Uddin', 'Ulhas', 'Ullah', 'Usha', 'Ekram', 'Emdad', 'Aishik', 'Kamal', 'Kabir', 'Karim',
            'Khan', 'Khandakar', 'Gani', 'Gazi', 'Zahid', 'Zaman', 'Zahir', 'Zubair', 'Talukdar', 'Tahir',
            'Dash', 'Dutta', 'Nahid', 'Nasir', 'Nayar', 'Nahian', 'Nur', 'Nurullah', 'Patowari', 'Pal',
            'Faruk', 'Farid', 'Farooqi', 'Begum', 'Bashar', 'Baksh', 'Bakshi', 'Bari', 'Babu', 'Billah',
            'Mahmud', 'Mahmudul', 'Mohsin', 'Mamun', 'Morshed', 'Mukul', 'Mostafa', 'Mujib', 'Munshi', 'Murshid',
            'Munir', 'Muhammad', 'Munna', 'Mahfuz', 'Mir', 'Rahman', 'Rahim', 'Raihan', 'Rakib', 'Reza',
            'Latif', 'Lal', 'Shah', 'Shahriar', 'Shams', 'Shaheen', 'Shahabuddin', 'Shahjahan', 'Shafik', 'Shafiullah',
            'Salam', 'Saleh', 'Sultan', 'Sumon', 'Sanaullah', 'Sohel', 'Sohan', 'Saifullah', 'Habib', 'Hasan',
            'Hossain', 'Haider', 'Hafiz', 'Hakim', 'Hanif', 'Hafizur', 'Haq', 'Hedayet', 'Humayun', 'Helal'
        ];



        $firstNameIndex = array_rand($firstNamesBn);
        $lastNameIndex = array_rand($lastNamesBn);

        $banglaFullName = $firstNamesBn[$firstNameIndex] . ' ' . $lastNamesBn[$lastNameIndex];
        $englishFullName = $firstNamesEn[$firstNameIndex] . ' ' . $lastNamesEn[$lastNameIndex];

        return [
            'bn' => $banglaFullName,
            'en' => $englishFullName
        ];
    }

    public static function banglaMaleNameGenerator() {
        $firstNamesBn = [
            'আবুল', 'আজিজ', 'আফরোজ', 'আশরাফুল', 'আব্দুল্লাহ', 'আদনান', 'আমিন', 'আরিফ', 'ইকবাল', 'ইমরান',
            'ইফতেখার', 'উজ্জ্বল', 'উমর', 'এনায়েত', 'কামরুল', 'কবির', 'কলিম', 'খালেদ', 'গোলাম', 'জাফর',
            'জাকির', 'জসিম', 'জুবায়ের', 'তারেক', 'তানভীর', 'তাহসিন', 'নাজমুল', 'নাঈম', 'নাসিম', 'নিহাল',
            'নূর', 'পার্থ', 'পিয়াল', 'পলাশ', 'ফাহিম', 'ফারুক', 'ফারহান', 'ফেরদৌস', 'বকুল', 'বাবুল',
            'বিজয়', 'বিপুল', 'বদরুল', 'বরকত', 'বিনয়', 'মাহবুব', 'মাহফুজ', 'মালেক', 'মানিক', 'মিজান',
            'মুমিন', 'মুসা', 'মুমিনুল', 'মেহেদী', 'মোজাম্মেল', 'মুহসিন', 'যুবায়ের', 'রফিক', 'রাশেদ', 'রাকিব',
            'রিজভী', 'রিয়াজ', 'রুবেল', 'শাহীন', 'শাকিল', 'শামীম', 'সালাম', 'সালেহ', 'সোহেল', 'সুমন',
            'হাবিব', 'হুমায়ুন', 'হাসান', 'হোসেন'
        ];

        $lastNamesBn = [
            'আহমেদ', 'আলী', 'আখতার', 'আকন্দ', 'আনসারী', 'আজাদ', 'আফ্রিদি', 'ইমাম', 'ইসলাম', 'ইকবাল',
            'উদ্দিন', 'উলহাস', 'উল্লাহ', 'একরাম', 'এমদাদ', 'কামাল', 'কাবির', 'কারিম', 'খান', 'খন্দকার',
            'গণি', 'গাজী', 'জাহিদ', 'জামান', 'জহির', 'জুবায়ের', 'তালুকদার', 'তাহের', 'নাহিদ', 'নাসির',
            'নায়ার', 'নাহিয়ান', 'নূর', 'নূরুল্লাহ', 'পাটোয়ারী', 'পাল', 'ফারুক', 'ফরিদ', 'ফারুকী', 'বাশার',
            'বকশ', 'বকশী', 'বারী', 'বাবু', 'বিল্লাহ', 'মাহমুদ', 'মাহমুদুল', 'মহসিন', 'মামুন', 'মোরশেদ',
            'মুকুল', 'মোস্তফা', 'মুজিব', 'মুন্সী', 'মুর্শিদ', 'মুনির', 'মুহাম্মদ', 'মুন্না', 'মাহফুজ', 'মীর',
            'রহমান', 'রহিম', 'রায়হান', 'রকিব', 'রেজা', 'লতিফ', 'লাল', 'শাহ', 'শাহরিয়ার', 'শামস',
            'শাহীন', 'শাহাবুদ্দিন', 'শাহজাহান', 'শফিক', 'শফিউল্লাহ', 'সালাম', 'সালেহ', 'সুলতান', 'সুমন', 'সানাউল্লাহ',
            'সোহেল', 'সোহান', 'সাইফুল্লাহ', 'হাবিব', 'হাসান', 'হোসেন', 'হায়দার', 'হাফিজ', 'হাকিম', 'হানিফ',
            'হাফিজুর', 'হক', 'হেদায়েত', 'হুমায়ুন', 'হেলাল'
        ];

        $firstNamesEn = [
            'Abul', 'Aziz', 'Afrooz', 'Ashraful', 'Abdullah', 'Adnan', 'Amin', 'Arif', 'Iqbal', 'Imran',
            'Iftekhar', 'Ujjwal', 'Umar', 'Enayet', 'Kamrul', 'Kabir', 'Kalim', 'Khaled', 'Golam', 'Jafar',
            'Jakir', 'Jasim', 'Zubair', 'Tarek', 'Tanvir', 'Tahsin', 'Najmul', 'Naeem', 'Nasim', 'Nihal',
            'Nur', 'Partha', 'Pial', 'Palash', 'Fahim', 'Faruk', 'Farhan', 'Ferdous', 'Bokul', 'Babul',
            'Bijoy', 'Bipul', 'Badarul', 'Barkat', 'Binoy', 'Mahbub', 'Mahfuz', 'Malek', 'Manik', 'Mizan',
            'Mumin', 'Musa', 'Muminul', 'Mehedi', 'Mozammel', 'Muhsin', 'Zubair', 'Rafik', 'Rashed', 'Rakib',
            'Rizvi', 'Riyaz', 'Rubel', 'Shaheen', 'Shakil', 'Shamim', 'Salam', 'Saleh', 'Sohel', 'Sumon',
            'Habib', 'Humayun', 'Hasan', 'Hossain'
        ];

        $lastNamesEn = [
            'Ahmed', 'Ali', 'Akhtar', 'Akand', 'Ansari', 'Azad', 'Afridi', 'Imam', 'Islam', 'Iqbal',
            'Uddin', 'Ulhas', 'Ullah', 'Ekram', 'Emdad', 'Kamal', 'Kabir', 'Karim', 'Khan', 'Khandakar',
            'Gani', 'Gazi', 'Zahid', 'Zaman', 'Zahir', 'Zubair', 'Talukdar', 'Tahir', 'Nahid', 'Nasir',
            'Nayar', 'Nahian', 'Nur', 'Nurullah', 'Patowari', 'Pal', 'Faruk', 'Farid', 'Farooqi', 'Bashar',
            'Baksh', 'Bakshi', 'Bari', 'Babu', 'Billah', 'Mahmud', 'Mahmudul', 'Mohsin', 'Mamun', 'Morshed',
            'Mukul', 'Mostafa', 'Mujib', 'Munshi', 'Murshid', 'Munir', 'Muhammad', 'Munna', 'Mahfuz', 'Mir',
            'Rahman', 'Rahim', 'Raihan', 'Rakib', 'Reza', 'Latif', 'Lal', 'Shah', 'Shahriar', 'Shams',
            'Shaheen', 'Shahabuddin', 'Shahjahan', 'Shafik', 'Shafiullah', 'Salam', 'Saleh', 'Sultan', 'Sumon', 'Sanaullah',
            'Sohel', 'Sohan', 'Saifullah', 'Habib', 'Hasan', 'Hossain', 'Haider', 'Hafiz', 'Hakim', 'Hanif',
            'Hafizur', 'Haq', 'Hedayet', 'Humayun', 'Helal'
        ];



        $firstNameIndex = array_rand($firstNamesBn);
        $lastNameIndex = array_rand($lastNamesBn);

        $banglaFullName = $firstNamesBn[$firstNameIndex] . ' ' . $lastNamesBn[$lastNameIndex];
        $englishFullName = $firstNamesEn[$firstNameIndex] . ' ' . $lastNamesEn[$lastNameIndex];

        return [
            'bn' => $banglaFullName,
            'en' => $englishFullName
        ];
    }
    
    public static function banglaFemaleNameGenerator() {
        $firstNamesBn = [
            'ঊর্মি', 'এলিনা', 'ঐশী', 'তাহমিনা', 'দিলরুবা', 'নাজমা', 'নাসরিন', 'নুসরাত', 'নুহা', 'প্রীতি',
            'ফারহানা', 'মালিহা', 'মুক্তি', 'মেহের', 'রুমানা', 'রুবিনা', 'লিপি', 'লায়লা', 'শাহানা', 'শামীমা',
            'সাবরিনা', 'সালেহা', 'সানজিদা'
        ];

        $lastNamesBn = [
            'বেগম', 'হাসান', 'হোসেন', 'রহিম', 'রহমান', 'ইসলাম', 'আখতার', 'নাসরিন', 'ফারহানা', 'জাহান',
            'আনসারী', 'আজাদ', 'ইমাম', 'উলহাস', 'এমদাদ', 'গোলাম', 'ফারুক', 'ফারুকী', 'কাবির', 'কামাল'
        ];

        $firstNamesEn = [
            'Urmi', 'Elina', 'Aishi', 'Tahmina', 'Dilruba', 'Najma', 'Nasrin', 'Nusrat', 'Nuha', 'Preeti',
            'Farhana', 'Maliha', 'Mukti', 'Meher', 'Rumana', 'Rubina', 'Lipi', 'Laila', 'Shahana', 'Shamima',
            'Sabrina', 'Saleha', 'Sanjida'
        ];

        $lastNamesEn = [
            'Begum', 'Hasan', 'Hossain', 'Rahim', 'Rahman', 'Islam', 'Akhtar', 'Nasrin', 'Farhana', 'Jahan',
            'Ansari', 'Azad', 'Imam', 'Ulhas', 'Emdad', 'Golam', 'Faruk', 'Farooqi', 'Kabir', 'Kamal'
        ];



        $firstNameIndex = array_rand($firstNamesBn);
        $lastNameIndex = array_rand($lastNamesBn);

        $banglaFullName = $firstNamesBn[$firstNameIndex] . ' ' . $lastNamesBn[$lastNameIndex];
        $englishFullName = $firstNamesEn[$firstNameIndex] . ' ' . $lastNamesEn[$lastNameIndex];

        return [
            'bn' => $banglaFullName,
            'en' => $englishFullName
        ];
    }

    public static function businessNameGenerator() {
        $banglaPrefixes = [
            'আলফা', 'বেটা', 'গামা', 'ডেল্টা', 'ইপসিলন', 'জেটা', 'এটা', 'থেটা', 'আইওটা', 'কাপা',
            'ল্যাম্বডা', 'মু', 'নু', 'জাই', 'ওমিক্রন', 'পি', 'রো', 'সিগমা', 'তাও', 'উপসিলন',
            'ফি', 'চি', 'পসি', 'ওমেগা', 'অ্যাপেক্স', 'প্রাইম', 'অল্ট্রা', 'মেগা', 'সুপার', 'হাই',
            'ম্যাক্স', 'অ্যাডভান্সড', 'প্রিমিয়াম', 'এলিট', 'প্রিমা', 'ডায়নামিক', 'পাওয়ার', 'পাওয়ারফুল', 'অপটিমা', 'এক্সেল',
            'ক্ল্যাসিক', 'ইনফিনিটি', 'অপটিমা', 'আর্ক', 'স্মার্ট', 'ইন্টেলিজেন্ট', 'ফাস্ট', 'কুইক', 'স্পীড',
            'অ্যাক্টিভ', 'প্যাসিভ', 'ফ্লেক্সি', 'ফ্লেক্সিবল', 'স্ট্রং', 'স্টার', 'স্ট্রাইড', 'ভাইব', 'ভাইব্রেন্ট', 'জেনারেল',
            'নেক্সট', 'নিউ', 'ট্রু', 'রিয়েল', 'মেট্রো', 'মেট্রোপলিটন', 'মার্ক', 'গ্র্যান্ড', 'মাস্টার', 'কিং',
            'কুইন', 'রয়েল', 'র‍্যাডিকাল', 'রেভোলিউশন', 'ইভো', 'ইভোলিউশন', 'জেন', 'জেনিথ', 'আলটিমা', 'অ্যাকমে',
            'বেস্ট', 'ব্লু', 'গ্রিন', 'রেড', 'গোল্ড', 'সিলভার', 'ব্রোঞ্জ', 'ডায়মন্ড', 'প্লাটিনাম', 'আল্ট্রা',
            'ইম্পেরিয়াল', 'অপ্টিমাস', 'প্রোটন', 'অ্যাটলাস', 'মার্ভেল', 'গ্যালাক্সি', 'কসমো', 'ইনোভা', 'ইনোভেশন', 'ভেরিটাস'
        ];
        
        $englishPrefixes = [
            'Alpha', 'Beta', 'Gamma', 'Delta', 'Epsilon', 'Zeta', 'Eta', 'Theta', 'Iota', 'Kappa',
            'Lambda', 'Mu', 'Nu', 'Xi', 'Omicron', 'Pi', 'Rho', 'Sigma', 'Tau', 'Upsilon',
            'Phi', 'Chi', 'Psi', 'Omega', 'Apex', 'Prime', 'Ultra', 'Mega', 'Super', 'High',
            'Max', 'Advanced', 'Premium', 'Elite', 'Prima', 'Dynamic', 'Power', 'Powerful', 'Optima', 'Excel',
            'Classic', 'Infinity', 'Optima', 'Arc', 'Smart', 'Intelligent', 'Fast', 'Quick', 'Speed',
            'Active', 'Passive', 'Flexi', 'Flexible', 'Strong', 'Star', 'Stride', 'Vibe', 'Vibrant', 'General',
            'Next', 'New', 'True', 'Real', 'Metro', 'Metropolitan', 'Mark', 'Grand', 'Master', 'King',
            'Queen', 'Royal', 'Radical', 'Revolution', 'Evo', 'Evolution', 'Zen', 'Zenith', 'Ultima', 'Acme',
            'Best', 'Blue', 'Green', 'Red', 'Gold', 'Silver', 'Bronze', 'Diamond', 'Platinum', 'Ultra',
            'Imperial', 'Optimus', 'Proton', 'Atlas', 'Marvel', 'Galaxy', 'Cosmo', 'Innova', 'Innovation', 'Veritas'
        ];

        $banglaSuffixes = [
            'লিমিটেড', 'প্রাইভেট লিমিটেড', 'পাবলিক লিমিটেড', 'ইন্টারন্যাশনাল', 'কর্পোরেশন', 'কোম্পানি', 'ইনকর্পোরেটেড', 'এন্টারপ্রাইজ', 
            'ইন্ডাস্ট্রিজ', 'ট্রেডিং', 'গ্রুপ', 'বিজনেস', 'সার্ভিসেস', 'সলিউশনস', 'মার্কেটিং', 'ডেভেলপমেন্ট', 'কনসালট্যান্সি', 
            'হোল্ডিংস', 'টেকনোলজি', 'রিসোর্সেস', 'ট্রাস্ট', 'কমার্শিয়াল', 'ফিনান্স', 'ইনভেস্টমেন্ট', 'ভেঞ্চারস', 'মাল্টিমিডিয়া', 
            'কমিউনিকেশন', 'লজিস্টিকস', 'পার্টনারশিপ', 'এসোসিয়েটস', 'ব্রোকারেজ', 'ডিস্ট্রিবিউশন', 'ইমপোর্ট', 'এক্সপোর্ট', 'কনস্ট্রাকশন', 
            'ডিজাইন', 'ম্যানেজমেন্ট', 'অপারেশন', 'পেট্রোলিয়াম', 'মাইনিং', 'ফার্মাসিউটিক্যালস', 'ফার্ম', 'ফুডস', 'ফুড অ্যান্ড বেভারেজ', 
            'এগ্রো', 'ট্রান্সপোর্ট', 'ক্যাপিটাল', 'এডুকেশন', 'রিয়েল এস্টেট', 'প্রপার্টি', 'রিসোর্ট', 'হোটেল', 'মোটেল', 'হসপিটালিটি', 
            'ফার্নিচার', 'গার্মেন্টস', 'টেক্সটাইল', 'অ্যাপারেল', 'ফুটওয়্যার', 'লেদার', 'স্পোর্টস', 'অটোমোবাইল', 'ইলেকট্রনিক্স', 
            'মেকানিক্যাল', 'সিভিল', 'আইটি', 'মিডিয়া', 'মোবাইল', 'কনজিউমার', 'হেলথ', 'বায়োটেক', 'রিসার্চ', 'ইঞ্জিনিয়ারিং', 'আর্টস', 
            'কালচার', 'সিনেমা', 'মিউজিক', 'এন্টারটেইনমেন্ট', 'ল ফার্ম', 'ল্যাবরেটরি', 'ডায়াগনস্টিক', 'মেডিকেল', 'জেনারেল', 'ট্রেডার্স', 
            'সাপ্লাই', 'ইকুইপমেন্ট', 'অফিস', 'ইন্স্যুরেন্স', 'ক্যাফে', 'রেস্তোরাঁ', 'বেকারি', 'সুপারমার্কেট', 'রিটেইল', 'ডিপার্টমেন্টাল', 
            'ওয়্যারহাউস', 'স্টোর', 'ডেলিভারি', 'প্যাকেজিং', 'পাবলিশিং', 'প্রিন্টিং'
        ];
        
        $englishSuffixes = [
            'Limited', 'Private Limited', 'Public Limited', 'International', 'Corporation', 'Company', 'Incorporated', 'Enterprise', 
            'Industries', 'Trading', 'Group', 'Business', 'Services', 'Solutions', 'Marketing', 'Development', 'Consultancy', 
            'Holdings', 'Technology', 'Resources', 'Trust', 'Commercial', 'Finance', 'Investment', 'Ventures', 'Multimedia', 
            'Communication', 'Logistics', 'Partnership', 'Associates', 'Brokerage', 'Distribution', 'Import', 'Export', 'Construction', 
            'Design', 'Management', 'Operation', 'Petroleum', 'Mining', 'Pharmaceuticals', 'Farm', 'Foods', 'Food and Beverage', 
            'Agro', 'Transport', 'Capital', 'Education', 'Real Estate', 'Property', 'Resort', 'Hotel', 'Motel', 'Hospitality', 
            'Furniture', 'Garments', 'Textile', 'Apparel', 'Footwear', 'Leather', 'Sports', 'Automobile', 'Electronics', 
            'Mechanical', 'Civil', 'IT', 'Media', 'Mobile', 'Consumer', 'Health', 'Biotech', 'Research', 'Engineering', 'Arts', 
            'Culture', 'Cinema', 'Music', 'Entertainment', 'Law Firm', 'Laboratory', 'Diagnostic', 'Medical', 'General', 'Traders', 
            'Supply', 'Equipment', 'Office', 'Insurance', 'Cafe', 'Restaurant', 'Bakery', 'Supermarket', 'Retail', 'Departmental', 
            'Warehouse', 'Store', 'Delivery', 'Packaging', 'Publishing', 'Printing'
        ];

        $banglalongSuffixes = [
            'এন্ড ইঞ্জিনিয়ারিং', 'এন্ড সল্যুশনস', 'এন্ড কনস্ট্রাকশন', 'এন্ড টেকনোলজি', 'এন্ড ডেভেলপমেন্ট', 
            'এন্ড সার্ভিসেস', 'এন্ড কনসালটেন্সি', 'এন্ড ট্রেডিং', 'এন্ড লজিস্টিকস', 'এন্ড এন্টারপ্রাইজ',
            'এন্ড ইনোভেশন', 'এন্ড ইন্ডাস্ট্রিজ', 'এন্ড কমিউনিকেশনস', 'এন্ড ফিনান্স', 'এন্ড হোল্ডিংস',
            'এন্ড ইনভেস্টমেন্ট', 'এন্ড সাপ্লাই', 'এন্ড হসপিটালিটি', 'এন্ড এডুকেশন', 'এন্ড রিসার্চ'
        ];
        
        $englishlongSuffixes = [
            'and Engineering', 'and Solutions', 'and Construction', 'and Technology', 'and Development',
            'and Services', 'and Consultancy', 'and Trading', 'and Logistics', 'and Enterprise',
            'and Innovation', 'and Industries', 'and Communications', 'and Finance', 'and Holdings',
            'and Investment', 'and Supply', 'and Hospitality', 'and Education', 'and Research'
        ];

        $prefixIndex = array_rand($banglaPrefixes);
        $suffixIndex = array_rand($banglaSuffixes);
        $longSuffixIndex = array_rand($banglalongSuffixes);
        
        $needLongSuffix = rand(0, 1);
        $banglaLongSuffix = $needLongSuffix ? ' '.$banglalongSuffixes[$longSuffixIndex] : '';
        $englishLongSuffix = $needLongSuffix ? ' '.$englishlongSuffixes[$longSuffixIndex] : '';

        $banglaName = $banglaPrefixes[$prefixIndex] . ' ' . $banglaSuffixes[$suffixIndex] . $banglaLongSuffix;
        $englishName = $englishPrefixes[$prefixIndex] . ' ' . $englishSuffixes[$suffixIndex] . $englishLongSuffix;

        return [
            'bn' => $banglaName,
            'en' => $englishName
        ];
    }

    public static function getNatureOfBusiness(){
        $bn = ['একক', 'যৌথ', 'অন্যান্য'];
        $en = ['Individual', 'Joint', 'Others'];

        $index = array_rand($bn);

        return [
            'bn' => $bn[$index],
            'en' => $en[$index]
        ];
    }
}












?>