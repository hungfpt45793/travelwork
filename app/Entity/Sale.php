<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $table = 'sale_package';
    protected $primaryKey = 'sale_package_id';
    protected $fillable = [
        'sale_package_id',
        'sale_package_name',
        'description',
        'status',
        'price',
        'recruit_number',
        'recruited',
        'province',
        'district',
        'contract_signing_date',
        'paid',
        'discount',
        'affiliate_id',
        'employer_id',
        'user_id',
        'created_at',
        'updated_at',
        'date_end'
    ];
}
