<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Cv_employee;
use App\Entity\Employee;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\Job_anwser;
use App\Entity\Job_application;
use App\Entity\JobFacebook;
use App\Entity\MailConfig;
use App\Entity\Notification_employer;
use App\Entity\Teacher;
use App\Entity\Teacher_submit_job_faacebook;
use App\Entity\Template_email;
use App\Entity\User;
use App\Exam\CategoriesExam;
use App\Exam\Detail_result_job_exam;
use App\Exam\Exam;
use App\Exam\Questions;
use App\Exam\Result_job_exam;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Ultility\Ultility;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Rules\Invateemails;
use Illuminate\Support\Facades\Validator;
use App\Mail\Resetpassword;
use App\Ultility\Error;


class JobUserSubmitController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        if (Auth::check()) {
            $this->middleware(function ($request, $next) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }

                $this->id_user = Auth::user()->id;
                $ckeditor = new CkedittorController();
                $session_image = $ckeditor->checkImage();
                return $next($request);
            });
        }
//        parent::__construct();
//        $this->middleware(function ($request, $next) {
//            session_start();
//            if (!Auth::check()) {
//                return redirect(route('list_job_face'))->with('error_login', 'Vui lòng dăng nhập để sử dụng chức năng này !');
//            }
//            else
//            {
//                $this->id_user = Auth::user()->id;
//                $ckeditor = new CkedittorController();
//                $session_image = $ckeditor->checkImage();
//            }
//
//            return $next($request);
//        });
    }

    public function checkImage()
    {

    }

    public function index(Request $request)
    {
//        hien thi o phan function getAllUser();
    }

    //kiem tra xem ứng viên này đã nộp hồ sơ cho công việc này chưa
    public function check_employee_submit($id_user, $id_job_fb, $status_job)
    {
        $employee = new Employee();
        $employee = $employee->select('*')->where('user_id', $id_user)->first();
        $job = new Job();
        $job = $job->select('job_id', 'slug')->where('job_id', $id_job_fb)->first();
        $submit_job_submit = new Employee_submit_job_faacebook();
        $submit_job_submit = $submit_job_submit->select('*')
            ->where('employee_id', $employee->employee_id)
            ->where('id_job_fb', $job->job_id)
            ->where('status_job', $status_job)
            ->first();
        if (!empty($submit_job_submit)) {
            return true;
        }
        return false;
    }

    //nộp hồ sơ và thi trắc nghiêm
    public function submitExamJob(Request $request, $id_job_fb)
    {
        $status_job = 1;
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->id_user = Auth::user()->id;
        //cau hinh de them avatar
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();

        if (Auth::check()) {
            $role = Auth::user()->role;
        }
        if (!Auth::check()) {
            return view('site.job_facebook.update_submit_job', compact('id_job_fb', 'status_job'));
            //neu chua dang nhap thi tao moi ung vien luon
        }
        $id_user = Auth::user()->id;
        if (Auth::user()->role == 1) {
//            $check_submit = $this->check_employee_submit($id_user, $id_job_fb, $status_job);
//            if ($check_submit) {
//                return redirect(route('list_cate_job'))->with('error_job', 'Bạn đã nộp hồ  sơ cho công việc này rồi');
//            }
//        kiem tra xem ứng viên này đã nộp hồ sơ cho công việc này chưa
            $job = new Job();
            $job = $job->select('job_id', 'status_exam', 'id_exam', 'date_exam_job', 'slug')->where('job_id', $id_job_fb)->first();
            if ($job->status_exam != 1) {
                return redirect(route('submitFileJobFacebook', ['id_job_fb' => $id_job_fb, 'id_job_fb' => 1]));
            }
            $id_exam = $job->id_exam;
            $exam = new Exam();
            $exam = $exam->select('*')
//            ->join('categories_join_exam','categories_join_exam.id_exam','=','exam.id_exam')
//            ->join('categories_exam','categories_exam.id_cate_exam','=','categories_join_exam.id_categories_exam')
                ->where('exam.bank_exam', '=', 1)
                ->where('exam.id_exam', '=', $id_exam)
                ->first();
            $categories_exams = new CategoriesExam();
            $categories_exams = $categories_exams->select('*')
                ->join('categories_join_exam', 'categories_join_exam.id_categories_exam', '=', 'categories_exam.id_cate_exam')
                ->where('categories_join_exam.id_exam', '=', $id_exam)
                ->get();

            $question = new Questions();
            $questions = $question->select('*')
                ->where('id_exam', '=', $id_exam)
//            ->groupBy('')
                ->orderBy('type_ques', 'asc')
                ->get();
            $countQuestion = $question->select('*')
                ->where('id_exam', '=', $id_exam)
                ->count();
            if ($countQuestion <= 0) {
                $url = redirect()->back()->getTargetUrl();
                return redirect($url)->with('errorQuestion', 'Đề thi này chưa được tạo câu hỏi');
            }
            //check user đã làm đề thi
            $employee = new Employee();
            $employee = $employee->select('employee_id','user_id')
                ->where('user_id',$id_user)
                ->first();
            $result_job_exam = new Result_job_exam();
            $result_job_exam = $result_job_exam->select('*')
                ->where('job_id',$id_job_fb)
                ->where('employee_id',$employee->employee_id)
                ->first();
                if(!empty($result_job_exam))
                {
                    return redirect(route('showResultExam',['id_result_job_exam'=>$result_job_exam->id_result_job_exam]))->with('error_job','Bạn đã làm đề thi trắc nghiệm này rồi !');
//                    return redirect('applySucces',['job_id'=>$id_job_fb])->with('error_job','Bạn đã làm đề thi trắc nghiệm này rồi !');
                }
            return view('site.jobs.job_exam', compact('id_exam', 'id_job_fb', 'exam', 'categories_exams', 'questions', 'countQuestion'));
        } else {
            $job = new Job();
            $job = $job->select('job_id', 'status_exam', 'id_exam', 'date_exam_job', 'slug')->where('job_id', $id_job_fb)->first();
            return redirect(route('job_detail', ['slug' => $job->slug]))->with('error_job', 'Vui lòng đăng nhập tài khoản ứng viên để ứng tuyển công việc này');
        }
    }


    //ket qua thi trac nghiem
    public function createResultJobExam(Request $request)
    {
//        try {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->id_user = Auth::user()->id;
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $user = Auth::user();
        $id_user = Auth::user()->id;
        $id_exam = $request->input('id_exam');
        $job_id = $request->input('id_job_fb');
//            echo $id_exam;die();
        $correct_answer = $request->input('answer');
        $question = new Questions();
        //lay ra
        //thong tin user
        $employee = new Employee();
        $employee = $employee->select('*')->where('user_id', $id_user)->first();
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $employee->employee_id)->orderBy('specialize_id', 'asc')->get();
        //Kinh nghiệm làm việc
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $employee->employee_id)->orderBy('experience_id', 'asc')->get();

        $job = Job::select('job_id','employer_id')->where('job_id',$job_id)->first();
        $employer = Employer::select('email','employer_id')->where('employer_id',$job->employer_id)->first();

