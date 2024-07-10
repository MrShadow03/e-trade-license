<?php

namespace Database\Factories;

use App\Helpers\Helpers;
use App\Models\User;
use App\Models\Signboard;
use App\Traits\FactoryHelper;
use App\Models\BusinessCategory;
use Illuminate\Support\Facades\Http;
use App\Models\TradeLicenseApplication;
use App\Models\TradeLicenseDocument;
use App\Models\TradeLicenseRequiredDocument;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TradeLicenseApplication>
 */
class TradeLicenseApplicationFactory extends Factory
{
    use FactoryHelper;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $businessName = FactoryHelper::businessNameGenerator();
        $natureOfBusiness = FactoryHelper::getNatureOfBusiness();
        $address = FactoryHelper::addressGenerator();
        $zone = FactoryHelper::banglaVillageNameGenerator();
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'business_category_id' => BusinessCategory::inRandomOrder()->first()->id,
            'signboard_id' => Signboard::inRandomOrder()->first()->id,
            'business_organization_name_bn' => $businessName['bn'],
            'business_organization_name' => $businessName['en'],
            'nature_of_business_bn' => $natureOfBusiness['bn'],
            'nature_of_business' => $natureOfBusiness['en'],
            'address_of_business_organization_bn' => $address['bn'],
            'address_of_business_organization' => $address['en'],
            'zone_bn' => $zone['bn'],
            'zone' => $zone['en'],
            'ward_no' => $this->faker->numberBetween(1, 30),
            'tin_no' => $this->faker->unique()->regexify('[0-9]{11}'),
            'bin_no' => $this->faker->unique()->regexify('[0-9]{11}'),
            'phone_no' => $this->faker->unique()->regexify('01[3-9]{1}[0-9]{8}'),
            'email' => $this->faker->unique()->safeEmail(),
            'fiscal_year' => $this->faker->randomElement(['2023-2024']),
            'business_starting_date' => $this->faker->date(),
            'expiry_date' => date('2025-06-30'),
            'status' => Helpers::PENDING_ASSISTANT_APPROVAL,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (TradeLicenseApplication $application) {
            // Add the image to the media collection 'owner_image'
            $randNumber = $this->faker->numberBetween(1, 43);
            $path = 'C:\Users\gjemo\Pictures\Cartoon Avaters\profile\img (' . $randNumber . ').jpg';
            $application->addMedia($path)
                ->preservingOriginal()
                ->usingFileName('avatar.jpg')
                ->toMediaCollection('owner_image');

            $docsId = [1, 2];

            foreach ($docsId as $docId) {
                $reqDoc = TradeLicenseRequiredDocument::find($docId);
            
                // Create a new TradeLicenseDocument
                $doc = TradeLicenseDocument::create([
                    'trade_license_application_id' => $application->id,
                    'trade_license_required_document_id' => $reqDoc->id,
                    'document_name' => $reqDoc->document_name,
                    'document_path' => 'default.pdf', // Replace with the actual path or name as per your needs
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            
                // Add the image to the media collection 'document'
                $doc->addMedia('C:\Users\gjemo\Pictures\admindek-admin-template.jpg')
                    ->preservingOriginal()
                    ->toMediaCollection('document');
            }
        });
    }
}
