<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Teacher_status extends Model
{
    protected $table = 'teacher_status';
    protected $primaryKey = 'teacher_status_id';
    protected $fillable = [
        'teacher_status_id',
        'teacher_status_name',
        'teacher_status_slug',
        'teacher_status_des',
        'created_at',
        'updated_at'
    ];
    public static function getALL()
    {
        $teacher = Teacher_status::select('*')->get();
        return $teacher;
    }
    public static function getId($teacher_status_id)
    {
        $teacher = Teacher_status::select('*')->where('teacher_status_id',$teacher_status_id)->first();
        return $teacher;
    }
}
