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

    public function swapAisles(Request $request)
    {
        // Retrieve aisle IDs from the form
        $aisle1Id = $request->input('aisle1');
        $aisle2Id = $request->input('aisle2');

        // Call the private method to handle the swap
        $this->executeAislesSwap($aisle1Id, $aisle2Id);

        // Fetch all aisles to update the view
        $aisles = Aisle::with('sections')->get();
        return view('aisles.index', ['aisles' => $aisles]);
    }


    private function executeAislesSwap($aisle1Id, $aisle2Id)
    {
        // Fetch aisles by their IDs, and get the sections for each aisle
        $aisle1 = Aisle::findOrFail($aisle1Id);
        $aisle2 = Aisle::findOrFail($aisle2Id);
    
        // Loop through each section of aisle 1
        foreach ($aisle1->sections as $section1) {
            // Try to find the corresponding section in aisle 2 with the same aisle_order
            $section2 = $aisle2->sections->firstWhere('aisle_order', $section1->aisle_order);
    
            if ($section2) {
                // Both sections exist, swap their aisle_ids
                $section1->aisle_id = $aisle2->id;
                $section2->aisle_id = $aisle1->id;
    
                // Save both sections after swapping
                $section1->save();
                $section2->save();
            } else {
                // Only section 1 exists, move it to aisle 2
                $section1->aisle_id = $aisle2->id;
                $section1->save();
            }
        }
    
        // Now handle the reverse: any section in aisle 2 that doesn't exist in aisle 1
        foreach ($aisle2->sections as $section2) {
            // Check if this section exists in aisle 1
            $section1 = $aisle1->sections->firstWhere('aisle_order', $section2->aisle_order);
    
            if (!$section1) {
                // Only section 2 exists, move it to aisle 1
                $section2->aisle_id = $aisle1->id;
                $section2->save();
            }
        }
    }


    public function swapSections(Request $request)
    {
        // Get the aisle and section info from the form
        [$aisle1Id, $section1Order] = explode(',', $request->input('section1'));
        [$aisle2Id, $section2Order] = explode(',', $request->input('section2'));

        // Fetch the aisles
        $aisle1 = Aisle::findOrFail($aisle1Id);
        $aisle2 = Aisle::findOrFail($aisle2Id);

        // Fetch the sections to swap based on their aisle_order
        $section1 = $aisle1->sections->firstWhere('aisle_order', $section1Order);
        $section2 = $aisle2->sections->firstWhere('aisle_order', $section2Order);

        if ($section1 && $section2) {
            // Step 1: Set section 2's aisle_id and aisle_order to null (to avoid constraint violations)
            $section2->aisle_id = null;
            $section2->aisle_order = null;
            $section2->save();
    
            // Step 2: Swap section 1's values with section 2
            $section1->aisle_id = $aisle2->id;
            $section1->aisle_order = $section2Order;
            $section1->save();
    
            // Step 3: Restore section 2's values
            $section2->aisle_id = $aisle1->id;
            $section2->aisle_order = $section1Order;
            $section2->save();
        }

        // Fetch all aisles to update the view
        $aisles = Aisle::with('sections')->get();
        return view('aisles.index', ['aisles' => $aisles]);
        

        // Redirect back to the aisles page to refresh
        //return redirect()->route('aisles.index');
    }

    /*
    public function swapSections(Request $request)
    {
        // Validate the inputs (aisle1, aisle2, section1, section2)
        $request->validate([
            'section1' => 'required|string',
            'section2' => 'required|string',
        ]);

        // Extract aisle_id and aisle_order from the selected values
        [$aisle1Id, $aisle1Order] = explode(',', $request->section1);
        [$aisle2Id, $aisle2Order] = explode(',', $request->section2);

        // Perform the section swap
        $this->swapAisles($aisle1Id, $aisle2Id);

        // Fetch the aisles and sections after swapping
        $aisles = Aisle::with('sections')->get();

        // Redirect back to the same page with the updated aisles
        return view('aisles.index', compact('aisles'));
    }
    */




    
    
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