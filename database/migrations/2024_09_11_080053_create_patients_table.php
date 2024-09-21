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
            $table->string('medical_record_number')->nullable();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('password');
            $table->text('encrypted_password');
            $table->rememberToken();
            $table->string('nik')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('religion')->nullable();
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place')->nullable();
            $table->date('birth_date')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('education')->nullable();
            $table->string('job')->nullable();
            $table->char('province_id', 6)->nullable();
            $table->char('city_id', 6)->nullable();
            $table->char('sub_district_id', 6)->nullable();
            $table->foreign('province_id')->references('id')->on('provinces');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('sub_district_id')->references('id')->on('sub_districts');
            $table->text('village');
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
