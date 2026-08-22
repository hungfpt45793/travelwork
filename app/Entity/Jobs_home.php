<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Jobs_home extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];


    protected $table = 'jobs_home';
    protected $primaryKey = 'job_id';
    public $timestamps = false;
    protected $fillable = [
        'job_id',
        'job_code',
        'approved',
        'vip',
        'views',
        'status',
        'employer_id',
        'experience',
        'literacy_id',
        'deadline_submit_profile',
        'number_recruit',
        'province',
        'district',
        'address_work',
        'salary_id',
        'age_id',
        'gender',
        'position',
        'content',
        'sale_package_id',
        'slug',
        'description',
        'tags',
        'image',
        'image_list',
        'created_at',
        'updated_at',
        'deleted_at',
        'number_recruited',
        'people_seen',
        'date_submit',
        'title',
        'applicants',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'date_end',
        'campain_candidate',
        'user_id_candidate',
        'campain_status',
        'jobgroup_id',
        'career_category_id',
        'status_exam',
        'id_exam',
        'date_exam_job',
        'software_id',
        'welfare',
        'count_updated_at',
        'active_job',
        'sale_money',
        'user_id',
        'day_handling',

    ];
}
