<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job_anwser extends Model
{
    protected $table = 'job_anwser';
    protected $primaryKey = 'job_anwser_id';
    public $timestamps = false;
    protected $fillable = [
        'job_anwser_id',
        'job_id',
        'job_qes_id',
        'submit_job_fb_id',
        'job_anwser_name',
        'created_at',
        'updated_at',
    ];
    public static function get_answer($job_id,$job_qes_id,$submit_job_fb_id)
    {
        $job_answer = Job_anwser::select('*')
            ->where('job_id',$job_id)
            ->where('job_qes_id',$job_qes_id)
            ->where('submit_job_fb_id',$submit_job_fb_id)
            ->first();
        return $job_answer;
    }


}
