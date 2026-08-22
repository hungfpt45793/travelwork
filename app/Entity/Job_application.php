<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Job_application extends Model
{

    protected $table = 'job_application';
    protected $primaryKey = 'job_app_id';
    public $timestamps = false;
    protected $fillable = [
        'job_app_id',
        'job_app_name',
        'job_app_content',
        'career_category_id',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function check_career_category_id($career_category_id)
    {
        $check = Job_application::where('career_category_id',$career_category_id)->count();
        return $check;
    }
    public static function get_all()
    {
        $list_job = Job_application::get();
        return $list_job;
    }
    public static function get_join_all()
    {
        $list_job = Job_application::select('job_application.job_app_id','job_application.career_category_id','career_categories.career_category_id','career_categories.career_category_name')->join('career_categories','career_categories.career_category_id','=','job_application.career_category_id')->get();
        return $list_job;
    }
}
