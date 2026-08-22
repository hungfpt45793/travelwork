<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Order_interactive extends Model
{
    protected $table = 'order_interactive';
    protected $fillable = [
        'id',
        'staff_id',
        'order_id',
        'content',
        'interactive_day',
        'type_order',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
}
