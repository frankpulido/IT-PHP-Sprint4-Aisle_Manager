<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Only create if doesn't exist
        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        } else {
            // Table exists - ensure it has proper schema
            // Check if it has the Laravel-standard primary key
            if (!Schema::hasColumn('sessions', 'id') || 
                DB::select("SHOW KEYS FROM `sessions` WHERE Key_name = 'PRIMARY' AND Column_name = 'id'") === []) {
                
                // Add standard Laravel primary key
                Schema::table('sessions', function (Blueprint $table) {
                    $table->string('id')->primary()->change();
                });
            }
        }
    }

    public function down(): void
    {
        // Don't drop in production - it's a system table
        // Schema::dropIfExists('sessions');
    }
};