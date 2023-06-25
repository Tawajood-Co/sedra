<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankTranslation extends Model
{
    use HasFactory;
    protected $table='bank_translations';
    protected $guarded=[];
}