//            tien hanh luu vao bang submit job
//            $employee_submit = new Employee_submit_job_faacebook();
//            $id_submit_job = $employee_submit->insertGetId([
//                'employee_id' => $employee->employee_id,
//                'id_job_fb' => $request->input('id_job_fb'),
//                'status_job' => 1,
//                'day_submit_job' => new \DateTime(),
//                'created_at' => new \DateTime(),
//                'updated_at' => new \DateTime(),
//            ]);
        //tien hnah luu vao bang ket qua
        $result_job_exam = new Result_job_exam();
        $id_result_job_exam = $result_job_exam->insertGetId([
            'job_id' => $job_id,
            'employee_id' => $employee->employee_id,
            'id_exam' => $id_exam,
            'created_at' => new \DateTime(),
        ]);
        //luu vao bang chi tiet ket qua
        $detail_job_result = new Detail_result_job_exam();
        foreach ($correct_answer as $id_ques => $correct) {
            $insert_detail_job_result = $detail_job_result->insert([
                'id_result_job_exam' => $id_result_job_exam,
                'id_ques' => $id_ques,
                'user_correct_ques' => $correct,
                'updated_at' => new \DateTime(),
            ]);
        }
        //hien thi ket qua
        $exam = new Exam();
        $exam = $exam->select('*')
            ->where('id_exam', '=', $id_exam)
            ->first();
        //Gửi email thông báo
        $send_email = MailConfigController::show_exam_employee($employee->employee_id, $job_id,$employer->email);
        return redirect(route('applySucces', ['job_id' => $job_id]))->with('success_exam', 'Bạn đã hoàn thành xong bài thi trắc nghiệm');
