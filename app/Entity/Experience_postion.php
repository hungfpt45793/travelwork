<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Experience_postion extends Model
{
    protected $table = 'experience_postion';
    protected $primaryKey = 'exp_id';
    protected $fillable = [
        'exp_id',
        'exp_name',
        'exp_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
