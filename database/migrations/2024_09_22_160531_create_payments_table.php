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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->onDelete('cascade');
            $table->foreignUuid('medical_id')->constrained('medicals')->onDelete('cascade');
            $table->foreignUuid('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->string('order_id')->nullable();
            $table->string('gross_amount')->nullable();
            $table->string('payment_type')->nullable();
            $table->dateTime('transaction_time')->nullable();
            $table->enum('transaction_status', ['pending', 'settlement', 'cancel', 'expire'])->nullable()->default('pending');
            $table->string('transaction_expired_time')->nullable();
            $table->longText('qris_url')->nullable();
            $table->longText('qris_raw')->nullable();
            $table->string('acquirer')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
