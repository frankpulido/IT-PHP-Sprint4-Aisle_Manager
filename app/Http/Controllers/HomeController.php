<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // When we have only 1 method we can use __invoke
    public function __invoke() {
        $title = "AisleManager - FloorPlan";
        return view('home', compact('title'));
        // This will show the project purpose, articles with KPIs and a link to README and GitHub repository
    }
}
?>