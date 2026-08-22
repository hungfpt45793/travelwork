<?php

namespace App\Entity;

use http\Env\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Learn_training_content extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;
    protected $table = 'learn_training_content';
    protected $primaryKey = 'learn_content_id';

    protected $fillable = [
        'learn_content_id',
        'learn_id',
        'trai_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function check_learn_training_content($learn_id,$trai_id)
    {
        $total = Learn_training_content::where('learn_id',$learn_id)
            ->where('trai_id',$trai_id)
            ->first();
        return $total;
    }
    public static function get_list_training($learn_id)
    {
        $list_training = Learn_training_content::select('learn_training_content.learn_id','learn_training_content.trai_id','training.trai_title','training.trai_id')
            ->join('training','training.trai_id','=','learn_training_content.trai_id')
            ->where('learn_training_content.learn_id',$learn_id)
            ->get();
        return $list_training;
    }
}
