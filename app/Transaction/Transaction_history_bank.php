<?php

namespace App\Transaction;

use Illuminate\Database\Eloquent\Model;

class Transaction_history_bank extends Model
{
    protected $table = 'transaction_history_bank';
    protected $primaryKey = 'transaction_bank_id';
    protected $fillable = [
        'transaction_bank_id',
        'transaction_employee_id',
        'transaction_bank_name',
        'transaction_bank_price',
        'transaction_bank_number',
        'transaction_total_coin',
        'transaction_home_name',
        'transaction_content',
        'transaction_status',
        'transaction_admin_id',
        'transaction_admin_reply',
        'created_at',
        'updated_at',
    ];

}
