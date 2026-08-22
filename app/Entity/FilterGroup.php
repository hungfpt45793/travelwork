<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FilterGroup extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'group_filter';

    protected $primaryKey = 'group_filter_id';

    protected $fillable = [
        'group_filter_id',
        'group_name',
        'created_at',
        'updated_at',
        'deleted_at '
    ];

    public static function showFilterGroup() {
        $filterGroup = new FilterGroup();
        $filterGroups = $filterGroup->orderBy('group_filter_id')->get();

        return $filterGroups;
    }
}
