<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InformationGeneral extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'information_general';

    protected $primaryKey = 'infor_id';

    protected $fillable = [
        'infor_id',
        'slug',
        'content',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
