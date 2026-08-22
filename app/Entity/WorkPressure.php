<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class WorkPressure extends Model
{
    protected $table = 'work_pressure';
    protected $primaryKey = 'work_id';
    protected $fillable = [
        'work_id',
        'work_name',
        'work_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
