<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // This was added by me
use Illuminate\Database\Eloquent\Casts\Attribute;  // This was added by me

class Section extends Model
{
    use HasFactory;
    protected $table = 'sections'; // This was added by me (not really necessary because I used class plural)
    protected $fillable = [ // These are the only attributes that can be mass-assigned by faker
        'aisle_id',
        'aisle_order',
        'kind', // An enum identifying the kind od products displayed in each section (same enum column for products, must match)
        'number_products',
        //'products',
        //'php_layout',
    ];

    public function aisle() // Define relationship with Aisle (each section belongs to one aisle)
    {
        return $this->belongsTo(Aisle::class);
    }

    // CHECK IF THIS IS NECESSARY
    protected $casts = [ // Cast the 'products' column to an array
        'products' => 'array',
    ];
}
