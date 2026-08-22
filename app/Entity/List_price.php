<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class List_price extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'list_price';

    protected $primaryKey = 'list_id';

    protected $fillable = [
        'list_id',
        'category_id', //id bảng giá
        'list_time',  //thời gian theo tuần
        'list_file',   //hồ sơ
        'list_price',  // giá
        'list_discount', //chiết khấu
        'list_vat',  // giá trị gia tăng VAT
        'list_point',  // điểm cho ntd
        'list_benifit', //  quyền lợi
        'list_endow', // ưu đãi
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
