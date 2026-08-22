<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_employee_status extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;
    protected $table = 'course_employee_status';
    protected $primaryKey = 'course_employee_status_id';
    protected $fillable = [
        'course_employee_status_id',
        'employee_id',
        'course_id',
        'course_chapter_id',
        'course_content_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    static function getProcess($course_id,$emplyee_id){
        $courseModel = new Courses();
        $total = $courseModel
            ->join('course_chapter_contents','course_chapter_contents.course_id','courses.course_id')
            ->where('courses.course_id',$course_id)
            ->count();
        $courseEmployeeModel = new Course_employee_status();
        $learned = $courseEmployeeModel->where('course_id',$course_id)
            ->where('employee_id',$emplyee_id)
            ->count();
        return ['total'=> $total,
                'learned'=>$learned
            ];
    }
}
