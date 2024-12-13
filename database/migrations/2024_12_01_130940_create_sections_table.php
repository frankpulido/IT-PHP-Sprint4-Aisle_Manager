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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('aisle_id')
                ->nullable() // Allow sections to exist without being assigned to an aisle initially
                ->constrained('aisles') // References 'id' column in `aisles` table
                ->onUpdate('cascade')    // Prevent updates if referenced ID changes
                ->onDelete('restrict');   // Prevent deletion of aisles with related sections
            $table->tinyInteger('aisle_order')->nullable(); // position within aisle
            $table->enum('kind', ['food', 'fresh food', 'personal care', 'cleaning', 'dairy', 'beer', 'water', 'beverages'])->default('food');
            // Important : database/factories/SectionFactory.php must consider same enums  
            $table->tinyInteger('number_products');
            // Important : consider modifying 'number_products' as enum matching column in table 'grid_layouts'
            $table->foreignId('grid_id')  // this will be the assigned grid layout
                ->nullable() // Allow sections to exist without being assigned a layout
                ->constrained('grid_layouts') // References 'id' column in `grid_layouts` table
                ->onUpdate('cascade')    // Prevent updates if referenced ID changes
                ->onDelete('restrict');   // Prevent deletion of grid layouts with related sections
            $table->timestamps();

            // Add composite unique constraint
            $table->unique(['aisle_id', 'aisle_order'], 'position_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sections');
    }
};