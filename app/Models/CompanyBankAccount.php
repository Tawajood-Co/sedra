<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyBankAccount extends Model
{
    use HasFactory;

    protected $table = 'company_bank_accounts';
    protected $guarded = [];
    protected $hidden = [];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class , 'company_id' , 'id');
    }

}
