<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_employee extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_employee';
    protected $primaryKey = 'course_employee_id';
    protected $fillable = [
        'course_employee_id',
        'employee_id',
        'course_id',
        'activation_code',
        'courde_profile',
        'status_select_active_code',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    static function isEmployeeOwnCourse($course_id,$employee_id){
        $courseEmployeeModel = new Course_employee();
        $courses = $courseEmployeeModel
            ->where('employee_id', $employee_id)
            ->where('courses.course_id',$course_id)
            ->join('courses', 'courses.course_id', 'course_employee.course_id')
            ->count();
        return !($courses == 0);
    }
    public static function get_total_employee($course_id)
    {
        return $total_employee = Course_employee::where('course_id',$course_id)->count();
    }
    public static function check_employee($employee_id,$course_id)
    {
        return $total_employee = Course_employee::where('employee_id',$employee_id)
            ->where('course_id',$course_id)
            ->count();
    }
}
