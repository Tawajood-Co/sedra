<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarcodeTemplate extends Model
{
    use HasFactory;
    protected $table='barcode_templats';
    protected $guarded=[];
}
