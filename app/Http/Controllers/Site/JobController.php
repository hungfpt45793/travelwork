<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Employee;
use App\Entity\Employee_profile;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employee_upload_cv;
use App\Entity\Employer;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\JobGroup;
use App\Entity\Notification_employer;
use App\Entity\Order;
use App\Entity\Salary;
use App\Entity\SettingGetfly;
use App\Entity\User;
use App\Entity\District;
use App\Entity\Workplace;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Ultility\CallApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;
use App\Ultility\Ultility;
use PDF;
use PDFMerger;
use Illuminate\Support\Facades\File;
use setasign\Fpdi\Fpdi;
use Illuminate\Support\Str;
use NcJoes\PopplerPhp\PdfInfo;
use NcJoes\PopplerPhp\Config;
use NcJoes\PopplerPhp\PdfToCairo;
use NcJoes\PopplerPhp\PdfToHtml;
use NcJoes\PopplerPhp\Constants as C;
use Illuminate\Support\Facades\Validator;

class JobController extends SiteController
{
    public function index($slug, Request $request)
    {
        $user = auth()->user();
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
            ->where('jobs.slug', $slug)
            ->first();

        if (empty($job->employer_id)) {
            return redirect(route('home'));
        }
        $employer = Employer::where('employer_id', $job->employer_id)->first();
        if (empty($job) || empty($employer)) {
            return redirect(route('home'));
        }

        $jobGroups = JobGroup::join('job_jobgroup', 'job_jobgroup.job_group_id', 'job_group.job_group_id')
            ->where('job_jobgroup.job_id', $job->job_id)
            ->get();

        Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
        //lay giờ theo giống facebook
        $date = date_create($job->updated_at);

        $date_fb = Carbon::create((date_format($date, "Y")), (date_format($date, "m")), (date_format($date, "d")), (date_format($date, "H")), (date_format($date, "i")), (date_format($date, "s")));
        $now = Carbon::now();
        $date_facebook = $date_fb->diffForHumans($now); //1 giờ trước

        $jobGroupIds = array();
        foreach ($jobGroups as $jobGroup) {
            $jobGroupIds[] = $jobGroup->job_group_id;
        }

        $countJobGroup = JobGroup::join('job_jobgroup', 'job_jobgroup.job_group_id', 'job_group.job_group_id')
            ->where('job_jobgroup.job_id', $job->job_id)
            ->count();
        $jobEmployers = Job::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
            ->leftJoin('province', 'province.province_id', 'jobs.province')
            ->leftJoin('district', 'district.district_id', 'jobs.district')
            ->select(
                'jobs.*',
                'salary.description as salary_description',
                'district_name',
                'province_name',
                'employer.enterprise_name',
                'employer.image as employer_image'
            )
            ->where('jobs.employer_id', $employer->employer_id)
            ->where('jobs.job_id', '!=', $job->job_id)
            ->where('jobs.active_job', 1)
            ->get();

        $jobRelations = Job::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('career_categories', 'career_categories.career_category_id', 'jobs.career_category_id')
            ->select(
                'jobs.title',
                'jobs.slug',
                'jobs.district',
                'salary.description as salary_description',
                'jobs.province',
                'jobs.employer_id',
                'jobs.career_category_id',
                'jobs.deadline_submit_profile',
                'jobs.salary_id',
                'jobs.date_submit',
                'jobs.updated_at',
                'jobs.active_job'
            )
            ->where('jobs.province', $job->province)
            ->where('jobs.job_id', '!=', $job->job_id)
            ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
            ->orWhere('jobs.career_category_id', $job->career_category_id)
            ->orWhere('jobs.employer_id', $job->employer_id)
            ->where('jobs.active_job', 1)
            ->orderBy('jobs.job_id', 'desc');
        $total_relations = $jobRelations->count();
        $jobRelations = $jobRelations->paginate(12);
        $workplaces = Workplace::where('job_id', $job->job_id)->get();


//        cap nhat luot xem;views
        $view = $job->views + 1;
        $jobview = Job::where('slug', $slug)->update([
            'views' => $view
        ]);

        if ($view == 50) {
            $email_employer = $job->email_to_profile;
            if (empty($job->email_to_profile)) {
                $email_employer = Employer::where('employer_id', $job->employer_id)->value('email');
            }
            $send_email_view = MailConfigController::send_email_50_view_job_employer($job->job_id, $email_employer, $view);
            //thong bao khi hồ sơ dạt dú lượng view
            $this->noti_view_job($job,$view);
        }
        if ($view == 100) {
            $email_employer = $job->email_to_profile;
            if (empty($job->email_to_profile)) {
                $email_employer = Employer::where('employer_id', $job->employer_id)->value('email');
            }
            $send_email_view = MailConfigController::send_email_50_view_job_employer($job->job_id, $email_employer, $view);
            $this->noti_view_job($job,$view);
        }
        if ($view == 150) {
            $email_employer = $job->email_to_profile;
            if (empty($job->email_to_profile)) {
                $email_employer = Employer::where('employer_id', $job->employer_id)->value('email');
            }
            $send_email_view = MailConfigController::send_email_50_view_job_employer($job->job_id, $email_employer, $view);
            $this->noti_view_job($job,$view);
        }

        //check tin tuyển dụng het han thi thong bao
        $date = date_create($job->deadline_submit_profile);
        $date_end = date_format($date, "d-m-Y");
        $today = date('d-m-Y');
        if(strtotime($today) == strtotime($date_end))
        {
            $this->noti_date_submit($job);
            //thong bao cho nha tuyen dụng tin tuyển dụng đã hết hạn
        }
        return view('site.jobs_site.job_detail', compact('job', 'jobGroups', 'countJobGroup', 'employer', 'total_relations', 'jobEmployers', 'jobRelations', 'workplaces', 'user', 'date_facebook'));
    }
    public function noti_date_submit($job)
    {
        $user_id = Employer::where('employer_id',$job->employer_id)->value('user_id');
        //check thông bao
        $check_noti = Notification_employer::where('user_id',$user_id)
            ->where('job_id',$job->job_id)
            ->where('type_job','submit_date')
            ->where('type_noti','employer')
            ->first();
        if(empty($check_noti))
        {
            //thông báo cho ứng viên
            $desc_title = 'Tin tuyển dụng của bạn đã hết hạn nộp hồ sơ' ;
            $noti_id = Notification_employer::insertGetId([
                'title_noti' => 'Sanketoan.vn thông báo', //tiêu đề thông báo
                'user_id' => $user_id, //	0 là thông báo chung
                'des_noti' =>$desc_title, //Nội dung thông báo
                'link_noti' => '', //Link thông báo trên window
                'type_noti' => 'employer', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
                'noti_status' => 0,//trạng thái thông báo 0 là chưa xem 1 đã xem
                'status_noti' =>0, //trạng thái thông báo 1 là đã xem 2 là đã xóa => tạm thời bỏ
                'view_noti' => 0, //Đã hiển thị thông báo ở cửa sơ window
                'job_id' => $job->job_id,
                'type_job' => 'submit_date',  //view là thông báo tin tuyển dụng đạt 50view , còn submit_date là tin tuyển dụng sắp hết hạn
                'created_at' => new \DateTime()
            ]);
            //push noti cho app
            $title = 'Sàn kế toán thông báo';
            $type = 'employer';
            $note = 'Tin tuyển dụng đã hết hạn nộp hồ sơ';
            $value = $noti_id;
            $to = $user_id;
            $push_noti_app = new NotificationMobileController();
            $send_push = $push_noti_app->pushNotification( $title, $desc_title, $to,$type,$note,$value);
        }
    }
    public function noti_view_job($job,$view)
    {
        $user_id = Employer::where('employer_id',$job->employer_id)->value('user_id');
        //thông báo cho ứng viên
        $desc_title = 'Tin tuyển dụng của bạn đã đạt ' .$view. ' lượt xem' ;
        $noti_id = Notification_employer::insertGetId([
            'title_noti' => 'Sanketoan.vn thông báo', //tiêu đề thông báo
            'user_id' => $user_id, //	0 là thông báo chung
            'des_noti' =>$desc_title, //Nội dung thông báo
            'link_noti' => '', //Link thông báo trên window
            'type_noti' => 'employer', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
            'noti_status' => 0,//trạng thái thông báo 0 là chưa xem 1 đã xem
            'status_noti' =>0, //trạng thái thông báo 1 là đã xem 2 là đã xóa => tạm thời bỏ
            'view_noti' => 0, //Đã hiển thị thông báo ở cửa sơ window
            'job_id' => $job->job_id,
            'type_job' => 'view',  //view là thông báo tin tuyển dụng đạt 50view , còn submit_date là tin tuyển dụng sắp hết hạn
            'created_at' => new \DateTime()
        ]);
        //push noti cho app
        $title = 'Sàn kế toán thông báo';
        $type = 'employer';
        $note = 'Tin tuyển dụng đạt được view';
        $value = $noti_id;
        $to = $user_id;
        $push_noti_app = new NotificationMobileController();
        $send_push = $push_noti_app->pushNotification( $title, $desc_title, $to,$type,$note,$value);
    }
    //giao dien job ung tuyển ngay
    public function apply_job(Request $request ,$slug)
    {
        if(Auth::check())
        {
            return redirect(route('job_detail',['slug' => $slug]));
        }
        $job = Job::where('jobs.slug', $slug)
            ->first();
        if(empty($job))
        {
            return redirect(route('list_job_face'));
        }
        return view('site.jobs_site.apply_job', compact('job'));
    }
    //dang dung cho ung tuyen ngay
    public function apply_job_now(Request $request)
    {
        $id_job_fb = $request->input('job_id');
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users|email',
            'name' => 'required',
            'phone' => 'required',
            'file' => 'required',
            'g-recaptcha-response' => 'required'
        ], [
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'name.required' => 'Họ và tên không được để trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'file.required' => 'Vui lòng chọn CV',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy hoặc  Im not a robot'
        ]);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $userModel = new User();
            $insert_id = $userModel->insertGetId([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => bcrypt('123456a@'),
                'phone' => $request->has('phone') ? $request->input('phone') : '',
                'role' => 1,
                'status_email_account' => 0,
                'created_at' => new \DateTime()
            ]);
            $link_confirm_account = str_random(10) . $insert_id;
            $update = $userModel->where('id', $insert_id)->update([
                'link_confirm_account' => $link_confirm_account
            ]);
            $employeeId = Employee::insertGetId([
                'employee_name' => $request->input('name'),
                'phone' => $request->has('phone') ? $request->input('phone') : '',
                'email' => $request->input('email'),
                'information_verifier' => !empty($request->input('information_verifier')) ? $request->input('information_verifier') : '',
                'user_id' => $insert_id,
                'status' => 0,
                'salary_id' => 6,
                'created_at' => new \DateTime()
            ]);
            $employee_slug = str_slug($request->input('name')) . '-' . $employeeId;
            $update = Employee::where('employee_id', $employeeId)->update([
                'employee_slug' => $employee_slug
            ]);
            //upload file //them su lieu thanh cong thi moi upload file
            //them vao bang cong viec
            $id_job_fb = $request->input('job_id');
            $status_job = $request->input('status_job');
