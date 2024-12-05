<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // This was added by me

class Product extends Model
{
    use HasFactory;
    protected $table = 'products'; // This was added by me (not really necessary because I used class plural)
    protected $fillable = [ // These are the only attributes that can be mass-assigned by faker
        'name',
        'kind', // An enum identifying the kind od products displayed in each section (same enum column for sections, must match)
        'price',
    ];

    // Relationship to Section
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
}
