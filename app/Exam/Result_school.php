<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Result_school extends Model
{

    protected $table = 'result_school';
    protected $primaryKey = 'id_result';
    protected $fillable = [
        'id_result',
        'id_room',
        'id_exam',
        'id_student',
        'date_result',
        'correct_question',
        'correct_question_2',
        'correct_question_3',
        'created_at',
        'updated_at',
        'star_time_submit',
        'end_time_submit',
    ];
    public static function getResult($id_result,$id_user)
    {
        $result = new ResultExam;
        $result = $result->select('*')->where('id_result',$id_result)->first();
        return $result;
    }
    public static function getResultUser($id_user)
    {
        $result = new ResultExam;
        $results = $result->select('*')->where('id_user',$id_user)
            ->get();
        return $results;
    }
}
