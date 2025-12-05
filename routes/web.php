<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // I added this to change assigned route return to HomeController
use App\Http\Controllers\AisleController; // I added this to change assigned route return to AisleController
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Models\Aisle;
use App\Models\Section;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

// Add to routes/web.php
Route::get('/db-check-detailed', function() {
    $connection = DB::connection();
    $pdo = $connection->getPdo();
    
    // Get ACTIVE connection details
    $host = $connection->getConfig('host');
    $database = $connection->getConfig('database');
    $username = $connection->getConfig('username');
    
    // Check what database we're actually connected to
    $currentDatabase = $connection->select('SELECT DATABASE() as db')[0]->db;
    
    // List ALL tables in the current database
    $tables = $connection->select('SHOW TABLES');
    
    // Check if using SQLite
    $driver = $connection->getDriverName();
    $sqlitePath = config('database.connections.sqlite.database');
    
    return response()->json([
        'driver' => $driver,
        'active_host' => $host,
        'active_database' => $database,
        'current_database' => $currentDatabase,
        'username' => $username,
        'tables_count' => count($tables),
        'tables_list' => array_map(function($table) {
            return array_values((array)$table)[0];
        }, $tables),
        'is_sqlite' => $driver === 'sqlite',
        'sqlite_path' => $sqlitePath ?? 'N/A',
        'env_db_host' => env('DB_HOST'),
        'env_db_database' => env('DB_DATABASE'),
        'app_env' => env('APP_ENV'),
    ]);
});

Route::get('/', HomeController::class)->name('home');
// ONLY BECAUSE HOMECONTROLLER HAS A SINGLE METHOD : I changes method index() to method __invoke() in app/Http/Controllers
// I will make an introduction to the project purpose

Route::get('/aisles', [AisleController::class, 'index'])->name('aisles.index'); // Renders the Grocery Store Floorplan (8 aisles)

Route::get('/aisles/{id}/', [AisleController::class, 'showAisle'])->name('aisles.showAisle'); // Renders the 8 aisle sections of a given aisle and products nested in them

Route::get('/section/{id}', [AisleController::class, 'showSection'])->name('sections.show'); // Renders details of a section with products

Route::get('/sections/orphaned', [AisleController::class, 'orphanedSections'])->name('sections.orphaned'); // Renders Orphaned Sections to Allocate



// GET route for swapping Orphaned Section with any section in Aisles
Route::post('/nest-orphaned', [AisleController::class, 'nestOrphaned'])->name('aisles.nestOrphaned');

// GET TERMINAR
Route::get('/create', [AisleController::class, 'createSection'])->name('section.create'); // Show available layouts to start creating a section

// POST Intermediate step for gathering missing data from form submission and create a section
Route::post('/create-bridge', [AisleController::class, 'createBridge'])->name('section.createBridge');

// GET TERMINAR
Route::get('/edit', [AisleController::class, 'editSection'])->name('section.edit'); // Edit section

// POST TERMINAR : updates and renders section again
Route::post('/update', [AisleController::class, 'updateSection'])->name('section.update');




// POST route for swapping aisles
Route::post('/swap-aisles', [AisleController::class, 'swapAisles'])->name('aisles.swap');

// POST route for swapping sections
Route::post('/swap-sections', [AisleController::class, 'swapSections'])->name('sections.swap');





// Showing jsons - decide whether to eliminate not only the route below but also SectionController (use AisleController for handling all routes) and leave ProductController for future development
Route::get('/sections', [SectionController::class, 'all']); // All sections regadless of allocation



/*
GET
POST
PUT
PATCH
DELETE
*/
?>