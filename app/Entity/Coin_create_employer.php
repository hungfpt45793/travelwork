<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Coin_create_employer extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;

    protected $table = 'coin_create_employer';
    protected $primaryKey = 'coin_create_id';
    protected $fillable = [
        'coin_create_title',
        'coin_create_content',
        'coin_create',
        'coin_create_sale',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at', // địa chỉ tạm trú
    ];


}
