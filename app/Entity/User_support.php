<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;


class User_support extends Model
{
    use SoftDeletes;
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
    protected $table = 'user_support';
    protected $primaryKey = 'sup_id';
    protected $fillable = [
        'sup_id',
        'user_id',
        'sup_des',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function get_list_support($count)
    {
        $list_support = User_support::select('user_support.*', 'users.name', 'users.image', 'users.role', 'users.id', 'user_support_question.support_id', 'user_support_question.ques_status', 'user_support_question.ques_id', 'user_support_question.ad_id')
            ->join('users', 'users.id', 'user_support.user_id')
            ->join('user_support_question', 'user_support_question.sup_id', 'user_support.sup_id')
            ->where('user_support_question.status_show',0)
            ->orderBy('user_support.sup_id', 'desc')
            ->distinct()
            ->skip(0)
            ->take($count)
            ->get();
        return $list_support;
    }

}
