<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Teacher_experience extends Model
{
    protected $table = 'teacher_experience';
    protected $primaryKey = 'experience_id';
    protected $fillable = [
        'experience_id',
        'experience_title',
        'star_working_time',
        'end_working_time',
        'company',
        'position',
        'des_position',
        'teacher_id', // địa chỉ tạm trú
        'created_at',
    ];
    public static function get_all_teacher_id($teacher_id)
    {
        $experience = New Employee_experience();
        $experience = $experience->select('*')
            ->where('teacher_id',$teacher_id)
            ->get();
        return $experience;
    }


    public static function listExp($teacher_id)
    {
        $experience = New Teacher_experience();
        $experience = $experience->select('*')
            ->where('teacher_id',$teacher_id)
            ->get();
        return $experience;
    }
    public static function min_Exp($teacher_id)
    {

        $experience = New Teacher_experience();
        $experience = $experience->where('teacher_id',$teacher_id)
            ->min('star_working_time');
        return $experience;
    }
    public static function total_exp($teacher_id)
    {
        $date=date_create();
        $experience = New Teacher_experience();
        $min_year = $experience->where('teacher_id',$teacher_id)
            ->min('star_working_time');
        $nowYear = (int)date_format($date,"Y");
        if($min_year > 1970){
            $total_exp = $nowYear -  $min_year;

        }else{
            $total_exp=0;
        }

        return $total_exp;
    }

    public static function total_listExp($teacher_id)
    {
        $experience = New Teacher_experience();
        $experience = $experience->select('*')
            ->where('teacher_id',$teacher_id)
            ->count();
        return $experience;
    }
}
