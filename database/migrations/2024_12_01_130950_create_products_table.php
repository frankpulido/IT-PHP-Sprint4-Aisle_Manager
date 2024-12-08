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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('section_id')
                ->nullable() // Allow sections to exist without being assigned to an aisle initially
                ->constrained('sections') // References 'id' column in `sections` table
                ->onUpdate('cascade')    // Prevent updates if referenced ID changes
                ->onDelete('restrict');   // Prevent deletion of aisles with related sections
            $table->tinyInteger('section_order')->nullable(); // position within section
            $table->string('name');
            $table->enum('kind', ['food', 'fresh food', 'personal care', 'cleaning', 'dairy', 'beer', 'water', 'beverages'])->default('food');
            // Important : database/factories/SectionFactory.php must consider same enums  
            $table->decimal('price',5,2); // total = 5 digits, 2 are decimal
            $table->decimal('revenues_year',8,2)->nullable();
            $table->decimal('turnover_year',4,2)->nullable();
            $table->tinyInteger('stockouts_year')->nullable();
            $table->timestamps();

            // Add composite unique constraint
            $table->unique(['section_id', 'section_order'], 'position_unique');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};