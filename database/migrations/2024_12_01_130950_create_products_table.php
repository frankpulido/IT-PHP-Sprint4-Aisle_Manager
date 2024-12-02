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
            $table->string('name');
            $table->enum('kind', ['food', 'fresh food', 'personal care', 'cleaning', 'dairy', 'beer', 'water', 'beverages'])->default('food');
            // Important : database/factories/SectionFactory.php must consider same enums  
            $table->decimal('price',5,2); // total = 5 digits, 2 are decimal
            $table->timestamps();
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