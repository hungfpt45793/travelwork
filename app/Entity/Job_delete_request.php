<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Job_delete_request extends Model
{
    protected $table = 'job_delete_request';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'job_id',
        'staff_id',
        'created_at'
    ];
}