<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 3/6/2018
 * Time: 6:54 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LaborExport extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'labor_export';

    protected $primaryKey = 'idlabor_export_id';

    protected $fillable = [
        'idlabor_export_id',
        'name',
        'age',
        'phone',
        'email',
        'marry',
        'hospital',
        'note',
        'academic_level',
        'family',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}