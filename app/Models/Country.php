<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class Country extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;
    protected $table = 'countries';
    public array $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $hidden = ['translations'];

    public function cities(): HasMany
    {
        return $this->hasMany(City::class , 'country_id' , 'id');
    }
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class , 'country_id' , 'id');
    }
}
