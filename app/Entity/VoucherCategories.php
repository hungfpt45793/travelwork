<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class VoucherCategories extends Model
{

    protected $table = 'voucher_categories';

    protected $primaryKey = 'id_cate_voucher';

    protected $fillable = [
        'id_cate_voucher',
        'name_cate_voucher',
        'slug_cate_voucher',
        'icon',
        'created_at',
        'updated_at',
        'meta_title',
        'meta_description',
        'meta_keyword',
    ];
    public  static function getALlCategorieVoucher()
    {
        $categories_voucher = new VoucherCategories();
        $categories_voucher = $categories_voucher->select('*')->get();
        return $categories_voucher;
    }


}
