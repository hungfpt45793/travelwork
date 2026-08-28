<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Career;
use App\Entity\Coin_apply_employee;
use App\Entity\Coin_history_employer;
use App\Entity\Coin_show_employee;
use App\Entity\Cv_employee;
use App\Entity\Cv_note_template;
use App\Entity\Cv_template;
use App\Entity\Employee;
use App\Entity\Employee_curriculum;
use App\Entity\Employee_upload_cv;
use App\Entity\Employer;
use App\Entity\HistoryWork;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;

use App\Entity\Job_desired;
use App\Entity\Province;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_job_group;

use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\JobGroup;
use App\Entity\Order;
use App\Entity\SettingGetfly;
use App\Entity\Teacher_specialize;
use App\Entity\User;
use App\Entity\District;
use App\Entity\Workplace;
use App\Ultility\CallApi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prophecy\Call\Call;

class jobFaceController extends SiteController
{
    public function index(Request $request)
    {
//        vip1
        $user = auth()->user();
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job'
            );
        $list_jobs = $list_jobs->publiclyVisible();
        $list_jobs = $list_jobs->where('jobs.vip','=', 1);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        //tong so bai viet
        $total_jobs = $list_jobs->count();
        $list_jobs = $list_jobs->paginate(18, ['*'], 'page_1s');
//        luu url khi phan trang
        $list_jobs->appends(request()->query());
        //vip 2
        $list_jobs2 = $jobModel
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job'
            );
        $list_jobs2 = $list_jobs2->publiclyVisible();
        $list_jobs2 = $list_jobs2->where('jobs.vip','!=', 1);
        $list_jobs2 = $list_jobs2->orderBy('jobs.vip', 'desc');
        $list_jobs2 = $list_jobs2->orderBy('jobs.updated_at', 'desc');
        //tong so bai viet
        $total_jobs2 = $list_jobs2->count();
        $list_jobs2 = $list_jobs2->paginate(18, ['*'], 'page_3s');
//        luu url khi phan trang
        $list_jobs2->appends(request()->query());


        $jobFb_model = new JobFacebook();
        $list_job_fb = $jobFb_model->select(
            'job_facebook.date_end',
            'job_facebook.vip',
            'job_facebook.updated_at',
            'job_facebook.title',
            'job_facebook.slug',
            'job_facebook.salary_id',
            'job_facebook.date_end',
            'job_facebook.district',
            'job_facebook.province',
            'job_facebook.company_name',
            'salary.description as salary_description',
            'salary.salary_id'
        );
        $list_job_fb = $list_job_fb->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
//        $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
//        sắp xếp theo lương
        $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
        $list_job_fb = $list_job_fb->orderBy('job_facebook.updated_at', 'desc');
        $list_job_fb = $list_job_fb->paginate(18, ['*'], 'page_2s');
        $list_job_fb->appends(request()->query());
        return view('site.job_facebook_site.category_job_fb', compact('list_jobs','list_jobs2', 'list_job_fb', 'user'));
    }

