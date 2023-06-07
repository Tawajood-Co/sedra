<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRegiment extends Model
{
    use HasFactory;

    protected $table = 'user_regiments';
    protected $guarded = [];
    protected $hidden = [];


    public function users()
    {
        return $this->hasMany(User::class ,'id' ,'user_id');
    }

}
