<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class DetailResultRoom extends Model
{
    protected $table = 'detail_result_room';
    protected $primaryKey = 'id_detail_result_room';
    protected $fillable = [
        'id_detail_result_room',
        'id_result_room',
        'id_ques',
        'user_correct_ques',
        'updated_at',
    ];
//    tông số câu hỏi đã làm
    public static function countDetailResultRoom($id_result)
    {
        $detail_result_room_exam = new DetailResultRoom();
        $countdetail = $detail_result_room_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_room.id_ques')
            ->where('detail_result_room.id_result_room',$id_result)
            ->count();
        return $countdetail;
    }
    //tong so cau hoi da ;lam
    public static function countRoomDetailType($id_result,$type)
    {
        $detail_result_room_exam = new DetailResultRoom();
        $countdetail = $detail_result_room_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_room.id_ques')
            ->where('detail_result_room.id_result_room',$id_result)
            ->where('questions.type_ques',$type)
            ->count();
        return $countdetail;
    }
//        lay ra cau tra loi
    public static function getRoomAllResult($id_result,$type)
    {
        $detail_result_room_exam = new DetailResultRoom();
        $countdetail = $detail_result_room_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_room.id_ques')
            ->where('detail_result_room.id_result_room',$id_result)
            ->where('questions.type_ques',$type)
            ->get();
        return $countdetail;
    }
    public static  function countRoomDetailAnser($id_result,$type)
    {
        $detail_result_room_exam = new DetailResultRoom();
        $countdetail = $detail_result_room_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_room.id_ques')
            ->where('detail_result_room.id_result_room',$id_result)
            ->where('detail_result_room.user_correct_ques','!=','')
            ->where('questions.type_ques',$type)
            ->count();
        return $countdetail;
    }
    public static function getDetailResult($id_result)
    {
        $detail_result_room_exam = new DetailResultRoom();
        $detail_result_room_exam = $detail_result_room_exam->select('*')
            ->where('id_result_room',$id_result)
            ->first();
        return $detail_result_room_exam;
    }

    public  static function getAnswer($id_result,$id_ques,$type)
    {
        $detail_result_room = new  DetailResultRoom();
        $countdetail = $detail_result_room->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_room.id_ques')
            ->where('detail_result_room.id_result_room',$id_result)
            ->where('questions.id_ques',$id_ques)
            ->where('questions.type_ques',$type)
            ->first();
        return $countdetail;

//        $detail_result_exam = new DetailResultExam();
//        $countdetail = $detail_result_exam->select('*')
//            ->leftJoin('questions','questions.id_ques','=','detail_result_exam.id_ques')
//            ->where('detail_result_exam.id_result',$id_result)
//            ->where('questions.id_ques',$id_ques)
//            ->where('questions.type_ques',$type)
//            ->first();
//        return $countdetail;
    }

}
