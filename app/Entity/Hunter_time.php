<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Hunter_time extends Model
{
    protected $table = 'hunter_time';
    protected $primaryKey = 'hunter_time_id';
    protected $fillable = [
        'hunter_time_id',
        'hunter_time_name',
        'hunter_time_name_small',
        'deleted_at',
        'created_at',
    ];
}
