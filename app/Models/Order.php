<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table='orders';
    public $guarded=[];
    public function detailes()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
