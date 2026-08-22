<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/21/2019
 * Time: 4:07 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class HistoryWork extends Model
{
    protected $table = 'history_work';
    protected $primaryKey = 'history_work_id';
    protected $fillable = [
        'history_work_id',
        'employee_id',
        'company',
        'position',
        'content',
        'created_at',
        'updated_at',
    ];

    public static function getAllWihtId($employee_id){
        $historys = static::select([
            'employee_id',
            'company',
            'position',
            'content'
            ])
        ->where('employee_id', $employee_id)
        ->get();
        return $historys; 

        
    }
}