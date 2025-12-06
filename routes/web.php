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



// Debugging static file serving issues (Ralway deployment)
Route::get('/test-static-serving', function() {
    // Try to access the CSS file directly via PHP's file functions
    $cssPath = public_path('styles/styles.css');
    
    // Method 1: Direct file serve
    if (file_exists($cssPath)) {
        return response()->file($cssPath, ['Content-Type' => 'text/css']);
    }
    
    return response()->json([
        'error' => 'File not found',
        'path' => $cssPath,
        'public_dir_exists' => is_dir(public_path()),
        'styles_dir_exists' => is_dir(public_path('styles')),
        'request_path' => request()->path(),
    ]);
});


// Debugging asset loading issues (Ralway deployment)
Route::get('/debug-assets', function() {
    return response()->json([
        'styles.css_url' => asset('styles/styles.css'),
        'styles.css_path' => public_path('styles/styles.css'),
        'styles.css_exists' => file_exists(public_path('styles/styles.css')),
        'section-layouts.css_exists' => file_exists(public_path('styles/section-layouts.css')),
        'app_url' => config('app.url'),
        'current_url' => url()->current()
    ]);
});

// Debugging railway database connection issues (Ralway deployment)
Route::get('/database-debug', function() {
    $connection = DB::connection();
    $config = $connection->getConfig();
    
    // Get ALL tables with row counts
    $tables = $connection->select('SHOW TABLES');
    
    $tableDetails = [];
    $totalRows = 0;
    
    foreach ($tables as $tableObj) {
        $tableName = array_values((array)$tableObj)[0];
        $rowCount = $connection->table($tableName)->count();
        $tableDetails[] = [
            'name' => $tableName,
            'row_count' => $rowCount
        ];
        $totalRows += $rowCount;
    }
    
    // Get migration status
    $migrations = $connection->table('migrations')->get();
    
    return response()->json([
        'connection_info' => [
            'host' => $config['host'],
            'database' => $config['database'],
            'driver' => $config['driver'],
            'username' => $config['username'],
        ],
        'tables_found' => count($tables),
        'table_list' => $tableDetails,
        'total_rows_across_all_tables' => $totalRows,
        'migrations_applied' => $migrations->count(),
        'migrations_list' => $migrations->pluck('migration'),
        'app_environment' => app()->environment(),
        'env_variables_check' => [
            'DB_CONNECTION' => env('DB_CONNECTION'),
            'DB_DATABASE' => env('DB_DATABASE'),
            'APP_ENV' => env('APP_ENV'),
        ]
    ]);
});

// Debugging : Detailed database connection and structure check (Ralway deployment)
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





// Solution : Laravel's Built-in Static Serving. Serve static assets directly (Ralway deployment)
// Must be after debugging routes to avoid interference
Route::get('/styles/{file}', function ($file) {
    $path = public_path('styles/' . $file);
    
    // Validate file exists and has allowed extension
    $allowed = ['css', 'js', 'png', 'jpg', 'jpeg', 'gif', 'svg', 'ico'];
    $ext = pathinfo($file, PATHINFO_EXTENSION);
    
    if (!in_array($ext, $allowed) || !file_exists($path)) {
        abort(404);
    }
    
    // Set correct Content-Type
    $mime = [
        'css' => 'text/css',
        'js' => 'application/javascript',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'svg' => 'image/svg+xml',
        'ico' => 'image/x-icon',
    ][$ext] ?? 'text/plain';
    
    return response()->file($path, ['Content-Type' => $mime]);
});

/*
GET
POST
PUT
PATCH
DELETE
*/
?>