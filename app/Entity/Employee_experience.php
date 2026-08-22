<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Employee_experience extends Model
{
    protected $table = 'employees_experience';
    protected $primaryKey = 'experience_id';
    protected $fillable = [
        'experience_id',
        'experience_title',
        'star_working_time',
        'end_working_time',
        'company',
        'business',
        'type_of_business_id',
        'position',
        'des_position',
        'employee_id', // địa chỉ tạm trú
        'created_at',
    ];
    public static function get_all_employee_id($employee_id)
    {
        $experience = New Employee_experience();
        $experience = $experience->select('*')
            ->where('employee_id',$employee_id)
            ->get();
        return $experience;
    }
}
