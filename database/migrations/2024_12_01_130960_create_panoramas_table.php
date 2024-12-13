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
        Schema::create('panoramas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')
                ->unique()
                ->constrained('sections') // References 'id' column in `aisles` table
                ->onUpdate('cascade')    // Updates if referenced ID changes
                ->onDelete('restrict');   // Prevent deletion of panoramas with related sections
            $table->string('panotourvirtual');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('panoramas');
    }
};
