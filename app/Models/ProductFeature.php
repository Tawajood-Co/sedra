<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeature extends Model implements TranslatableContract
{
    use HasFactory;
    use Translatable;

    protected $table = 'product_features';
    public array $translatedAttributes = ['feature', 'value'];
    protected $guarded = [];
    protected $hidden = ['translations'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class , 'product_id' , 'id');
    }
}
