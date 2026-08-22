<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;


class Employee_profile extends Model
{
    public $timestamps = false;
    protected $table = 'employee_profile';
    protected $primaryKey = 'profile_id';
    protected $fillable = [
        'profile_id',
        'employee_id',
        'profile_info',
        'profile_cv',
        'profile_staff',
        'profile_course',
        'profile_avg',
        'created_at',
        'updated_at'
    ];
    public static function get_employee_profile($employee_id)
    {
        $get_employee_profile = Employee_profile::where('employee_id',$employee_id)->first();
        return $get_employee_profile;
    }
}
