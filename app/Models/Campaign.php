<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Campaign extends Model implements TranslatableContract
{
    use Translatable;
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'campaigns';
    public array $translatedAttributes = ['name', 'description'];
    protected $guarded = [];
    protected $hidden = ['translations'];


    public function getImgAttribute($value) {
        return asset('uploads/companies/campaigns/'.$value);
    }


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
