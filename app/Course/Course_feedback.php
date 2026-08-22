<?php

namespace App\Course;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Course_feedback extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'course_feedback';
    protected $primaryKey = 'course_feedback_id';
    protected $fillable = [
        'course_feedback_id',
        'employee_id',
        'ratings',
        'course_id',
        'course_feedback_descript',
        'course_feedback_status',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    static function getCourseFeedback($course_id){
        $courseFeedbackModel = new Course_feedback();

        $course_feedbacks = $courseFeedbackModel
            ->select('employees.employee_id',
                'employees.employee_name',
                'employees.employee_image',
                'course_feedback.ratings',
                'course_feedback.course_id',
                'course_feedback.course_feedback_descript'
            )
            ->join('employees', 'employees.employee_id', 'course_feedback.employee_id')
            ->where('course_feedback_status', 1)
            ->where('course_id',$course_id)
            ->limit(12)
            ->get();
        return $course_feedbacks;
    }
    static function getAllCourseFeedback()
    {
        $courseFeedbackModel = new Course_feedback();

        $course_feedbacks = $courseFeedbackModel
            ->select('employees.employee_id',
                'employees.employee_name',
                'employees.employee_image',
                'employees.information_verifier',
                'course_feedback.ratings',
                'course_feedback.course_id',
                'course_feedback.course_feedback_descript'
            )
            ->join('employees', 'employees.employee_id', 'course_feedback.employee_id')
            ->where('course_feedback_status', 1)
            ->limit(12)
            ->get();
        return $course_feedbacks;
    }

    static function getRatings($course_slug)
    {
        $course_id = Courses::where('course_slug',$course_slug)->first()['course_id'];
        if(!isset($course_id))
        {
            return ['star' => 5, 'total_feedback' => 0];
        }
        $feedbackModel = new Course_feedback();
        $star = $feedbackModel->where('course_id', $course_id)
            ->where('course_feedback_status', 1)
            ->avg('ratings');
        $total_feedback = $feedbackModel->where('course_id', $course_id)
            ->count();


        return ['star' => $star, 'total_feedback' => $total_feedback];
    }

}
