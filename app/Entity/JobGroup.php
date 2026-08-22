<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class JobGroup extends Model
{
    protected $table = 'job_group';
    protected $primaryKey = 'job_group_id';
    protected $fillable = [
        'job_group_id',
        'job_group_name',
        'content',
        'slug',
        'image',
        'meta_title',
        'meta_description',
        'meta_keyword',
        'total_jobs',
        'recruit',
        'created_at',
        'updated_at',
        'icon'
    ];

    public function jobs() {
        return $this->belongsToMany('App\Entity\Job', 'job_jobgroup', 'job_group_id', 'job_id');
    }

    public static function ShowJobGroup () {
        return static::get();
    }
    public  static  function getAll()
    {
        $jobgroup = new JobGroup();
        $jobgroup  =$jobgroup->select('*')->orderBy('job_group_id','desc')->get();
        return $jobgroup;
    }

}
