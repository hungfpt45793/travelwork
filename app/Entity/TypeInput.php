<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeInput extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'type_input';

    protected $primaryKey = 'type_input_id';

    protected $fillable = [
        'type_input_id',
        'title',
        'slug',
        'type_input',
        'placeholder',
        'post_used',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