//        } catch (\Exception $exception) {
////            $error = 1;
//        }
    }

    public function showResultExam(Request $request, $id_result_job_exam)
    {
//        try {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->id_user = Auth::user()->id;
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();

        $user = Auth::user();
        $employee = new Employee();
        $employee = $employee->select('*')->where('user_id', $user->id)->first();
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $employee->employee_id)->orderBy('specialize_id', 'asc')->get();
        //Kinh nghiệm làm việc
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $employee->employee_id)->orderBy('experience_id', 'asc')->get();
        $id_job_fb = '';
        $id_exam = '';
        $result_job_exam = new Result_job_exam();
        $result_job_exam = $result_job_exam->select('*')->where('id_result_job_exam', $id_result_job_exam)->first();

        $id_job_fb = $result_job_exam->job_id;
        $id_exam = $result_job_exam->id_exam;
        $status_job = 1;

        $jobs = new Job();
        $job = $jobs->select('*')->where('job_id', $result_job_exam->job_id)->first();

        return view('site.jobs.apply_job_exam', compact('id_result_job_exam', 'id_exam', 'id_user', 'question_1', 'question_2', 'question_3', 'id_job_fb', 'id_exam', 'employee', 'specialize', 'experience', 'user', 'status_job', 'job'))->with('success_exam', 'Bạn đã hoàn thành bài thi vui lòng cập nhật lại thông tin hồ sơ trước khi nộp hồ sơ');
    }
    public function update_question_showResultExam(Request $request)
    {

        try {
            $id_result_job_exam = $request->input('id_result_job_exam');
            $question_1 = $request->input('question_1');
            $question_2 = $request->input('question_2');
            $question_3 = $request->input('question_3');

            $result_room = new Result_job_exam();
            $result_room = $result_room->where('id_result_job_exam', $id_result_job_exam)->update([
                'correct_question_1' => $question_1,
                'correct_question_2' => $question_2,
                'correct_question_3' => $question_3,
            ]);
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        }
        catch (\Exception $e)
        {
            return response([
                'status' => 500,
            ])->header('Content-Type', 'text/plain');
        }

    }


