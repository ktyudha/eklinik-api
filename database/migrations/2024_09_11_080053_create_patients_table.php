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
            $table->string('no_medical_record')->unique();
            $table->string('name');
            $table->date('date_of_birth');
            $table->string('nik');
            $table->string('education');
            $table->string('job');
            $table->enum('gender', ['female', 'male']);
            $table->foreignUuid('province_id')->constrained('provinces');
            $table->foreignUuid('city_id')->constrained('cities');
            $table->foreignUuid('sub_district_id')->constrained('sub_districts');
            $table->text('address');
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
