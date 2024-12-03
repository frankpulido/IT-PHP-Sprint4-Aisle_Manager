<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /*
    public function index() {
        //return view('welcome'); // Welcome is Laravel homepage
        return "This is me fooling around";
    }
    */
    // When we have only 1 method we can use __invoke
    public function __invoke() {
        $title = "AisleManager - FloorPlan";
        return view('home', compact('title'));
        //return "The homepage should show the grocery store FloorPlan... The menu will have a button [ FLOOR PLAN ] to return home";
    }
}
?>