<?php

namespace App\Http\Controllers;
use App\Models\Aisle;
use App\Models\GridLayout;
use App\Models\Section;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


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

        return view('sections.orphaned', compact('sections', 'aisles'));
    }


    public function nestOrphaned(Request $request)
    {
        Log::info('Request Data:', $request->all()); // debugging with logs/laravel.log
        // Validate the Form input
        $request->validate([
            'orphaned_section_id' => 'required|exists:sections,id',
            'aisle_id' => 'required|exists:aisles,id',
            'aisle_order' => 'required|integer|min:1',
        ]);
    
        // Retrieve the orphaned section
        $orphanedSection = Section::findOrFail($request->input('orphaned_section_id'));
    
        // Assign the first matching grid layout (number of products)
        $gridLayout = GridLayout::where('number_products', $orphanedSection->number_products)->first();
        if (!$gridLayout) {
            return redirect()->back()->withErrors('No matching grid layout found for the orphaned section.');
        }
    
        // Retrieve the section currently occupying the selected position
        $aisle_id = $request->input('aisle_id');
        $aisle_order = $request->input('aisle_order');
        $sectionToReplace = Section::where('aisle_id', $aisle_id)
                                    ->where('aisle_order', $aisle_order)
                                    ->first();
    
        // Clear the position if a section exists
        if ($sectionToReplace) {
            $sectionToReplace->aisle_id = null;
            $sectionToReplace->aisle_order = null;
            $sectionToReplace->update();
        }
    
        // Update the orphaned section
        $orphanedSection->grid_id = $gridLayout->id;
        $orphanedSection->aisle_id = $aisle_id;
        $orphanedSection->aisle_order = $aisle_order;
        $orphanedSection->save();
    
        // Redirect to the index view
        return redirect()->route('aisles.index')->with('success', 'Orphaned section successfully nested!');
    }
    


    public function createSection(Request $request)
    {
        // Retrieve layouts
        $layouts = GridLayout::all();

        // Get coordinates (query) to nest in the right place
        $aisleId = $request->query('aisle_id');
        $position = $request->query('position');
        // Add enum kind (I should have created another Model)
        $kinds = ['food', 'fresh food', 'personal care', 'cleaning', 'dairy', 'beer', 'water', 'beverages'];

        return view('sections.create', compact('layouts', 'aisleId', 'position', 'kinds'));
    }


    public function createBridge(Request $request)
    {
        
        //Log::info('Request Data:', $request->all()); // debugging with logs/laravel.log
        
        // Validate the input
        $request->validate([
            'aisle_id' => 'required|exists:aisles,id',
            'position' => 'required|integer|min:1',
            'grid_id' => 'required|exists:grid_layouts,id',
            'kind' => 'required|string|in:food,fresh food,personal care,cleaning,dairy,beer,water,beverages',
        ]);

        $gridLayout = GridLayout::findOrFail($request->input('grid_id'));
        
        // Create the section using direct assignment
        $section = new Section();
        $section->aisle_id = $request->aisle_id;
        $section->aisle_order = $request->position;
        $section->kind = $request->kind;
        $section->number_products = $gridLayout->number_products;
        $section->grid_id = $request->grid_id;
        $section->save();

        // THIS WAS THE ISSUE : IF USING Section::Create we have the "fillable" restrictions of the Model
        /* Create a new Section
        $section = Section::create([
            'aisle_id' => $request->input('aisle_id'),
            'aisle_order' => $request->input('position'),
            'kind' => $request->input('kind'),
            'number_products' => $gridLayout->number_products, // Set from the grid layout
            //'number_products' => GridLayout::find($request->input('grid_id'))->number_products,
            'grid_id' => $request->input('grid_id'),
        ]);
        */

        
        //Redirect to editSection for the newly created section
        return redirect()->route('section.edit', ['section_id' => $section->id])
                        ->with('success', 'Section created successfully! Now you can add products.');
        
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
        //Log::info('Request Data:', $request->all()); // debugging with logs/laravel.log

        // Validate the request
        $request->validate([
            'matching_products.*' => 'nullable|exists:products,id',
        ]);

        
        // Withdraw existing products from the Section. Remember migration restriction :
        // $table->unique(['section_id', 'section_order'], 'position_unique');
        Product::where('section_id', $section->id)
        ->update(['section_id' => null, 'section_order' => null]);


        // Update products in the section
        foreach ($request->matching_products as $section_order => $product_id) {

            $section_order = (int) $section_order; // Explicitly cast to integer (needed?? check)
            
            if ($product_id) {
                $product = Product::findOrFail($product_id);

                // Use explicit property assignment and save
                $product->section_id = $section->id;
                $product->section_order = $section_order;
                $product->save();
            
                //THE CODE BELOW DOESN'T WORK IF THERE ARE FILLABLE RESTRICTIONS !!!!
                /*
                Product::findOrFail($product_id)->update([
                    'id' => $section->id,
                    'section_order' => $section_order,
                ]);
                */
            }
        }

        // Redirect back to the section view
        return redirect()->route('sections.show', ['id' => $section->id])
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