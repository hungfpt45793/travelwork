<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_specialize extends Model
{
    protected $table = 'employees_specialize';
    protected $primaryKey = 'specialize_id';
    protected $fillable = [
        'specialize_id',
        'specialize_title',
        'star_specialize_time',
        'end_specialize_time',
        'school',
        'majors',
        'leve',
        'specialize_status',
        'employee_id', // địa chỉ tạm trú
        'created_at',
    ];
    public static function get_all_employee_id($employee_id)
    {
        $specialize = New Employee_specialize();
        $specialize = $specialize->select('*')
            ->where('employee_id',$employee_id)
            ->get();
        return $specialize;
    }
}
