<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job_question extends Model
{
    protected $table = 'job_question';
    protected $primaryKey = 'job_qes_id';
    public $timestamps = false;
    protected $fillable = [
        'job_qes_id',
        'job_id',
        'employer_id',
        'job_qes_name',
        'created_at',
        'updated_at',
    ];



}
