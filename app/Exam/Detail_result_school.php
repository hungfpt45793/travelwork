<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Detail_result_school extends Model
{

    protected $table = 'detail_result_school';
    protected $primaryKey = 'id_detail_result';
    protected $fillable = [
        'id_result',
        'id_ques',
        'user_correct_ques',
        'teacher_correct',
        'created_at',
        'updated_at',
    ];

    public static function countDetail($id_result)
    {
        $detail_result_school = new Detail_result_school();
        $countdetail = $detail_result_school->select('*')
            ->where('id_result',$id_result)
            ->count();
        return $countdetail;
    }
    public static function getResult($id_result,$id_ques)
    {
        $detail_result_school = new Detail_result_school();
        $details = $detail_result_school->select('*')
            ->where('id_result',$id_result)
            ->where('id_ques',$id_ques)
            ->first();
        return $details;
    }
    public static function getAllResult($id_result,$type)
    {
        $detail_result_school = new Detail_result_school();
        $details = $detail_result_school->select('*')
            ->leftJoin('questions_school','questions_school.id_ques','=','detail_result_school.id_ques')
            ->where('detail_result_school.id_result',$id_result)
            ->where('questions_school.type_ques',$type)
            ->get();
        return $details;
    }
    //tinh tong so cua ket qua

    //tinh tong so ket qua tra loi cua cau hoi
    public static function countDetailType($id_result,$type)
    {
        $detail_result_school = new Detail_result_school();
        $countdetail = $detail_result_school->select('*')
            ->leftJoin('questions_school','questions_school.id_ques','=','detail_result_school.id_ques')
            ->where('detail_result_school.id_result',$id_result)
            ->where('questions_school.type_ques',$type)
            ->count();
        return $countdetail;
    }
    //cau hoi tu luan
    public static  function countDetailAnser($id_result,$type)
    {
        $detail_result_school = new Detail_result_school();
        $countdetail = $detail_result_school->select('*')
            ->leftJoin('questions_school','questions_school.id_ques','=','detail_result_school.id_ques')
            ->where('detail_result_school.id_result',$id_result)
            ->where('detail_result_school.user_correct_ques','!=','')
            ->where('questions_school.type_ques',$type)
            ->count();
        return $countdetail;
    }
    // lay ve dap an cua cau hoi
    public  static function getAnswer($id_result,$id_ques)
    {
//        echo $id_result;
//        echo '--'.$id_ques;
        $detail_result_school = new Detail_result_school();
        $countdetail = $detail_result_school->select('detail_result_school.user_correct_ques')
            ->leftJoin('questions_school','questions_school.id_ques','=','detail_result_school.id_ques')
            ->where('detail_result_school.id_result',$id_result)
            ->where('questions_school.id_ques',$id_ques)
            ->first();
        return $countdetail;
    }
}
