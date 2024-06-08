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
        Schema::create('amendment_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_license_application_id')->constrained()->onDelete('cascade');
            $table->string('type');
            $table->json('data');
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('amendment_applications');
    }
};
