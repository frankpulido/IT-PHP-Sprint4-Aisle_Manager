<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\GridLayout;

class GridLayoutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {   
        $layouts = [
            'section-grid-1',
            'section-grid-2',
            'section-grid-3',
            'section-grid-4',
            'section-grid-4-flexible1',
            'section-grid-4-flexible2',
            'section-grid-5',
            'section-grid-5-flexible1',
            'section-grid-6-flexible1',
            'section-grid-6-flexible2',
            'section-grid-8-flexible1',
        ];

        foreach ($layouts as $layout) {
            GridLayout::create(['gridlayoutcss' => $layout]);
        }
    }
}
