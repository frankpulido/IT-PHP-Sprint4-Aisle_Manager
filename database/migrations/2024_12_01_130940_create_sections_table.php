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
            $table->id(); //$table->string('name');
            $table->foreignId('aisle_id')
                ->nullable() // Allow sections to exist without being assigned to an aisle initially
                ->constrained('aisles') // References 'id' column in `aisles` table
                ->onUpdate('cascade')    // Prevent updates if referenced ID changes
                ->onDelete('restrict');   // Prevent deletion of aisles with related sections
            $table->tinyInteger('aisle_order')->nullable(); // position within aisle
            $table->enum('kind', ['food', 'fresh food', 'personal care', 'cleaning', 'dairy', 'beer', 'water', 'beverages'])->default('food');
            // Important : database/factories/SectionFactory.php must consider same enums  
            $table->tinyInteger('number_products');
            //$table->json('products')->nullable(); // product id's displayed in section. Array size no greater than number_products
            $table->string('php_layout')->nullable(); // this will be the grid layout
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