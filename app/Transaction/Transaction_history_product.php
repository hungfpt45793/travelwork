<?php

namespace App\Transaction;

use Illuminate\Database\Eloquent\Model;

class Transaction_history_product extends Model
{
    protected $table = 'transaction_history_product';
    protected $primaryKey = 'transaction_id';
    protected $fillable = [
        'transaction_id',
        'transaction_employee_id',
        'transaction_product_name',
        'transaction_product_price',
        'transaction_product_id',
        'transaction_content',
        'transaction_status',
        'transaction_admin_id',
        'transaction_admin_reply',
        'created_at',
        'updated_at',
    ];
}
