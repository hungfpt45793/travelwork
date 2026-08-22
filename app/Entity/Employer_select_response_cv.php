<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Employer_select_response_cv extends Model
{
    protected $table = 'employer_select_response_cv';
    protected $primaryKey = 'employer_select_response_cv_id';
    protected $fillable = [
        'employer_select_response_cv_id',
    	'employer_select_response_id',
        'employer_response_cv_id',
        'status_response', //	0 là chưa trả điểm 1 là đã trả điểm
        'created_at',
        'updated_at'
    ];
    public static function get_select_reponse_cv($employer_response_cv_id)
    {
        $list_select_reponse_cv = Employer_select_response_cv::select('employer_select_response_cv.employer_response_cv_id','employer_select_response.response')->join('employer_select_response','employer_select_response.employer_select_response_id','=','employer_select_response_cv.employer_select_response_id')
            ->where('employer_select_response_cv.employer_response_cv_id',$employer_response_cv_id)
            ->get();
        return $list_select_reponse_cv;
    }
    public static function get_total($employer_select_response_id)
    {
        $total_select_reponse_cv = Employer_select_response_cv::where('employer_select_response_cv.employer_select_response_id',$employer_select_response_id)->count();
        return $total_select_reponse_cv;
    }
}
