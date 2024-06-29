<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Traits\FactoryHelper;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    use FactoryHelper;
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userName = FactoryHelper::banglaNameGenerator();
        $fatherName = FactoryHelper::banglaMaleNameGenerator();
        $motherName = FactoryHelper::banglaFemaleNameGenerator();
        $caVillageName = FactoryHelper::banglaVillageNameGenerator();
        $caUpazillaName = FactoryHelper::banglaUpazillaNameGenerator();
        $caDivisionName = FactoryHelper::banglaDivisionNameGenerator();
        $caDistrictName = FactoryHelper::banglaDistrictNameGenerator($caDivisionName['bn']);
        $paVillageName = FactoryHelper::banglaVillageNameGenerator();
        $paUpazillaName = FactoryHelper::banglaUpazillaNameGenerator();
        $paDivisionName = FactoryHelper::banglaDivisionNameGenerator();
        $paDistrictName = FactoryHelper::banglaDistrictNameGenerator($paDivisionName['bn']);

        return [
            'name_bn' => $userName['bn'],
            'name' => $userName['en'],
            'email' => $this->faker->unique()->safeEmail(),
            'phone' => $this->faker->unique()->regexify('01[3-9]{1}[0-9]{8}'),
            'image' => 'users/default.png',
            'father_name_bn' => $fatherName['bn'],
            'father_name' => $fatherName['en'],
            'mother_name_bn' => $motherName['bn'],
            'mother_name' => $motherName['en'],
            'national_id_no' => $this->faker->unique()->regexify('[1950-2003]{4}[0-9]{13}'),
            'birth_registration_no' => $this->faker->unique()->regexify('[0-9]{17}'),
            'passport_no' => $this->faker->unique()->regexify('[A-Z]{2}[0-9]{7}'),
            'ca_holding_no' => $this->faker->regexify('[0-9]{1,3}'),
            'ca_road_no' => $this->faker->regexify('[0-9]{1,3}'),
            'ca_village_bn' => $caVillageName['bn'],
            'ca_village' => $caVillageName['en'],
            'ca_post_office_bn' => $caVillageName['bn'],
            'ca_post_office' => $caVillageName['en'],
            'ca_post_code' => $this->faker->regexify('[0-9]{4}'),
            'ca_upazilla_bn' => $caUpazillaName['bn'],
            'ca_upazilla' => $caUpazillaName['en'],
            'ca_district_bn' => $caDistrictName['bn'],
            'ca_district' => $caDistrictName['en'],
            'ca_division_bn' => $caDivisionName['bn'],
            'ca_division' => $caDivisionName['en'],
            'ca_country_bn' => 'বাংলাদেশ',
            'ca_country' => 'Bangladesh',
            'pa_holding_no' => $this->faker->regexify('[0-9]{1,3}'),
            'pa_road_no' => $this->faker->regexify('[0-9]{1,3}'),
            'pa_village_bn' => $paVillageName['bn'],
            'pa_village' => $paVillageName['en'],
            'pa_post_office_bn' => $paVillageName['bn'],
            'pa_post_office' => $paVillageName['en'],
            'pa_post_code' => $this->faker->regexify('[0-9]{4}'),
            'pa_upazilla_bn' => $paUpazillaName['bn'],
            'pa_upazilla' => $paUpazillaName['en'],
            'pa_district_bn' => $paDistrictName['bn'],
            'pa_district' => $paDistrictName['en'],
            'pa_division_bn' => $paDivisionName['bn'],
            'pa_division' => $paDivisionName['en'],
            'pa_country_bn' => 'বাংলাদেশ',
            'pa_country' => 'Bangladesh',
            'email_verified_at' => now(),
            'phone_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'needs_password_reset' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

}
