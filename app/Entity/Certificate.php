<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $table = 'certificate';
    protected $primaryKey = 'cer_id';
    protected $fillable = [
        'cer_id',
        'cer_name',
        'cer_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