//    public function submit_search_jobfb(Request $request)
//    {
//        $user = auth()->user();
//        $career = 'tuyen-ke-toan';
//        if (!empty($request->input('career_category_id'))) {
//            $career = 'tuyen-' . $request->input('career_category_id');
//        }
//        $career .= '';
//        if (!empty($request->input('province'))) {
//            $career .= '-tai-' . $request->input('province');
//        }
//        $career_caetgory = Career::select('*')->where('career_category_slug', $request->input('career_category_id'))->first();
//        $provice = Province::select('*')->where('province_slug', $request->input('province'))->first();
//        $district = District::select('*')->where('district_slug', $request->input('district'))->first();
//
//        $career .= '?';
//        if (!empty($request->input('career_category_id'))) {
//            $career .= 'career_category_id[]=' . $career_caetgory['career_category_id'];
//        }
//        if (!empty($request->input('province'))) {
//            $career .= '&province=' . $provice['province_slug'];
//        }
//        if (!empty($request->input('word'))) {
//            $career .= '&w=' . $request->input('word');
//        }
//        return redirect(route('seacrh_job_facebook', ['slug' => $career]));
//    }
//
//    //tìm kiếm
//    public function seacrh_job_facebook(Request $request, $slug)
//    {
////        echo $slug;die();
//        $user = Auth()->user();
//        $jobfaceModule = new JobFacebook();
////        sắp xếp theo tin mới nhất
//        $list_job_fb = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
//        $list_job_fb = $list_job_fb->select(
//            'job_facebook.slug',
//            'job_facebook.district',
//            'job_facebook.province',
//            'job_facebook.title',
//            'job_facebook.company_name',
//            'job_facebook.career_category_id',
//            'job_facebook.updated_at',
//            'salary.description as salary_description'
//        );
//        if (!empty($request->input('province'))) {
//            $province_id = Province::where('province_slug', $request->input('province'))->value('province_id');
//            $list_job_fb = $list_job_fb->where('job_facebook.province', $province_id);
//        }
//        if (!empty($request->input('district_id'))) {
//            $district_id_array  = $request->input('district_id');
//            $list_job_fb = $list_job_fb->whereIn('job_facebook.district', $district_id_array);
//        }
//        if (!empty($request->input('career_category_id'))) {
//            $career_category_id_array  = $request->input('career_category_id');
//            $list_job_fb = $list_job_fb->whereIn('job_facebook.career_category_id', $career_category_id_array);
//        }
//        if (!empty($request->input('array_salary'))) {
//            $array_salary  = $request->input('array_salary');
//            $list_job_fb = $list_job_fb->whereIn('job_facebook.salary_id', $array_salary);
//        }
//        if ($request->input('date_create')) {
////            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));
//            $list_job_fb = $list_job_fb->whereDate('job_facebook.updated_at', '>=', $request->input('date_create'));
//            $list_job_fb = $list_job_fb->whereDate('job_facebook.updated_at', '<=', date('Y-m-d'));
//        }
//
//        $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
////        sắp xếp theo lương
//        $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
//        $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
//        $list_job_fb = $list_job_fb->orderBy('job_facebook.job_facebook_id', 'desc');
//        $total_job_fb = $list_job_fb->count();
//        $list_job_fb = $list_job_fb->paginate(10);
//        $list_job_fb->appends(request()->query());
//
//
//        $jobModel = new Job();
//
//
//        $list_jobs = $jobModel
//            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
//            ->select(
//                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.career_category_id', 'jobs.vip', 'jobs.updated_at', 'jobs.province', 'jobs.district', 'jobs.salary_id', 'jobs.active_job',
//                'salary.description as salary_description', 'jobs.deadline_submit_profile'
//            );
//        if (!empty($request->input('province'))) {
//            $province_id = Province::where('province_slug', $request->input('province'))->value('province_id');
//            $list_jobs = $list_jobs->where('jobs.province', $province_id);
//        }
//        if (!empty($request->input('district_id'))) {
//            $district_id_array  = $request->input('district_id');
//            $list_jobs = $list_jobs->whereIn('jobs.district', $district_id_array);
//        }
//        if (!empty($request->input('career_category_id'))) {
//            $career_category_id_array  = $request->input('career_category_id');
//            $list_jobs = $list_jobs->whereIn('jobs.career_category_id', $career_category_id_array);
//        }
//        if (!empty($request->input('array_salary'))) {
//            $array_salary  = $request->input('array_salary');
//            $list_jobs = $list_jobs->whereIn('jobs.salary_id', $array_salary);
//        }
//        if (!empty($request->input('date_create'))) {
////            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));
//            $list_jobs = $list_jobs->whereDate('jobs.updated_at', '>=', $request->input('date_create'));
//            $list_jobs = $list_jobs->whereDate('jobs.updated_at', '<=', date('Y-m-d'));
//        }
//        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
//        $list_jobs = $list_jobs->where('jobs.active_job', 1);
//        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
//        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
//        //tong so bai viet
//        $total_jobs = $list_jobs->count();
//        $list_jobs = $list_jobs->paginate(10);
////        luu url khi phan trang
//        $list_jobs->appends(request()->query());
//
////        lưu vào việc làm mong muốn với tài khoản user
//        if (!empty($request->input('save_fillter_job')) && Auth::check() && Auth::user()->role == 1) {
//            $this->save_fillter_job($request);
//        }
//        return view('site.job_facebook_site.search_job_facebook', compact('list_job_fb', 'list_jobs', 'total_jobs', 'total_job_fb'));
//    }

    public function submit_search_jobfb(Request $request)
    {
        $user = auth()->user();
        $career = 'tuyen-ke-toan';
        if (!empty($request->input('career'))) {
            $career = 'tuyen-' . $request->input('career');
        }
        $career .= '';
        if (!empty($request->input('province'))) {
            $career .= '-tai-' . $request->input('province');
        }
        $career_caetgory = Career::select('*')->where('career_category_slug', $request->input('career'))->first();
        $provice = Province::select('*')->where('province_slug', $request->input('province'))->first();
        $district = District::select('*')->where('district_slug', $request->input('district'))->first();

        $career .= '?';
        if (!empty($request->input('career'))) {
            $career .= 'c=' . $career_caetgory['career_category_id'];
        }
        if (!empty($request->input('province'))) {
            $career .= '&p=' . $provice['province_id'];
        }
        if (!empty($request->input('district'))) {
            $career .= '&q=' . $district['district_id'];
        }
        if (!empty($request->input('salary'))) {
            $career .= '&l=' . $request->input('salary');
        }
        if ($request->has('vip')) {
            $career .= '&v=' . $request->input('vip');
        }
        if (!empty($request->input('word'))) {
            $career .= '&w=' . $request->input('word');
        }
        return redirect(route('seacrh_job_facebook', ['slug' => $career]));
    }

    public function seacrh_job_facebook(Request $request, $slug)
    {
//        echo $slug;die();
        $user = Auth()->user();
        $word = trim((string) $request->input('word', $request->input('w', '')));
        $vip = $request->input('vip', $request->input('v'));

        if ($request->boolean('search_by_title') && $word === '') {
            return redirect()->back()->with(
                'job_search_error',
                'Vui lòng nhập việc theo tên'
            );
        }

        $jobfaceModule = new JobFacebook();
//        sắp xếp theo tin mới nhất
        $list_job_fb = $jobfaceModule->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
        if (!empty($request->input('c'))) {
            $list_job_fb = $list_job_fb->where('job_facebook.career_category_id', $request->input('c'));
        }
        if (!empty($request->input('p'))) {
            $list_job_fb = $list_job_fb->where('job_facebook.province', $request->input('p'));
        }
        if (!empty($request->input('district_id'))) {
            $list_job_fb = $list_job_fb->whereIn('job_facebook.district', $request->input('district_id'));
        }
        if (!empty($request->input('array_salary'))) {
//            print_r($request->input('array_salary')) ;die();
            $list_job_fb = $list_job_fb->whereIn('job_facebook.salary_id', $request->input('array_salary'));
        }
        if ($word !== '') {
            $list_job_fb = $list_job_fb->where('job_facebook.title', 'like', '%' . $word . '%');
        }
        if ($vip !== null && $vip !== '') {
            $list_job_fb = $list_job_fb->where('job_facebook.vip', $vip);
        }

        $list_job_fb = $list_job_fb->select(
            'job_facebook.slug',
            'job_facebook.district',
            'job_facebook.province',
            'job_facebook.title',
            'job_facebook.company_name',
            'job_facebook.date_end',
            'job_facebook.updated_at',
            'salary.description as salary_description'
        );
        if ($request->input('date_create')) {
//            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));
            $list_job_fb = $list_job_fb->whereDate('job_facebook.updated_at', '>=', $request->input('date_create'));
            $list_job_fb = $list_job_fb->whereDate('job_facebook.updated_at', '<=', date('Y-m-d'));
        }
        $list_job_fb = $list_job_fb->where('warning_job_fb', '<', 4);
//        sắp xếp theo lương
        $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));
        $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
        $list_job_fb = $list_job_fb->orderBy('job_facebook.job_facebook_id', 'desc');
        $total_job_fb = $list_job_fb->count();
        $list_job_fb = $list_job_fb->paginate(12);
        $list_job_fb->appends(request()->query());


        $jobModel = new Job();


        $list_jobs = $jobModel
            ->join('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.career_category_id', 'jobs.vip', 'jobs.updated_at', 'jobs.province', 'jobs.district', 'jobs.salary_id', 'jobs.active_job',
                'salary.description as salary_description', 'jobs.deadline_submit_profile'
            );
        if (!empty($request->input('c'))) {
            $list_jobs = $list_jobs->where('jobs.career_category_id', $request->input('c'));
        }
        if (!empty($request->input('p'))) {
            $list_jobs = $list_jobs->where('jobs.province', $request->input('p'));
        }
        if (!empty($request->input('district_id'))) {
            $list_jobs = $list_jobs->whereIn('jobs.district', $request->input('district_id'));
        }
        if (!empty($request->input('array_salary'))) {
//            print_r($request->input('array_salary')) ;die();
            $list_jobs = $list_jobs->whereIn('jobs.salary_id', $request->input('array_salary'));
        }
        if ($word !== '') {
            $list_jobs = $list_jobs->where('jobs.title', 'like', '%' . $word . '%');
        }
        if ($vip !== null && $vip !== '') {
            $list_jobs = $list_jobs->where('jobs.vip', $vip);
        }
        if (!empty($request->input('date_create'))) {
//            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));
            $list_jobs = $list_jobs->whereDate('jobs.updated_at', '>=', $request->input('date_create'));
            $list_jobs = $list_jobs->whereDate('jobs.updated_at', '<=', date('Y-m-d'));
        }
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        //tong so bai viet
        $total_jobs = $list_jobs->count();
        $list_jobs = $list_jobs->paginate(12);
