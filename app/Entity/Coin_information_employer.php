<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Coin_information_employer extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'coin_information_employer';
    protected $primaryKey = 'infor_id';
    protected $fillable = [
        'slug_type_input',
        'content',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


}
