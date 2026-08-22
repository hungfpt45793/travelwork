<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Hunter_pos extends Model
{
    protected $table = 'hunter_pos';
    protected $primaryKey = 'hunter_pos_id';
    protected $fillable = [
        'hunter_pos_id',
        'hunter_pos_name',
        'deleted_at',
        'created_at',
    ];
}
