<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class School_subject extends Model
{
    protected $table = 'school_subject';
    protected $primaryKey = 'sub_id';
    protected $fillable = [
        'sub_id',
        'sub_code',
        'sub_name',
        'created_at',
        'updated_at',
    ];
    public static function getAll()
    {
        $list_sub = School_subject::get();
        return $list_sub;
    }
    public static function get_sub_id($sub_id)
    {
        $sub = School_subject::where('sub_id',$sub_id)->first();
        return $sub;
    }
    public static function  getTotal($type,$teacher_sc_id,$sub_id)
    {
        $total = School_subject::leftJoin('questions_school','questions_school.sub_id','=','school_subject.sub_id')
        ->where('school_subject.sub_id',$sub_id)
        ->where('questions_school.type_ques',$type)
        ->where('questions_school.teacher_sc_id',$teacher_sc_id)->count();
        return $total;
    }
}
