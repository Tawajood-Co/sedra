<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImg extends Model
{
    use HasFactory;
    protected $table='product_imgs';
    protected $guarded=[];

    public function getImgAttribute($value){

        return asset('uploads/products/imgs/'.$value);
    }
}
