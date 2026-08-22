<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Coin_history_employer extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'coin_history_employer';
    protected $primaryKey = 'coin_history_id';
    protected $fillable = [
        'coin_history_title',
        'coin',
        'coin_history_status',//	0 là xử dụng xu miễn phí hằng ngày để xem , 1 là dùng xu nạp từ tìa khoản
        'coin_employee_status',//	0 là xem thông tin ứng viên  , 1 là mới ứng viên ứng tuyển
        'employer_id',
        'created_at',
        'updated_at',
        'deleted_at', // địa chỉ tạm trú
    ];
    public static function sum_coin($employer_id)
    {
        $coin = Coin_history_employer::where('employer_id',$employer_id)
            ->where('coin_history_status',0)
            ->whereDate('created_at', '=', date('Y-m-d'))
            ->sum('coin');
        return $coin;
    }
}
