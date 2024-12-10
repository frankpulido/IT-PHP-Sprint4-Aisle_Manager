<?php

namespace App\Http\Controllers;
use App\Models\Aisle;
use App\Models\GridLayout;
use App\Models\Section;
use Illuminate\Http\Request;

class AisleController extends Controller
{
    public function index() {
        //$aisles = Aisle::all();
        //return $aisles;
        $aisles = Aisle::with(['sections' => function ($query) {
            $query->orderBy('aisle_id')->orderBy('aisle_order');  // Order by aisle_id and then by aisle_order within each aisle;
        }])->get();
        return view('aisles.index', ['aisles' => $aisles]);
    }

    /* SEE BELOW
    public function show($id) {
        //$aisle = Aisle::find($id);
        //return $aisle;
    }
    */

    public function showAisle($id) {
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

    public function showSection($id) {
        return "This page will show details of section $id";
        //return view('sections.show', ['id' => $id]); // returns sections/show.blade.php passing variable "id"
        //$section = Section::find($id); // OJO, ABAJO HAY QUE PASAR TB LA $SECTION
        //return view('sections.show', compact('id')); // returns sections/show.blade.php passing variable "id"
    }



    public function swapAisles(Request $request)
    {
        // Retrieve aisle IDs from the form
        $aisle1Id = $request->input('aisle1');
        $aisle2Id = $request->input('aisle2');

        // Fetch aisles and their respective sections
        $aisle1 = Aisle::findOrFail($aisle1Id);
        $aisle2 = Aisle::findOrFail($aisle2Id);

        // Ensure both aisles have the same number of sections
        $maxSections = max($aisle1->number_sections, $aisle2->number_sections);

        // Iterate through all possible positions in the aisles
        for ($aisleOrder = 1; $aisleOrder <= $maxSections; $aisleOrder++) {
            // Formulate the data for `swapSections`
            $section1Key = "{$aisle1Id},{$aisleOrder}";
            $section2Key = "{$aisle2Id},{$aisleOrder}";

            // Simulate a request for swapping the sections
            $this->swapSections(new Request([
                'section1' => $section1Key,
                'section2' => $section2Key,
            ]));
        }

        // Redirect back to the aisles index page
        return redirect()->route('aisles.index');
    }


    public function swapSections(Request $request)
    {
        // Get the sections from the request
        list($aisle1Id, $section1Order) = explode(',', $request->input('section1'));
        list($aisle2Id, $section2Order) = explode(',', $request->input('section2'));

        // Retrieve the sections from the database
        $section1 = Section::where('aisle_id', $aisle1Id)
            ->where('aisle_order', $section1Order)
            ->first();

        $section2 = Section::where('aisle_id', $aisle2Id)
            ->where('aisle_order', $section2Order)
            ->first();

        // Case 1 : Both sections exist
        if ($section1 && $section2) {
            // Step 1: Set section 2's aisle_id and aisle_order to null
            $section2->aisle_id = null;
            $section2->aisle_order = null;
            $section2->save();

            // Step 2: Set section 1's aisle_id and aisle_order to section 2's original values
            $section1->aisle_id = $aisle2Id;
            $section1->aisle_order = $section2Order;
            $section1->save();

            // Step 3: Set section 2's aisle_id and aisle_order to section 1's original values
            $section2->aisle_id = $aisle1Id;
            $section2->aisle_order = $section1Order;
            $section2->save();

            // Fetch updated aisles to display updated content
            //$aisles = Aisle::with('sections')->get();

            // Redirect back to the aisles index page with updated data
            return redirect()->route('aisles.index');
        }

        // Case 2 : Neither sections exist : Do nothing
        if (!$section1 && !$section2) {
            return redirect()->route('aisles.index');
        }

        // Case 3: Section 1 does not exist
        if (!$section1) {
            $section2->aisle_id = $aisle1Id;
            $section2->aisle_order = $section1Order;
            $section2->save();

            return redirect()->route('aisles.index');
        }

        // Case 4: Section 2 does not exist
        if (!$section2) {
            $section1->aisle_id = $aisle2Id;
            $section1->aisle_order = $section2Order;
            $section1->save();

            return redirect()->route('aisles.index');
        }

        // Just in case, but this is impossible
        return redirect()->route('aisles.index')->with('error', 'Sections not found.');
    }

    public function orphanedSections()
    {
        // Retrieve sections where aisle_id and aisle_order are null
        $sections = Section::whereNull('aisle_id')->whereNull('aisle_order')
            ->with('products') // Load related products
            ->get();

        return view('aisles.orphaned', compact('sections'));
    }

    public function createSection()
    {
        // Retrieve layouts
        $layouts = GridLayout::all();
        return view('aisles.create', compact('layouts'));
    }








    // Code below is not in use

    
    
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