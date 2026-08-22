<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Job_company extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'job_company';
    protected $primaryKey = 'job_company_id';
    public $timestamps = false;
    protected $fillable = [
    'job_company_id',
    'job_id',
    'employer_id',
    'tax_code',
    'job_company_title',
    'province_id',
    'district_id',
    'address',
    'introduction',
    'created_at',
    'updated_at',
    'deleted_at',
    ];
    public static function get_post_id($job_id)
    {
        $job = Job_company::where('job_id',$job_id)->first();
        return $job;
    }
    public static function get_job_company_title($job_id)
    {
        $job = Job_company::where('job_id',$job_id)->value('job_company_title');
        return $job;
    }
}