//    end ket qua thi
    //nộp hồ sơ việc làm với trường hợp khi thi trắc nghiêm
    public function submitFileJobFacebook(Request $request, $id_job_fb, $status_job)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if ($status_job == 0 or $status_job == 1) {
            if (Auth::check()) {
                $role = Auth::user()->role;
                $this->id_user = Auth::user()->id;
                $ckeditor = new CkedittorController();
                $session_image = $ckeditor->checkImage();
            }
            if (!Auth::check()) {
                return view('site.job_facebook.update_submit_job', compact('id_job_fb', 'status_job'));
                //neu chua dang nhap thi tao moi ung vien luon
            }
            //ung vien

            if (Auth::check() && $role == 1) {
                $user = Auth::user();
                $id = Auth::user()->id;
                $employees = new Employee();
                $employee = $employees->select('*')->where('user_id', $id)->first();
//              nếu hồ sơ trên 70% thì tiến hành nộp hồ luôn
                if($status_job == 1)
                {
                    $job = Job::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                        ->leftJoin('province', 'province.province_id', 'jobs.province')
                        ->leftJoin('district', 'district.district_id', 'jobs.district')
                        ->leftJoin('literacies', 'literacies.literacy_id', 'jobs.literacy_id')
                        ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
                        ->select(
                            'jobs.*',
                            'employer.employer_id',
                            'employer.enterprise_name',
                            'employer.website as employer_website',
                            'employer.image as employer_image',
                            'salary.description as salary_description',
                            'salary.salary_from',
                            'salary.salary_to',
                            'literacies.literacy_name',
                            'district_name',
                            'province_name',
                            'postalcode'
                        )
                        ->where('jobs.job_id', $id_job_fb)
                        ->first();
                    if(empty($job))
                    {
                        return redirect(route('list_job_face'));
                    }

                    Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
                    //lay giờ theo giống facebook
                    $date=date_create($job->updated_at);

                    $date_fb = Carbon::create((date_format($date,"Y")), (date_format($date,"m")), (date_format($date,"d")), (date_format($date,"H")), (date_format($date,"i")), (date_format($date,"s")));
                    $now = Carbon::now();
                    $date_facebook = $date_fb->diffForHumans($now); //1 giờ trước

                    $employer = Employer::select('employer_id','enterprise_name')->where('employer_id',$job->employer_id)->first();
                    //don xin việc
                    $job_app = Job_application::select('career_category_id','job_app_content')->where('career_category_id',$job->career_category_id)->first();


                    return view('site.jobs_site.submit_job', compact('id_job_fb', 'user', 'employee', 'status_job','job','employer','job_app','date_facebook'));
                }
                if($status_job == 0)
                {
                    $jobFacebook = JobFacebook::leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id')
                        ->leftJoin('province', 'province.province_id', 'job_facebook.province')
                        ->leftJoin('district', 'district.district_id', 'job_facebook.district')
                        ->leftJoin('career_categories', 'career_categories.career_category_id', 'job_facebook.career_category_id')
                        ->select('job_facebook.*',
                            'salary.description as salary_description',
                            'salary.salary_from',
                            'salary.salary_to',
                            'district_name',
                            'province_name',
                            'postalcode',
                            'career_categories.career_category_name'
                        )
                        ->where('job_facebook.job_facebook_id', $id_job_fb)
                        ->first();

                    Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
                    //lay giờ theo giống facebook
                    $date = date_create($jobFacebook->created_at);
                    $date_fb = Carbon::create((date_format($date, "Y")), (date_format($date, "m")), (date_format($date, "d")), (date_format($date, "H")), (date_format($date, "i")), (date_format($date, "s")));
                    $now = Carbon::now();
                    $date_facebook = $date_fb->diffForHumans($now); //1 giờ trước

                    $job_app = Job_application::select('career_category_id','job_app_content')->where('career_category_id',$jobFacebook->career_category_id)->first();
                    $employer = '';
                    if(!empty($jobFacebook->employer_id))
                    {
                        $employer = Employer::select('employer_id','enterprise_name')->where('employer_id',$jobFacebook->employer_id)->first();
                    }


                    return view('site.job_facebook_site.submit_job_facebook', compact('jobFacebook', 'user', 'employee', 'status_job','employer','job_app','date_facebook'));


//                    return view('site.job_facebook.submit_job_facebook', compact('jobFacebook', 'user', 'employee', 'status_job','cv_employee','job','employer','job_app','date_facebook'));
                }
            } //            giao vien
            else {
                if ($status_job == 1) {
                    $job = new Job();
                    $job = $job->select('job_id', 'status_exam', 'id_exam', 'date_exam_job', 'slug')->where('job_id', $id_job_fb)->first();
                    return redirect(route('job_detail', ['slug' => $job->slug]))->with('error_job', 'Vui lòng đăng nhập tài khoản ứng viên để ứng tuyển công việc này');
                }
                if ($status_job == 0) {
                    $job_facebok = new JobFacebook();
                    $job_facebok = $job_facebok->select('slug', 'job_facebook_id')
                        ->where('job_facebook_id', $id_job_fb)
                        ->first();
                    return redirect(route('detail_job_face', ['slug' => $job_facebok->slug]))->with('error_job', 'Vui lòng đăng nhập tài khoản ứng viên để ứng tuyển công việc này');
                }
            }
        } else {
            return redirect(route('list_job_face'));
        }


    }
    //nộp hồ sở với tin tuyển dụng của ntd
    public static function submit_apply_now(Request $request)
    {
        if(!Auth::check())
        {
            return redirect(route('list_job_face'));
        }

        $user = Auth::user();
        $id = Auth::user()->id;
        $employees = new Employee();
        $employee = $employees->select('*')->where('user_id', $id)->first();
        if(empty($employee->status_employee))
        {
            return redirect()->back()->error('Hồ sơ của bạn chưa được duyệt nên không thể ứng tuyển cho công việc này !');
        }
        $id_job_fb = $request->input('id_job_fb');
        $status_job = $request->input('status_job');
        $value_select = $request->input('list_job_app');
        $job_app_content = $request->input($value_select);
//        echo $job_app_content;die();

        //check xem ho so da nop chua nêu nop roi chuyen sang nop thnah cong luon
        $check_submit_job = Employee_submit_job_faacebook::where('employee_id',$employee->employee_id)
            ->where('status_job',$status_job)
            ->where('id_job_fb',$id_job_fb)
            ->count();
        if(!empty($check_submit_job))
        {
            if ($status_job == 0) {
                return redirect(route('applySucces_job_facebook',['job_facebook_id'=> $id_job_fb]))->with('success','Nộp hồ sơ thành công');
            }
            if($status_job == 1)
            {
                return redirect(route('applySucces',['job_id'=> $id_job_fb]))->with('success','Nộp hồ sơ thành công');
            }
        }
        $submit_job_fb_id = Employee_submit_job_faacebook::insertGetId([
            'employee_id'=> $employee->employee_id,
            'id_job_fb' => $id_job_fb,
            'status_job' =>$status_job,//trang thai 0 là tin fb 2 la tin tuỷen
            'day_submit_job' => new \DateTime(),
            'job_app_content'=> $job_app_content,
            'created_at' => new \DateTime(),
        ]);
        if ($status_job == 0) {
            $job_facebook = new JobFacebook();
            $job_facebook = $job_facebook->select('*')->where('job_facebook_id', $id_job_fb)->first();
            //thông tin ung vien
//                gủi email thông báo cho ugn vien
            MailConfigController::send_submit_job_fb_email(1,$job_facebook,$employee,$employee->email,$submit_job_fb_id);
//                $this->send_submit_job_fb_email(1,$job_facebook,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
            MailConfigController::send_submit_job_fb_email(2,$job_facebook,$employee,$job_facebook->email,$submit_job_fb_id);
//                $this->send_submit_job_fb_email(2,$job_facebook,$emplo,$job_facebook->email);
            //gửi thông báo info den ứng viên
            return redirect(route('applySucces_job_facebook',['job_facebook_id'=> $id_job_fb]))->with('success','Nộp hồ sơ thành công');
        }

        if($status_job == 1)
        {
            //gửi email và thông báo cho ntd
            $job = new Job();
            $job = $job->select('*')->where('job_id', $id_job_fb)->first();
            $employer = new Employer();
            $employer = $employer->select('employer_id', 'email','user_id')->where('employer_id', $job->employer_id)->first();
            //email nhận hồ sơ  của ứng viên úng tuyển
            $email_to_profile_employer = !empty($job->email_to_profile) ? $job->email_to_profile : $employer->email;
//                gủi email thông báo cho ugn vien
            MailConfigController::send_submit_job_email(1,$job,$employee,$employee->email,$submit_job_fb_id);
//                $this->send_submit_job_email(1,$job,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
            MailConfigController::send_submit_job_email(2,$job,$employee,$email_to_profile_employer,$submit_job_fb_id);
//                $this->send_submit_job_email(2,$job,$emplo,$employer->email);

            //gửi thông báo info den ứng viên
            $noti_model = new Notification_employer();
            $link_noti = route('list_Job_Candidate_Employee');
            $noti_insert =  $noti_model->insert([
                'title_noti' => 'Sanketoan.vn thông báo',
                'user_id' => $employer->user_id,
                'employee_id' => $employee->employee_id,
                'job_id' => $id_job_fb,
                'des_noti' => 'Có ứng viên nộp hồ sơ với công việc '.$job->title ,
                'link_noti' => $link_noti,
                'type_noti' => 'employer',
                'created_at' => new \DateTime()
            ]);
//                    gui api thong bao tren mobile
            $api_push_noti = new NotificationMobileController();
            $title = 'Sàn kế toán thông báo';
            $body = 'Công việc'.$job->title.' trên Sàn kế toán đã có ứng viên ứng tuyển';
            $type = 'submit_job';
            $note = 'Ứng viên trên  sanketoan $value đã id của ứng viên';
            $value = $employee->employee_id;
            $to = $employer->user_id;
            $send_noti = $api_push_noti->pushNotification( $title, $body, $to,$type,$note,$value);

            return redirect(route('applySucces',['job_id'=> $id_job_fb]))->with('success','Nộp hồ sơ thành công');
        }
    }

    public function show_appy_to_success($submit_job_fb_id , Request $request)
    {
        return view('site.jobs.show_appy_to_success');
    }
    //nộp hồ sơ ứng tuyển
        public function updateEmployeeSubmit(Request $request)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->id_user = Auth::user()->id;
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();

        $user = Auth::user();
        $email = Auth::user()->email;
        $id = Auth::user()->id;
        $validation = Validator::make($request->all(), [
            'employee_name' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'employee_name.required' => 'Tên ứng viên không được bỏ trống',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
//        try {
            $employee = new Employee();

            $updateem_ployee = $employee->where('user_id', $id)->update([
                'email' => $email,
                'employee_name' => $request->input('employee_name'),
                'marry' => $request->input('marry'),
                'gender' => $request->input('gender'),
                'career_category_id' => $request->input('career_category_id'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'information_verifier' => $request->input('information_verifier'),
                'employee_image' => $request->has('images') ? $request->input('images') : '',
                'birthday' => $request->input('birthday'),
                'school' => $request->input('school'),
                'majors' => $request->input('majors'),
                'cmt' => $request->input('cmt'),
                'cmt_date' => $request->input('cmt_date'),
                'cmt_local' => $request->input('cmt_local'),
                'code_intro' => $request->input('code_intro'),
                'my_facebook' => $request->input('my_facebook'),
                'updated_at' => new \DateTime()
            ]);
            $id_job_fb = $request->input('id_job_fb');
            $status_job = $request->input('status_job');
            $emplo = $employee->select('*')->where('user_id', $id)->first();
            $update_profile = \App\Entity\Employee::get_user_id_Profile($id);
            if($emplo->profile >= 70)
            {
                $empoyee_submit_job = new Employee_submit_job_faacebook();
                $total_submit_job = $empoyee_submit_job->select('*')
                    ->where('employee_id', $emplo->employee_id)
                    ->where('id_job_fb', $id_job_fb)
                    ->where('status_job', $status_job)
                    ->count();
                if ($total_submit_job < 1) {
                    $insert = $empoyee_submit_job->insert([
                        'employee_id' => $emplo->employee_id,
                        'id_job_fb' => $id_job_fb,
                        'status_job' => $status_job,
                        'day_submit_job' => new \DateTime(),
                        'created_at' => new \DateTime(),
                    ]);
                }
//            $status_job 0 laf tin fb 1 la tin NTD
                //công việc facebook
                if ($status_job == 0) {
                    $job_facebook = new JobFacebook();
                    $job_facebook = $job_facebook->select('*')->where('job_facebook_id', $id_job_fb)->first();
                    //thông tin ung vien
//                gủi email thông báo cho ugn vien
                    MailConfigController::send_submit_job_fb_email(1,$job_facebook,$emplo,$emplo->email);
//                $this->send_submit_job_fb_email(1,$job_facebook,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
                    MailConfigController::send_submit_job_fb_email(2,$job_facebook,$emplo,$job_facebook->email);
//                $this->send_submit_job_fb_email(2,$job_facebook,$emplo,$job_facebook->email);
                    //gửi thông báo info den ứng viên
                }
                //công viec NTD
                if ($status_job == 1) {
                    $job = new Job();
                    $job = $job->select('*')->where('job_id', $id_job_fb)->first();
                    $employer = new Employer();
                    $employer = $employer->select('employer_id', 'email','user_id')->where('employer_id', $job->employer_id)->first();
//                gủi email thông báo cho ugn vien
                    MailConfigController::send_submit_job_email(1,$job,$emplo,$emplo->email);
//                $this->send_submit_job_email(1,$job,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
                    MailConfigController::send_submit_job_email(2,$job,$emplo,$employer->email);
//                $this->send_submit_job_email(2,$job,$emplo,$employer->email);

                    //gửi thông báo info den ứng viên
                    $noti_model = new Notification_employer();
                    $link_noti = route('list_Job_Candidate_Employee');
                    $noti_insert =  $noti_model->insert([
                        'title_noti' => 'Sanketoan.vn thông báo',
                        'user_id' => $employer->user_id,
                        'employee_id' => $emplo->employee_id,
                        'job_id' => $id_job_fb,
                        'des_noti' => 'Có ứng viên nộp hồ sơ với công việc '.$job->title ,
                        'link_noti' => $link_noti,
                        'created_at' => new \DateTime()
                    ]);

//                    gui api thong bao tren mobile
                    $api_push_noti = new NotificationMobileController();
                    $title = 'Sàn kế toán thông báo';
                    $body = 'Công việc'.$job->title.' trên Sàn kế toán đã có ứng viên ứng tuyển';
                    $type = 'submit_job';
                    $note = 'Ứng viên trên  sanketoan $value đã id của ứng viên';
                    $value = $emplo->employee_id;
                    $to = $employer->user_id;
                     $send_noti = $api_push_noti->pushNotification( $title, $body, $to,$type,$note,$value);

//                     echo '<pre>';
//                     print_r($send_noti);die();



                    return redirect(route('applySucces', ['job_id' => $job->job_id]));
                }
                return redirect()->back()->with('suscess_job', 'Bạn đã ứng tuyển công việc này thành công');
            }
            else
            {
                return redirect()->back()->with('erorr', 'Vui lòng hoàn thiện thông tin hồ sơ >= 70% thì mới nộp được hồ sơ.Bạn có thể thêm trình độ ứng viên và kinh nghiệm làm việc để hoàn thành hồ sơ');
            }

//        } catch (\Exception $e) {
//            return redirect()->back()->with('erorr', 'Đã có lỗi xảy ra vui lòng thử lại');
//        }
    }

    public function applySucces($job_id)
    {
        $job = Job::select('job_id','title','employer_id','slug','career_category_id')->where('job_id',$job_id)->first();
        $employer = Employer::select('employer_id','enterprise_name')->where('employer_id',$job->employer_id)->first();

        return view('site.jobs.apply_now_success', compact('job','employer'));

    }
    public function applySucces_job_facebook($job_id)
    {
//        $jobs = new Job();
//        $job = $jobs->select('*')
//            ->where('job_id', $job_id)
//            ->first();
//
//        $exam = Exam::select('id_exam','name_exam')->where('id_exam',$job->id_exam)->first();
//        $job_question = Job_question::select('*')->where('job_id',$job_id)->get();
//
//        $user_id = Auth::user()->id;
//        $employee = Employee::select('employee_id','user_id')->where('user_id',$user_id)->first();
//        $employee_submit_job = Employee_submit_job_faacebook::select('submit_job_fb_id',
//            'employee_id',
//            'id_job_fb',
//            'status_job',//trang thai 0 là tin fb 2 la tin tuỷen
//            'id_status_submit_job', //trang thai ho so
//            'day_submit_job')
//            ->where('id_job_fb',$job_id)
//            ->where('employee_id',$employee->employee_id)
//            ->first();
//
//        $result_job_exam = Result_job_exam::select('*')
//            ->where('job_id',$job_id)
//            ->where('id_exam',$job->id_exam)
//            ->where('employee_id',$employee->employee_id)
//            ->first();
//        $employer = Employer::select('employer_id','enterprise_name','phone','email')
//            ->where('employer_id',$job->employer_id
//            )->first();
        $job_facebook = JobFacebook::select('*')->where('job_facebook_id',$job_id)->first();
        return view('site.job_facebook.apply_now_success', compact('job_facebook'));

    }
    public function employee_answer(Request $request)
    {

        $list_question = $request->input('question');
        $job_id = $request->input('job_id');
        $submit_job_fb_id = $request->input('submit_job_fb_id');

        try{
            if(!empty($list_question))
            {
                //xoa cau tra loi cu roi them moi
                $job_answer = Job_anwser::where('job_id',$job_id)
                    ->where('submit_job_fb_id',$submit_job_fb_id)
                    ->delete();
                foreach ($list_question as $id_question=>$anwser)
                {
                    //them moi lai cau hoi
                    $job_answer = Job_anwser::insert([
                        'job_id' => $job_id,
                        'job_qes_id' => $id_question,
                        'job_anwser_name' => $anwser,
                        'submit_job_fb_id' => $submit_job_fb_id,
                        'created_at' => new \DateTime()
                    ]);
                }
            }
            return redirect(route('applySucces',['job_id'=>$job_id]))->with('success','Bạn đã trả lời câu hỏi của nhà tuyển dụng thành công');
        }catch (\Exception $e)
        {
            return redirect(route('applySucces',['job_id'=>$job_id]))->with('error','Bạn đã trả lời câu hỏi của nhà tuyển dụng thất bại');
        }

    }

    public function createEmployeeSubmit(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'employee_name' => 'required',
            'g-recaptcha-response' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required|min:6',
            'birthday' => 'required',
        ], [
            'employee_name.required' => 'Tên ứng viên không được bỏ trống',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy',
            'email.required' => 'Email không được để trống',
            'email.unique' => 'Email đã tồn tại',
            'password.required' => 'Password không được để trống',
            'password.min' => 'Password không được ít hơn 6 kí tự',
            'birthday.required' => 'Ngày sinh không được để trống',
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        $id_job_fb = $request->input('id_job_fb');
        $status_job = $request->input('status_job');
        try {
            DB::beginTransaction();
            $userWithPhone = $this->createUser($request);
            $this->createNewEmployee($request, $userWithPhone);
            Auth::guard()->login($userWithPhone);
            $email = $userWithPhone->email;
            //cap nhat ti lệ hoàn thành hồ sơ
            $update = \App\Entity\Employee::get_user_id_Profile($userWithPhone->id);
//         end gui email thong bao
            DB::commit();
            MailConfigController::send_email_employee_confirm($userWithPhone);

        } catch (\Exception $e) {
            Error::setErrorMessage("Không thể Đăng ký hồ sơ. Vui lòng thử lại ");
            DB::rollBack();
            return redirect()->back()->with('error', 'Đăng kí hồ sơ thất bại ! Vui lòng thử lại');
        } finally {
            return redirect()->back()->with('success_create', 'Bạn đã tạo hồ sơ thành công ? Vui lòng cập nhật thêm trình độ ứng viên và kinh nghiêm làm việc của bạn để nhà tuyển dụng biết rõ được năng lực của bạn');
        }
    }

    private function createUser($request)
    {
        $userModel = new User();
        $userWithPhone = $userModel->where('email', $request->input('email'))
            ->first();
        if (empty($userWithPhone)) {
            return $userModel->create([
                'name' => $request->input('employee_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('phone') ? $request->input('phone') : '',
                'role' => 1
            ]);
        }
        return $userWithPhone;
    }

    private function createNewEmployee($request, $userWithPhone)
    {
        $employeeId = Employee::insertGetId([
            'email' => $request->input('email'),
            'employee_name' => $request->input('employee_name'),
            'marry' => $request->input('marry'),
            'gender' => $request->input('gender'),
            'career_category_id' => $request->input('career_category_id'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'user_id' => $userWithPhone->id,
            'province' => $request->input('province'),
            'district' => $request->input('district'),
            'information_verifier' => $request->input('information_verifier'),
            'employee_image' => $request->has('images') ? $request->input('images') : '',
            'birthday' => $request->input('birthday'),
            'school' => $request->input('school'),
            'majors' => $request->input('majors'),
            'cmt' => $request->input('cmt'),
            'cmt_date' => $request->input('cmt_date'),
            'cmt_local' => $request->input('cmt_local'),
            'code_intro' => $request->input('code_intro'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

//        $employee_code = $employeeId.'UV'.$userWithPhone->id;
//        $update = Employee::where('employee_id',$employeeId)->update([
//            'employee_code' => $employee_code
//        ]);
    }

    public function updateTeacherSubmit(Request $request)
    {
        $user = Auth::user();
        $email = Auth::user()->email;
        $id = Auth::user()->id;
        $validation = Validator::make($request->all(), [
            'teacher_name' => 'required',
            'teacher_phone' => 'required',
            'g-recaptcha-response' => 'required',
        ], [
            'teacher_name.required' => 'Tên giáo viên không được bỏ trống',
            'teacher_phone.required' => 'Số điện thoại không được bỏ trống',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            $teacher = new Teacher();
            $tea = $teacher->select('teacher_id', 'slug', 'teacher_name', 'user_id')->where('user_id', $id)->first();
            $updateem_ployee = $teacher->where('user_id', $id)->update([
                'teacher_email' => $email,
                'teacher_name' => $request->input('teacher_name'),
                'gender' => $request->input('gender'),
                'address' => $request->input('address'),
                'teacher_phone' => $request->input('teacher_phone'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'information_verifier' => $request->input('information_verifier'),
                'teacher_images' => $request->has('images') ? $request->input('images') : '',
                'birthday' => $request->input('birthday'),
                'career_category_id' => $request->input('career_category_id')
            ]);
            $slug = Ultility::createSlug($request->input('teacher_name'));
            if (!empty(Teacher::where('slug', $slug)->first())) {
                $slug .= '-' . $tea->teacher_id;
            }
            Teacher::where('teacher_id', $tea->teacher_id)->update([
                'slug' => $slug
            ]);

            $id_job_fb = $request->input('id_job_fb');
            $status_job = $request->input('status_job');

            $teacher_submit_job = new Teacher_submit_job_faacebook();

            $total_submit_job = $teacher_submit_job->select('*')
                ->where('teacher_id', $tea->teacher_id)
                ->where('id_job_fb', $id_job_fb)
                ->where('status_job', $status_job)
                ->count();
            if ($total_submit_job < 1) {
                $insert = $teacher_submit_job->insert([
                    'teacher_id' => $tea->teacher_id,
                    'id_job_fb' => $id_job_fb,
                    'status_job' => $status_job,
                    'day_submit_job' => new \DateTime(),
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            }

            if ($status_job == 0) {
                $job_facebook = new JobFacebook();
                $job_facebook = $job_facebook->select('*')->where('job_facebook_id', $id_job_fb)->first();

                $subject = 'Sanketoan.vn thông báo';

                $email = $job_facebook->email;
                $content = '<h2> Công việc tuyển dụng của bạn đã có người ứng tuyển!</h2>';
                $content .= '<h3>Thông tin công việc</h3>';
                $content .= '<a href="' . route('detail_job_face', ['slug' => $job_facebook->slug]) . '">';
                $content .= 'Link xem công việc';
                $content .= '</a>';
                $content .= '<h3>Thông tin người ứng tuyển </h3>';
                $content .= '<a href="' . route('show_teacher', ['teacher_id' => $tea->teacher_id]) . '">';
                $content .= 'Link xem thông tin người ứng tuyển';
                $content .= '</a>';

                MailConfig::sendMail($email, $subject, $content);
            }
            //công viec NTD
            if ($status_job == 1) {
                $job = new Job();
                $job = $job->select('job_id', 'slug', 'employer_id')->where('job_id', $id_job_fb)->first();

                $employer = new Employer();
                $employer = $employer->select('employer_id', 'email')->where('employer_id', $job->employer_id)->first();

                $subject = 'Sanketoan.vn thông báo';

                $email = $employer->email;
                $content = '<h2> Công việc tuyển dụng của bạn đã có người ứng tuyển!</h2>';
                $content .= '<h3>Thông tin công việc</h3>';
                $content .= '<a href="' . route('job_detail', ['slug' => $job->slug]) . '">';
                $content .= 'Link xem công việc';
                $content .= '</a>';
                $content .= '<h3>Thông tin người ứng tuyển </h3>';
                $content .= '<a href="' . route('show_teacher', ['teacher_id' => $tea->teacher_id]) . '">';
                $content .= 'Link xem thông tin người ứng tuyển';
                $content .= '</a>';

                MailConfig::sendMail($email, $subject, $content);
            }

            return redirect()->back()->with('suscess', 'Bạn đã nộp sơ ứng tuyển thành công');


        } catch (\Exception $e) {
            return redirect()->back()->with('erorr', 'Bạn đã nộp sơ ứng tuyển thất bại');
        }
    }


}
