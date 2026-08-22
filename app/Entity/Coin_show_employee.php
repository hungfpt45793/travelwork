<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Coin_show_employee extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $dates = ['deleted_at'];
    public $timestamps = false;

    protected $table = 'coin_show_employee';
    protected $primaryKey = 'coin_show_id';
    protected $fillable = [
        'coin_history_id',
        'employer_id',
        'employee_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    public static function check_employer_contact_employee($employer_id,$employee_id)
    {
        $coin_show_employee = Coin_show_employee::select('employee_id','employer_id')
            ->where('employer_id',$employer_id)
            ->where('employee_id',$employee_id)
            ->first();
        return $coin_show_employee;
    }


}