//            $check_submit_job = Employee_submit_job_faacebook::where('employee_id',$employeeId)
//                ->where('status_job',$status_job)
//                ->where('id_job_fb',$id_job_fb)
//                ->count();
//            $slug_job = Job::where('job_id',$id_job_fb)->value('slug');
//            if(!empty($check_submit_job))
//            {
//                return redirect(route('apply_job',['slug'=> $slug_job]))->with('success','Nộp hồ sơ thành công');
//            }
            $submit_job_fb_id = Employee_submit_job_faacebook::insertGetId([
                'employee_id'=> $employeeId,
                'id_job_fb' => $id_job_fb,
                'status_show_cv' => 0,
                'status_apply_cv' => 1,
                'status_job' =>$status_job,//trang thai 0 là tin fb 2 la tin tuỷen
                'day_submit_job' => new \DateTime(),
                'created_at' => new \DateTime(),
            ]);
            $slug_job = Job::where('job_id',$id_job_fb)->value('slug');
            DB::commit();
            $upload_file = new Upload_FileController();
            $result = $upload_file->ajax_upload_file_cv($insert_id, $_FILES['file']);
            $link_upload_cv = $result[0];
            if (empty($link_upload_cv)) {
                return redirect(route('apply_job',['slug'=> $slug_job]))->with('error','File upload phải là pdf và dung lượng file < 10M');
            }
            if ($result[1] == 'pdf') {
                $this->PdfToHtml($result[0],$insert_id);
                $result_repalce_public = str_replace('public/', '', $result[0]);
                $string_random = Ultility::create_random_string(15,25);
                $link_pdf = '/library_employee_cv/'.$insert_id.'/cv'.$string_random.'.pdf';
                rename(public_path($result_repalce_public), public_path($link_pdf)); //doi ten file pdf de mã hoa xem
                $employee_link_html = str_replace('.pdf', '-html.html', $result[0]); //link htmk convert
                $link_upload_cv = '/public'.$link_pdf;
            }
            $insert_cv_id = Employee_upload_cv::insert([
                'employee_id' => $employeeId,
                'employee_link_cv' => $link_upload_cv,
                'employee_link_html' => $employee_link_html,
                'employee_cv_status' => 1,
                'created_at' => new \DateTime()
            ]);
            //cong điểm cho ứng viên
            $update_profile = Employee::where('user_id', $insert_id)->update([
                'profile' => 50
            ]);
            //thêm vào bảng profile
            $insert_employee_profile = Employee_profile::insert([
                'employee_id' => $employeeId,
                'profile_info' => 5,
                'profile_cv' => 40,
                'profile_course' => 5,
                'created_at' => new \DateTime()
            ]);
            //email xác thực tài khoản
            MailConfigController::send_email_apply_now_cv($id_job_fb,$request->input('email'));
            $user = User::where('id',$insert_id)->first();
            Auth::login($user);
            return redirect(route('applySucces',['job_id'=> $id_job_fb]))->with('success','Bạn đã nộp CV ứng tuyển thành công ,Bạn vui lòng xác thực tài khoản trong email để hoàn tất hồ sơ');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('apply_job',['slug'=> $slug_job]))->with('error','Không thể gửi hồ sơ ứng tuyển nhanh tài khoản. Vui lòng thử lại');
        }
    }
    private function PdfToHtml($link_pdf,$insert_id)
    {
        $public_full = public_path();
        $public_html = str_replace('public', '', $public_full);
        $public = str_replace('_html', 'public_html', $public_html);

        //        Config::setBinDirectory($public . 'vendor/bin/poppler');
        // set Poppler utils binary location
        Config::setBinDirectory($public . 'public/custom_vendor_PDF/bin/poppler');
        // set output directory
        Config::setOutputDirectory(public_path() . '/library_employee_cv/' . $insert_id);


        $pdfToHtml = new PdfToHtml($public . $link_pdf);
        $pdfToHtml->setZoomRatio(1.8);
        $pdfToHtml->exchangePdfLinks();
        $pdfToHtml->startFromPage(1)->stopAtPage(5);
        $pdfToHtml->generateSingleDocument();
        $pdfToHtml->generate();
    }
