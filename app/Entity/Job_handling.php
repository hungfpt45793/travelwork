<?php

namespace App\Entity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Job_handling extends Model
{
    protected $table = 'job_handling';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'user_id_handling',
        'job_id',
        'status',
        'feedback',
        'created_at'
    ];
}
