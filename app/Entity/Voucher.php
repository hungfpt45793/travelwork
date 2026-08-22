<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class Voucher extends Model
{


    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'voucher';

    protected $primaryKey = 'id_voucher';

    protected $fillable = [
        'id_voucher',
        'name_voucher',
        'slug_voucher',
        'des_voucher',
        'image_voucher',
        'content_voucher',
        'type_voucher',
        'view_voucher',
        'link_dowload_voucher',
        'link_dowload_file',
        'dowload_voucher',
        'id_cate_child',
        'sale_money',
        'created_at',
        'updated_at',
        'deleted_at',
        'meta_title',
        'meta_description',
        'user_create_voucher',
        'user_update_voucher',
    ];
    public static function getVoucher($id_cate_child)
    {
        $voucher = new Voucher();
        $voucher = $voucher->select('*')
            ->where('id_cate_child',$id_cate_child)
            ->orderBy('id_cate_child','desc')
            ->get();
        return $voucher;
    }
    public static function getVoucherLimit($id_cate_child,$limit)
    {
        $voucher = new Voucher();
        $voucher = $voucher->select('*')
            ->where('id_cate_child',$id_cate_child)
            ->orderBy('id_cate_child','desc')
            ->limit($limit)
            ->get();
        return $voucher;
    }

    public static function getID($id_voucher)
    {
        $voucher = new Voucher();
        $voucher = $voucher->select('*')
            ->where('id_voucher',$id_voucher)
            ->first();
        return $voucher;
    }
    public static function getAllVoucher($limit)
    {
        $voucher = new Voucher();
        $voucher = $voucher->select('slug_voucher','name_voucher','image_voucher','dowload_voucher','id_voucher','view_voucher')
            ->orderBy('view_voucher','desc')
            ->orderBy('dowload_voucher','desc')
            ->limit($limit)
            ->get();
        return $voucher;
    }
}
