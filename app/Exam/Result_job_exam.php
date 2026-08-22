<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Result_job_exam extends Model
{

    protected $table = 'result_job_exam';
    protected $primaryKey = 'id_result_job_exam';
    protected $fillable = [
        'id_result_job_exam',
        'job_id',
        'employee_id',
        'id_exam',
        'correct_question_1',
        'correct_question_2',
        'correct_question_3',
        'created_at',
        'updated_at',
    ];
    public static function getResult($id_result,$id_user)
    {
        $result = new Result_job_exam;
        $result = $result->select('*')->where('id_result_job_exam',$id_result)->first();
        return $result;
    }
    public static function getResultUser($id_user)
    {
        $result = new Result_job_exam;
        $results = $result->select('*')->where('employee_id',$id_user)
            ->get();
        return $results;
    }
    public static function getId_result_job_exam($job_id,$employee_id)
    {
        $result = new Result_job_exam;
        $results = $result->select('*')
            ->where('employee_id',$employee_id)
            ->where('job_id',$job_id)
            ->first();
        return $results;
    }
}
