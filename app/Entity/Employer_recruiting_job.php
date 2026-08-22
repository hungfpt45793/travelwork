<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employer_recruiting_job extends Model
{

    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'employer_recruiting_job';
    protected $primaryKey = 'employer_recruiting_job';
    protected $fillable = [
        'employer_recruiting_job',
        'employer_id', //nhà tuyern dụng đăng tin hộ
        'job_id',
        'employer_name',
        'employer_des',
        'employer_tax_code', //mã số thuế
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
