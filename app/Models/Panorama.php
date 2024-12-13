<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // This was added by me

class Panorama extends Model
{
    //
    use HasFactory;
    protected $table = 'panoramas'; // This was added by me (not really necessary because I used class plural)
    protected $fillable = [ // These are the only attributes that can be mass-assigned by faker
        //
    ];

    // Relationship with Sections
    public function section()
    {
        return $this->belongsTo(Section::class, 'related_section_id', 'id');
    }

}
