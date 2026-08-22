<?php

namespace App\Http\Controllers\Api;

use App\Entity\Career;
use App\Entity\Employee;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employees_save_job_facebook;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\Province;
use App\Entity\User;
use App\Http\Controllers\Site\MailConfigController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class JobsController extends Controller
{
    public function category_jobs(Request $request)
    {
        try {
            $jobModel = new Job();
            $list_jobs = $jobModel
                ->select(
                    'jobs.title', 'jobs.job_id', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'jobs.active_job',
                    'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province',
                    'employer.enterprise_name', 'employer.image', 'jobs.number_recruit', 'employer.employer_id', 'province.province_name', 'district.district_name'
                )
                ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
                ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district');
            $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $list_jobs = $list_jobs->where('jobs.active_job', 1);
            $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
            $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
            $total = $list_jobs->count();
            $list_jobs = $list_jobs->paginate(20);
            foreach ($list_jobs as $id => $jobs) {
                $list_jobs[$id]['image'] = !empty($jobs->image) ? asset($jobs->image) : '';
                $status_save_job = 0;
                $string_save_job = 'Chưa lưu';
                $status_submit_job = 0;
                $string_submit_job = 'Chưa nộp hồ sơ';
                if (!empty($request->token)) {
                    try {
                        $user = JWTAuth::toUser($request->token);
                        if ($user->role == 1) {
                            $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
                            $check_save_job = Employees_save_job_facebook::checkSaveJobFacebook($employee_id, $jobs->job_id, 1);
                            $status_save_job = !empty($check_save_job) ? 1 : 0;
                            $string_save_job = !empty($check_save_job) ? 'Đã lưu' : 'Chưa lưu';
                            $check_submit_from = Employee_submit_job_faacebook::where('employee_id', $employee_id)
                                ->where('status_job', 1)
                                ->where('id_job_fb', $jobs->job_id)
                                ->first();
                            $status_submit_job = !empty($check_submit_from) ? 1 : 0;
                            $string_submit_job = !empty($check_submit_from) ? 'Đã nộp hồ sơ' : 'Chưa nộp hồ sơ';
                            $list_jobs[$id]['employee_id'] = $employee_id;
                        }
                    } catch (\Exception $exception) {

                    }
                }
                $list_jobs[$id]['status_save_job'] = $status_save_job;
                $list_jobs[$id]['string_save_job'] = $string_save_job;
                $list_jobs[$id]['status_submit_job'] = $status_submit_job;
                $list_jobs[$id]['string_submit_job'] = $string_submit_job;
                $submit_profile = Employee_submit_job_faacebook::where('id_job_fb', $jobs->job_id)
                    ->where('status_job', 1)
                    ->count();
                $list_jobs[$id]['total_submit_profile'] = !empty($submit_profile) ? $submit_profile : 0;
            }
            if (empty($list_jobs)) {
                return response([
                    'status' => 404,
                    'message' => 'Không có công việc nào'
                ], 404);
            }
            return response([
                'status' => 200,
                'list_jobs' => $list_jobs,
                'total' => $total,
            ], 200);
        } catch (\Exception $e) {
            return response([
                'status' => 400,
                'error' => 'Không tìm thấy bản ghi nào',
            ], 404);
        }

    }

    public function search_jobs(Request $request)
    {
        try {
            $jobModel = new Job();
            $list_jobs = $jobModel
                ->select(
                    'jobs.title', 'jobs.job_id', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'jobs.active_job',
                    'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province',
                    'employer.enterprise_name', 'employer.image', 'jobs.number_recruit', 'employer.employer_id', 'province.province_name', 'district.district_name'
                )
                ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
                ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
                ->leftJoin('province', 'province.province_id', 'jobs.province')
                ->leftJoin('district', 'district.district_id', 'jobs.district');
            $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
            $list_jobs = $list_jobs->where('jobs.active_job', 1);
            if (!empty($request->input('career_category_id'))) {
                $list_jobs = $list_jobs
                    ->where('jobs.career_category_id', $request->input('career_category_id'));
            }
            if (!empty($request->input('district_id'))) {
                if (!empty($request->input('district_id'))) {
                    $list_jobs = $list_jobs->where('jobs.district', $request->input('district_id'));
                }
            } else {
                if (!empty($request->input('province_id'))) {
                    $list_jobs = $list_jobs->where('jobs.province', $request->input('province_id'));
                }
            }
            if (!empty($request->input('salary_id'))) {
                $list_jobs = $list_jobs->where('jobs.salary_id', $request->input('salary_id'));
            }
            if (!empty($request->input('title'))) {
                $title = $request->input('title');
                $list_jobs = $list_jobs->where('jobs.title', 'like', '%' . $title . '%');
            }

            if (!empty($request->has('vip'))) {
                $vip = $request->input('vip');
                if ($vip != '') {
                    $list_jobs = $list_jobs->where('jobs.vip', $vip);
                }
            }
            if ($request->input('date_create')) {
//            $total_job = $total_job->whereBetween(DB::raw('DATE(updated_at)'), array($date_form, $date_to));
                $list_jobs = $list_jobs->whereDate('jobs.updated_at', '>=', $request->input('date_create'));
                $list_jobs = $list_jobs->whereDate('jobs.updated_at', '<=', date('Y-m-d'));
            }
            $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
            $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
            $total = $list_jobs->count();
            $list_jobs = $list_jobs->paginate(20);
            foreach ($list_jobs as $id => $jobs) {
                $list_jobs[$id]['image'] = !empty($jobs->image) ? asset($jobs->image) : '';
                $status_save_job = 0;
                $string_save_job = 'Chưa lưu';
                $status_submit_job = 0;
                $string_submit_job = 'Chưa nộp hồ sơ';
                if (!empty($request->token)) {
                    try {
                        $user = JWTAuth::toUser($request->token);
                        if ($user->role == 1) {
                            $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
                            $check_save_job = Employees_save_job_facebook::checkSaveJobFacebook($employee_id, $jobs->job_id, 1);
                            $status_save_job = !empty($check_save_job) ? 1 : 0;
                            $string_save_job = !empty($check_save_job) ? 'Đã lưu' : 'Chưa lưu';
                            $check_submit_from = Employee_submit_job_faacebook::where('employee_id', $employee_id)
                                ->where('status_job', 1)
                                ->where('id_job_fb', $jobs->job_id)
                                ->first();
                            $status_submit_job = !empty($check_submit_from) ? 1 : 0;
                            $string_submit_job = !empty($check_submit_from) ? 'Đã nộp hồ sơ' : 'Chưa nộp hồ sơ';
                            $list_jobs[$id]['employee_id'] = $employee_id;
                        }
                    } catch (\Exception $exception) {

                    }
                }
                $list_jobs[$id]['status_save_job'] = $status_save_job;
                $list_jobs[$id]['string_save_job'] = $string_save_job;
                $list_jobs[$id]['status_submit_job'] = $status_submit_job;
                $list_jobs[$id]['string_submit_job'] = $string_submit_job;
                $submit_profile = Employee_submit_job_faacebook::where('id_job_fb', $jobs->job_id)
                    ->where('status_job', 1)
                    ->count();
                $list_jobs[$id]['total_submit_profile'] = !empty($submit_profile) ? $submit_profile : 0;
            }
            if (empty($list_jobs)) {
                return response([
                    'status' => 404,
                    'message' => 'Không có công việc nào'
                ], 404);
            }
            return response([
                'status' => 200,
                'list_jobs' => $list_jobs,
                'total' => $total,
            ], 200);
        } catch (\Exception $e) {
            return response([
                'status' => 400,
                'error' => 'Không tìm thấy bản ghi nào',
            ], 404);
        }


    }

    public function jobs_detail($slug, Request $request)
    {
        $jobModel = new Job();
        $job = Job::leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('province', 'province.province_id', 'jobs.province')
            ->leftJoin('district', 'district.district_id', 'jobs.district')
            ->leftJoin('literacies', 'literacies.literacy_id', 'jobs.literacy_id')
            ->leftJoin('employer', 'employer.employer_id', 'jobs.employer_id')
            ->leftJoin('software', 'software.software_id', 'jobs.software_id')
            ->leftJoin('career_categories', 'career_categories.career_category_id', 'jobs.career_category_id')
            ->leftJoin('age', 'age.id_age', 'jobs.age_id')
            ->select(
                'jobs.job_id',
                'jobs.job_id',
                'jobs.job_code',
                'jobs.title',
                'jobs.content',
                'jobs.vip',
                'jobs.gender',
                'jobs.position',
                'jobs.experience_id',
                'jobs.deadline_submit_profile',
                'jobs.number_recruit',
                'jobs.number_recruited',
                'jobs.address_work',
                'jobs.views',
                'jobs.date_submit',
                'jobs.updated_at',
                'jobs.welfare',
                'jobs.id_exam',
                'jobs.description',
                'jobs.date_exam_job',
                'employer.enterprise_name',
                'employer.slug as employer_slug',
                'employer.website as employer_website',
                'employer.phone as employer_phone',
                'employer.address as employer_address',
                'salary.description as salary_description',
                'literacies.literacy_name',
                'district_name',
                'province_name',
                'career_categories.career_category_name',
                'software.software_name',
                'age.name_age'
            )
            ->where('jobs.slug', $slug)
            ->first();
        //        cap nhat luot xem;views
        $status_save_job = 0;
        $string_save_job = 'Chưa lưu';
        $status_submit_job = 0;
        $string_submit_job = 'Chưa nộp hồ sơ';
        if (!empty($request->token)) {
            try {
                $user = JWTAuth::toUser($request->token);
                if ($user->role == 1) {
                    $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
                    $check_save_job = Employees_save_job_facebook::checkSaveJobFacebook($employee_id, $job->job_id, 1);
                    $status_save_job = !empty($check_save_job) ? 1 : 0;
                    $string_save_job = !empty($check_save_job) ? 'Đã lưu' : 'Chưa lưu';
                    $check_submit_from = Employee_submit_job_faacebook::where('employee_id', $employee_id)
                        ->where('status_job', 1)
                        ->where('id_job_fb', $job->job_id)
                        ->first();
                    $status_submit_job = !empty($check_submit_from) ? 1 : 0;
                    $string_submit_job = !empty($check_submit_from) ? 'Đã nộp hồ sơ' : 'Chưa nộp hồ sơ';
                    $job['employee_id'] = $employee_id;
                }
            } catch (\Exception $exception) {

            }
        }

//        gender
        $job['status_save_job'] = $status_save_job;
        $job['string_save_job'] = $string_save_job;
        $job['status_submit_job'] = $status_submit_job;
        $job['string_submit_job'] = $string_submit_job;
        $submit_profile = Employee_submit_job_faacebook::where('id_job_fb', $job->job_id)
            ->where('status_job', 1)
            ->count();
        $job['total_submit_profile'] = !empty($submit_profile) ? $submit_profile : 0;

        $message_gender = 'Không yêu cầu giới tính';
        if ($job->gender == 1) {
            $message_gender = 'Nữ';
        }
        if ($job->gender == 2) {
            $message_gender = 'Nam';
        }
        if ($job->gender == 3) {
            $message_gender = 'Cả nam và nữ';
        }
        $job['message_gender'] = $message_gender;
        $view = $job->views + 1;
        $jobview = Job::where('slug', $slug)->update([
            'views' => $view
        ]);
        if (empty($job)) {
            return response([
                'status' => 404,
                'message' => 'Không tồn tại công việc này !'
            ], 404);
        }
        return response([
            'status' => 200,
            'job' => $job,
        ], 200);
    }

    public function list_save_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng đăng nhập để xem thông tin này'
            ], 400);
        }
        $employee_id = Employee::where('user_id', $user->id)->value('employee_id');

        $jobModel = new Job();
        $list_jobs = $jobModel
            ->select(
                'jobs.title', 'jobs.job_id', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'jobs.active_job',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province',
                'employer.enterprise_name', 'employer.image', 'jobs.number_recruit', 'employer.employer_id', 'province.province_name', 'district.district_name'
            )
            ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('province', 'province.province_id', 'jobs.province')
            ->leftJoin('district', 'district.district_id', 'jobs.district')
            ->leftJoin('employees_save_job_facebook', 'employees_save_job_facebook.id_job_fb', 'jobs.job_id');
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('employees_save_job_facebook.employee_id', $employee_id);
        $list_jobs = $list_jobs->where('employees_save_job_facebook.status_job', 1);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        $total = $list_jobs->count();
        $list_jobs = $list_jobs->paginate(20);
        foreach ($list_jobs as $id => $jobs) {
            $list_jobs[$id]['image'] = !empty($jobs->image) ? asset($jobs->image) : '';
        }
        if (empty($list_jobs)) {
            return response([
                'status' => 404,
                'message' => 'Không tồn tại công việc này !'
            ], 404);
        }
        return response([
            'status' => 200,
            'message' => 'Danh sách việc làm đã lưu',
            'job' => $list_jobs,
        ], 200);
    }

    //dung tren website
    public function web_category_jobs(Request $request, $limit)
    {
        if (empty($limit)) {
            $limit = 10;
        }
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->select(
                'jobs.title', 'jobs.job_id', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'jobs.active_job',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province',
                'employer.enterprise_name', 'employer.employer_id', 'province.province_name', 'district.district_name'
            )
            ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('province', 'province.province_id', 'jobs.province')
            ->leftJoin('district', 'district.district_id', 'jobs.district');
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
//        $total = $list_jobs->count();
        $list_jobs = $list_jobs->limit($limit)
            ->get();
        if (empty($list_jobs)) {
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ], 404);
        }
        return response([
            'status' => 200,
            'list_jobs' => $list_jobs,
        ], 200);
    }


    public function inforEmployee(Request $request)
    {
        $user = JWTAuth::toUser($request->input('token'));
        try {
            $employee = Employee::where('employee_user_id', $user->id)->first();
            if (empty($employee)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
                ], 404);
            }
            return response()->json([
                'status' => 200,
                'employee' => $employee
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
            ], 404);
        }
    }

    public function create_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng này chỉ dành cho nhà tuyên dụng'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'career_category_id' => 'required',
            'salary_id' => 'required',
            'experience_id' => 'required',
            'deadline_submit_profile' => 'required',
            'number_recruit' => 'required',
            'literacy_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_work' => 'required',
            'description' => 'required',
            'content' => 'required',
            'welfare' => 'required'

        ], [
            'career_category_id.required' => 'Vui lòng chọn vị trí cần tuyển',
            'salary_id.required' => 'Vui lòng chọn mức lương',
            'experience_id.required' => 'Vui lòng chọn kinh nghiệm cần tuyển',
            'deadline_submit_profile.required' => 'Vui lòng chọn hạn nộp hồ sơ',
            'number_recruit.required' => 'Số lượng cần tuyển không được để trống',
            'literacy_id.required' => 'Vui lòng chọn trình độ học vấn',
            'province.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận huyện',
            'address_work.required' => 'Địa chỉ làm việc không được để trống',
            'description.required' => 'Mô tả vị trí công việc không được để trống',
            'content.required' => 'Yêu cầu công việc không được để trống',
            'welfare.required' => 'Phúc lợi xã hội không được để trống'
        ]);
        if ($validation->fails()) {
            $massage = '';
            foreach ($validation->errors()->all() as $error) {
                $massage .= $error;
            }
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }
        try {
            $employer = New Employer();
            $employer = $employer->select('employer_id', 'enterprise_name', 'email', 'profile')->where('user_id', $user->id)->first();
            DB::beginTransaction();
            $active_job = 0;
            $tags = "";
            if (!empty($request->input('tags'))) {
                foreach ($request->input('tags') as $tag) {
                    $tags .= $tag . ',';
                }
                $tags = rtrim($tags, ",");
            }

            // END thêm tag
            $jobs = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $job_id = $jobs->insertGetId([
                'age_id' => !empty($request->input('age_id') ? $request->input('age_id') : 0),
                'description' => $request->has('description') ? $request->input('description') : '',
                'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                'experience_id' => !empty($request->input('experience_id')) ? $request->input('experience_id') : 0,
                'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                'content' => !empty($request->input('content')) ? $request->input('content') : '',
                'number_recruit' => !empty($request->input('number_recruit')) ? $request->input('number_recruit') : 1,
                'province' => !empty($request->input('province')) ? $request->input('province') : 0,
                'district' => !empty($request->input('district')) ? $request->input('district') : 0,
                'tags' => $tags,
                'vip' => 0,
                'gender' => !empty($request->input('gender')) ? $request->input('gender') : '',
                'date_end' => $request->input('deadline_submit_profile'),
                'date_submit' => new \DateTime(),
                'updated_at' => new \DateTime(),
                'created_at' => new \DateTime(),
                //goi bán hàng
                'employer_id' => $employer->employer_id,
                //phần mềm Y/C
                'software_id' => !empty($request->input('software')) ? $request->input('software') : 0,
//                danh mục ngành nghề
                'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
                'address_work' => $request->input('address_work'),
                'status_exam' => $status_exam,
                'id_exam' => !empty($request->input('id_exam')) ? $request->input('id_exam') : 0,
                'welfare' => $request->input('welfare'),
                'active_job' => $active_job,
                'count_updated_at' => 0
            ]);
            $string_career = Career::where('career_category_id', $request->input('career_category_id'))->value('career_category_name');
            $string_province = Province::where('province_id', $request->input('province'))->value('province_name');
            $title = $string_career . ' tại ' . $string_province;
            $slug = str_slug($string_career) . '-tai-' . str_slug($string_province) . '-' . $job_id;
            $update = $jobs->where('job_id', $job_id)->update([
                'job_code' => 'SKT' . $job_id,
                'title' => $title,
                'slug' => $slug
            ]);

            //gửi email hướng dẫn sử dụng chức năng của  nhà tuyển dụng
//            $send_email = MailConfigController::employer_create_job($employer->email);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => 'Thêm mới việc làm thất bại, Vui lòng thử lại',
            ], 400);
        } finally {
            return response()->json([
                'status' => 200,
                'message' => 'Thêm mới việc làm thành công, Vui lòng chờ Admin duyệt tin của bạn',
            ], 200);
        }
    }

    public function list_employer_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng này chỉ dành cho nhà tuyên dụng'
            ], 400);
        }
        $employer = New Employer();
        $employer_id = $employer->where('user_id', $user->id)->value('employer_id');
        if (empty($employer_id)) {
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ], 404);
        }
        $jobModel = new Job();
        $list_jobs = $jobModel
            ->select(
                'jobs.title', 'jobs.job_id', 'jobs.active_job', 'jobs.employer_id', 'jobs.slug', 'jobs.vip', 'jobs.updated_at', 'jobs.active_job',
                'salary.description as salary_description', 'jobs.deadline_submit_profile', 'jobs.district', 'jobs.province',
                'employer.enterprise_name', 'employer.employer_id', 'employer.image', 'province.province_name', 'district.district_name'
            )
            ->leftJoin('employer', 'employer.employer_id', '=', 'jobs.employer_id')
            ->leftJoin('salary', 'salary.salary_id', 'jobs.salary_id')
            ->leftJoin('province', 'province.province_id', 'jobs.province')
            ->leftJoin('district', 'district.district_id', 'jobs.district');
