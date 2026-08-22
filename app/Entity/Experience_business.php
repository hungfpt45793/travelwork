<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Experience_business extends Model
{
    protected $table = 'experience_business';
    protected $primaryKey = 'exp_bus_id';
    protected $fillable = [
        'exp_bus_id',
        'exp_bus_name',
        'exp_bus_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
