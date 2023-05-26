<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignTranslation extends Model
{
    use HasFactory;

    protected $table = 'campaign_translations';
    protected $guarded = [];
    public $timestamps = false;
}
