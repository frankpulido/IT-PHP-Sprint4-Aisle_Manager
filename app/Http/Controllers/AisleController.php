<?php

namespace App\Http\Controllers;
use App\Models\Aisle;
use Illuminate\Http\Request;

class AisleController extends Controller
{
    public function index() {
        $aisles = Aisle::all();
        return $aisles;
        //return "Aisles floorplan"; // Check notes in iphone
        //return view('aisles.index', [$aisles]);
    }
    
    public function create() {
        return view('aisles.create');
        /* Ver minuto 06:00 Episodio Lista Coders Free "09 - Eloquent - Curso Laravel 11 desde cero"
        $aisle = new Aisle();
        $aisle->name = 'Perishable';
        $aisle->number_products = 8;
        $aisle->save();
        return $aisle;
        */
    }

    public function find($id) {
        $aisle = Aisle::find($id);
        return $aisle;
    }

    public function map($id, $category = 'ALL') {
        //dd($id, $category); // dump and die debugging... variables are being passed
        return view('aisles.map', ['aisle' => $id, 'category' => $category]);
        /*
        if ($category) {return "This view will map the aisle \"{$aisle}\" and the products stored in the shelves of section \"{$category}\"...";}
        return "This view will map the aisle \"{$aisle}\".";
        */
        // $aisle = 1 - 2 - 3
        // $category = sodas, water, beer, dairy
    }
}
?>