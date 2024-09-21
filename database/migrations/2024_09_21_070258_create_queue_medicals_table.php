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
        Schema::create('queue_medicals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('patient_id')->constrained('patients')->onDelete('cascade');
            $table->dateTime('appointment_date')->nullable();
            $table->text('description')->nullable();
            $table->enum('status', ['belum diperiksa', 'sedang diperiksa', 'sudah diperiksa', 'batal berobat'])->nullable()->default('belum diperiksa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('queue_medicals');
    }
};
