<?php

namespace App\Models;

use Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // This was added by me

class Aisle extends Model
{
    use HasFactory;
    protected $table = 'aisles'; // This was added by me (not really necessary because I used class plural)
    protected $fillable = [ // These are the only attributes that can be mass-assigned by faker
        'name',
        'number_sections', // necessary regardless of the php_layout
        //'sections', // this array was replaced by foreign key and aisle_order in table sections
        //'php_layout',
    ];

    
    public function sections() // Define relationship with Sections (one aisle has many sections)
    {
        return $this->hasMany(Section::class)->orderBy('aisle_order');
    }

}
