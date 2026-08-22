<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GroupTheme extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'group_theme';

    protected $primaryKey = 'group_id';

    protected $fillable = [
        'group_id',
        'name',
        'description',
        'image',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
