<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Regiment extends Model
{
    use HasFactory;

    protected $table = 'regiments';
    protected $guarded = [];
    protected $hidden = [];

    public function campaign(): BelongsTo
    {
        return $this->belongsTo(Campaign::class , 'campaign_id' , 'id');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class , 'user_regiments' , 'regiment_id' , 'user_id' , 'id' , 'id');
    }
}
