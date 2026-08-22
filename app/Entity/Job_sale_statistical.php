<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Job_sale_statistical extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'job_sale_statistical';
    protected $primaryKey = 'statis_id';
    protected $fillable = [
        'statis_id',
        'employee_id',
        'job_id',
        'total_share',
        'total_view_sale',
        'total_money_view',
        'total_coin',
        'created_at',
        'updated_at',
    ];
    public static function getTotalShare($job_id)
    {
        $post_sale_statistical_model = new Job_sale_statistical();
        $total_share = $post_sale_statistical_model->select('job_id')
            ->where('job_id',$job_id)
            ->sum('total_share');
        return $total_share;
    }
    public static function getTotalViewSale($job_id)
    {
        $post_sale_statistical_model = new Job_sale_statistical();
        $total_view_share = $post_sale_statistical_model->select('job_id')
            ->where('job_id',$job_id)
            ->sum('total_view_sale');
        return $total_view_share;
    }
    public static function Employee_TotalShare($employee_id)
    {
        $post_sale_statistical_model = new Job_sale_statistical();
        $total_share = $post_sale_statistical_model->select('job_id')
            ->where('employee_id',$employee_id)
            ->sum('total_share');
        return $total_share;
    }
    public static function Employee_TotalView($employee_id)
    {
        $post_sale_statistical_model = new Job_sale_statistical();
        $total_share = $post_sale_statistical_model->select('job_id')
            ->where('employee_id',$employee_id)
            ->sum('total_view_sale');
        return $total_share;
    }
    public static function Employee_TotalMoney($employee_id)
    {
        $post_sale_statistical_model = new Job_sale_statistical();
        $total_share = $post_sale_statistical_model->select('job_id')
            ->where('employee_id',$employee_id)
            ->sum('total_money_view');
        return $total_share;
    }
    public static function Employee_TotalCoin($employee_id)
    {
        $post_sale_statistical_model = new Job_sale_statistical();
        $total_share = $post_sale_statistical_model->select('job_id')
            ->where('employee_id',$employee_id)
            ->sum('total_coin');
        return $total_share;
    }
}
