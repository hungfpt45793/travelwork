<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Cron_vouchers extends Model
{
    protected $table = 'cron_vouchers';
    protected $primaryKey = 'cron_voucher_id';
    public $timestamps = false;
    protected $fillable = [
        'cron_voucher_id',
        'slug_voucher',
        'id_voucher',
        'name_voucher',
        'image_voucher',
        'dowload_voucher',
        'view_voucher',
        'created_at',
        'updated_at',
    ];
    public static function get_all_cron_voucher()
    {
        $cron_voucher = new Cron_vouchers();
        $cron_voucher = $cron_voucher->select('*')->orderBy('view_voucher','desc')->orderBy('dowload_voucher','desc')->get();
        return $cron_voucher;
    }
    public static function getAllVoucher()
    {
        $voucher = new Voucher();
        $voucher = $voucher->select('slug_voucher','name_voucher','image_voucher','dowload_voucher','id_voucher','view_voucher')
            ->orderBy('view_voucher','desc')
            ->orderBy('dowload_voucher','desc')
            ->get();
        return $voucher;
    }
}
