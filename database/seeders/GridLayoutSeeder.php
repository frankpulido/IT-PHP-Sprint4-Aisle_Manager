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
             [1, 'section-grid-1'],
             [2, 'section-grid-2'],
             [3, 'section-grid-3'],
             [4, 'section-grid-4'],
             [4, 'section-grid-4-flexible1'],
             [4, 'section-grid-4-flexible2'],
             [5, 'section-grid-5'],
             [5, 'section-grid-5-flexible1'],
             [6, 'section-grid-6-flexible1'],
             [6, 'section-grid-6-flexible2'],
             [8, 'section-grid-8-flexible1'],
             [9, 'section-grid-9'],
             [10, 'section-grid-10'],
             [12, 'section-grid-12'],
             [15, 'section-grid-15'],
             [20, 'section-grid-20'],
         ];
     
         foreach ($layouts as $layout) {
             GridLayout::create([
                 'number_products' => $layout[0],
                 'gridlayoutcss' => $layout[1],
             ]);
         }
    }

    /*
    public function run(): void
    {   
        /*$layouts = [
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
        ];*/
/*
        $layouts = [
            ['gridlayoutcss' => 'section-grid-1', 'number_products' => 1],
            ['gridlayoutcss' => 'section-grid-2', 'number_products' => 2],
            ['gridlayoutcss' => 'section-grid-3', 'number_products' => 3],
            ['gridlayoutcss' => 'section-grid-4', 'number_products' => 4],
            ['gridlayoutcss' => 'section-grid-4-flexible1', 'number_products' => 4],
            ['gridlayoutcss' => 'section-grid-4-flexible2', 'number_products' => 4],
            ['gridlayoutcss' => 'section-grid-5', 'number_products' => 5],
            ['gridlayoutcss' => 'section-grid-5-flexible1', 'number_products' => 5],
            ['gridlayoutcss' => 'section-grid-6-flexible1', 'number_products' => 6],
            ['gridlayoutcss' => 'section-grid-6-flexible2', 'number_products' => 6],
            ['gridlayoutcss' => 'section-grid-8-flexible1', 'number_products' => 8],
            ['gridlayoutcss' => 'section-grid-9', 'number_products' => 9],
            ['gridlayoutcss' => 'section-grid-10', 'number_products' => 10],
            ['gridlayoutcss' => 'section-grid-12', 'number_products' => 12],
            ['gridlayoutcss' => 'section-grid-15', 'number_products' => 15],
            ['gridlayoutcss' => 'section-grid-20', 'number_products' => 20],
        ];

        foreach ($layouts as $layout) {
            GridLayout::create(['gridlayoutcss' => $layout]);
        }
    }
        */
}
