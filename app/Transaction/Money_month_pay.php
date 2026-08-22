<?php

namespace App\Transaction;

use Illuminate\Database\Eloquent\Model;

class Money_month_pay extends Model
{
    protected $table = 'money_month_pay';
    protected $primaryKey = 'money_id';
    protected $fillable = [
        'money_id',
        'total_money_month',
        'money_surplus',
        'money_month_year',
        'created_at',
        'updated_at',

    ];
    public static function get_month_pay($month ,$year)
    {
        $money_month_pay_model = new Money_month_pay();
        $money_pay = $money_month_pay_model->select('*')
            ->whereYear('money_month_year', '=', $year)
            ->whereMonth('money_month_year', $month)
            ->first();
        return $money_pay;
    }
}
