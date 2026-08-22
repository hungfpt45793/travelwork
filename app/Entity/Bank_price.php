<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Bank_price extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'bank_price';

    protected $primaryKey = 'bank_id';

    protected $fillable = [
        'bank_id',
        'bank_name', //tên ngân hàng
        'bank_image',  // hình ảnh ngân hàng
        'bank_acount_number',  //số tài khoản
        'bank_acount_name', // tên tài khoản ngân hàng
        'bank_acount_branch', // chi nhánh ngân hàng
        'bank_transfer', //nội dung chuyển khoản
        'bank_test', // ví dụ chuyển khoản
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
