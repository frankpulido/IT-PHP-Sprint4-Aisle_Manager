<?php

namespace App\Http\Controllers;
use App\Models\Aisle;
use App\Models\GridLayout;
use App\Models\Section;
use App\Models\Product;
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
        $section = Section::with([
            'products' => function ($query) {
                $query->orderBy('section_order');
            }
        ])->find($id);
        //return $section;
        return view('sections.show', compact('section')); // returns sections/show.blade.php
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
        // Retrieve ALL possible locations within the store
        $aisles = Aisle::all();

        // Retrieve Sections where aisle_id and aisle_order are null
        $sections = Section::whereNull('aisle_id')->whereNull('aisle_order')
            ->with('products') // Load related products
            ->get();

        return view('aisles.orphaned', compact('sections', 'aisles'));
    }


    public function nestOrphaned(Request $request)
    {
        // Validate the Form input
        $request->validate([
            'orphaned_section_id' => 'required|exists:sections,id',
            'aisle_id' => 'required|exists:aisles,id',
            'aisle_order' => 'required|integer|min:1',
        ]);

        $orphanedSection = Section::findOrFail($request->orphaned_section_id);

        // Assign the first matching grid layout (number products)
        $gridLayout = GridLayout::where('number_products', $orphanedSection->number_products)->first();
        if (!$gridLayout) {
            return redirect()->back()->withErrors('No matching grid layout found for the orphaned section.');
        }

        // Update the orphaned section
        $orphanedSection->grid_id = $gridLayout->id;
        $orphanedSection->aisle_id = $request->aisle_id;
        $orphanedSection->aisle_order = $request->aisle_order;
        $orphanedSection->save();

        // Call swapSections to handle potential conflicts
        $this->swapSections($request);

        // GOTO index view
        return redirect()->route('aisles.index')->with('success', 'Orphaned section successfully nested and swapped!');
    }



    public function createSection(Request $request)
    {
        // Retrieve layouts
        $layouts = GridLayout::all();

        // Get coordinates (query) to nest in the right place
        $aisleId = $request->query('aisle_id');
        $position = $request->query('position');

        return view('sections.create', compact('layouts', 'aisleId', 'position'));
    }



    public function editSection(Request $request)
    {
        $section = Section::with(['products', 'gridLayout'])->findOrFail($request->section_id);
        $matchingProducts = Product::where('kind', $section->kind)->get();
        // Receives the section data and forwards it to the edit view
        return view('sections.edit', compact('section', 'matchingProducts'));
    }



    public function updateSection(Request $request)
{
    $section = Section::findOrFail($request->section_id);

    // Validate the request
    $request->validate([
        'matching_products.*' => 'nullable|exists:products,id',
    ]);

    // Update products in the section
    foreach ($request->matching_products as $section_order => $product_id) {
        if ($product_id) {
            $product = Product::findOrFail($product_id);
            $product->update([
                'section_id' => $section->id,
                'section_order' => $section_order,
            ]);
        }
    }

    // Redirect back to the section view
    return redirect()->route('section.show', ['section_id' => $section->id])
        ->with('success', 'Section updated successfully!');
}





    
    

    /* Ver minuto 06:00 Episodio Lista Coders Free "09 - Eloquent - Curso Laravel 11 desde cero"
    $aisle = new Aisle();
    $aisle->name = 'Perishable';
    $aisle->number_products = 8;
    $aisle->save();
    return $aisle;
    */
    

}
?>