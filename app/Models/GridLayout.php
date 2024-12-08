<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory; // This was added by me


class GridLayout extends Model
{
    use HasFactory;
    protected $table = 'grid_layouts'; // This was added by me (not really necessary because I used class plural)
    protected $fillable = [ // These are the only attributes that can be mass-assigned by faker
        'gridlayoutcss'
    ];

    public function sections()
    {
        return $this->hasMany(Section::class, 'grid_id');
    }

}
