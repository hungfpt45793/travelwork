<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class List_support extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $casts = ['deleted_at' => 'datetime'];
    protected $table = 'list_support';
    protected $primaryKey = 'support_id';
    protected $fillable = [
        'support_id',
        'title_support',
        'created_at',
        'updated_at',
        'deleted_at'
    ];



}
