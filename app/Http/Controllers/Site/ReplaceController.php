<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Employer;
use App\Entity\Employee;
use App\Entity\User;
use App\Entity\Job;
use App\Entity\User_new;
use App\Entity\Employer_stk;
use App\Entity\Employer_recruitment;
use App\Entity\Seeker;
use App\Entity\Seeker_cv;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Province;
use App\Entity\District;
use App\Entity\Location_Province;
use App\Entity\Location_District;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReplaceController extends SiteController
{
    public function Replace(){
        $Employer_sktModel  = new Employer_stk();
        $EmployerModel  = new Employer();
        $Employer_recruitmentModel  = new Employer_recruitment();
        $EmployeeModel  = new Employee();
        $JobModel  = new Job();
        $user_newModel = new User_new();
        $userModel = new User();



        $SeekerModell = new Seeker();

        $provinceModel = new Province();
        $districtModel = new District();

        $location_province = new Location_Province();
        $location_district = new Location_District();

        $users = $SeekerModell
        ->select(
            'id',
            'item_id',
        )
        // $count = $Employers->count();
        ->get();

        // return $Employers;


        foreach ($users as $user ) {
             // print_r($jobs);

                DB::beginTransaction();
                    $Employee = $EmployeeModel
                    ->where('employee_user_id',$user->id)
                    ->update([
                        'employee_code' => isset($user->item_id) ? $user->item_id : '0' 
                    ]);
                DB::commit();

        }


            // $content = isset($job->content) ? $job->content : '';
            // $content1 = isset($job->content1) ? $job->content1 : '';
            // $content2 = isset($job->content2) ? $job->content2 : '';
            // $content3 = isset($job->content3) ? $job->content3 : '';
            // $contents = $content.'</br>'.$content1.'</br>'.$content2.'</br>'.$content3;

            // $provinces = isset($job->expected_province) ? $job->expected_province : '0';

            // $province1 = explode(',', $provinces);
            // $province = $province1[0];

            // $id = isset($job->id) ? $job->id : '';

            // $slug = Ultility::createSlug($job->title);
            // if (!empty($slug)) {
            //     $slug1 = $slug;
            // }
            // else{
            //      $slug1 = $id;
            // }

        // $Employer_skts = $Employer_sktModel->select([
        //     'item_id',
        //     'company',
        //     'size',
        //     'content',
        //     'phone',
        //     'province',
        //     'district',
        //     'address',
        //     'website',
        //     'contact_email'
        // ])

        // ->paginate(1);
        // return $Employer_skts;

        // foreach ($Employer_skts as $Employer) {
        //      $employernew = DB::Employer->insertGetId(

        //         'enterprise_id',
        //         'enterprise_name',
        //         'phone',
        //         'email',
        //         'address',
        //         'introduction',
        //         'province',
        //         'district',
        //         'address',
        //         'user_id',
        //         'image',
        //         'status',
        //         'slug',
        //         'website',
        //         'company_size',
        //     )
        // }
       

       

    }

   
  
}
