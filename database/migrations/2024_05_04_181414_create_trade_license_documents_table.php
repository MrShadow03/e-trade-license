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
        Schema::create('trade_license_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trade_license_application_id')->constrained()->onDelete('cascade');
            $table->foreignId('trade_license_required_document_id')->constrained()->onDelete('restrict')->name('fk_trade_license_documents_trade_license_required_document_id');
            $table->string('document_name')->nullable(false);
            $table->string('document_path')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trade_license_documents');
    }
};
