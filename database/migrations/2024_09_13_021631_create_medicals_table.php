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
        Schema::create('medicals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients');
            $table->foreignUuid('classification_id')->constrained('classifications');
            $table->dateTime('checkup_date')->nullable();
            $table->string('diagnosis')->nullable();
            $table->text('complaints')->nullable();
            $table->string('illness_duration_years')->nullable();
            $table->string('illness_duration_months')->nullable();
            $table->string('illness_duration_days')->nullable();
            $table->text('medical_history')->nullable();
            $table->text('drug_allergies')->nullable();
            $table->text('food_allergies')->nullable();
            $table->text('other_allergies')->nullable();
            $table->string('sistole')->nullable();
            $table->string('diastole')->nullable();
            $table->string('height')->nullable();
            $table->string('weight')->nullable();
            $table->string('pulse')->nullable();
            $table->string('temperature')->nullable();
            $table->boolean('pregnancy')->nullable()->default(false);
            $table->enum('heart', ['regular', 'iregular'])->nullable();
            $table->string('other_checkup')->nullable();
            $table->text('treatment')->nullable();
            $table->text('recipe')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicals');
    }
};
