<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Teacher_job_group extends Model
{
    protected $table = 'teacher_job_group';
    protected $primaryKey = 'teacher_job_id';
    protected $fillable = [
        'teacher_job_id',
        'teacher_id',
        'job_group_id',
        'created_at',
        'updated_at',
    ];
    public static function getAllTeacherJob()
    {
        $teacher_job = new Teacher_job_group();
        $teacher_job = $teacher_job->select('*')->get();
        return $teacher_job;
    }

}
