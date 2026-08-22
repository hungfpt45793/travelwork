<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class JobSoftware extends Model
{
    protected $table = 'job_software';
    protected $primaryKey = 'job_software_id';
    protected $fillable = [
        'job_software_id',
        'job_id',
        'software_id',
        'created_at	',
        'updated_at'
    ];
}
