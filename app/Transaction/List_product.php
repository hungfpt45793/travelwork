<?php

namespace App\Transaction;

use Illuminate\Database\Eloquent\Model;

class List_product extends Model
{
    protected $table = 'list_product';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_id',
        'product_name',
        'product_slug',
        'product_price',
        'product_discount',
        'product_image',
        'product_content',
        'product_link',
        'created_at',
        'updated_at',
    ];
    public static function get_product_id($product_id)
    {
        $list_product_model = new List_product();
        $product = $list_product_model->select('*')
            ->where('product_id',$product_id)
            ->first();
        return $product;
    }

}
