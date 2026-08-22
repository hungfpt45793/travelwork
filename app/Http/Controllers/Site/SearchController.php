<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:23 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Product;
use App\Entity\SettingOrder;
use App\Entity\User;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class SearchController extends SiteController
    {
    	public function search(Request $request){
        $user = auth()->user();

    	$career = $request->has('career') ? $request->input('career') : '';
    	// $type = $request->input('type');
    	$province =$request->has('province') ? $request->input('province') : '';
    	$salary =$request->has('salary') ? $request->input('salary') : '';
    	$literacy = $request->has('literacy') ? $request->input('literacy') : 0;
    	$word = $request->has('word') ? $request->input('word') : '';

        
    	$jobModel = new Job();

    	$jobs = $jobModel->join('employer', 'employer.employer_id', 'jobs.employer_id')
                        ->join('employer_typeof_business','employer_typeof_business.employer_id','employer.employer_id')
                        ->join('type_of_business','type_of_business.type_of_business_id','employer_typeof_business.type_of_business_id')
                        ->join('job_career_categories','job_career_categories.job_id','jobs.job_id')
                        ->join('career_categories','career_categories.career_category_id','job_career_categories.career_category_id')
                        ->join('salary', 'salary.salary_id', 'jobs.salary_id')
                        ->join('province', 'province.province_id', 'jobs.province')
                        ->join('district', 'district.district_id', 'jobs.district');
                        
        if (!empty($career)) {
                $jobs = $jobs
    		    ->where('career_categories.career_category_id', $career);
        }

        if ($request->has('type')) {
            $type = $request->input('type');
            $jobs = $jobs
            ->where('type_of_business.type_of_business_id', $type);
        }

     	if (!empty($province)) {
            $jobs = $jobs->where('jobs.province', $province);
        }

        if ($request->has('district')) {
        	foreach ($request->input('district') as $district) {
        		 $jobs = $jobs->where('jobs.district', $district);
        	}
        }

        if (!empty($salary)) {

            $jobs = $jobs->where('jobs.salary_id', $salary);
        }

         if ($literacy != 0) {
            $jobs = $jobs->where('jobs.literacy_id', $literacy);
        }

         if ($request->has('word') && $request->input('word')) {
            $jobs = $jobs->where('jobs.title',  'like', '%' . $word . '%');
        }

        $jobs = $jobs->distinct()
        ->select(
                    'jobs.*',
                    'salary.description as salary_description',
                    'employer.enterprise_name',
                    'employer.image as employer_image',
                    'district.district_name as district_name ',
                    'province.province_name as province_name'
                )
                ->orderBy('jobs.job_id', 'desc')
                ->paginate(10);

    	return view('site.default.search',compact('jobs','user'));
	
	}


    public function ajaxProvince($province){
        if($province == 0){
            echo '<option> -- Tất cả các quận/huyện --</option>';
        }
        $districts = District::where('province_id', $province)->get();
        echo '<option value="">'. '-- Vui lòng chọn quận huyện --' .'</option>';
        foreach ($districts as $district){
            echo '<option value="'. $district->district_id .'">'. $district->district_name .'</option>';
        }
    }
    public function ajaxProvince_radio(Request $request ,$province){
        $word = $request->input('province');

        if ( empty($word) ) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
        $districts = District::where('province_id', $province)->get();
        return response([
            'status' => 200,
            'districts' => $districts
        ])->header('Content-Type', 'text/plain');
    }

    public function ajaxDistrictSearch($province){
        if($province != 0){
             $districts = District::where('province_id', $province)->get();
            foreach ($districts as $district){
                echo 
                ' <div class="form-check item col">
                          <input type="checkbox" name="district[]"
                           class="form-check-input h25x w25x"
                            value="'.$district->district_id.'">
                          <label class="form-check-label mgt5 mgl15" for="exampleCheck1">'.$district->district_name.'</label>
                </div>';
            }
        }
     
    }

}