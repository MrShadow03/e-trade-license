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
        Schema::create('trade_license_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_license_application_id')->constrained()->onDelete('cascade');
            $table->string('payment_id')->nullable();
            $table->string('gateway')->nullable();
            $table->decimal('amount')->nullable(false);
            $table->string('method')->nullable();
            $table->string('received_by')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_license_payments');
    }
};