//        luu url khi phan trang
        $list_jobs->appends(request()->query());

//        lưu vào việc làm mong muốn với tài khoản user
        if (!empty($request->input('save_fillter_job')) && Auth::check() && Auth::user()->role == 1) {
            $this->save_fillter_job($request);
        }
        return view('site.job_facebook_site.search_job_facebook', compact('list_job_fb', 'list_jobs', 'total_jobs', 'total_job_fb'));
    }



    public function save_fillter_job($request)
    {
        $job_desired_model = new Job_desired();
        $user_id = Auth::user()->id;
        $employee = Employee::select('user_id', 'employee_id')->where('user_id', $user_id)->first();
        $district = 0;
        $province = 0;
        $array_career = '';
        $array_salary = '';
        $date_create = new \DateTime();
        if (!empty($request->input('q'))) {
            $district = $request->input('q');
        }
        if (!empty($request->input('p'))) {
            $province = $request->input('p');
        }
        if (!empty($request->input('array_career'))) {
            $array_career_input = $request->input('array_career');
//            print_r($array_career_input);die();
            $array_career = implode(',', $array_career_input);
        }
        if (!empty($request->input('array_salary'))) {
            $array_salary_input = $request->input('array_salary');
            $array_salary = implode(',', $array_salary_input);
        }
        if (!empty($request->input('date_create'))) {
            $date_create = $request->input('date_create');
        }
        $job_desired = $job_desired_model->select('employee_id')
            ->where('employee_id', $employee->employee_id)
            ->first();
        if (!empty($job_desired)) {
            $update = $job_desired_model->where('employee_id', $employee->employee_id)->update([
                'province_id' => $province,
                'district_id' => $district,
                'salary_id' => $array_salary,
                'career_category_id' => $array_career,
                'date_create' => $date_create,
                'updated_at' => new \DateTime(),
            ]);
        } else {
            $insert = $job_desired_model->insert([
                'employee_id' => $employee->employee_id,
                'province_id' => $province,
                'district_id' => $district,
                'salary_id' => $array_salary,
                'career_category_id' => $array_career,
                'date_create' => $date_create,
                'created_at' => new \DateTime(),
            ]);
        }
        return true;
    }

    public function detailJobFace($slug)
    {

        $user = Auth()->user();
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
            ->where('job_facebook.slug', $slug)
            ->first();
        if (empty($jobFacebook)) {
            return redirect(route('list_job_face'))->with('mesage_modal','Tin tuyển dụng này không tồn tại hoặc đã hết hạn tuyển dụng');
        }
        $view = $jobFacebook->view + 1;
        $view_jobFacebook = JobFacebook::select('*')->where('job_facebook.slug', $slug)->update([
            'view' => $view
        ]);
        Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
        //lay giờ theo giống facebook
        $date = date_create($jobFacebook->created_at);
        $date_fb = Carbon::create((date_format($date, "Y")), (date_format($date, "m")), (date_format($date, "d")), (date_format($date, "H")), (date_format($date, "i")), (date_format($date, "s")));
        $now = Carbon::now();

        $date_facebook = $date_fb->diffForHumans($now); //1 giờ trước
        $jobFacebookRelatives = JobFacebook::leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id')
            ->leftJoin('province', 'province.province_id', 'job_facebook.province')
            ->leftJoin('district', 'district.district_id', 'job_facebook.district')
            ->select('job_facebook.*',
                'salary.description as salary_description',
                'district_name',
                'province_name',
                'postalcode')
            ->whereDate('job_facebook.date_end', '>=', date('Y-m-d'))
            ->where('job_facebook.province', $jobFacebook->province)
            ->where('job_facebook.slug', '!=', $slug)
            ->orWhere('job_facebook.career_category_id', $jobFacebook->career_category_id)
//            ->orderBy('job_facebook.province','desc')
            ->orderBy('job_facebook.job_facebook_id', 'desc')
//            ->groupBy('job_facebook.province','job_facebook.career_category_id')
            ->paginate(12);

//        echo '<pre>';
//        print_r($jobFacebook);die();

        return view('site.job_facebook_site.detail_job_face', compact('jobFacebook', 'jobFacebookRelatives', 'user', 'date_facebook'));
    }

    public function ajaxProvince($province)
    {
        if ($province == 0) {
            echo '<option value="0">  Tất cả các quận/huyện </option>';
        }
        $districts = District::where('province_id', '=', $province)->get();
        foreach ($districts as $id => $district) {
            if ($id == 0) {
                echo '<option value="0"> Tất cả các quận/huyện</option>';
            }
            echo '<option value=" ' . $district->district_id . '">' . $district->district_name . '</option>';
        }
    }

    public function ajaxSlugProvince($province_slug)
    {
        $province_model = new Province();
        $province = $province_model::select('*')
            ->where('province_slug', $province_slug)
            ->first();
        $districts = District::where('province_id', '=', $province->province_id)->get();
        foreach ($districts as $id => $district) {
            if ($id == 0) {
                echo '<option value="0"> Tất cả các quận/huyện</option>';
            }
            echo '<option value="' . $district->district_slug . '">' . $district->district_name . '</option>';
        }
    }

    public function show_emplooyee($employee_id)
    {
        if (Auth::check() && Auth::user()->role == 2) {
            $employer_m = new Employer();
            $user = Auth::user();
            $check_employer = $employer_m->select('*')
                ->where('user_id', $user->id)
                ->first();
            return redirect(route('show_contact_detail_employee', ['employee_id' => $employee_id]));
        }


        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        if (empty($employee)) {
            return redirect(route('home'))->with('error_employee', 'Không tồn tại ứng viên này !');
        }
        $views = $employee->views + 1;
        $update_view_employee = Employee::where('employee_id', $employee_id)->update([
            'views' => $views
        ]);

        //trinh do chuyen mon
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $employee_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm làm việc
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $employee_id)->orderBy('experience_id', 'asc')->get();

        $relate_employee = $employees->select('employees.employee_id', 'employees.employee_name', 'employees.province', 'employees.district', 'employees.phone', 'employees.employee_level_id', 'employees.experience_id', 'employees.employee_image', 'employees.profile', 'employees.updated_at as date_update', 'employees.created_at as date_create', 'employees.salary_id', 'employees.career_category_id', 'employees.email', 'statistical_employees.*')
            ->leftJoin('statistical_employees', 'statistical_employees.employees_id', '=', 'employees.employee_id')
            ->where('employees.career_category_id', $employee->career_category_id)
            ->where('employees.employee_id', '!=', $employee->employee_id)
            ->limit(15)
            ->orderBy('statistical_employees.money', 'desc')
            ->orderBy('statistical_employees.total_teacher', 'desc')
            ->orderBy('statistical_employees.total_exam', 'desc')
            ->orderBy('statistical_employees.total__dowload_voucher', 'desc')
            ->orderBy('statistical_employees.total_view_voucher', 'desc')
            ->orderBy('statistical_employees.total_view_job', 'desc')
            ->orderBy('statistical_employees.total_cv', 'desc')
            ->orderBy('statistical_employees.id_statistical', 'asc')
            ->orderBy('employees.employee_id', 'desc')->get();
