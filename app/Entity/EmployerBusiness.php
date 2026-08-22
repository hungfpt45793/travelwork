<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployerBusiness extends Model
{
    protected $table = 'employer_business_type';
    protected $primaryKey = 'employer_business_type_id';
    protected $fillable = [
        'employer_business_type_id',
        'employer_id',
        'business_type_id',
        'recruit',
		'recruited',
		'price',
        'created_at',
        'updated_at'
    ];
}
