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
        Schema::create('patients', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_medical_record')->nullable()->unique();
            $table->string('name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('nik')->nullable();
            $table->string('education')->nullable();
            $table->string('job')->nullable();
            $table->enum('gender', ['female', 'male'])->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};