//        print_r($employee);die();

        if (!empty($employee)) {
            return view('site.job_facebook.show_employee', compact('user', 'employee', 'specialize', 'experience', 'relate_employee'));
        } else {
            return redirect()->back();
        }
    }

    //thông tin ứng viên
    public function show_detail_emplooyee($employee_id)
    {
        try {
            $employees = new Employee();
            $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
            $views = $employee->views + 1;
            $update_view_employee = Employee::where('employee_id', $employee_id)->update([
                'views' => $views
            ]);
            $employer = '';
            if (Auth::check() && Auth::user()->role == 2) {
                $employer = $this->check_user_role();
            }
            $relate_employee = $employees->select('employees.employee_id',
                'employees.employee_name',
                'employees.employee_image',
                'employees.updated_at as date_update',
                'employees.created_at as date_create',
                'employees.status',
                'employees.profile',
                'career_categories.career_category_name',
                'salary.description',
                'province.province_name',
                'district.district_name')
                ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id')
                ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
                ->leftJoin('province', 'province.province_id', '=', 'employees.province')
                ->leftJoin('district', 'district.district_id', '=', 'employees.district')
                ->where('employees.province', $employee->province)
                ->where('employees.employee_id', '!=', $employee->employee_id)
                ->limit(15)
                ->orderBy('employees.profile', 'desc')
                ->orderBy('employees.employee_id', 'desc')
                ->get();
            return view('site.job_facebook.show_detail_employee', compact('user', 'employee', 'employer', 'relate_employee'));
        } catch (\Exception $ex) {
//            return redirect(route('show_employee'));
            return redirect()->back()->with('error_employee', 'Không tồn tại ứng viên này !');
        }
    }
    //tam thoi k dung den function nay
    public function show_cv_detail_employee($employee_id)
    {
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        $views = $employee->views + 1;
        $update_view_employee = Employee::where('employee_id', $employee_id)->update([
            'views' => $views
        ]);
        $employer = '';
        if (Auth::check() && Auth::user()->role == 2) {
            $employer = $this->check_user_role();
        }
        $relate_employee = $employees->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_image',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.status',
            'employees.profile',
            'career_categories.career_category_name',
            'salary.description',
            'province.province_name',
            'district.district_name')
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('district', 'district.district_id', '=', 'employees.district')
            ->where('employees.province', $employee->province)
            ->where('employees.employee_id', '!=', $employee->employee_id)
            ->limit(15)
            ->orderBy('employees.profile', 'desc')
            ->orderBy('employees.employee_id', 'desc')
            ->get();
        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();
        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();

        return view('site.job_facebook.show_cv_detail_employee', compact('employee', 'employer', 'cv_template', 'cv_note_template', 'cv_employee', 'employee_id'));


//        try {
//            if (Auth::check()) {
//                $user = Auth::user();
//                $employees = new Employee();
//                $check_employee = $employees->select('*')
//                    ->where('employee_id', $employee_id)
//                    ->first();
//
//                if (!empty($check_employee) or $user->role == 2) {
//                    $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
//                    if (!empty($employee)) {
//                        $views = $employee->views + 1;
//                        $update_view_employee = Employee::where('employee_id', $employee_id)->update([
//                            'views' => $views
//                        ]);
//                        //trường hợp mà ứng viên đã xem thi vào luôn trang chi tiết ứng viên
//                        $employer = $this->check_user_role();
//                        $check_employer_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
//
//                        $cv_template = Cv_template::select('*')->first();
//                        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id',$cv_template->cv_template_id)->first();
//                        $check_employee = Cv_employee::select('*')->where('employee_id',$employee->employee_id)->count();
//                        $cv_employee = Cv_employee::select('*')->where('employee_id',$employee->employee_id)->first();
//                        return view('site.job_facebook.show_cv_detail_employee',compact('employee','employer','cv_template','cv_note_template','cv_employee','experience','specialize','employee_id','check_employer_show_employee'));
//
//                    } else {
//                        return redirect()->back()->with('error_employee_show', 'Ứng viên này không tồn tại !');
//                    }
//                } else {
//                    return redirect()->back()->with('error_employee', 'Bạn phải đăng nhập tài khoản nhà tuyển dụng mới xem được thông tin ứng viên');
//                }
//            } else {
//                return redirect()->back()->with('error_employee', 'Bạn phải đăng nhập tài khoản nhà tuyển dụng mới xem được thông tin ứng viên');
//            }
//        } catch (\Exception $ex) {
////            return redirect(route('show_employee'));
//            return redirect()->back();
//        }
    }

    public function show_cv_detail_employee_no_login($employee_id)
    {
        if (Auth::check() && Auth::user()->role == 2) {
            $employer_m = new Employer();
            $user = Auth::user();
            $check_employer = $employer_m->select('*')
                ->where('user_id', $user->id)
                ->first();
            return redirect(route('show_cv_detail_employee', ['employee_id' => $employee_id]));
        }
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        if (!empty($employee)) {
            $views = $employee->views + 1;
            $update_view_employee = Employee::where('employee_id', $employee_id)->update([
                'views' => $views
            ]);
            //trường hợp mà ứng viên đã xem thi vào luôn trang chi tiết ứng viên


            $cv_template = Cv_template::select('*')->first();
            $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();
            $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
            $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
            return view('site.job_facebook.show_cv_detail_employee_no_login', compact('employee', 'employer', 'cv_template', 'cv_note_template', 'cv_employee', 'experience', 'specialize', 'employee_id', 'check_employer_show_employee'));

        } else {
            return redirect()->back()->with('error_employee_show', 'Ứng viên này không tồn tại !');
        }


    }


    public function show_syll_detail_employee($employee_id)
    {
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        $views = $employee->views + 1;
        $update_view_employee = Employee::where('employee_id', $employee_id)->update([
            'views' => $views
        ]);
        $employer = '';
        if (Auth::check() && Auth::user()->role == 2) {
            $employer = $this->check_user_role();
        }
        $relate_employee = $employees->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_image',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.status',
            'employees.profile',
            'career_categories.career_category_name',
            'salary.description',
            'province.province_name',
            'district.district_name')
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('district', 'district.district_id', '=', 'employees.district')
            ->where('employees.province', $employee->province)
            ->where('employees.employee_id', '!=', $employee->employee_id)
            ->limit(15)
            ->orderBy('employees.profile', 'desc')
            ->orderBy('employees.employee_id', 'desc')
            ->get();

        $employee_curriculum = '';
        $employee_curriculum = Employee_curriculum::select('employee_curriculum.*', 'employee_curriculum_extend.*')
            ->leftJoin('employee_curriculum_extend', 'employee_curriculum_extend.employee_id', 'employee_curriculum.employee_id')
            ->where('employee_curriculum.employee_id', $employee->employee_id)
            ->first();
