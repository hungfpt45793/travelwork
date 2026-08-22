<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Regex extends Model
{
    protected $table = 'regexs';
    protected $primaryKey = 'regex_id';
    protected $fillable = [
        'regex_id',
        'order_regex',
        'des',
        'content',
        'deleted_at',
        'updated_at'
    ];

    public static function get_regexs(){
        $regexs = Regex::orderBy('order_regex', 'asc')
            ->get();
        return $regexs;
    }

}
