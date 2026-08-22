<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Filter extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'filter';

    protected $primaryKey = 'filter_id';

    protected $fillable = [
        'filter_id',
        'name_filter',
        'group_filter_id',
        'created_at',
        'updated_at',
        'deleted_at '
    ];

    public static function showFilter ($groupFilter_id){
        $filter = new Filter();
        $filters = $filter->orderBy('filter_id')->where('group_filter_id', $groupFilter_id)->get();

        return $filters;
    }

}
