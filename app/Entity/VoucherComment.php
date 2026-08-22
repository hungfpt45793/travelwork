<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class VoucherComment extends Model
{
    protected $table = 'voucher_comment';
    protected $primaryKey = 'id_voucher_cm';
    protected $fillable = [
        'id_voucher_cm',
        'content_voucher_cm',
        'user_id',
        'id_voucher',
        'parent_id_voucher_cm',
        'day_comment',
        'created_at',
        'updated_at',
    ];

    public static function getPanentId($id_voucher_cm)
    {
        $voucher_comment = new VoucherComment();
        $voucher_comment = $voucher_comment->select('voucher_comment.*','users.name','users.image')
            ->join('users','users.id','=','voucher_comment.user_id')
            ->where('voucher_comment.parent_id_voucher_cm',$id_voucher_cm)
            ->first();
        return $voucher_comment;
    }
    public static function countComment($id_voucher)
    {
        $voucher_comment = new VoucherComment();
        $voucher_comment = $voucher_comment->select('*')
            ->where('id_voucher', $id_voucher)
            ->count();
        return $voucher_comment;
    }


}
