<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Employee_delete_request extends Model
{
    protected $table = 'employee_delete_request';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'employee_id',
        'staff_id',
        'created_at'
    ];
}