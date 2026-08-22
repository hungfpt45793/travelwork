<?php
/**
 * Created by PhpStorm.
 * User: ADMIN
 * Date: 11/29/2017
 * Time: 10:09 AM
 */

namespace App\Entity;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Notification extends Model
{

//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'notification';

    protected $primaryKey = 'notify_id';

    protected $fillable = [
        'notify_id',
        'content',
        'url',
        'title',
        'status',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function countReport(){
        try {
            $countNotification = $this->where('status', 0)->count();

            return $countNotification;
        } catch (\Exception $e) {
            Log::error('Entity->Notification->countReport: Lỗi lấy tổng số report');

            return 0;
        }

    }
}
