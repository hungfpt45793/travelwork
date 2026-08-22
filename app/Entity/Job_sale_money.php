<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Job_sale_money extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'job_sale_money';
    protected $primaryKey = 'sale_id';
    protected $fillable = [
        'sale_id',
        'employee_id',
        'job_id',
        'ip_sale',
        'mac_sale',
        'date_sale',
        'created_at',
        'updated_at',
    ];
    public static function getMonthView($job_id,$employe_id,$day_date_static)
    {
        $post_sale_money_model = new Job_sale_money();
        $post_coun =$post_sale_money_model->select('*')
            ->where('job_id',$job_id)
            ->where('employee_id',$employe_id)
            ->whereMonth('date_sale',date_format($day_date_static, "m"))
            ->whereYear('date_sale', date_format($day_date_static, "Y"))
            ->count();
        return $post_coun;
    }
}
