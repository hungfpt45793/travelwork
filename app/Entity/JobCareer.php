<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class JobCareer extends Model
{
    protected $table = 'job_career_categories';
    protected $primaryKey = 'job_career_id';
    protected $fillable = [
        'job_career_id',
        'job_id',
        'career_category_id',
        'recruit',
        'recruited',
        'created_at',
        'updated_at'
    ];

    public static function getIdJob($job_id)
    {
        $joc_career = new JobCareer();
        $joc_career = $joc_career->select('job_career_categories.*','career_categories.career_category_name')->where('job_id', $job_id);
        $joc_career = $joc_career->leftJoin('career_categories','career_categories.career_category_id','job_career_categories.career_category_id');
        $joc_career = $joc_career->orderBy('career_category_id', 'asc')->get();
        return $joc_career;
    }
}
