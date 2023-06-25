<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTransfare extends Model
{
    use HasFactory;
    protected $table='bank_transfares';
    protected $guarded=[];
}
