<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupHelpVideo extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'group_help_video';

    protected $primaryKey = 'group_id';

    protected $fillable = [
        'group_id',
        'title',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
