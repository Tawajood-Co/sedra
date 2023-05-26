<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    protected $guarded = [];
    protected $hidden = [];

    public function companyBankAccounts(): HasMany
    {
        return $this->hasMany(CompanyBankAccount::class , 'company_id' , 'id');
    }
    public function campaign(): HasMany
    {
        return $this->hasMany(Campaign::class , 'company_id' , 'id');
    }
    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class , 'country_id' , 'id');
    }
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class , 'city_id' , 'id');
    }

}
