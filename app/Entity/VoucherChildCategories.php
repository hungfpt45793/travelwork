<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class VoucherChildCategories extends Model
{

    protected $table = 'voucher_child_categories';

    protected $primaryKey = 'id_cate_child';

    protected $fillable = [
        'id_cate_child',
        'name_cate_child',
        'slug_cate_child',
        'id_cate_voucher',
        'created_at',
        'updated_at',
        'meta_title',
        'meta_description',
        'keyword',
    ];
    public static  function getAllCategoryChild($id_cate_voucher)
    {
        $category_child = new VoucherChildCategories();
        $category_child = $category_child->select('*')->where('id_cate_voucher',$id_cate_voucher)->get();
        return $category_child;
    }


}
