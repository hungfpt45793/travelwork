<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeSubPost extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'type_sub_post';

    protected $primaryKey = 'type_sub_post_id';

    protected $fillable = [
        'type_sub_post_id',
        'title',
        'slug',
        'input_default_used',
        'template',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
