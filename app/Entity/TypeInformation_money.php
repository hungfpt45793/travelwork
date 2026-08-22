<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeInformation_money extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'type_information_money';

    protected $primaryKey = 'type_infor_id';

    protected $fillable = [
        'type_infor_id',
        'title',
        'slug',
        'type_input',
        'placeholder',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
