<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_handling extends Model
{
    protected $table = 'employee_handling';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id_handling',
        'employee_id',
        'status',
        'feedback',
        'created_at'
    ];
}
