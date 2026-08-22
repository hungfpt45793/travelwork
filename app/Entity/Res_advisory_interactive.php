<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Res_advisory_interactive extends Model
{
    protected $table = 'res_advisory_interactive';
    protected $fillable = [
        'id',
        'advisory_id',
        'interactive_day',
        'staff_id',
        'content',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
