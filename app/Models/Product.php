<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $table = 'products';
    public array $translatedAttributes = ['name', 'description'];
    protected $guarded = [];
    protected $hidden = ['translations'];

    public function productFeatures(): HasMany
    {
        return $this->hasMany(ProductFeature::class , 'product_id' , 'id');
    }

    public function imgs(): HasMany
    {
        return $this->hasMany(ProductImg::class , 'product_id' , 'id');
    }

    public function getMainImgAttribute($value){

        return asset('uploads/products/main_imgs/'.$value);
    }
}
