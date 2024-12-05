<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // I added this to change assigned route return to HomeController
use App\Http\Controllers\AisleController; // I added this to change assigned route return to AisleController
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ProductController;
use App\Models\Aisle;
use App\Models\Section;
use App\Models\Product;

Route::get('/', HomeController::class);
// ONLY BECAUSE HOMECONTROLLER HAS A SINGLE METHOD : I changes method index() to method __invoke() in app/Http/Controllers
// I will make an introduction to the project purpose

Route::get('/aisles', [AisleController::class, 'index']); // Renders the Grocery Store Floorplan (8 aisles)

Route::get('/aisles/{id}/', [AisleController::class, 'show']); // Renders the 8 aisle sections of a given aisle

// POST route for swapping aisles
Route::post('/swap-aisles', [AisleController::class, 'swapAisles'])->name('aisles.swap');

// POST route for swapping sections
Route::post('/swap-sections', [AisleController::class, 'swapSections'])->name('sections.swap');






Route::get('/aisles/create', [AisleController::class, 'create']); // Not in use (for future development)

Route::get('/aisles/{id}/{category?}', [AisleController::class, 'map']);
// Question mark after category declares variable as optional
// if ($category) {return "This view will map the aisle \"{$id}\" and the products stored in the shelves \"{$category}\"...";}
// return "This view will map the aisle \"{$id}\".";

Route::get('/sections/', [SectionController::class, 'all']);

Route::get('/section/{id}', [SectionController::class, 'show']);

Route::get('/section/create', [SectionController::class, 'create']);

/*
Route::get('/test_crud', function(){
    // Create AISLE
    $aisle = new Aisle;
    $table->string = 'AISLE 1';
    $table->json('sections');
    $table->string('php_layout');
    $aisle->save();
})
*/

/*
GET
POST
PUT
PATCH
DELETE
*/
?>