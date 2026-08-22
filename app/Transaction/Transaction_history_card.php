<?php

namespace App\Transaction;

use Illuminate\Database\Eloquent\Model;

class Transaction_history_card extends Model
{
    protected $table = 'transaction_history_card';
    protected $primaryKey = 'transaction_card_id';
    protected $fillable = [
        'transaction_card_id',
        'transaction_employee_id',
        'transaction_card_name',
        'transaction_card_price',
        'transaction_card_phone',
        'transaction_total_coin',
        'transaction_content',
        'transaction_status',	//Trạng thái giao dịch 0 là chưa giao dịch 1 là hủy giao dịch 2 là giao dịch thành công
        'transaction_admin_id',
        'transaction_admin_reply',
        'created_at',
        'updated_at',
    ];
    public static  function check_history_card($month,$year)
    {
        $transaction_history_card_model = new Transaction_history_card();
        $transaction_history_card = $transaction_history_card_model->select('transaction_card_id','created_at')
            ->whereMonth('created_at',$month)
            ->whereYear('created_at',$year)
            ->first();
        return $transaction_history_card;
    }

}
