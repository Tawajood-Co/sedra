<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Bank extends Model  implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    protected $table='banks';
    public array $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $hidden = ['translations'];
}
