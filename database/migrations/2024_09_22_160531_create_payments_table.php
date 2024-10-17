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
            $table->dateTime('payment_date')->nullable();
            $table->string('payment_method')->nullable();
            $table->string('status')->nullable()->default('pending');
            $table->string('total_amount')->nullable();
            $table->string('snap_token')->nullable();
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