//                        echo '<pre>';
//                        print_r($employee_curriculum);die();

        return view('site.job_facebook.show_syll_detail_employee', compact('employee', 'employer', 'employee_curriculum', 'employee_id'));


    }

    public function show_syll_detail_employee_no_login($employee_id)
    {


        if (Auth::check() && Auth::user()->role == 2) {
            $employer_m = new Employer();
            $user = Auth::user();
            $check_employer = $employer_m->select('*')
                ->where('user_id', $user->id)
                ->first();
            return redirect(route('show_syll_detail_employee', ['employee_id' => $employee_id]));
        }

        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();


        if ($employee->show_hidden_syll == 1) {
            return redirect()->back()->with('error_employee_show', 'Ứng viên này không chia sẻ sơ yếu lý lịch');
        }

        if (!empty($employee)) {
            $views = $employee->views + 1;
            $update_view_employee = Employee::where('employee_id', $employee_id)->update([
                'views' => $views
            ]);
            //trường hợp mà ứng viên đã xem thi vào luôn trang chi tiết ứng viên

            $employee_curriculum = '';
            $employee_curriculum = Employee_curriculum::select('employee_curriculum.*', 'employee_curriculum_extend.*')
                ->leftJoin('employee_curriculum_extend', 'employee_curriculum_extend.employee_id', 'employee_curriculum.employee_id')
                ->where('employee_curriculum.employee_id', $employee->employee_id)
                ->first();
//                        echo '<pre>';
//                        print_r($employee_curriculum);die();

            return view('site.job_facebook.show_syll_detail_employee_no_login', compact('employee', 'employer', 'employee_curriculum', 'employee_id', 'check_employer_show_employee'));

        } else {
            return redirect()->back()->with('error_employee_show', 'Ứng viên này không tồn tại !');
        }


    }


    public function show_emplooyee_intership($employee_id)
    {
        $user = Auth::user();
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        $views = $employee->views + 1;
        $update_view_employee = Employee::where('employee_id', $employee_id)->update([
            'views' => $views
        ]);
        //trinh do chuyen mon
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $employee_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm làm việc
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $employee_id)->orderBy('experience_id', 'asc')->get();

        $relate_employee = $employees->select('employees.employee_id', 'employees.employee_name', 'employees.province', 'employees.district', 'employees.phone', 'employees.employee_level_id', 'employees.experience_id', 'employees.employee_image', 'employees.profile', 'employees.updated_at as date_update', 'employees.created_at as date_create', 'employees.salary_id', 'employees.career_category_id', 'employees.email', 'statistical_employees.*')
            ->leftJoin('statistical_employees', 'statistical_employees.employees_id', '=', 'employees.employee_id')
            ->where('employees.career_category_id', $employee->career_category_id)
            ->where('employees.employee_id', '!=', $employee->employee_id)
            ->limit(15)
            ->orderBy('statistical_employees.money', 'desc')
            ->orderBy('statistical_employees.total_teacher', 'desc')
            ->orderBy('statistical_employees.total_exam', 'desc')
            ->orderBy('statistical_employees.total__dowload_voucher', 'desc')
            ->orderBy('statistical_employees.total_view_voucher', 'desc')
            ->orderBy('statistical_employees.total_view_job', 'desc')
            ->orderBy('statistical_employees.total_cv', 'desc')
            ->orderBy('statistical_employees.id_statistical', 'asc')
            ->orderBy('employees.employee_id', 'desc')->get();
