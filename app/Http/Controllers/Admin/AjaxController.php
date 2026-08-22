<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Business;
use App\Entity\Career;
use App\Entity\District;
use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\JobGroup;
use App\Entity\Sale;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AjaxController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'setting');

            return $next($request);
        });
    }

    public function ajaxEmployerProvince($employer){
        if($employer==0){
            echo '<label for="exampleInputEmail1">Tỉnh thành</label>
                <input type="text" class="form-control" name="province" placeholder="Tỉnh thành" disabled/>';
            return;
        }
        $province = Employer::join('province', 'province.province_id','=','employer.province')
            ->where('employer_id', $employer)->first();
        echo "<label for='exampleInputEmail1'>Tỉnh thành</label>
              <input type='text' class='form-control' name='province' placeholder='Tỉnh thành' value='" . $province->province_name . "' disabled/>";
    }

    public function ajaxEmployerDistrict($employer){
        if($employer==0){
            echo '<label for="exampleInputEmail1">Quận, Huyện</label>
                  <input type="text" class="form-control" name="district" placeholder="Quận, Huyện" disabled/>';
            return;
        }
        $district = Employer::join('district', 'district.district_id','=','employer.district')
            ->where('employer_id', $employer)->first();
        echo "<label for='exampleInputEmail1'>Quận, Huyện</label>
              <input type='text' class='form-control' name='province' placeholder='Quận, Huyện' value='" . $district->district_name . "' disabled/>";
    }

    public function ajaxEmployerBusinessType($employer){
        $businessTypes = Employer::join('employer_business_type','employer_business_type.employer_id','=','employer.employer_id')
            ->join('business_type','business_type.business_type_id','=','employer_business_type.business_type_id')
            ->where('employer.employer_id', $employer)->get();
        $string = "<label for='exampleInputEmail1'>Loại hình kinh doanh</label>
              <input type='text' class='form-control' name='businessType' placeholder='Loại hình kinh doanh' value='";
        if($businessTypes->count() == 1){
            foreach ($businessTypes as $businessType){
                $string .= $businessType->business_type_name;
            }
        }else{
            foreach ($businessTypes as $businessType){
                $string .= $businessType->business_type_name . ", ";
            }
        }
        $string .= "' disabled/>";
        echo $string;
    }

    public function ajaxEmployerTypeBusiness($employer){
        $typeBusinessList = Employer::join('employer_typeof_business','employer_typeof_business.employer_id','=','employer.employer_id')
            ->join('type_of_business','type_of_business.type_of_business_id','=','employer_typeof_business.type_of_business_id')
            ->where('employer.employer_id', $employer)->get();
        $string = "<label for='exampleInputEmail1'>Loại hình doanh nghiệp</label>
              <input type='text' class='form-control' name='businessType' placeholder='Loại hình doanh nghiệp' value='";
        if($typeBusinessList->count() == 1){
            foreach ($typeBusinessList as $typeBusiness){
                $string .= $typeBusiness->type_of_business_name;
            }
        }else{
            foreach ($typeBusinessList as $typeBusiness){
                $string .= $typeBusiness->type_of_business_name . ", ";
            }
        }
        $string .= "' disabled/>";
        echo $string;
    }

    public function ajaxStaff($staff){
        if($staff==0){
            echo '<label> Họ và tên : </label>
                <p>Địa chỉ: </p>
                <p>Hotline: </p>
                <p>Email : </p>';
            return;
        }
        $userStaff = User::where('id',$staff)->first();
        echo "<label> Họ và tên : " .$userStaff->name ."</label>
             <p>Địa chỉ: " . $userStaff->address . "</p>
             <p>Hotline: " . $userStaff->phone  ."</p>
             <p>Email : ". $userStaff->email ."</p>";
    }

    public function ajaxEmployer($employer){
        if($employer == 0){
            echo '<label></label>
                  <p>Địa chỉ: </p>
                  <p>Hotline: </p>
                  <p>Người đại diện: </p>
                  <p>Doanh nghiệp: </p>';
            return;
        }
        $employers = Employer::join('employer_representative','employer_representative.employer_id','=','employer.employer_id')
            ->join('province','province.province_id','=','employer.province')
            ->join('district','district.district_id','=','employer.district')
            ->where('employer.employer_id', $employer)->first();
        echo "<label>" . $employers->enterprise_name . "</label>
                  <p>Địa chỉ: " . $employers->district_name . " - " . $employers->province_name . "</p>
                  <p>Hotline: " . $employers->phone . "</p>
                  <p>Người đại diện: " . $employers->representative_name ."</p>
                  <p>Doanh nghiệp: " .$employers->enterprise_name . "</p>";
    }

    public function ajaxEmployee($employee){
        if($employee==0){
            echo '<label></label>
                <p>Địa chỉ thường trú :</p>
                <p>SĐT :  </p>
                <p>Họ và tên: </p>';
            return;
        }
        $employees = Employee::where('employee_id',$employee)->first();
        echo "<label>" . $employees->employee_name ."</label>
              <p>Địa chỉ thường trú : ". $employees-> address . "</p>
              <p>SĐT : " . $employees->phone ."</p>
              <p>Họ và tên: " . $employees->employee_name ."</p>";
    }

    public function ajaxProvince($province){
        if($province == 0){
            echo '<option  value=""> -- Tất cả các quận/huyện --</option>';
        }
        $districts = District::where('province_id', $province)->get();
        foreach ($districts as $id =>$district ){
            if($id == 0)
            {
                echo '<option value=""> Tất cả các quận/huyện</option>';
            }
            echo '<option value=" ' . $district->district_id .'">' . $district->district_name . '</option>';
        }
    }

    public function ajaxJobGroup($jobGroupName){
        $jobGroups = JobGroup::where('job_group_name', 'like','%'.$jobGroupName.'%')
            ->orderBy('job_group_name')->get();
        $string = '';


        foreach ($jobGroups as $jobgroup){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="jobgroups[]" value="' . $jobgroup->job_group_id . '" class="flat-red">'
                . $jobgroup->job_group_name .
                '</label>
                        </div>';
        }
        echo $string;
    }

    public function ajaxJobGroupList(){
        $jobGroups = JobGroup::orderBy('job_group_name')->get();
        $string = '';
        foreach ($jobGroups as $jobgroup){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="jobgroups[]" value="' . $jobgroup->job_group_id . '" class="flat-red">'
                . $jobgroup->job_group_name .
                '</label>
                        </div>';
        }
        echo $string;
    }

    public function ajaxCareerList(){
        $careers = Career::orderBy('career_category_name')->get();
        $string = '';
        foreach ($careers as $career){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="careers[]" value="' . $career->career_category_id . '" class="flat-red">'
                . $career->career_category_name .
                '</label>
                        </div>';
        }
        echo $string;

    }

    public function ajaxCareer($careerName){
        $careers = Career::orderBy('career_category_name')
            ->where('career_category_name','like','%'.$careerName.'%')->get();
        $string = '';
        foreach ($careers as $career){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="careers[]" value="' . $career->career_category_id . '" class="flat-red">'
                . $career->career_category_name .
                '</label>
                        </div>';
        }
        echo $string;
    }

    public function ajaxType($typeName){
        $typeBusinessList =  TypeOfBusiness::where('type_of_business_name','like','%'.$typeName.'%')
                            ->orderBy('type_of_business_name')->get();
        $string = '';
        foreach ($typeBusinessList as $typeBusiness){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="careers[]" value="' . $typeBusiness->type_of_business_id . '" class="flat-red">'
                . $typeBusiness->type_of_business_name .
                '</label>
                        </div>';
        }
        echo $string;
    }

    public function ajaxTypeList(){
        $typeBusinessList =  TypeOfBusiness::orderBy('type_of_business_name')->get();
        $string = '';
        foreach ($typeBusinessList as $typeBusiness){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="type_business[]" value="' . $typeBusiness->type_of_business_id . '" class="flat-red">'
                . $typeBusiness->type_of_business_name .
                '</label>
                        </div>';
        }
        echo $string;
    }

    public function ajaxBusiness($businessName){
        $businessList = Business::where('business_type_name','like','%'.$businessName.'%')
        ->orderBy('business_type_name')->get();
        $string = '';
        foreach ($businessList as $business){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="business[]" value="' . $business->business_type_id . '" class="flat-red">'
                . $business->business_type_name .
                '</label>
                        </div>';
        }
        echo $string;
    }

    public function ajaxBusinessList(){
        $businessList = Business::orderBy('business_type_name')->get();
        $string = '';
        foreach ($businessList as $business){
            $string .= '<div class="form-group">
                            <label>
                                <input type="checkbox" name="business[]" value="' . $business->business_type_id . '" class="flat-red">'
                . $business->business_type_name .
                '</label>
                        </div>';
        }
        echo $string;
    }

    public function ajaxSale($sale){
        if($sale == 0){
            $employers = Employer::get();
            $string = '';
            $string .= '<option value="0"> -- Chọn nhà tuyển dụng -- </option>';
            foreach ($employers as $employer){
                $string .= '<option value="' . $employer->employer_id .'">'.
                           $employer->enterprise_name . '</option>';
            }
            echo $string;
            return;
        }
        $employers = Sale::join('employer','employer.employer_id','=','sale_package.employer_id')
                    ->where('sale_package.sale_package_id',$sale)->get();
        $string = '';
        foreach ($employers as $employer){
            $string .= '<option value="' . $employer->employer_id .'">'.
                $employer->enterprise_name . '</option>';
        }
        echo $string;
    }

    public function ajaxJob($employer){
        $string = '';
        if($employer == 0){
            $string .= '<option value="0"> -- Chọn công việc -- </option>';
            $jobs = Job::get();
            foreach ($jobs as $job){
                $string .= '<option value="'. $job->job_id .'">' .
                            $job->title . '</option>';
            }
            echo $string;
            return;
        }
        $jobs = Job::where('employer_id', $employer)->get();
        foreach ($jobs as $job){
            $string .= '<option value="'. $job->job_id .'">' .
                $job->title . '</option>';
        }
        echo $string;
    }
}
