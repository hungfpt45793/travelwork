<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Teacher_save_job_facebook extends Model
{
    protected $table = 'teacher_save_job_facebook';
    protected $primaryKey = 'save_job_fb_id';
    protected $fillable = [
        'save_job_fb_id ',
        'teacher_id',
        'id_job_fb',
        'status_job',
        'created_at',
        'updated_at',
    ];

    public static function checkSaveJobFacebook($teacher_id,$id_job_fb,$status_job)
    {
        $save_job_fb = new Teacher_save_job_facebook();
        $count_save = $save_job_fb->where('id_job_fb',$id_job_fb)
            ->where('teacher_id', $teacher_id)
            ->where('status_job',$status_job)
            ->count();
        return $count_save;
    }
}
