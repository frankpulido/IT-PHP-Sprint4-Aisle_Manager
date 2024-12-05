<?php

namespace App\Http\Controllers;
use App\Models\Aisle;
use Illuminate\Http\Request;

class AisleController extends Controller
{
    public function index() {
        //$aisles = Aisle::all();
        //return $aisles;
        $aisles = Aisle::with(['sections' => function ($query) {
            $query->orderBy('aisle_order');
        }])->get();
        return view('aisles.index', ['aisles' => $aisles]);
    }

    /* SEE BELOW
    public function show($id) {
        //$aisle = Aisle::find($id);
        //return $aisle;
    }
    */

    public function show($id) {
        // Retrieve the aisle with its sections and their products
        $aisle = Aisle::with([
            'sections' => function ($query) {
                $query->orderBy('aisle_order'); // Order sections in the aisle
            },
            'sections.products' => function ($query) {
                $query->orderBy('section_order'); // Order products within each section
            }
        ])->find($id);
    
        // Check if the aisle exists
        if (!$aisle) {
            abort(404, 'Aisle not found');
        }

        //dd($aisle->toArray());
        return view('aisles.show', compact('aisle'));
    }

    public function swap(Request $request) {

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

    /*
    public function find($id) {
    $aisle = Aisle::find($id);
    return $aisle;
    }
    */

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