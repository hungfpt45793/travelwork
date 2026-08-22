<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Detail_result_job_exam extends Model
{

    protected $table = 'detail_result_job_exam';
    protected $primaryKey = 'id_detail_result';
    protected $fillable = [
        'id_detail_result',
        'id_result_job_exam',
        'id_ques',
        'user_correct_ques',
        'updated_at',
    ];
    public static function getResult($id_result,$id_ques)
    {
        $detail_result_exam = new Detail_result_job_exam();
        $details = $detail_result_exam->select('*')
            ->where('id_detail_result',$id_result)
            ->where('id_quesa',$id_ques)
            ->first();
        return $details;
    }
    public static function getAllResult($id_result,$type)
    {
        $detail_result_exam = new Detail_result_job_exam();
        $details = $detail_result_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_job_exam.id_ques')
            ->where('detail_result_job_exam.id_result_job_exam',$id_result)
            ->where('questions.type_ques',$type)
            ->get();
        return $details;
    }
    //tinh tong so cua ket qua
    public static function countDetail($id_result)
    {
        $detail_result_exam = new Detail_result_job_exam();
        $countdetail = $detail_result_exam->select('*')
            ->where('id_result_job_exam',$id_result)
            ->count();
        return $countdetail;
    }
    //tinh tong so ket qua tra loi cua cau hoi
    public static function countDetailType($id_result,$type)
    {
        $detail_result_exam = new Detail_result_job_exam();
        $countdetail = $detail_result_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_job_exam.id_ques')
            ->where('detail_result_job_exam.id_result_job_exam',$id_result)
            ->where('questions.type_ques',$type)
            ->count();
        return $countdetail;
    }
    //cau hoi tu luan
    public static  function countDetailAnser($id_result,$type)
    {
        $detail_result_exam = new Detail_result_job_exam();
        $countdetail = $detail_result_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_job_exam.id_ques')
            ->where('detail_result_job_exam.id_result_job_exam',$id_result)
            ->where('detail_result_job_exam.user_correct_ques','!=','')
            ->where('questions.type_ques',$type)
            ->count();
        return $countdetail;
    }
    // lay ve dap an cua cau hoi
    public  static function getAnswer($id_result,$id_ques,$type)
    {
        $detail_result_exam = new Detail_result_job_exam();
        $countdetail = $detail_result_exam->select('*')
            ->leftJoin('questions','questions.id_ques','=','detail_result_job_exam.id_ques')
            ->where('detail_result_job_exam.id_result_job_exam',$id_result)
            ->where('questions.id_ques',$id_ques)
            ->where('questions.type_ques',$type)
            ->first();
        return $countdetail;
    }
}
