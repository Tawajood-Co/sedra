<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Company extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'companies';
    protected $guarded = [];
    protected $hidden = [
        'password',
    ];


    public function getJWTIdentifier() {
        return $this->getKey();
    }
    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims() {
        return [];
    }





    public function setPasswordAttribute($value) {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getLogoAttribute($value) {
        return asset('uploads/companies/'.$value);
    }


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
