<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class EmployeeSoftware extends Model
{
    protected $table = 'employee_software';
    protected $primaryKey = 'employee_software_id';
    protected $fillable = [
        'employee_software_id',
        'employee_id',
        'software_id',
        'created_at',
        'updated_at'
    ];
}