//        print_r($employee);die();

        if (!empty($employee)) {
            return view('site.job_facebook.show_employee_intership', compact('user', 'employee', 'specialize', 'experience', 'relate_employee'));
        } else {
            return redirect()->back();
        }
    }

    public function show_teacher($teacher_id)
    {
        $user = Auth::user();
        $teachers = new Teacher();
        $teacher = $teachers->select('*')->where('teacher_id', $teacher_id)->first();
        //trinh do chuyen mon
        $specialize = new Teacher_specialize();
        $specialize = $specialize->select('*')->where('teacher_id', $teacher_id)->orderBy('specialize_id', 'asc')->get();
//            Kinh nghiệm làm việc

        $experience = new Teacher_experience();
        $experience = $experience->select('*')->where('teacher_id', $teacher_id)->orderBy('experience_id', 'asc')->get();
        if (!empty($teacher)) {
            return view('site.job_facebook.show_teacher', compact('user', 'teacher', 'specialize', 'experience'));
        } else {
            return redirect()->back();
        }
    }

    public function show_contact_detail_employee($employee_id)
    {
        // try {

        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();

        $views = $employee->views + 1;
        $update_view_employee = Employee::where('employee_id', $employee_id)->update([
            'views' => $views
        ]);
        $caree = \App\Entity\Career::getIdCareer($employee->career_category_id);
        $employer = $this->check_user_role();

        //trường hợp mà nhà tuyển dụng đã xem ứng viên này rồi
        $coin_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        //danh sach ứng viên đã xem
        $relate_employee = Coin_show_employee::select('coin_show_employee.employee_id',
            'employees.employee_id',
            'employees.employee_name',
            'employees.employee_image',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.status',
            'employees.profile',
            'career_categories.career_category_name',
            'salary.description',
            'province.province_name',
            'district.district_name')
            ->leftJoin('employees', 'employees.employee_id', 'coin_show_employee.employee_id')
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('district', 'district.district_id', '=', 'employees.district')
            ->limit(15)
            ->get();
        if (!empty($coin_show_employee)) {
            return view('site.job_facebook.show_contact_detail_employee', compact('user', 'employee', 'employer', 'relate_employee'));
        }
        //check trường hopnj ntd hết xu
        $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
        $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
        if (empty($employer->total_employer_coin) && $coin_surplus < $caree->view_profile) {
            return redirect()->back()->with('error', 'Số điểm miễn phí của bạn không đủ để xem thông tin liên hệ của ứng viên này');
        }
        if (!empty($employer->total_employer_coin) && $employer->employer_coin < $caree->view_profile) {
            return redirect()->back()->with('error', 'Số điểm còn lại không đủ để xem thông tin liên hệ của ứng viên này');
        }
        //tiến hành trừ điểm
        DB::beginTransaction();
        if (!empty($employer->total_employer_coin)) {
            //trường họp trừ xu của ntd
            $coin_history_status = 1;
            $employer_coin = $employer->employer_coin - $caree->view_profile;
            $update_coin = Employer::where('employer_id', $employer->employer_id)->update([
                'employer_coin' => $employer_coin
            ]);
        } else {
            //trường hợp xu miễn phí
            $coin_history_status = 0;
        }
        //trừ xu
        $insert_get_id = Coin_history_employer::insertGetId([
            'coin_history_title' => 'Xem thông tin liên lạc ứng viên',
            'coin' => $caree->view_profile,
            'coin_history_status' => $coin_history_status,
            'coin_employee_status' => 0,
            'employer_id' => $employer->employer_id,
            'created_at' => new \DateTime()
        ]);
        $inser_coin_show_employee = Coin_show_employee::insertGetId([
            'coin_history_id' => $insert_get_id,
            'employer_id' => $employer->employer_id,
            'employee_id' => $employee_id,
            'created_at' => new \DateTime()
        ]);
        DB::commit();
        return view('site.job_facebook.show_contact_detail_employee', compact('user', 'employer', 'employee', 'relate_employee'));
        // } catch (\Exception $ex) {
        //     DB::rollBack();
        //     return redirect()->back()->with('error', 'Có lỗi xảy ra ! vui lòng thử lại');
        // }
    }

    public function check_coint_free($coin, $coin_free)
    {
        //check nha tuyen dung
        $employer = $this->check_user_role();
        //kiểm tra số xu dùng miễn phí hằng ngày
        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
        if ($coin_surplus > $coin) {
            return true;
        }
        return false;
    }

    public function check_coint_employer($coin)
    {
        //check nha tuyen dung
        $employer = $this->check_user_role();
        //kiểm tra số xu dùng miễn phí hằng ngày
        if (!empty($employer->total_employer_coin) && $employer->total_employer_coin > $coin) {
            return true;
        }
        return false;
    }

    public function check_user_role()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            $user_id = Auth::user()->id;
            $employer = Employer::select('employer_id',
                'enterprise_name',
                'phone',
                'email',
                'employer_coin',
                'total_employer_coin',
                'total_money_coin',
                'user_id')->where('user_id', $user_id)->first();
            return $employer;
        }
        return false;
    }

    public function invitation_apply_detail_employee($employee_id)
    {
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        //trinh do chuyen mon
        $specialize = new Employee_specialize();
        $specialize = $specialize->select('*')->where('employee_id', $employee_id)->orderBy('specialize_id', 'asc')->get();
        // Kinh nghiệm làm việc
        $experience = new Employee_experience();
        $experience = $experience->select('*')->where('employee_id', $employee_id)->orderBy('experience_id', 'asc')->get();

        //lấy xu theo danh mục công việc
        $caree = \App\Entity\Career::getIdCareer($employee->career_category_id);
        $employer = $this->check_user_role();
        if (empty($employer)) {
            return redirect(route('list_job_face'))->with('mesage_modal', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin của ứng viên này ');
        }
        //check trường hopnj ntd hết xu
        $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
        $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
        $history_coin = 0;
        if(!empty($employer->employer_id))
        {
            $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        }
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
//        echo $coin_free;die();
//        view_apply
        if (empty($employer->total_employer_coin) && $coin_surplus <= 0) {
            return redirect()->back()->with('error', 'Số điểm miễn phí không đủ để mời ứng viên ứng tuyển');
        }
        //danh sách tin tuyển dụng
        $jobModel = new Job();

        $list_jobs = $jobModel
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->select(
                'jobs.title', 'jobs.job_code', 'jobs.job_id', 'jobs.views', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job'
            );
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        if(!empty($employer->employer_id))
        {
            $list_jobs = $list_jobs->where('employer_id', $employer->employer_id);
        }
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');

        $list_jobs = $list_jobs->limit(20)
            ->get();

//        echo '<pre>';
//        print_r($list_jobs);die();
        return view('site.job_facebook.invitation_list_jobs', compact('user', 'employee', 'coin_free', 'employer', 'specialize', 'experience', 'total_jobs', 'list_jobs'));
    }

    public function invitation_job_apply_detail_employee(Request $request)
    {
//        try {
        $jobs_id = $request->input('job_ids');
        if (empty($jobs_id)) {
            return redirect()->back()->with('error', 'Vui lòng chọn tin tuyển dụng để mời ứng viên ứng tuyển');
        }
        $employee_id = $request->input('employee_id');
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        $caree = \App\Entity\Career::getIdCareer($employee->career_category_id);
        $total_coin = !empty(count($jobs_id) * $caree->view_apply) ? count($jobs_id) * $caree->view_apply : 0;
        $employer = $this->check_user_role();
        $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
        $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
        //trường hợp ntd dùng điểm miễn phí
        if (empty($employer->total_employer_coin) && $coin_surplus < $total_coin) {
            return redirect()->back()->with('error', 'Số điểm miễn phí không đủ để mời ứng viên ứng tuyển');
        }
        //trường họp ntd dùng điểm đã nạp
        if (!empty($employer->total_employer_coin) && $employer->employer_coin < $total_coin) {
            return redirect()->back()->with('error', 'Số điểm của bạn không đủ để mời ứng viên ứng tuyển');
        }
        DB::beginTransaction();
        if (!empty($employer->total_employer_coin)) {
            //trường họp trừ xu của ntd
            $coin_history_status = 1;
            $employer_coin = $employer->employer_coin - $total_coin;
            $update_coin = Employer::where('employer_id', $employer->employer_id)->update([
                'employer_coin' => $employer_coin
            ]);
        } else {
            //trường hợp xu miễn phí
            $coin_history_status = 0;
        }
        //trừ xu
        $insert_get_id = Coin_history_employer::insertGetId([
            'coin_history_title' => 'Mời ứng viên ứng tuyển tin tuyển dụng',
            'coin' => $total_coin,
            'coin_history_status' => $coin_history_status,
            'coin_employee_status' => 1,
            'employer_id' => $employer->employer_id,
            'created_at' => new \DateTime()
        ]);
        foreach ($jobs_id as $job) {
            $inser_coin_show_employee = Coin_apply_employee::insertGetId([
                'coin_history_id' => $insert_get_id,
                'employer_id' => $employer->employer_id,
                'employee_id' => $employee_id,
                'job_id' => $job,
                'created_at' => new \DateTime()
            ]);
            $sendmail = MailConfigController::send_email_invitation_employee($job, $employee_id);
        }
        DB::commit();
        return redirect()->back()->with('suscess', 'Mời ứng viên ứng tuyển thành công');
//        } catch (\Exception $ex) {
//            DB::rollBack();
//            return redirect()->back()->with('error', 'Có lỗi xảy ra ! vui lòng thử lại');
//        }
    }

    public function show_info_cv_detail_employee(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();

        //lấy xu theo danh mục công việc
        $caree = \App\Entity\Career::getIdCareer($employee->career_category_id);
        $employer = $this->check_user_role();
        if (empty($employer)) {
            return redirect()->back()->with('error_employee_show', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin của ứng viên này ');
        }
        //trường hợp mà nhà tuyển dụng đã xem ứng viên này rồi
        $coin_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        //danh sach ứng viên đã xem
        $relate_employee = Coin_show_employee::select('coin_show_employee.employee_id', 'employees.*')->leftJoin('employees', 'employees.employee_id', 'coin_show_employee.employee_id')->paginate(15);
        if (!empty($coin_show_employee)) {
            return redirect()->back();
        }

        //check trường hopnj ntd hết xu
        $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
        $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
        if (empty($employer->total_employer_coin) && $coin_surplus < $caree->view_profile) {
            return redirect()->back()->with('error', 'Số điểm miễn phí của bạn không đủ để xem thông tin liên hệ của ứng viên này');
        }
        if (!empty($employer->total_employer_coin) && $employer->employer_coin < $caree->view_profile) {
            return redirect()->back()->with('error', 'Số điểm còn lại không đủ để xem thông tin liên hệ của ứng viên này');
        }
        //tiến hành trừ điểm
        DB::beginTransaction();
        if (!empty($employer->total_employer_coin)) {
            //trường họp trừ xu của ntd
            $coin_history_status = 1;
            $employer_coin = $employer->employer_coin - $caree->view_profile;
            $update_coin = Employer::where('employer_id', $employer->employer_id)->update([
                'employer_coin' => $employer_coin
            ]);
        } else {
            //trường hợp xu miễn phí
            $coin_history_status = 0;
        }
        //trừ xu
        $insert_get_id = Coin_history_employer::insertGetId([
            'coin_history_title' => 'Xem thông tin liên lạc ứng viên',
            'coin' => $caree->view_profile,
            'coin_history_status' => $coin_history_status,
            'coin_employee_status' => 0,
            'employer_id' => $employer->employer_id,
            'created_at' => new \DateTime()
        ]);
        $inser_coin_show_employee = Coin_show_employee::insertGetId([
            'coin_history_id' => $insert_get_id,
            'employer_id' => $employer->employer_id,
            'employee_id' => $employee_id,
            'created_at' => new \DateTime()
        ]);
        DB::commit();
        return redirect()->back()->with('success', 'Xem thông tin liên hệ thành công');
//        return redirect(route('show_cv_detail_employee',['employee_id'=>$employee_id]));
    }

    public function ajax_show_info_cv_detail_employee(Request $request)
    {
        $employee_id = $request->employee_id;
        $employees = new Employee();
        $employee = $employees->select('career_category_id', 'user_id')->where('employee_id', $employee_id)->first();

        //lấy xu theo danh mục công việc
        $caree = \App\Entity\Career::getIdCareer($employee->career_category_id);
        $employer = $this->check_user_role();
        if (empty($employer)) {
            return response()->json([
                'status' => 'error',
                'mess' => 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin của ứng viên này.'
            ]);
        }
        //trường hợp mà nhà tuyển dụng đã xem ứng viên này rồi
//        $coin_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);

        //check trường hopnj ntd hết xu
        $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
        $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
        if (empty($employer->total_employer_coin) && $coin_surplus <= $caree->view_profile) {
            return response()->json([
                'status' => 'error',
                'mess' => 'Số điểm miễn phí của bạn không đủ để xem thông tin liên hệ của ứng viên này.'
            ]);
        }
        if (!empty($employer->total_employer_coin) && $employer->employer_coin <= $caree->view_profile) {
            return response()->json([
                'status' => 'error',
                'mess' => 'Số điểm còn lại không đủ để xem thông tin liên hệ của ứng viên này.'
            ]);
        }
        //tiến hành trừ điểm
        DB::beginTransaction();
        if (!empty($employer->total_employer_coin)) {
            //trường họp trừ xu của ntd
            $coin_history_status = 1;
            $employer_coin = $employer->employer_coin - $caree->view_profile;
            $update_coin = Employer::where('employer_id', $employer->employer_id)->update([
                'employer_coin' => $employer_coin
            ]);
        } else {
            //trường hợp xu miễn phí
            $coin_history_status = 0;
        }
        //trừ xu
        $insert_get_id = Coin_history_employer::insertGetId([
            'coin_history_title' => 'Xem thông tin liên lạc ứng viên',
            'coin' => $caree->view_profile,
            'coin_history_status' => $coin_history_status,
            'coin_employee_status' => 0,
            'employer_id' => $employer->employer_id,
            'created_at' => new \DateTime()
        ]);
        $inser_coin_show_employee = Coin_show_employee::insertGetId([
            'coin_history_id' => $insert_get_id,
            'employer_id' => $employer->employer_id,
            'employee_id' => $employee_id,
            'created_at' => new \DateTime()
        ]);
        // tt lien lac ung vien
        $employee_contact = Employee::select('phone', 'email')->where('employee_id', $employee_id)
            ->first();
        // link cv upload
        $link_cv_upload = Employee_upload_cv::select('employee_link_cv', 'employee_cv_status')
            ->where('employee_id', $employee_id)
            ->first();
        //check cv
        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        if (!empty($check_show_employee)) {
            if (!empty($link_cv_upload->employee_cv_status)) {
                $link_cv_upload_contact = asset('employee_link_cv');
            } else {
                $link_cv_upload_contact = route('exportpdf_cv_user_id', ['user_id' => $employee->user_id]);
            }
        }
        DB::commit();
        return response()->json([
            'status' => 'success',
            'mess' => 'Xem thông tin liên hệ thành công.',
            'employee_contact' => $employee_contact,
            'link_cv_upload' => $link_cv_upload_contact
        ]);
    }

    public function search_job_view_mobile(Request $request)
    {
        $list_jobs = array();
        $list_job_fb = array();
        if (!empty($request->input())) {
            $user = auth()->user();
            $jobModel = new Job();
            $list_jobs = $jobModel
                ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->select(
                    'jobs.title', 'jobs.job_id', 'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
                    'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province', 'jobs.active_job'
                );
            $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $list_jobs = $list_jobs->where('jobs.active_job', 1);
            if (!empty($request->input('career'))) {
                $list_jobs = $list_jobs->where('jobs.career_category_id', $request->input('career'));
            }
            if (!empty($request->input('province'))) {
                $list_jobs = $list_jobs->where('jobs.province', $request->input('province'));
            }
            if (!empty($request->input('district'))) {
                $list_jobs = $list_jobs->where('jobs.district', $request->input('district'));
            }
            if (!empty($request->input('salary'))) {
                $list_jobs = $list_jobs->where('jobs.salary_id', $request->input('salary'));
            }
            if ($request->has('vip')) {
                $list_jobs = $list_jobs->where('jobs.vip', $request->input('vip'));
            }
            if (!empty($request->input('word'))) {
                $list_jobs = $list_jobs->where('jobs.title', 'like', '%' . $request->input('word') . '%');
            }

            $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
            $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
            $total_jobs = $list_jobs->count();
            $list_jobs = $list_jobs->paginate(20, ['*'], 'page_1s');

            $list_jobs->appends(request()->query());

            $jobFb_model = new JobFacebook();
            $list_job_fb = $jobFb_model->select(
                'job_facebook.date_end',
                'job_facebook.vip',
                'job_facebook.updated_at',
                'job_facebook.career_category_id',
                'job_facebook.title',
                'job_facebook.slug',
                'job_facebook.salary_id',
                'job_facebook.district',
                'job_facebook.province',
                'job_facebook.company_name',
                'salary.description as salary_description',
                'salary.salary_id'
            );
            $list_job_fb = $list_job_fb->leftJoin('salary', 'salary.salary_id', 'job_facebook.salary_id');
//            $list_job_fb = $list_job_fb->whereDate('job_facebook.date_end', '>=', date('Y-m-d'));

            if (!empty($request->input('career'))) {
                $list_job_fb = $list_job_fb->where('job_facebook.career_category_id', $request->input('career'));
            }
            if (!empty($request->input('province'))) {
                $list_job_fb = $list_job_fb->where('job_facebook.province', $request->input('province'));
            }
            if (!empty($request->input('district'))) {
                $list_job_fb = $list_job_fb->where('job_facebook.district', $request->input('district'));
            }
            if (!empty($request->input('salary'))) {
                $list_job_fb = $list_job_fb->where('job_facebook.salary_id', $request->input('salary'));
            }
            if ($request->has('vip')) {
                $list_job_fb = $list_job_fb->where('job_facebook.vip', $request->input('vip'));
            }
            if (!empty($request->input('word'))) {
                $list_job_fb = $list_job_fb->where('job_facebook.title', 'like', '%' . $request->input('word') . '%');
            }


            $list_job_fb = $list_job_fb->orderBy('job_facebook.vip', 'desc');
            $list_job_fb = $list_job_fb->orderBy('job_facebook.updated_at', 'desc');
            $list_job_fb = $list_job_fb->paginate(20, ['*'], 'page_2s');
            $list_job_fb->appends(request()->query());
            return view('site.job_facebook.search_job_view_mobile', compact('list_jobs', 'list_job_fb'));
        } else {
            return view('site.job_facebook.search_job_view_mobile', compact('list_jobs', 'list_job_fb'));
        }

    }

    public function get_list_jobs(Request $request)
    {
        $employer = Employer::where('user_id', Auth::id())->first();
        //danh sách tin tuyển dụng
        $jobModel = new Job();

        $list_jobs = $jobModel->select(
            'jobs.title', 'jobs.job_code', 'jobs.job_id', 'jobs.views',
            'jobs.date_submit', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at',
            'salary.description as salary_description', 'jobs.deadline_submit_profile',
            'jobs.district', 'jobs.province', 'jobs.active_job'
        )
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id');
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('employer_id', $employer->employer_id);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        $list_jobs = $list_jobs->get();

        return response()->json([
            'list_jobs' => Auth::id()
        ], 200);
    }


    public function ajax_get_total_job_carrer()
    {
        $list_carrer = Career::select('career_category_id')->get();
//        $count_employee = array();
//        $count_employee[$carrer->career_category_id] = 0;
        foreach ($list_carrer as $id => $carrer) {
            $jobfaceModule = new JobFacebook();
            $count_job_fb = $jobfaceModule->where('job_facebook.career_category_id', $carrer->career_category_id)
                ->where('warning_job_fb', '<', 4)
                ->whereDate('job_facebook.date_end', '>=', date('Y-m-d'))
                ->count();

            $jobModel = new Job();
            $count_job = $jobModel->where('jobs.career_category_id', $carrer->career_category_id)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->where('jobs.active_job', 1)
                ->count();
            $count_employee[$carrer->career_category_id] = $count_job_fb + $count_job;
        }
        return response([
            'status' => 200,
            'count_employee' => $count_employee,
        ])->header('Content-Type', 'text/plain');

    }

    public function ajax_get_total_job_province()
    {
        $list_province = Province::select('province_id')->get();
//        $count_employee = array();

        foreach ($list_province as $id => $province) {
            $employees = new Employee();
            $jobfaceModule = new JobFacebook();
            $count_job_fb = $jobfaceModule->where('job_facebook.province', $province->province_id)
                ->where('warning_job_fb', '<', 4)
                ->whereDate('job_facebook.date_end', '>=', date('Y-m-d'))
                ->count();

            $jobModel = new Job();
            $count_job = $jobModel->where('jobs.province', $province->province_id)
                ->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'))
                ->where('jobs.active_job', 1)
                ->count();
            $count_employee[$province->province_id] = $count_job_fb + $count_job;
        }
        return response([
            'status' => 200,
            'count_employee' => $count_employee,
        ])->header('Content-Type', 'text/plain');

    }


}