//        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
//        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('jobs.employer_id', $employer_id);
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        $total = $list_jobs->count();
        $list_jobs = $list_jobs->paginate(20);
        foreach ($list_jobs as $id => $job) {
            $message_job = 'Tin chưa duyệt';
            if ($job->active_job == 1) {
                $message_job = 'Tin đã duyệt';
            }
            if ($job->vip == 1) {
                $message_job = 'Tin Vip';
            }
            $date = date_create($job->deadline_submit_profile);
            $date_end = date_format($date, "d-m-Y");
            $today = date('d-m-Y');
            if (strtotime($today) > strtotime($date_end)) {
                $message_job = 'Tin hết hạn';
            }
            $list_jobs[$id]['message_status'] = $message_job;
            $list_jobs[$id]['image'] = !empty($job->image) ? asset($job->image) : '';
        }
        if (empty($list_jobs)) {
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ], 404);
        }
        return response([
            'status' => 200,
            'message' => 'Danh sách việc làm đã đăng',
            'list_jobs' => $list_jobs,
            'total' => $total,
        ], 200);

    }

    public function detail_jobs($job_id, Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng này danh cho nhà tuyển dụng'
            ], 400);
        }
        $employer_id = Employer::where('user_id', $user->id)->value('employer_id');
        $job = Job::where('job_id', $job_id)->where('employer_id', $employer_id)->first();
        $job['salary_id'] = !empty($job->salary_id) ? $job->salary_id : 0;
        $job['province_id'] = !empty($job->province) ? $job->province : '';
        $job['district_id'] = !empty($job->district) ? $job->district : '';
        $job['literacy_id'] = !empty($job->literacy_id) ? $job->literacy_id : '';
        $job['career_category_id'] = !empty($job->career_category_id) ? $job->career_category_id : '';
        $job['literacy_id '] = !empty($job->literacy_id) ? $job->literacy_id : '';
        if (empty($job)) {
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy tin tuyển dụng này'
            ], 400);
        }


        return response([
            'status' => 200,
            'message' => 'Danh sách việc làm đã đăng',
            'job' => $job,
        ], 200);
    }

    public function update_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng này chỉ dành cho nhà tuyên dụng'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'career_category_id' => 'required',
            'job_id' => 'required',
            'salary_id' => 'required',
            'experience_id' => 'required',
            'deadline_submit_profile' => 'required',
            'number_recruit' => 'required',
            'literacy_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'address_work' => 'required',
            'description' => 'required',
            'content' => 'required',
            'welfare' => 'required'

        ], [
            'career_category_id.required' => 'Vui lòng chọn vị trí cần tuyển',
            'job_id.required' => 'Vui lòng chọn tin tuyển dụng',
            'salary_id.required' => 'Vui lòng chọn mức lương',
            'experience_id.required' => 'Vui lòng chọn kinh nghiệm cần tuyển',
            'deadline_submit_profile.required' => 'Vui lòng chọn hạn nộp hồ sơ',
            'number_recruit.required' => 'Số lượng cần tuyển không được để trống',
            'literacy_id.required' => 'Vui lòng chọn trình độ học vấn',
            'province.required' => 'Vui lòng chọn thành phố',
            'district.required' => 'Vui lòng chọn quận huyện',
            'address_work.required' => 'Địa chỉ làm việc không được để trống',
            'description.required' => 'Mô tả vị trí công việc không được để trống',
            'content.required' => 'Yêu cầu công việc không được để trống',
            'welfare.required' => 'Phúc lợi xã hội không được để trống'
        ]);
        if ($validation->fails()) {
            $massage = '';
            foreach ($validation->errors()->all() as $error) {
                $massage .= $error;
            }
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }
        try {
            $employer = New Employer();
            $employer = $employer->select('employer_id', 'enterprise_name', 'email', 'profile')->where('user_id', $user->id)->first();
            DB::beginTransaction();
            $tags = "";
            if (!empty($request->input('tags'))) {
                foreach ($request->input('tags') as $tag) {
                    $tags .= $tag . ',';
                }
                $tags = rtrim($tags, ",");
            }

            // END thêm tag
            $jobs = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $update_job = $jobs->where('employer_id', $employer->employer_id)
                ->where('job_id', $request->job_id)
                ->update([
                    'age_id' => !empty($request->input('age_id') ? $request->input('age_id') : 0),
                    'description' => $request->has('description') ? $request->input('description') : '',
                    'salary_id' => !empty($request->input('salary_id')) ? $request->input('salary_id') : 0,
                    'experience_id' => !empty($request->input('experience_id')) ? $request->input('experience_id') : 0,
                    'literacy_id' => !empty($request->input('literacy_id')) ? $request->input('literacy_id') : 0,
                    'deadline_submit_profile' => $request->input('deadline_submit_profile'),
                    'content' => !empty($request->input('content')) ? $request->input('content') : '',
                    'number_recruit' => !empty($request->input('number_recruit')) ? $request->input('number_recruit') : 1,
                    'province' => !empty($request->input('province')) ? $request->input('province') : 0,
                    'district' => !empty($request->input('district')) ? $request->input('district') : 0,
                    'tags' => $tags,
                    'vip' => 0,
                    'gender' => !empty($request->input('gender')) ? $request->input('gender') : '',
                    'date_end' => $request->input('deadline_submit_profile'),
                    'date_submit' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                    'created_at' => new \DateTime(),
                    //goi bán hàng
                    //phần mềm Y/C
                    'software_id' => !empty($request->input('software')) ? $request->input('software') : 0,
//                danh mục ngành nghề
                    'career_category_id' => $request->input('career_category_id'),
//                Địa chỉ
                    'address_work' => $request->input('address_work'),
                    'status_exam' => $status_exam,
                    'id_exam' => !empty($request->input('id_exam')) ? $request->input('id_exam') : 0,
                    'welfare' => $request->input('welfare'),
                    'count_updated_at' => 0
                ]);
            $string_career = Career::where('career_category_id', $request->input('career_category_id'))->value('career_category_name');
            $string_province = Province::where('province_id', $request->input('province'))->value('province_name');
            $title = $string_career . ' tại ' . $string_province;
            $slug = str_slug($string_career) . '-tai-' . str_slug($string_province) . '-' . $request->job_id;
            $update = $jobs->where('job_id', $request->job_id)->update([
                'job_code' => 'SKT' . $request->job_id,
                'title' => $title,
                'slug' => $slug
            ]);

            //gửi email hướng dẫn sử dụng chức năng của  nhà tuyển dụng
//            $send_email = MailConfigController::employer_create_job($employer->email);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollback();
            return response()->json([
                'status' => 400,
                'message' => 'Cập nhật việc làm thất bại việc làm thất bại, Vui lòng thử lại',
            ], 400);
        } finally {
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật việc làm thành công, Vui lòng chờ Admin duyệt tin của bạn',
            ], 200);
        }
    }

    public function update_dealine_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng này chỉ dành cho nhà tuyên dụng'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'job_id' => 'required'
        ], [
            'job_id.required' => 'Vui lòng chọn tin tuyển dụng'
        ]);
        if ($validation->fails()) {
            $massage = '';
            foreach ($validation->errors()->all() as $error) {
                $massage .= $error;
            }
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }
        try {
            DB::beginTransaction();
            $jobs_model = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user->id)->first();
            $job = $jobs_model->select('count_updated_at')->where('employer_id', $employer->employer_id)
                ->where('job_id', $request->job_id)
                ->first();
            $count_updated_at = 1;
            if ($job->count_updated_at > 0) {
                $count_updated_at = $count_updated_at + $job->count_updated_at;
            }
            $job_id = $jobs_model->where('employer_id', $employer->employer_id)
                ->where('job_id', $request->job_id)
                ->update([
                    'updated_at' => new \DateTime(),
                    'count_updated_at' => $count_updated_at
                ]);
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Đẩy tin tuyển dụng thành công',
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Đẩy tin tuyển dụng thất bại',
            ], 400);
            DB::rollback();
        } finally {
            return response()->json([
                'status' => 200,
                'message' => 'Đẩy tin tuyển dụng thành công',
            ], 200);
        }

    }

    public function delete_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng này chỉ dành cho nhà tuyên dụng'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'job_id' => 'required'
        ], [
            'job_id.required' => 'Vui lòng chọn tin tuyển dụng'
        ]);
        if ($validation->fails()) {
            $massage = '';
            foreach ($validation->errors()->all() as $error) {
                $massage .= $error;
            }
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }
        try {
            DB::beginTransaction();
            $jobs_model = new Job();
            $status_exam = 0;
            if (!empty($request->input('id_exam'))) {
                $status_exam = 1;
            }
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user->id)->first();
            $job = $jobs_model->select('count_updated_at')->where('employer_id', $employer->employer_id)
                ->where('job_id', $request->job_id)
                ->first();
            $count_updated_at = 1;
            if ($job->count_updated_at > 0) {
                $count_updated_at = $count_updated_at + $job->count_updated_at;
            }
            $job_id = $jobs_model->where('employer_id', $employer->employer_id)
                ->where('job_id', $request->job_id)
                ->delete();
            DB::commit();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa tin tuyển dụng thành công',
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Xóa tin tuyển dụng thất bại',
            ], 400);
            DB::rollback();
        } finally {
            return response()->json([
                'status' => 200,
                'message' => 'Xóa tin tuyển dụng thành công',
            ], 200);
        }

    }

    //ung vien ung tuyen voi job_id
    public function list_Job_Candidate_Employee(Request $request, $job_id)
    {
        try {
            try {
                $user = JWTAuth::toUser($request->token);
            } catch (\Exception $exception) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng kiểm tra lại token !'
                ], 400);
            }
            if ($user->role != 2) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Chức năng này chỉ dành cho nhà tuyên dụng'
                ], 400);
            }
            $job = Job::select(
                'job_id',
                'job_code',
                'id_exam',
                'title',
                'slug',
                'deadline_submit_profile',
                'date_submit'
            )
                ->where('job_id', $job_id)
                ->first();
            if (empty($job)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Công việc này bạn đã dừng ứng tuyển'
                ], 400);
            }
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id')->where('user_id', $user->id)->first();
            $job_model = New Job();
            //danh sach cong viec
            $list_jobs = $job_model::select(
                'employee_submit_job_facebook.*',
                'employees.employee_id',
                'employees.profile',
                'employees.employee_name',
                'employees.employee_slug',
                'employees.district',
                'employees.province',
                'province.province_name'
            )
                ->join('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', '=', 'jobs.job_id')
                ->leftJoin('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
                ->leftJoin('province', 'province.province_id', '=', 'employees.province')
                ->where('employee_submit_job_facebook.status_job', 1)
                ->where('jobs.status_select_job', 0)
                ->where('jobs.employer_id', $employer->employer_id)
                ->where('jobs.job_id', $job_id);
            if (!empty($request->input('id_status_submit'))) {
                $id_status_submit = $request->input('id_status_submit');
                $list_jobs = $list_jobs->whereIn('employee_submit_job_facebook.id_status_submit_job', $id_status_submit);
            }
            $list_jobs = $list_jobs->orderBy('jobs.job_id', 'desc');
            $list_jobs = $list_jobs->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');
            $total_employee = $list_jobs->count();
            $list_jobs = $list_jobs->get();
            $list_status = \App\Entity\Status_submit_job::getAll();
            foreach ($list_jobs as $id => $employee) {
                $list_jobs[$id]['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee->employee_id]);
                $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee->employee_id);
                if (!empty($check_show_employee)) {
                    $list_jobs[$id]['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee->employee_id]) . '?employer_id=' . $employer->employer_id;
                }
                foreach ($list_status as $status) {
                    $status_ho_so = 'Trạng thái';
                    if ($employee->id_status_submit_job == $status->id_status) {
                        $status_ho_so = $status->name_status;
                    }
                    $list_jobs[$id]['trang-thai-ho-so'] = $status_ho_so;
                }
                $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
                $district_name = '';
                if (!empty($list_district_name)) {
                    foreach ($list_district_name as $id_d => $district) {
                        $string_phay = '';
                        if ($id_d > 0) {
                            $string_phay = ' , ';
                        }
                        $district_name .= $string_phay . $district->district_name;
                    }
                }
                $list_jobs[$id]['district_name'] = $district_name;
            }
            return response()->json([
                'status' => 200,
                'message' => 'Danh sách ứng viên nộp hồ sơ',
                'job' => $job,
                'total_employee' => $total_employee,
                'list_jobs' => $list_jobs,
            ], 200);


            return view('site.jobs_site.list_cadidate_job', compact('list', 'list_jobs', 'job_id', 'job', 'total_employee'));


        } catch (\Exception $e) {
            return redirect(route('list_job_face'))->with('error', 'Ứng viên này không tồn tại');
        }
    }

    //danh sách trạng thái
    public function list_status_employee()
    {
        $list_status = \App\Entity\Status_submit_job::getAll();
        return response()->json([
            'status' => 200,
            'message' => 'Trạng thái ứng viên',
            'list_status' => $list_status,
        ], 200);
    }

    //cập nhật trạng thái ứng viên
    public function update_id_status_job(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 2) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng này chỉ dành cho nhà tuyên dụng'
            ], 400);
        }
        $submit_job_fb_id = $request->submit_job_fb_id;
        $id_status_submit_job = $request->id_status;


        $employee_submit = new Employee_submit_job_faacebook();
        $check_profile = $employee_submit->where('submit_job_fb_id', $submit_job_fb_id)->first();
        if (empty($check_profile)) {
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy hồ sơ này'
            ], 400);
        }
        //cập nhật trạng thái của hồ sơ đã nộp
        $update = $employee_submit->where('submit_job_fb_id', $submit_job_fb_id)->update([
            'id_status_submit_job' => $id_status_submit_job,
        ]);
        //xem hồ sơ thì thông báo cho ứng viên

        if ($id_status_submit_job == 1) {
            $job_submit = $employee_submit->where('submit_job_fb_id', $submit_job_fb_id)
                ->where('status_job', 1)
                ->first();
            $employee_email = Employee::where('employee_id', $job_submit->employee_id)->value('email');
            $mail = MailConfigController::send_email_view_profile_employee($job_submit->id_job_fb, $employee_email);
        }
        //nếu là hủy hồ sơ
        if ($id_status_submit_job == 4) {

            $submit_job_face = $employee_submit->select('*')->where('submit_job_fb_id', $submit_job_fb_id)->first();

            $emloyee_model = new Employee();
            $employee = $emloyee_model->select('employee_id', 'email', 'user_id')->where('employee_id', $submit_job_face->employee_id)->first();


            $job = Job::select('slug', 'title', 'job_id', 'employer_id')->where('job_id', $submit_job_face['id_job_fb'])->first();

            //job là nội dung công việc cần title ,slug
            //$email là email gửi thu
            MailConfigController::send_delete_file($job, $employee['email']);

            //gửi thông báo info den ứng viên
            $noti_model = new NotificationWindow();
            $link_noti = route('list_Jobs_Submit_Employee');
            $noti_insert_id = $noti_model->insertGetId([
                'title_noti' => 'Sanketoan.vn thông báo',
                'user_id' => $employee['user_id'],
                'employee_id' => $employee['employee_id'],
                'des_noti' => 'Nhà tuyển dụng đã loại hồ sơ của bạn khỏi tin tuyển dụng',
                'link_noti' => $link_noti,
                'created_at' => new \DateTime()
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Cập nhập trạng thái ứng viên thành công',
        ], 200);

    }

}
