<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Coefficients_exp extends Model
{
    protected $table = 'coefficients_exp';
    protected $primaryKey = 'coe_exp';
    protected $fillable = [
        'coe_exp',
        'coe_id',
        'exp_id',
        'exp_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
