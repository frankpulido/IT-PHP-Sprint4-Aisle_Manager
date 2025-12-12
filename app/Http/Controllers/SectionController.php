<?php
declare(strict_types=1);

namespace App\Http\Controllers;
use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function create() {
        //
    }

    public function delete($id) {
        $section = Section::find($id);
        $section->delete();
        return "Section with id $id has been deleted from the database.";
    }

    public function update() {
        //
    }

    /*
    public function show($id) {
        //return "This page will show details of section $id";
        //return view('sections.show', ['id' => $id]); // returns sections/show.blade.php passing variable "id"
        $section = Section::find($id); // OJO, ABAJO HAY QUE PASAR TB LA $SECTION
        return view('sections.show', compact('id')); // returns sections/show.blade.php passing variable "id"
    }
    */

    public function all() {
        $sections = Section::all(); // We could also use Section::get() with same outcome.
        // $sections = Section::get(); // We could also use Section::all() with same outcome.
        // $sections = Section::orderby('kind', 'asc')->get(); // ALL ordered as 'kind' ascendent
        return $sections;
    }

    public function allAisle($aisle_id) {
        $sections = Section::where('aisle_id', $aisle_id)->get();
        return $sections;
    }

    public function find($id) {
        $section = Section::find($id);
        return $section;
    }

    public function findKind($kind) {
        $section = Section::where('kind', $kind)->first();
        return $section;
    }

    public function getLayoutById($id) {
        $layout = Section::find($id)->select('php_layout')->get();
        return $layout;
    }

    public function getLayoutByKind($kind) {
        $layout = Section::where('kind', $kind)->first()->select('php_layout')->get();
        return $layout;
    }
}
?>