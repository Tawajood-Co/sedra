<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'settings';
    public array $translatedAttributes = ['about_us', 'terms', 'policy'];
    protected $guarded = [];
    protected $hidden = ['translations'];
}
