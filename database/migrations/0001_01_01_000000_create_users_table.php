<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name_bn');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique();
            $table->string('image')->default('users/default.png')->nullable();

            $table->string('father_name_bn')->nullable(false);
            $table->string('father_name')->nullable(false);
            $table->string('mother_name_bn')->nullable(false);
            $table->string('mother_name')->nullable(false);
            $table->string('spouse_name_bn')->nullable();
            $table->string('spouse_name')->nullable();

            $table->string('national_id_no')->unique();
            $table->string('birth_registration_no')->unique()->nullable();
            $table->string('passport_no')->unique()->nullable();

            $table->string('ca_holding_no')->nullable(false);
            $table->string('ca_road_no')->nullable();
            $table->string('ca_village_bn')->nullable(false);
            $table->string('ca_village')->nullable(false);
            $table->string('ca_post_office_bn')->nullable(false);
            $table->string('ca_post_office')->nullable(false);
            $table->string('ca_post_code')->nullable();
            $table->string('ca_upazilla_bn')->default('বরিশাল মেট্রোপলিটন পুলিশ স্টেশন')->nullable(false);
            $table->string('ca_upazilla')->default('Barishal Metropolitan Police Station')->nullable(false);
            $table->string('ca_district_bn')->default('বরিশাল')->nullable(false);
            $table->string('ca_district')->default('Barishal')->nullable(false);
            $table->string('ca_division_bn')->default('বরিশাল')->nullable(false);
            $table->string('ca_division')->default('Barishal')->nullable(false);
            $table->string('ca_country_bn')->default('বাংলাদেশ')->nullable(false);
            $table->string('ca_country')->default('Bangladesh')->nullable(false);

            $table->string('pa_holding_no')->nullable(false);
            $table->string('pa_road_no')->nullable();
            $table->string('pa_village_bn')->nullable(false);
            $table->string('pa_village')->nullable(false);
            $table->string('pa_post_office_bn')->nullable(false);
            $table->string('pa_post_office')->nullable(false);
            $table->string('pa_post_code')->nullable();
            $table->string('pa_upazilla_bn')->nullable(false);
            $table->string('pa_upazilla')->nullable(false);
            $table->string('pa_district_bn')->nullable(false);
            $table->string('pa_district')->nullable();
            $table->string('pa_division_bn')->nullable(false);
            $table->string('pa_division')->nullable();
            $table->string('pa_country_bn')->nullable('বাংলাদেশ');
            $table->string('pa_country')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();
            $table->string('password');
            $table->boolean('needs_password_reset')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
