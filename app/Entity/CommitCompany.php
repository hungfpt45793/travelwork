<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class CommitCompany extends Model
{
    protected $table = 'commit_company';
    protected $primaryKey = 'com_id';
    protected $fillable = [
        'com_id',
        'com_name',
        'com_give',
        'com_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
