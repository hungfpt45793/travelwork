<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class JobJobGroup extends Model
{
    protected $table = 'job_jobgroup';
    protected $primaryKey = 'job_jobgroup_id';
    protected $fillable = [
        'job_jobgroup_id',
        'job_id',
        'job_group_id',
        'recruit',
		'recruited',
        'created_at',
        'updated_at'
    ];
    public static function getAllGroup (){
      return static::get();
    }
}
