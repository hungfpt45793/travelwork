<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Staff_status_job_submit extends Model
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];

    protected $table = 'staff_status_job_submit';
    protected $primaryKey = 'staff_status_job_submit_id';
    protected $fillable = [
        'staff_status_job_submit_id', 
        'staff_job_id', 
        'staff_title', 
        'staff_des', 
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];
}
