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
        Schema::create('recipe_medicine', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('recipe_id')->constrained('recipes')->onDelete('cascade');
            $table->foreignUuid('medicine_id')->constrained('medicines')->onDelete('cascade');
            $table->decimal('quantity', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recipe_medicine');
    }
};
