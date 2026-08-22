<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class JobFacebookWarning extends Model
{
    protected $table = 'job_facebook_warning';
    protected $primaryKey = 'id_job_warning';

    protected $fillable = [
        'id_job_warning',
        'job_facebook_id',
        'user_warning',
        'updated_at',
    ];
}
