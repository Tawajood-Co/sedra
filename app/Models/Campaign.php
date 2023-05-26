<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Campaign extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;

    protected $table = 'campaigns';
    public array $translatedAttributes = ['name', 'description'];
    protected $guarded = [];
    protected $hidden = ['translations'];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class , 'company_id' , 'id');
    }
    public function campaignOfficial(): HasOne
    {
        return $this->hasOne(CampaignOfficial::class , 'campaign_id' , 'id');
    }
    public function regiments(): HasMany
    {
        return $this->hasMany(Regiment::class , 'campaign_id' , 'id');
    }


}
