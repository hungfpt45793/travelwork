<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class ResultRoomExam extends Model
{
    protected $table = 'result_room_exam';
    protected $primaryKey = 'id_result_room';
    protected $fillable = [
        'id_room',
        'id_result_room',
        'user_exam_room',
        'id_exam',
        'correct_question_1',
        'correct_question_2',
        'correct_question_3',
        'time_user_star_room',
        'created_at',
        'updated_at',
    ];
    public  static function checkUserRoom($id_room,$id_user)
    {
        $result = ResultRoomExam::select('*')->where('id_room',$id_room)->where('user_exam_room',$id_user)->first();
       return $result;
    }
    public static function getResultRoomExam($id_result_room)
    {
        $result = ResultRoomExam::select('*')->where('id_result_room',$id_result_room)->first();
        return $result;
    }
    public static function total_result_room($id_room)
    {
        $result = ResultRoomExam::select('*')->where('id_room',$id_room)->count();
        return $result;
    }
}
