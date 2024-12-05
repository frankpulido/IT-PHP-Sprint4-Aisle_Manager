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
        Schema::create('aisles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('number_sections');
            //$table->json('sections')->nullable(); // Sections should be relocated with total freedom 
            //$table->string('php_layout')->nullable(); // No layout, sections take order_aisle (from 1 to 8)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('aisles');
    }
};