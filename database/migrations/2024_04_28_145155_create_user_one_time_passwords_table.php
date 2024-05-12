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
        Schema::create('user_one_time_passwords', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('otp');
            $table->timestamp('expires_at')->required();
            $table->boolean('is_used')->default(false);
            $table->string('last_used_ip')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->integer('left_attempts')->default(3);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_one_time_passwords');
    }
};
