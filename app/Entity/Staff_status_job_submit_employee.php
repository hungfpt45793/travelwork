<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Staff_status_job_submit_employee extends Model
{
    use SoftDeletes;

    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'staff_status_job_submit_employee';
    protected $primaryKey = 'staff_employee_id';
    protected $fillable = [
        'staff_employee_id', 
        'submit_job_fb_id', 
        'staff_id', 
        'staff_id_comment', 
        'staff_job_id', 
        'created_at', 
        'updated_at', 
        'deleted_at'
    ];
}
