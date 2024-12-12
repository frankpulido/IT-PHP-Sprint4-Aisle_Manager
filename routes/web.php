<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // I added this to change assigned route return to HomeController
use App\Http\Controllers\AisleController; // I added this to change assigned route return to AisleController
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Models\Aisle;
use App\Models\Section;
use App\Models\Product;

Route::get('/', HomeController::class)->name('home');
// ONLY BECAUSE HOMECONTROLLER HAS A SINGLE METHOD : I changes method index() to method __invoke() in app/Http/Controllers
// I will make an introduction to the project purpose

Route::get('/aisles', [AisleController::class, 'index'])->name('aisles.index'); // Renders the Grocery Store Floorplan (8 aisles)

Route::get('/aisles/{id}/', [AisleController::class, 'showAisle'])->name('aisles.showAisle'); // Renders the 8 aisle sections of a given aisle and products nested in them

Route::get('/section/{id}', [AisleController::class, 'showSection'])->name('sections.show'); // Renders details of a section with products

Route::get('/sections/orphaned', [AisleController::class, 'orphanedSections'])->name('sections.orphaned'); // Renders Orphaned Sections to Allocate



// TERMINAR GET route for swapping Orphaned Section with any section in Aisles
Route::get('/nest-orphaned', [AisleController::class, 'nestOrphaned'])->name('aisles.nestOrphaned');

// TERMINAR
Route::get('/create', [AisleController::class, 'createSection'])->name('section.create'); // Show available layouts to start creating a section

// TERMINAR : updates and renders section again
Route::post('/update', [AisleController::class, 'updateSection'])->name('section.update');

// TERMINAR
Route::get('/edit', [AisleController::class, 'editSection'])->name('section.edit'); // Edit section



// POST route for swapping aisles
Route::post('/swap-aisles', [AisleController::class, 'swapAisles'])->name('aisles.swap');

// POST route for swapping sections
Route::post('/swap-sections', [AisleController::class, 'swapSections'])->name('sections.swap');





// Showing jsons - decide whether to eliminate not only the route below but also SectionController (use AisleController for handling all routes) and leave ProductController for future development
Route::get('/sections', [SectionController::class, 'all']); // All sections regadless of allocation






// ROUTES BELOW ARE NOT IN USE

Route::get('/section/create', [SectionController::class, 'create']);

Route::get('/aisles/{id}/{category?}', [AisleController::class, 'map']);
// Question mark after category declares variable as optional
// if ($category) {return "This view will map the aisle \"{$id}\" and the products stored in the shelves \"{$category}\"...";}
// return "This view will map the aisle \"{$id}\".";

// Defines the route to fetch product details
//Route::get('/aisles/{aisleId}/products/{productId}', [ProductController::class, 'show']);


/*
GET
POST
PUT
PATCH
DELETE
*/
?>