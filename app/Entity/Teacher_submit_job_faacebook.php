<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Teacher_submit_job_faacebook extends Model
{
    protected $table = 'teacher_submit_job_facebook';
    protected $primaryKey = 'submit_job_fb_id';
    protected $fillable = [
        'submit_job_fb_id ',
        'teacher_id',
        'id_job_fb',
        'status_job',
        'day_submit_job',
        'created_at',
        'updated_at',
    ];

    public static function checkSubmitJobFacebook($teacher_id,$id_job_fb,$status_job)
    {
        $submit_job_fb = new Teacher_submit_job_faacebook();
        $count_save = $submit_job_fb->where('id_job_fb',$id_job_fb)
            ->where('teacher_id', $teacher_id)
            ->where('status_job', $status_job)
            ->count();
        return $count_save;
    }
    public static function getTotalsubmitJon($id_job_fb,$status_job)
    {
        $submit_job_fb = new Teacher_submit_job_faacebook();
        $count_save = $submit_job_fb
            ->where('id_job_fb',$id_job_fb)
            ->where('status_job', $status_job)
            ->count();
        return $count_save;
    }
}
