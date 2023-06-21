<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table='cart';
    public $guarded=[];

    public function items()
    {
        return $this->hasMany(CartItem::class , 'cart_id' , 'id');
    }


}