//    co camera tu chup  ảnh
    public function applyNow(Request $request, $jobId)
    {
        $job = Job::where('job_id', $jobId)->first();
        if (empty($job)){
            return redirect(route('home'));
        }
        $employee = '';
        $historyCompanies = '';
        if (Auth::check()) {
            $employee = Employee::where('employee_user_id', Auth::user()->id)
                ->whereNotNull('majors')
                ->first();
            if (!empty($employee)) {
                // $historyCompanies = HistoryWork::where('employee_id', $employee->employee_id)->get();
                // if ($historyCompanies->isEmpty()) {
                // $historyCompanies = '';
                // }

                // tạo đơn hàng
                $this->createOrder($request, $employee->employee_id, $job->job_id);

                // gửi lên chiến dịch getfly
                $this->addNewCampaignGetfly($request, $employee, $job->job_id);

                return view('site.jobs.apply_now_success', compact('job'));
            }
        }
        return view('site.jobs.apply_now', compact('job', 'employee', 'historyCompanies'));

    }

    public function updateApplyNow(Request $request)
    {
        try {

            DB::beginTransaction();
            // tạo tài khoản đăng nhập
            if (!Auth::check()) {
                $user = $this->createUser($request);
            } else {
                $user = Auth::user();
            }

            // thêm mới vào bảng ứng viên va động bộ getfly
            $employeeId = $this->updateCandidate($request, $user->id);

            // tạo đơn hàng
            $this->createOrder($request, $employeeId);


            // đăng nhập với user vừa tạo
            Auth::guard()->login($user);

            DB::commit($user);
            return view('site.jobs.apply_now_success');
        } catch (\Exception $exception) {
        } finally {
            return view('site.jobs.apply_now_success');
        }
    }

    private function createUser($request)
    {
        try {
            $userModel = new User();
            $userWithPhone = $userModel->where('phone', $request->input('phone'))
                ->orWhere('email', $request->input('email'))
                ->first();
            if (Auth::check()) {
                $userWithPhone = $userModel->where('id', Auth::user()->id)
                    ->first();
            }

            if (empty($userWithPhone)) {
                return $userModel->create([
                    'name' => $request->input('employee_name'),
                    'email' => $request->input('email'),
                    'password' => bcrypt($request->input('password')),
                    'phone' => $request->has('phone') ? $request->input('phone') : '',
                    'role' => 1,
                ]);
            }

            $userWithPhone->where('id', $userWithPhone->id)
                ->update([
                    'name' => $request->input('employee_name'),
                ]);

            if (!empty($request->input('password'))) {
                $userWithPhone->where('id', $userWithPhone->id)
                    ->update([
                        'password' => bcrypt($request->input('password')),
                    ]);
            }

            return $userWithPhone;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function updateCandidate($request, $userId)
    {
        try {
            if ($request->hasFile('fuFileAttach')) {
                $file = $request->file('fuFileAttach');
                $name = $file->getClientOriginalName();
                $file->move('CV/', $name);
            }
            $employee = '';
            if (Auth::check()) {
                $employee = Employee::where('employee_user_id', Auth::user()->id)->first();
            }

            // Nếu chưa tồn tại ứng viên thì thêm mới
            if (empty($employee)) {
                // gửi lên chiến dịch getfly
                $this->addNewCampaignGetfly($request);

                return $this->addEmployee($request, $userId);
            }


            // gửi lên chiến dịch getfly
            $this->addNewCampaignGetfly($request, $employee);

            //Nếu đã tồn tại employee
            return $this->updateEmployee($request, $employee->employee_id);;

        } catch (\Exception $e) {
            return 0;
        }
    }

    private function updateEmployee($request, $employeeId)
    {
        Employee::where('employee_id', $employeeId)
            ->update([
                'gender' => $request->input('gender'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'address' => $request->input('address'),
                'address_stay' => $request->input('address_stay'),
                'school' => $request->input('school'),
                'majors' => $request->input('majors'),
                'information_verifier' => $request->input('information_verifier'),
                'my_facebook' => $request->input('my_facebook'),
                'literacy' => $request->has('literacy') ? $request->input('literacy') : '',
                'soft_skills' => $request->has('softSkill') ? $request->input('softSkill') : '',
                'file_cv' => isset($name) ? $name : '',
                'employee_image' => $request->input('image'),
                'employee_code' => $request->input('cmt'),
                'job_id' => $request->input('jobs'),
                'tags' => $request->input('tags'),
                'status' => 0,
                'updated_at' => new \DateTime()
            ]);

        $historyCompanies = $request->input('historyCompany');
        $positions = $request->input('position');
        $descriptionCompanies = $request->input('descriptionCompany');

        HistoryWork::where('employee_id', $employeeId)->delete();

        foreach ($historyCompanies as $id => $historyCompany) {
            HistoryWork::insert([
                'company' => $historyCompany,
                'employee_id' => $employeeId,
                'position' => $positions[$id],
                'content' => $descriptionCompanies[$id],
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        }

        return $employeeId;
    }

    private function addEmployee($request, $userId)
    {
        $employeeId = Employee::insertGetId([
            'employee_name' => $request->input('employee_name'),
            'phone' => $request->input('phone'),
            'email' => $request->has('email') ? $request->input('email') : '',
            'gender' => $request->input('gender'),
            'marry' => $request->input('marry'),
            // 'birthday' => new \DateTime($request->input('birthday_Year').'-'.$request->input('birthday_Month').'-'.$request->input('birthday_day')),
            'birthday' => $request->input('birthday'),
            'province' => $request->input('province'),
            'address' => $request->input('address'),
            'address_stay' => $request->input('address_stay'),
            'school' => $request->input('school'),
            'majors' => $request->input('majors'),
            'my_facebook' => $request->input('my_facebook'),
            'literacy' => $request->has('literacy') ? $request->input('literacy') : '',
            'soft_skills' => $request->has('softSkill') ? $request->input('softSkill') : '',
            'file_cv' => isset($name) ? $name : '',
            'employee_image' => $request->input('image'),
            'employee_code' => $request->input('cmt'),
            'job_id' => $request->input('jobs'),
            'employee_user_id' => $userId,
            'tags' => $request->input('tags'),
            'status' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
        $historyCompanies = $request->input('historyCompany');
        $positions = $request->input('position');
        $descriptionCompanies = $request->input('descriptionCompany');
        foreach ($historyCompanies as $id => $historyCompany) {
            if (!empty($historyCompany)) {
                HistoryWork::insert([
                    'company' => $historyCompany,
                    'employee_id' => $employeeId,
                    'position' => $positions[$id],
                    'content' => $descriptionCompanies[$id],
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
            }
        }
        return $employeeId;
    }

    private function addNewCampaignGetfly($request, $employee = null, $jobId = null)
    {
        try {
            $job = Job::where('job_id', !empty($jobId) ? $jobId : $request->input('jobs'))->first();
            if (empty($job->campain_status) || empty($job->campain_candidate)) {
                return false;
            }

            $account = (object)[
                "account_name" => isset($employee->employee_name) ? $employee->employee_name : $request->input('employee_name'),
                "phone_office" => isset($employee->phone) ? $employee->phone : $request->input('phone'),
                "email" => isset($employee->email) ? $employee->email : $request->input('email'),
                "gender" => isset($employee->gender) ? $employee->gender : $request->input('gender'),
                "billing_address_street" => isset($employee->address) ? $employee->address : $request->input('address'),
                // "birthday" => $request->input('birthday_day').'/'.$request->input('birthday_Month').'/'.$request->input('birthday_Year'),
                "account_type" => 1,
                "industry" => "2,3"
            ];

            $opportunity = (object)[
                'token_api' => $job->campain_candidate,
                'user_id' => "",
                'recipient' => $job->user_id_candidate,
                'opportunity_status' => $job->campain_status,

            ];
            $contacts = [
                "first_name" => isset($employee->employee_name) ? $employee->employee_name : $request->input('employee_name'),
                "email" => isset($employee->email) ? $employee->email : $request->input('email'),
                "phone_mobile" => isset($employee->phone) ? $employee->phone : $request->input('phone')
            ];
            $referer = (object)[
                "utm_source" => "https://tiva.vn/cong-viec/" . $job->slug,
                "utm_campaign" => $job->title,
            ];

            $data = (object)[
                'account' => $account,
                'contacts' => $contacts,
                'opportunity' => $opportunity,
                'referer' => $referer
            ];
            // đồng bộ lên getfly.
            $callApi = new CallApi();
            $callApi->addNewCampaign($data);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    private function createOrder($request, $employeeId, $jobId = null)
    {
        $job = Job::where('job_id', !empty($jobId) ? $jobId : $request->input('jobs'))->first();

        $orderId = Order::insertGetId([
            'employer_id' => $job->employer_id,
            'employee_id' => $employeeId,
            'user_id' => 1,
            'date_order' => $request->has('date_order') ? $request->input('date_order') : new \DateTime(),
            'job_id' => !empty($jobId) ? $jobId : $request->input('jobs'),
            'status' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
    }

    public function increaseView(Request $request)
    {
        $job = Job::where('job_id', $request->input('job_id'))->first();
        if (!empty($job)) {
            $views = $job->views + 1;
            $job->update([
                'views' => $views
            ]);
        }
    }

    public function ajaxProvince($province)
    {
        if ($province == 0) {
            echo '<option> -- Tất cả các quận/huyện --</option>';
        }
        $districts = District::where('province_id', $province)->get();

        foreach ($districts as $district) {
            echo '<option value=" ' . $district->district_id . '">' . $district->district_name . '</option>';
        }
    }

}
