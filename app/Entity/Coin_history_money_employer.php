<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Coin_history_money_employer extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'coin_history_money_employer';
    protected $primaryKey = 'coin_money_id';
    protected $fillable = [
        'coint_money',
        'coint',
        'employer_id',
        'user_id',
        'coin_content',//	0 là xử dụng xu miễn phí hằng ngày để xem , 1 là dùng xu nạp từ tìa khoản
        'created_at',
        'updated_at',
        'deleted_at', // địa chỉ tạm trú
    ];
    public static function get_coint_employer($employer_id)
    {
        $coint_employer = Coin_history_money_employer::select('employer.enterprise_name','employer.slug','coin_history_money_employer.coint')
            ->join('employer','employer,employer_id','=','coin_history_money_employer.employer_id')
            ->where('coin_history_money_employer.employer_id',$employer_id)
            ->first();
        return $coint_employer;
    }


}
