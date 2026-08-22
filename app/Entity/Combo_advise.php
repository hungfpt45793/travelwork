<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class Combo_advise extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $casts = ['deleted_at' => 'datetime'];
    protected $table = 'combo_advise';
    protected $primaryKey = 'combo_ad_id';
    protected $fillable = [
        'combo_ad_id',
        'user_id',
        'combo_title',
        'combo_price', //Giá của gói gia sư
        'combom_des',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
