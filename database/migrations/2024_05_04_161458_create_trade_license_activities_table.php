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
        Schema::create('trade_license_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_license_application_id')->constrained()->onDelete('cascade');
            $table->string('activity')->nullable(false);
            $table->string('message')->nullable();
            $table->decimal('payment_amount', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_license_activities');
    }
};
