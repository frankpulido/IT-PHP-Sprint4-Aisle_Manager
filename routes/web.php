<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; // I added this to change assigned route return to HomeController
use App\Http\Controllers\AisleController; // I added this to change assigned route return to AisleController
use App\Http\Controllers\SectionController;
use App\Models\Aisle;
use App\Models\Section;
use App\Models\Product;

/*
Route::get('/', function () {
    return view('test');
});
*/

Route::get('/', HomeController::class);
// ONLY BECAUSE HOMECONTROLLER HAS A SINGLE METHOD : I changes method index() to method __invoke() in app/Http/Controllers
//Route::get('/', [HomeController::class, 'index']); // I created HomeController to replace code right below

/*
Route::get('/', function () {
    //return view('welcome');
    //return "Welcome to the HomePage";
});
*/

Route::get('/aisles', [AisleController::class, 'index']); // I created AisleController to replace code right below

/*
Route::get('/aisles', function () { // This is me following CodersFree Tutorial
    return "This view will show the merchandising menu to manage the aisles";
    // $aisle = sodas, water, beer, dairy
});
*/

Route::get('/aisles/create', [AisleController::class, 'create']); // I created AisleController to replace code right below

/*
Route::get('/aisles/create', function () { // This is me following CodersFree Tutorial
    return "This view will show form to create a new aisle";
    // $aisle = sodas, water, beer, dairy
});
*/

Route::get('/aisles/{id}/{category?}', [AisleController::class, 'map']); // I created AisleController to replace code right below

/*
Route::get('/aisles/{id}/{category?}', function ($id, $category = null) { // This is me following CodersFree Tutorial - question mark after category declares variable as optional
    if ($category) {return "This view will map the aisle \"{$id}\" and the products stored in the shelves \"{$category}\"...";}
    return "This view will map the aisle \"{$id}\".";
    // $aisle = 1 - 2 - 3
    // $category = sodas, water, beer, dairy
});
*/

Route::get('/section/{id}', [SectionController::class, 'show']);

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