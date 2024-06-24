<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $dependsOnTables = ['users', 'business_categories', 'signboards'];
    public function up(): void
    {
        Schema::create('trade_license_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('restrict');
            $table->foreignId('business_category_id')->constrained()->onDelete('restrict');
            $table->foreignId('signboard_id')->constrained()->onDelete('restrict');
            $table->string('business_organization_name_bn')->nullable(false);
            $table->string('business_organization_name')->nullable(false);
            $table->string('nature_of_business_bn')->nullable(false);
            $table->string('nature_of_business')->nullable();
            $table->string('address_of_business_organization_bn')->nullable(false);
            $table->string('address_of_business_organization')->nullable(false);
            $table->string('zone_bn')->nullable();
            $table->string('zone')->nullable();
            $table->string('ward_no')->nullable();

            $table->string('tin_no')->nullable();
            $table->string('bin_no')->nullable();
            $table->string('phone_no')->nullable(false);
            $table->string('email')->nullable();
            $table->string('fiscal_year')->nullable(false);
            $table->date('business_starting_date')->nullable(false);

            $table->string('image')->nullable();
            $table->string('application_type')->default('new');
            $table->string('ccmts_2016_serial_no')->nullable();

            $table->decimal('form_fee')->nullable();
            $table->decimal('new_application_fee')->nullable();
            $table->decimal('renewal_application_fee')->nullable();
            $table->decimal('arrear')->nullable();
            $table->decimal('surcharge')->nullable();
            $table->decimal('amendment_fee')->nullable();
            $table->decimal('signboard_fee')->nullable();
            $table->decimal('income_tax')->nullable();
            $table->decimal('vat')->nullable();
            $table->decimal('other_fee')->nullable();
            $table->decimal('total_fee')->nullable();
            
            $table->string('uuid')->unique()->nullable();
            $table->string('trade_license_no')->nullable();
            $table->timestamp('issued_at')->nullable();
            $table->date('expiry_date')->nullable();

            $table->string('status')->default('pending_tl_assistant_approval');
            $table->longText('corrections')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_license_applications');
    }
};
