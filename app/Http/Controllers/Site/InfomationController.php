<?php

namespace App\Http\Controllers\Site;


use App\Entity\Input;
use App\Entity\InformationGeneral;
use App\Entity\JobSalePackage;
use App\Entity\JobSoftware;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Post;
use App\Entity\User;
use App\Entity\Workplace;
use App\Mail\Mail;
use App\Mail\Resetpassword;
use App\Ultility\Error;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Mockery\Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use App\Entity\Job;
use Illuminate\Support\Facades\DB;
use App\Entity\JobJobGroup;
use App\Entity\Employer;
use App\Entity\Employee;
use App\Entity\JobCareer;
use App\Entity\Invite;
use App\Entity\HistoryWork;

class InfomationController extends SiteController
{
    public function index(){
        $user = auth()->user();

        if($user->role == 1){
            $employeeModel = new Employee();
            $employee = $employeeModel->select(
                'employees.*'
            )

            ->where('employees.employee_user_id' , $user->id)
            ->first();
            $historyCompanies = HistoryWork::where('employee_id', $employee->employee_id)->get();
             if ($historyCompanies->isEmpty()) {
             $historyCompanies = '';
             }
            return view('site.infomation.employee.index', compact('user','employee','historyCompanies'));
        }

        if($user->role >= 2){
            $employerModel = new Employer();
            $employer = $employerModel->select(
                'employer.*'
            )
			
            ->where('employer.employer_user_id' , $user->id)
            ->first();
            return view('site.infomation.employer.index', compact('user','employer'));
        }
    }
    //sửa thông tin nhà tuyển dụng 

