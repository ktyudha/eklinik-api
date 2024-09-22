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
        Schema::create('medicines', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('medicine_category_id')->constrained('medicine_categories')->onDelete('cascade');
            $table->string('name');
            $table->string('description')->nullable();
            $table->dateTime('expired_date')->nullable();
            $table->string('unit')->nullable();
            $table->integer('stock')->nullable();
            $table->string('price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medicines');
    }
};
