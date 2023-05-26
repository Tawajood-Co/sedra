<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;

    protected $table = 'cities';
    public array $translatedAttributes = ['name'];
    protected $guarded = [];
    protected $hidden = ['translations'];

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class , 'country_id' , 'id');
    }
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class , 'city_id' , 'id');
    }

}
