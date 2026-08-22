<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployerTypeBusiness extends Model
{
    protected $table = 'employer_typeof_business';
    protected  $primaryKey = 'employer_typeof_business_id';
    protected $fillable = [
        'employer_typeof_business_id',
        'employer_id',
        'type_of_business_id',
		'recruit',
		'recruited',
		'price',
        'created_at',
        'updated_at'
    ];
}
