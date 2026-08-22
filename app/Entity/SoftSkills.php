<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SoftSkills extends Model
{
    protected $table = 'soft_skills';
    protected $primaryKey = 'soft_id';
    protected $fillable = [
        'soft_id',
        'soft_name',
        'soft_give',
        'soft_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