     public function updateEmployer(Request $request){
        $user = Auth::user();
        $userModel = new User();
        $employerModel = new Employer();
           try{
            $employer = $employerModel->where('employer_user_id', $user->id)
            ->update([
                'enterprise_name' => $request->input('enterprise_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'company_size' => $request->input('size'),
                'tax_code' => $request->input('tax_code'),
                'address' => $request->input('address'),      
                'district' => $request->input('district'),
                'website' => $request->input('website'),
                'province' => $request->input('province'),
                'introduction' => $request->input('introduction'),
                'image'=>  $request->input('image'),
            ]);

            $employerID = $employerModel->where('employer_user_id', $user->id)
            ->first();

            

            if(!empty($employerID))
            {
                if($request->has('remuneration')){
                     $remunerations = new Remuneration();
                     $remunerations = $remunerations->where('employer_id' , $employerID->employer_id)->delete();
                        foreach ($request->input('remuneration') as $remunerationss){
                                Remuneration::insert([
                            'employer_id' => $employerID->employer_id,
                            'remuneration_title' => $remunerationss
                        ]);
                    }
                }
                if($request->has('reason_choose')){
                     $reason_chooses = new Reason_choose();
                     $reason_chooses = $reason_chooses->where('employer_id' , $employerID->employer_id)->delete();
                        foreach ($request->input('reason_choose') as $reason_choosess){
                            Reason_choose::insert([
                            'employer_id' => $employerID->employer_id,
                            'reason_choose_title' => $reason_choosess
                        ]);
                    }
                } 
            }
          DB::commit(); 


     }
         catch (\Exception $e) {
        Error::setErrorMessage("Không thể Chỉnh sửa công việc vui lòng thử lại ");
         DB::rollBack();
       }

        return redirect()->back()->with('sucsses','Cập nhật thành công');
}

//đổi ảnh user luôn 

 

    //check nếu là nhà tuyển dụng thì cho vào trang tạo job
    public function showCreateJob(){
        $user = Auth::user();
          if($user->role >= 2){

           return view('site.infomation.employer.create_job');
        }
        return redirect()->back();
    }

    //Tạo job
    public function createJob(Request $request){
          // check xem là dữ liệu hợp lệ không
          $validation = $this->validateJob($request);
          if ($validation->fails()) {
              return redirect()->back()
                  ->withErrors($validation)
                  ->withErrors(['msg', 'Lỗi ']);
          }
          try {
              DB::beginTransaction();
              // Tạo dữ liệu cho bảng user với role = 2 để đăng nhập nhà tuyển dụng
              $insertJob = $this->insertJob($request);
             //Thêm dữ liệu bảng jobgroup
             $this->addJobGroup($request, $insertJob);
             // dữ liệu bảng nghành nghề
             $this->addJobCarrer($request, $insertJob);

              DB::commit();
          } catch (\Exception $e) {
              Error::setErrorMessage("Không thể Tạo mới công việc vui lòng thử lại ");
              DB::rollBack();
          } finally {
              return redirect(route('show_candidates'))->with('sucsses','Thêm mới công việc thành công! Hãy mời ứng viên tham gia công việc của mình ');
          }
    }
  
      // check điều kiện submit form
    private function validateJob($request) {
          $validation = Validator::make($request->all(), [
              'title' => 'required',
              'position'=>'required',
              'address'=>'required',
              'number_recruited'=>'required',
              'description'=>'required',
              'content'=>'required',
              'deadline_submit_profile'=>'required'

          ],[
              'title.required' => 'Tên công việc không được để trống .',
              'position.required' => 'Vị trí công việc không được để trống .',
              'address.required' => 'Địa chỉ công việc không được để trống .',
              'number_recruited.required'=>'Số lượng Cần tuyển không được để trống ',
              'description.required'=>'Mô tả công việc không được để trống ',
              'content.required'=>'Nội dung công việc không được để trống ',
              'deadline_submit_profile.required'=>'Hạn nộp công việc không được để trống '

          ]);
          return $validation;
    }
  
      // tao moi user
    private function insertJob ($request) {
          $user = Auth::user();
          $jobModel = new Job();
          $employers = new Employer();
          $employer_id = $employers->select('employer.employer_id')
          ->where('employer_user_id',$user->id)
          ->first();

          $insertJob = $jobModel->insertGetId([
              'employer_id'=>$employer_id->employer_id,
              'title' => $request->input('title'),
              'position' => $request->input('position'),
              'address_work' => $request->input('address'),
              'salary_id' => $request->input('salary'),
              'number_recruit' => $request->input('number_recruited'),
              'experience' => $request->input('experience'),
              'literacy_id' => $request->input('literacy'),
              'gender' => $request->input('gender'),
              'age' => $request->input('age'),
              'description' => $request->input('description'),
              'content' => $request->input('content'),
              'deadline_submit_profile' => $request->input('deadline_submit_profile')
          ]);
          return $insertJob;
    }

    private function addJobGroup ($request, $insertJob)
    {
        if ($request->has('job_group')) {
            JobJobGroup::where('job_id', $insertJob)->delete();
            foreach($request->input('job_group') as $jobgroup) {
                JobJobGroup::insert([
                        'job_id' => $insertJob,
                        'job_group_id' => $jobgroup,
                        'recruit' => $request->input('number_recruited'),
                        'created_at'=>new \DateTime(),
                        'updated_at' => new \DateTime()
                    ]);
            }
        }
    }

    private function deleteJobGroup($jobID){
        $job = Job::where('job_id', $jobID)->first();
        JobJobGroup::where('job_id', $job->job_id)->delete();
    }

    private function addJobCarrer ($request, $insertJob)
    {
        if ($request->has('careers')){
            foreach ($request->input('careers') as $career){
                JobCareer::insert([
                    'job_id' =>  $insertJob,
                    'career_category_id' => $career,
                    'recruit'=> $request->input('number_recruited'),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
            }
        }
    }

    private function deleteJobCarrer($jobID){
        $job = Job::where('job_id', $jobID)->first();
        JobCareer::where('job_id', $job->job_id)->delete();
    }

    private function updateJob($request, $slug){
        $user = Auth::user();
        $jobModel = Job::where('slug', $slug)->first();
        $employers = new Employer();
        $employer_id = $employers->select('employer.employer_id')
            ->where('employer_user_id',$user->id)
            ->first();
        if (!empty($jobModel)){
            $jobModel->update([
                'employer_id'=>$employer_id->employer_id,
                'title' => $request->input('title'),
                'position' => $request->input('position'),
                'address_work' => $request->input('address'),
                'salary_id' => $request->input('salary'),
                'number_recruit' => $request->input('number_recruited'),
                'experience' => $request->input('experience'),
                'literacy_id' => $request->input('literacy'),
                'gender' => $request->input('gender'),
                'age' => $request->input('age'),
                'description' => $request->input('description'),
                'content' => $request->input('content'),
                'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                'updated_at' => new \DateTime()
            ]);
            $this->deleteJobCarrer($jobModel->job_id);
            $this->addJobCarrer($request, $jobModel->job_id);
            $this->deleteJobGroup($jobModel->job_id);
            $this->addJobGroup($request, $jobModel->job_id);
        }
    }

    public function showCandidates($count = 30){
        $user = Auth::user();
        $employer = Employer::select('*')
        ->where('employer_user_id', $user->id)->first();
        if($user->role >= 2){
            $candidateModel = new Employee();
            $candidates = $candidateModel->leftJoin('literacies','literacies.literacy_id','employees.literacy')
            ->select(
                'employees.*',
                'literacies.literacy_name'
                )
                ->limit($count)
                ->get();
                return view('site.infomation.employer.invite', compact('user','candidates','employer'));
            }
            return redirect()->back();
    }
    

    public function inviteCandidate(Request $request){
        Invite::insert([
            'employer_id' => $request -> input('employer_id'),
            'job_id' => $request -> input('job_id'),
            'employee_id' => $request -> input('employee_id'),
            'status' => 0,
            'created_at' => new \DateTime()
        ]);
    }

    public function deleteInvite($employee, $job){
        try{
            DB::beginTransaction();
            $user = Auth::user();
            $employer = Employer::where('employer_user_id', $user->id)->first();
            if(!empty($employer)){
                Invite::where('employer_id', $employer->employer_id)
                    ->where('employee_id', $employee)
                    ->where('job_id', $job)
                    ->update([
                        'deleted_at' => new \DateTime()
                    ]);
            }
            DB::commit();
        }catch (Exception $exception){
            DB::rollBack();
            Error::setErrorMessage('Không thể xóa ứng viên đã mời. Đã có lỗi xảy ra');
        }

        return redirect(route('management_employee', ['slug'=>$employer->slug]));
    }

    public function jobManagement($slug){
        $jobs = Job::join('employer','employer.employer_id','=','jobs.employer_id')
            ->leftJoin('sale_package_job', 'sale_package_job.job_id','=','jobs.job_id')
            ->leftJoin('sale_package','sale_package.sale_package_id','=','sale_package_job.sale_package_id')
            ->where('employer.slug', $slug)
            ->select('jobs.job_id',
                'jobs.slug as slug',
                'jobs.position',
                'sale_package.sale_package_name as sale_package_name'
                )
            ->paginate(10);

        $countJob = Job::join('employer','employer.employer_id','=','jobs.employer_id')
            ->where('employer.slug', $slug);
        $countStill = $countJob->where('date_end','>', Carbon::now())
            ->orWhere('date_end','=', Carbon::now())->count();

        $countExpire = $countJob->where('date_end','<', Carbon::now())->count();

        $countExpiring = $countJob->where('date_end','>',Carbon::now()->subDays(3))
            ->orWhere('date_end','=', Carbon::now())->count();

        return view('site.infomation.employer.job_management', compact('slug','jobs','countStill', 'countExpire', 'countExpiring'));
    }

    public function edit($slug){
        $job = Job::where('slug', $slug)->first();
        return view('site.infomation.employer.edit', compact('slug', 'job'));
    }

    public function update(Request $request, $slug){
        $validation = $this->validateJob($request);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withErrors(['msg', 'Lỗi ']);
        }

        $employer_id = Employer::where('employer_user_id',Auth::user()->id)
            ->first();

        try{
            DB::beginTransaction();
            $this->updateJob($request, $slug);
            DB::commit();
        }catch (Exception $exception){
            Error::setErrorMessage('Không thể cập nhật tin tuyển dụng. Đã có lỗi xảy ra trong quá trình nhập liệu.');
            DB::rollBack();
        }finally{
            return redirect(route('job_management', ['slug'=>$employer_id->slug]));
        }

    }

    public function destroy($slug){
        $employer_id = Employer::where('employer_user_id',Auth::user()->id)
            ->first();
        try{
            DB::beginTransaction();
            $job = Job::where('slug', $slug)->first();
            if (!empty($job)){
                $this->deleteJobGroup($job->job_id);
                JobSalePackage::where('job_id', $job->job_id)->delete();
                $this->deleteJobCarrer($job->job_id);
                Workplace::where('job_id', $job->job_id)->delete();
                $job->delete();
            }
            DB::commit();
        }catch (Exception $exception){
            Error::setErrorMessage('Không thể xóa tin tuyển dụng. Đã có lỗi xảy ra.');
            DB::rollBack();
        }finally{
            return redirect(route('job_management', ['slug'=>$employer_id->slug]));
        }
    }
}