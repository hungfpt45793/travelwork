<?php

namespace App\Http\Controllers\Api;

use App\Entity\Coin_history_employer;
use App\Entity\Coin_show_employee;
use App\Entity\Employee;
use App\Entity\Employee_business_type;
use App\Entity\Employee_career_categories;
use App\Entity\Employees_save_job_facebook;
use App\Entity\Employer_response_cv;
use App\Entity\Employer_select_response;
use App\Entity\Employer_select_response_cv;
use App\Entity\Forum_notification;
use App\Entity\Literacy;
use App\Entity\Employee_coins;
use App\Entity\Employee_district;
use App\Entity\Employee_experience;
use App\Entity\Employee_profile;
use App\Entity\Employee_specialize;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employee_upload_cv;
use App\Entity\Employer;
use App\Entity\Job;
use App\Entity\JobFacebook;
use App\Entity\Notification_employer;
use App\Entity\NotificationWindow;
use App\Entity\Province;
use App\Entity\Salary;
use App\Entity\Forum_post;
use App\Entity\Forum_minus_coin_user;
use App\Entity\Forum_post_comment;
use App\Entity\Teacher;
use App\Entity\User_forum_code_intro;
use App\Http\Controllers\Site\MailConfigController;
use App\Http\Controllers\Site\Upload_FileController;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
//use Illuminate\Validation\Validator;
use JWTAuth;
use App\Entity\User;
use Validator;
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


class EmployeeController extends Controller
{
    public function create_employee(Request $request)
    {
//        echo $request->input('email');die();
        // check xem là dữ liệu hợp lệ không
        $validation = $this->validateEmployee($request);
        if ($validation->fails()) {
            return response()->json([
                'status' => 404,
                'descript' => 'Dữ liệu không hợp lệ',
                'validation' => $validation->errors(),
            ]);
        }
        try {
            DB::beginTransaction();
//            Tạo tài khoản để login trong bang user
            $userWithPhone = $this->createUser($request);
            //Tạo ứng viên trong bảng employee
            $createEmployee = $this->createNewEmployee($request, $userWithPhone);
            // Đẩy thông tin lên getfly
//            $this->addNewCampaignGetfly($request);
            //Gửi email thông báo và kích hoạt tài khoản


            if ($createEmployee) {
                $profile_employee = 10;
                //cong điểm cho ứng viên
                $update_profile = Employee::where('user_id', $userWithPhone->id)->update([
                    'profile' => $profile_employee
                ]);
                //thêm vào bảng profile
                $employee_id = Employee::where('user_id', $userWithPhone->id)->value('employee_id');
                $insert_employee_profile = Employee_profile::insert([
                    'employee_id' => $employee_id,
                    'profile_info' => 10,
                    'created_at' => new \DateTime()
                ]);

                MailConfigController::send_email_employee_confirm($userWithPhone);
                //cap nhat ti lệ hoàn thành hồ sơ

                DB::commit();
                return response()->json([
                    'status' => 200,
                    'descript' => 'Bạn đã đăng kí tài khoản ứng viên thành công',
                ], 200);
            }
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'descript' => 'Bạn đã đăng kí tài khoản ứng viên thất bại',
            ], 400);
        }
    }

    public function tax_code($tax_code)
    {

        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $response = file_get_contents('https://thongtindoanhnghiep.co/api/company/' . $tax_code, false, stream_context_create($arrContextOptions));
//        return response()->json([
//            'status' => 200,
//            'descript' => 'Bạn đã đăng kí tài khoản ứng viên thành công',
//        ], 200);
        return $response;

    }


    // check điều kiện submit form
    private function validateEmployee($request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users|unique:employees|unique:employer|unique:teacher,teacher_email|email',
            'password' => 'required|min:8',
            'name' => 'required',
            'phone' => 'required',
            'career_category_id' => 'required',
            'province' => 'required',
            'district' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'email.email' => 'Vui lòng nhập đúng định dạng email.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'name.required' => 'Họ và tên không được để trống',
            'career_category_id.required' => 'Công việc cần tìm không được để trống',
            'province.required' => 'Tỉnh / thành phố không được để trống',
            'district.required' => 'Quận / huyện không được để trống',

        ]);
        return $validation;
    }

    //dang ki user của bang user
    private function createUser($request)
    {
        $userModel = new User();
        $insert_id = $userModel->insertGetId([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->has('phone') ? $request->input('phone') : '',
            'role' => 1,
            'status_email_account' => 0,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        $link_confirm_account = str_random(10) . $insert_id;
        $update = $userModel->where('id', $insert_id)->update([
            'link_confirm_account' => $link_confirm_account
        ]);
        $userWithPhone = $userModel->select('name', 'email', 'password', 'phone', 'status_email_account', 'id', 'link_confirm_account')->where('id', $insert_id)->first();
        return $userWithPhone;
    }


//    tao mới ưng viên
    private function createNewEmployee($request, $userWithPhone)
    {
        try {
            $employeeId = Employee::insertGetId([
                'employee_name' => $userWithPhone['name'],
                'phone' => $userWithPhone['phone'],
                'email' => $userWithPhone['email'],
                'user_id' => $userWithPhone['id'],
                'status' => 0,
                'salary_id' => 6,
                'career_category_id' => $request->input('career_category_id'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]);
            //danh sách nhóm công việc
            if (!empty($request->input('career_category_id'))) {
                $insert_career = Employee_career_categories::insert([
                    'employee_id' => $employeeId,
                    'career_category_id' => $request->input('career_category_id'),
                    'created_at' => new \DateTime()
                ]);
            }
            //danh sách quận / huyện
            if (!empty($request->input('district'))) {
                $insert_dis = Employee_district::insert([
                    'employee_id' => $employeeId,
                    'district_id' => $request->input('district'),
                    'created_at' => new \DateTime()
                ]);
            }
            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

//    dung cho website
    public function web_list_employee($limit)
    {
        if (empty($limit)) {
            $limit = 10;
        }
        $employee_model = new Employee();
        $list_employee = $employee_model->select('employees.employee_id', 'employees.employee_name', 'employees.employee_image', 'employees.updated_at as date_update', 'employees.created_at as date_create', 'employees.status', 'employees.profile', 'province_name', 'district_name', 'career_category_name', 'experience.experience_name', 'salary.description as salary_description');
        $list_employee = $list_employee->leftJoin('province', 'province.province_id', '=', 'employees.province');
        $list_employee = $list_employee->leftJoin('district', 'district.district_id', '=', 'employees.district');
        $list_employee = $list_employee->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id');
        $list_employee = $list_employee->leftJoin('salary', 'salary.salary_id', 'employees.salary_id');
        $list_employee = $list_employee->leftJoin('experience', 'experience.experience_id', 'employees.experience_id');
        $list_employee = $list_employee->whereNotNull('employees.email');
        $list_employee = $list_employee->orderBy('employees.salary_id', 'desc');
        $list_employee = $list_employee->limit($limit)
            ->get();

        if (empty($list_employee)) {
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ], 404);
        }
        return response([
            'status' => 200,
            'list_employee' => $list_employee,

        ], 200);
    }

    public function list_employee(Request $request)
    {
        $employees = new Employee();
        //sap xep theo so tien
        $list_employee = $employees->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.employee_level_id',
            'employees.time_to_work',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.user_id',
            'employees.status',
            'employees.views',
            'employees.marry',
            'employees.profile',
            'province.province_name',
            'salary.description as salary_description', 'experience.experience_name'
        )
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('experience', 'experience.experience_id', 'employees.experience_id')
            ->where('employees.status_employee', 1)
            ->where('employees.show_hidden_profile', 0);
        $list_employee = $list_employee->whereNotNull('employees.email');
        $list_employee = $list_employee->orderBy('employees.updated_at', 'desc');
        $list_employee = $list_employee->paginate(20);
        $message = 'Danh sách ứng viên';

        foreach ($list_employee as $id => $employee) {
            $list_employee[$id]['employee_image'] = !empty($employee->employee_image) ? asset($employee->employee_image) : '';
            $employee_level = \App\Entity\Literacy::get_literacy_name($employee->employee_level_id);
            $list_employee[$id]['trinh-do'] = !empty($employee_level->literacy_name) ? $employee_level->literacy_name : 'Đang cập nhật';
            //danh sach quan huyen cua ung vien
            $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
            $list_employee[$id]['quan-huyen'] = $list_district_name;
            //danh sach cong viec can tim
            $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
            $list_employee[$id]['cong-viec-can-tim'] = $list_career_name;
            //kinh nghiem lam viec
            $date_day = date_create();
            $year_day = date_format($date_day, "Y") - $employee->time_to_work;
            $list_employee[$id]['kinh-nghiem-lam-viec'] = $year_day;
            //kinh nghiem trong linh vuc
            $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
            $list_employee[$id]['kinh-nghiem-trong-linh-vuc'] = $list_business_name;
            $list_employee[$id]['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee->employee_id]);
            $list_employee[$id]['status_show_employee'] = 0;
            $list_employee[$id]['message_status_show_employee'] = 'Chưa xem';
            $employer_id = 0;
            if (!empty($request->token)) {
                try {
                    $user = JWTAuth::toUser($request->input('token'));
                    if ($user->role == 2) {
                        $employer_id = Employer::where('user_id', $user->id)->value('employer_id');
                    }
                    $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer_id, $employee->employee_id);
                    if (!empty($check_show_employee)) {
                        $list_employee[$id]['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee->employee_id]) . '?employer_id=' . $employer_id;
                        $list_employee[$id]['status_show_employee'] = 1;
                        $list_employee[$id]['message_status_show_employee'] = 'Đã xem';
                    }
                } catch (\Exception $exception) {
                }
            }
        }

        if (empty($list_employee)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        return response([
            'status' => 200,
            'message' => $message,
            'employer_id' => $employer_id,
            'list_employee' => $list_employee
        ], 200);
    }

    public function get_fillter_search_employee(Request $request)
    {

    }

    public function search_employee(Request $request)
    {

        $employees = new Employee();
        //sap xep theo so tien
        $list_employee = $employees->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.employee_level_id',
            'employees.time_to_work',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.status',
            'employees.views',
            'employees.marry',
            'employees.user_id',
            'employees.profile',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
//            //join với công việc cần tìm
            ->where('employees.status_employee', 1)
            ->where('employees.show_hidden_profile', 0);
        $list_employee = $list_employee->whereNotNull('employees.email');
        if (!empty($request->input('province'))) {
            $list_employee = $list_employee->where('employees.province', $request->input('province'));
        }
        if (!empty($request->input('career_category_id'))) {
//            echo $request->input('career_category_id');
            $list_employee = $list_employee->join('employee_career_categories', 'employee_career_categories.employee_id', '=', 'employees.employee_id');
            $career_category_id = $request->input('career_category_id');
            $list_employee = $list_employee->where('employee_career_categories.career_category_id', $career_category_id);
        }
        if (!empty($request->input('district_id'))) {
            //            //join với quận huyện
            $list_employee = $list_employee->join('employee_district', 'employee_district.employee_id', '=', 'employees.employee_id');
            $list_employee = $list_employee->join('district', 'district.district_id', '=', 'employee_district.district_id');
            $district_id = $request->input('district_id');
            $list_employee = $list_employee->where('employee_district.district_id', $district_id);
        }
        if (!empty($request->input('salary_id'))) {
            $salary_id = $request->input('salary_id');
            $list_employee = $list_employee->where('employees.salary_id', $salary_id);
        }
        if (!empty($request->input('word'))) {
            $word = $request->input('word');
            $list_employee = $list_employee->where('employees.employee_name', 'like', '%' . $word . '%');
        }
        if (!empty($request->input('experience_id'))) {
            $experience_id = $request->input('experience_id');
            $list_employee = $list_employee->where('employees.experience_id', $experience_id);
        }
        if (!empty($request->input('profile'))) {
            $profile = $request->input('profile');
            $array_profile = explode(",", $profile);
            $list_employee = $list_employee->whereBetween('employees.profile', [$array_profile[0], $array_profile[1]]);
        }
        if ($request->has('time_to_work')) {
            $date_home = date_create();
            $date_home_year = date_format($date_home, "Y");
            $time_to_work = $request->input('time_to_work');
            $time_ex = $date_home_year - $time_to_work;
//            echo $time_ex;die();
            if ($time_to_work >= 6) {
                $list_employee = $list_employee->where('employees.time_to_work', '<=', $time_ex);
            } else {
                $list_employee = $list_employee->where('employees.time_to_work', '<=', $time_ex);
                $list_employee = $list_employee->orderBy('employees.time_to_work', 'desc');
            }
        }
        $list_employee = $list_employee->distinct();
        $list_employee = $list_employee->orderBy('employees.updated_at', 'desc');
        $count = $list_employee->count();
        $list_employee = $list_employee->paginate(20);
        $list_employee->appends(request()->query());
        $employer_id = 0;
        $message = 'Danh sách tìm kiếm ứng viên';
        if (!empty($request->token)) {
            try {
                $user = JWTAuth::toUser($request->input('token'));
                if ($user->role == 2) {
                    $employer_id = Employer::where('user_id', $user->id)->value('employer_id');
                }
            } catch (\Exception $exception) {
                $message = 'Vui lòng kiểm tra lại token đăng nhập NTD';
            }
        }
        foreach ($list_employee as $id => $employee) {
            $list_employee[$id]['employee_image'] = !empty($employee->employee_image) ? asset($employee->employee_image) : '';
            $employee_level = \App\Entity\Literacy::get_literacy_name($employee->employee_level_id);
            $list_employee[$id]['trinh-do'] = !empty($employee_level->literacy_name) ? $employee_level->literacy_name : 'Đang cập nhật';
            //danh sach quan huyen cua ung vien
            $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
            $list_employee[$id]['quan-huyen'] = $list_district_name;
            //danh sach cong viec can tim
            $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
            $list_employee[$id]['cong-viec-can-tim'] = $list_career_name;
            //kinh nghiem lam viec
            $date_day = date_create();
            $year_day = date_format($date_day, "Y") - $employee->time_to_work;
            $list_employee[$id]['kinh-nghiem-lam-viec'] = $year_day;
            //kinh nghiem trong linh vuc
            $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
            $list_employee[$id]['kinh-nghiem-trong-linh-vuc'] = $list_business_name;
            $list_employee[$id]['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee->employee_id]);
            $list_employee[$id]['status_show_employee'] = 0;
            $list_employee[$id]['message_status_show_employee'] = 'Chưa xem';
            if(!empty($employer_id))
            {
                $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer_id, $employee->employee_id);
                if (!empty($check_show_employee)) {
                    $list_employee[$id]['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee->employee_id]) . '?employer_id=' . $employer_id;
                    $list_employee[$id]['status_show_employee'] = 1;
                    $list_employee[$id]['message_status_show_employee'] = 'Đã xem';
                }
            }

        }


        if (empty($list_employee)) {
            return response([
                'status' => 404,
                'message' => 'Không có công việc nào'
            ], 404);
        }
        return response([
            'status' => 200,
            'message' => $message,
            'employer_id' => $employer_id,
            'list_employee' => $list_employee

        ], 200);
    }

    public function detail_employee($employee_id, Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng đăng nhập tài khoản nhà tuyển dụng dễ xem thông tin ứng viên'
            ], 400);
        }


        $employee_model = new Employee();
        $employee = $employee_model->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.email as employees_email',
            'employees.phone as employees_phone',
            'employees.employee_level_id',
            'employees.time_to_work',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.user_id',
            'employees.status',
            'employees.views',
            'employees.marry',
            'employees.gender',
            'employees.address',
            'employees.birthday',
            'employees.profile',
            'province.province_name',
            'salary.description as salary_description', 'experience.experience_name'
        )
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('experience', 'experience.experience_id', 'employees.experience_id')
//            ->where('employees.status_employee', 1)
//            ->where('employees.show_hidden_profile', 0)
            ->where('employee_id', $employee_id);
        $employee = $employee->first();
        if (empty($employee)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        $employee['employee_image'] = !empty($employee->employee_image) ? asset($employee->employee_image) : '';
        $employee_level = \App\Entity\Literacy::get_literacy_name(!empty($employee->employee_level_id) ? $employee->employee_level_id : 0);
        $employee['trinh-do'] = !empty($employee_level->literacy_name) ? $employee_level->literacy_name : 'Đang cập nhật';

        //danh sach quan huyen cua ung vien
        $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
        $employee['quan-huyen'] = $list_district_name;
        //danh sach cong viec can tim
        $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        $employee['cong-viec-can-tim'] = $list_career_name;
        //kinh nghiem lam viec
        $date_day = date_create();
        $year_day = date_format($date_day, "Y") - $employee->time_to_work;
        $employee['kinh-nghiem-lam-viec'] = $year_day;
        //kinh nghiem trong linh vuc
        $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
        $employee['kinh-nghiem-trong-linh-vuc'] = $list_business_name;
        $employee['email'] = '*********';
        $employee['phone'] = '*********';

        $employer_id = 0;
        $employee['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee_id]);
        $employee['linh-cv'] = '';
        $token = $request->input('token');
        $message = 'Thông tin ứng viên và token đăng nhập NTD xem thông tin ứng viên';
        $employee['status_show_employee'] = 0;
        $employee['message_status_show_employee'] = 'Chưa xem';
        $employer_id = 0;
        if (!empty($token)) {
            try {
                $user = JWTAuth::toUser($request->input('token'));
                if ($user->role == 2) {
                    $employer_id = Employer::where('user_id', $user->id)->value('employer_id');
                    $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer_id, $employee_id);
                    if (!empty($check_show_employee)) {
                        $employee['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee_id]) . '?employer_id=' . $employer_id;
                        $employee['status_show_employee'] = 1;
                        $employee['message_status_show_employee'] = 'Đã xem';
                        $employee['email'] = $employee['employees_email'];
                        $employee['phone'] = $employee['employees_phone'];
                        $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee_id);
                        if (!empty($cv_upload->employee_cv_status)) {
                            $employee['linh-cv'] = asset($cv_upload->employee_link_cv);
                        } else {
                            $user_id = Employee::where('employee_id', $employee->employee_id)->value('user_id');
                            $employee['linh-cv'] = route('employer_exportpdf_cv_user_id', ['user_id' => $user_id]);
                        }
                    }

                }
            } catch (\Exception $exception) {
                $message = 'Vui lòng kiểm tra lại token đăng nhập NTD';
//                return response()->json([
//                    'status' => 400,
//                    'message' => 'Vui lòng kiểm tra lại token !'
//                ], 400);
            }
        }
        return response([
            'status' => 200,
            'message' => $message,
            'employer_id' => $employer_id,
            'employee' => $employee,
        ], 200);
    }

    public function detail_employee_submit($employee_id, Request $request)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.email as employees_email',
            'employees.phone as employees_phone',
            'employees.employee_level_id',
            'employees.time_to_work',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.user_id',
            'employees.status',
            'employees.views',
            'employees.marry',
            'employees.gender',
            'employees.address',
            'employees.birthday',
            'employees.profile',
            'province.province_name',
            'salary.description as salary_description', 'experience.experience_name'
        )
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('experience', 'experience.experience_id', 'employees.experience_id')
//            ->where('employees.status_employee', 1)
//            ->where('employees.show_hidden_profile', 0)
            ->where('employee_id', $employee_id);
        $employee = $employee->first();
        if (empty($employee)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        $employee['employee_image'] = !empty($employee->employee_image) ? asset($employee->employee_image) : '';
        $employee_level = \App\Entity\Literacy::get_literacy_name(!empty($employee->employee_level_id) ? $employee->employee_level_id : 0);
        $employee['trinh-do'] = !empty($employee_level->literacy_name) ? $employee_level->literacy_name : 'Đang cập nhật';

        //danh sach quan huyen cua ung vien
        $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
        $employee['quan-huyen'] = $list_district_name;
        //danh sach cong viec can tim
        $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        $employee['cong-viec-can-tim'] = $list_career_name;
        //kinh nghiem lam viec
        $date_day = date_create();
        $year_day = date_format($date_day, "Y") - $employee->time_to_work;
        $employee['kinh-nghiem-lam-viec'] = $year_day;
        //kinh nghiem trong linh vuc
        $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
        $employee['kinh-nghiem-trong-linh-vuc'] = $list_business_name;
        $employer_id = 0;
        $employee['link_preview_cv_full'] = route('link_preview_cv_full', ['employee_id' => $employee_id]);
        $employee['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee_id]);
        $employee['linh-cv'] = '';
        $token = $request->input('token');
        $message = 'Thông tin ứng viên và token đăng nhập NTD xem thông tin ứng viên';
        $employee['status_show_employee'] = 0;
        $employee['message_status_show_employee'] = 'Chưa xem';
        if (!empty($token)) {
            try {
                $user = JWTAuth::toUser($request->input('token'));
                if ($user->role == 2) {
                    $employer_id = Employer::where('user_id', $user->id)->value('employer_id');
                    $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer_id, $employee_id);
                    if (!empty($check_show_employee)) {
                        $employee['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee_id]) . '?employer_id=' . $employer_id;
                        $employee['status_show_employee'] = 1;
                        $employee['message_status_show_employee'] = 'Đã xem';
                        $employee['email'] = $employee['employees_email'];
                        $employee['phone'] = $employee['employees_phone'];
                        $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee_id);
                        if (!empty($cv_upload->employee_cv_status)) {
                            $employee['linh-cv'] = asset($cv_upload->employee_link_cv);
                        } else {
                            $user_id = Employee::where('employee_id', $employee->employee_id)->value('user_id');
                            $employee['linh-cv'] = route('employer_exportpdf_cv_user_id', ['user_id' => $user_id]);
                        }
                    }

                }
            } catch (\Exception $exception) {
                $message = 'Vui lòng kiểm tra lại token đăng nhập NTD';
//                return response()->json([
//                    'status' => 400,
//                    'message' => 'Vui lòng kiểm tra lại token !'
//                ], 400);
            }
        }
        return response([
            'status' => 200,
            'message' => $message,
            'employee' => $employee,
        ], 200);
    }

    //hien thi thông tin
    public function editEmployee(Request $request)
    {

//        echo $token;
//        print_r($user);die();
        try {
            $token = $request->input('token');
            $user = JWTAuth::toUser($request->input('token'));
            if (empty($token) || empty($user)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng kiểm tra lại token.'
                ], 400);
            }
            $employee = Employee::select(
                'employees.*', 'province.province_name', 'district.district_name', 'career_categories.career_category_name', 'salary.description as salary_description', 'literacies.literacy_name', 'experience.experience_name'
            )
//            $employee = Employee::select(
//                'employee_id',
//                'employee_name',
//                'phone',
//                'province',
//                'email',
//                'district',
//                'address',
//                'experience',
//                'salary_id',
//                'literacy',
//                'information_verifier',
//                'status',
//                'user_id',
//                'career_category_id',
//                'employee_image',
//                'gender', // 0: chưa xác định. 1: nữ  2. nam
//                'birthday',
//                'marry', // 0: độc thân   1: đã kết hôn
//                'cmt',
//                'cmt_date',
//                'cmt_local',
//                //kinh nghiệm
//                'experience_id',
//                'profile',
//                //mã giới thiệu từ ntd nếu có
//                'code_intro',
////                trình dộ
//                'employee_level_id'
//            )
                ->leftJoin('province', 'province.province_id', '=', 'employees.province')
                ->leftJoin('district', 'district.district_id', '=', 'employees.district')
                ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id')
                ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
                ->leftJoin('experience', 'experience.experience_id', '=', 'employees.experience_id')
                ->leftJoin('literacies', '.literacies.literacy_id', '=', 'employees.employee_level_id')
                ->where('employees.user_id', $user->id)
                ->first();
            //trinh do chuyen mon
            $specialize = Employee_specialize::select(
                'specialize_id',
                'star_specialize_time',
                'end_specialize_time',
                'school',
                'majors',
                'leve',
                'specialize_status',
                'employee_id'// địa chỉ tạm trú
            )->where('employee_id', $employee->employee_id)
                ->orderBy('specialize_id', 'asc')
                ->get();
//            Kinh nghiệm làm việc
            $experience = Employee_experience::select('experience_id',
                'star_working_time',
                'end_working_time',
                'company',
                'position',
                'des_position',
                'employee_id')
                ->where('employee_id', $employee->employee_id)
                ->orderBy('experience_id', 'asc')
                ->get();

            if (empty($employee)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'employee' => $employee,
                'specialize' => $specialize,
                'experience' => $experience,
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Token đã hết hạn .Vui lòng đăng nhập lại.'
            ], 404);
        }
    }

///de sau
    public function updateEmployee(Request $request)
    {
        $edit_validation = $this->editvalidateEmployee($request);
        if ($edit_validation->fails()) {
            return response()->json([
                'status' => 404,
                'message' => 'Dữ liệu không hợp lệ',
                'validation' => $edit_validation->errors(),
            ], 404);
        }
        try {
            $token = $request->input('token');
            $user = JWTAuth::toUser($request->input('token'));
            $updateem_ployee = Employee::where('user_id', $user->id)->update([
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
                'employee_level_id' => $request->input('employee_level_id'),
                'experience_id' => $request->input('experience_id'),
                'address_stay' => $request->input('address_stay'),
                'salary_id' => $request->input('salary_id'),
                'status' => $request->input('status'),
                'code_intro' => $request->input('code_intro'),
                'updated_at' => new \DateTime()
            ]);
            if ($request->hasFile('images')) {
                $file = $request->images;
                $maxsize = 10500000;  //khoang 10Mb
                if ($file->getSize() >= $maxsize) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'File quá lớn , không thể upload',
                    ]);
                }
                $name_file = Ultility::createSlug($file->getClientOriginalName()) . $user->id . '.' . $file->getClientOriginalExtension();
                $type = $file->getClientOriginalExtension();
                $imgleEmployee = Employee::select('user_id', 'employee_image')->where('user_id', $user->id)->first();
                if (file_exists($imgleEmployee->employee_image)) {
                    unlink(public_path($imgleEmployee->link_dowload_voucher));
                }
                $file->move('api_image', $name_file);
            }
            //cap nhat user
            $user_model = new User();
            $update = $user_model->where('id', $user->id)->update([
                'name' => $request->input('employee_name'),
                'phone' => $request->input('phone'),
            ]);

            //cap nhat ti lệ hoàn thành hồ sơ
            $update = \App\Entity\Employee::get_user_id_Profile($user->id);
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông tin ứng viên thành công',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 404,
                'message' => 'Cập nhật thông tin ứng viên thất bại',
            ], 404);
        }

    }

    private function editvalidateEmployee($request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'career_category_id' => 'required',
            'province' => 'required',
            'district' => 'required',
            'birthday' => 'required|date_format:"Y-m-d"',
            'gender' => 'required',
            'images' => 'required',
            'address' => 'required',
            'salary_id' => 'required',
            'employee_level_id' => 'required',
            'experience_id' => 'required',
            'token' => 'required',
        ], [
            'email.email' => 'Vui lòng nhập đúng định dạng email.',
            'name.required' => 'Họ và tên không được để trống',
            'career_category_id.required' => 'Công việc cần tìm không được để trống',
            'province.required' => 'Tỉnh / thành phố không được để trống',
            'district.required' => 'Quận / huyện không được để trống',
            'birthday.required' => 'Ngày tháng năm sinh không được để trống',
            'birthday.date_format' => 'Vui lòng nhập đúng định dạng Y-m-d',
            'gender.required' => 'Giới tính không được để trống',
            'images.required' => 'Giới tính không được để trống',
            'address.required' => 'Địa chỉ không được để trống',
            'salary_id.required' => 'Mức lương không được để trống',
            'employee_level_id.required' => 'Trình độ không được để trống',
            'experience_id.required' => 'Kinh nghiệm không được để trống',
            'token.required' => 'Vui lòng truyền token lên để xác nhận ứng viên',
        ]);
        return $validation;
    }

    public function submitEmployee(Request $request, $job_id, $status)
    {

        if (empty($request->token)) {
            return response()->json([
                'status' => '400',
                'message' => 'Vui lòng đăng nhập trước khi nộp hồ sơ.'
            ], 400);
        }
//        $status  = 0; la tin chuyen kiểm duyệt hay là tin facebook
//        $status  = 1; là tin đã kiểm duyệt la tin nha tuyển dụng
//        try {
        $user = JWTAuth::toUser($request->token);
        $employee = Employee::select('employee_id',
            'employee_name',
            'phone',
            'province',
            'email',
            'district',
            'status_employee',
            'user_id'
        )->where('user_id', $user->id)
            ->first();
        if (empty($employee['status_employee'])) {
            return response()->json([
                'status' => 400,
                'employee' => $employee,
                'message' => 'Hồ sơ của bạn chưa dầy đủ thông tin , vui lòng cập nhật thêm thông tin hồ sơ!',
            ], 400);
        }
        $empoyee_submit_job = new Employee_submit_job_faacebook();
        $total_submit_job = $empoyee_submit_job->select('*')
            ->where('employee_id', $employee->employee_id)
            ->where('id_job_fb', $job_id)
            ->where('status_job', $status)
            ->count();
        if (!empty($total_submit_job)) {
            return response()->json([
                'status' => 400,
                'message' => 'Bạn đã nộp hồ sơ cho công việc này rồi!',
            ], 400);
        }
        if ($status == 0) {
            $job_facebook = new JobFacebook();
            $job_facebook = $job_facebook->select('*')
                ->where('job_facebook_id', $job_id)
                ->first();
            //thông tin ung vien
//                gủi email thông báo cho ugn vien
            if (!empty($job_facebook)) {
                if ($total_submit_job < 1) {
                    $insert = $empoyee_submit_job->insert([
                        'employee_id' => $employee->employee_id,
                        'id_job_fb' => $job_id,
                        'status_job' => $status,
                        'day_submit_job' => new \DateTime(),
                        'created_at' => new \DateTime(),
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Bạn đã ứng tuyển công việc này rồi ! Vui lòng chờ phản hồi của nhà tuyển dụng !',
                    ], 400);
                }
                MailConfigController::send_submit_job_fb_email(1, $job_facebook, $employee, $employee->email, 0);
//                $this->send_submit_job_fb_email(1,$job_facebook,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
                MailConfigController::send_submit_job_fb_email(2, $job_facebook, $employee, $job_facebook->email, 0);
//                $this->send_submit_job_fb_email(2,$job_facebook,$emplo,$job_facebook->email);
                //gửi thông báo info den ứng viên
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Không tồn tại tin tuyển dụng này',
                    'status' => '0 là tin chưa kiểm duyệt 1 là tin đã kiểm duyệt',
                    'note' => 'Kiểm tra lại status của tin',
                ], 400);
            }

        } //công viec NTD
        elseif ($status == 1) {
            $job = new Job();
            $job = $job->select('*')->where('job_id', $job_id)->first();
            if (!empty($job)) {
                if ($total_submit_job < 1) {
                    $insert = $empoyee_submit_job->insert([
                        'employee_id' => $employee->employee_id,
                        'id_job_fb' => $job_id,
                        'status_job' => $status,
                        'day_submit_job' => new \DateTime(),
                        'created_at' => new \DateTime(),
                    ]);
                } else {
                    return response()->json([
                        'status' => 400,
                        'message' => 'Bạn đã ứng tuyển công việc này rồi ! Vui lòng chờ phản hồi của nhà tuyển dụng !',
                    ], 400);
                }
                $employer = new Employer();
                $employer = $employer->select('employer_id', 'email', 'user_id')->where('employer_id', $job->employer_id)->first();
                //                gủi email thông báo cho ugn vien
                MailConfigController::send_submit_job_email(1, $job, $employee, $employee->email, 1);
//                $this->send_submit_job_email(1,$job,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
                MailConfigController::send_submit_job_email(2, $job, $employee, $employer->email, 1);
//                $this->send_submit_job_email(2,$job,$emplo,$employer->email);
                //gửi thông báo info den ứng viên
                //gửi thông báo info den ứng viên
                $noti_model = new Notification_employer();
                $link_noti = route('list_Job_Candidate_Employee');
                $noti_insert = $noti_model->insert([
                    'title_noti' => 'Sanketoan.vn thông báo',
                    'user_id' => $employer->user_id,
                    'employee_id' => $employee->employee_id,
                    'job_id' => $job_id,
                    'des_noti' => 'Có ứng viên nộp hồ sơ với công việc ' . $job->title,
                    'link_noti' => $link_noti,
                    'type_noti' => 'employer',
                    'created_at' => new \DateTime()
                ]);
//                    gui api thong bao tren mobile
                $api_push_noti = new NotificationMobileController();
                $title = 'Sàn kế toán thông báo';
                $body = 'Công việc' . $job->title . ' trên Sàn kế toán đã có ứng viên ứng tuyển';
                $type = 'employer';
                $note = 'Ứng viên trên  sanketoan $value đã id của ứng viên';
                $value = $employee->employee_id;
                $to = $employer->user_id;
                $send_noti = $api_push_noti->pushNotification($title, $body, $to, $type, $note, $value);

            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'Không tồn tại tin tuyển dụng này',
                    'status' => '0 là tin chưa kiểm duyệt 1 là tin đã kiểm duyệt',
                    'note' => 'Kiểm tra lại status của tin',
                ], 400);
            }


        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng chọn đúng trạng thái tin !',
                'status' => '0 là tin chưa kiểm duyệt 1 là tin đã kiểm duyệt'
            ], 400);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Nộp hồ sơ ứng tuyển thành công',
        ], 200);
//        } catch (\Exception $e) {
//            return response()->json([
//                'status' => 400,
//                'message' => 'Có lỗi xảy ra ! Vui lòng thử lại sau !',
//                'note' => 'Kiểm tra lại token có thể token đã hết hạn , hoặc token sai',
//            ], 400);
//        }
    }

    public function noti_updateEmployee(Request $request)
    {
        try {
            $token = $request->input('token');
            $user = JWTAuth::toUser($request->input('token'));
            if (empty($token) || empty($user)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Vui lòng kiểm tra lại token.'
                ], 400);
            }
            $employee = Employee::select(
                'employee_id',
                'user_id',
                'profile'
            )->where('user_id', $user->id)
                ->first();
            if (empty($employee)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Bạn cần đăng nhập để có thể xem thông tin của mình.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'employee' => $employee,
            ], 200);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Token đã hết hạn .Vui lòng đăng nhập lại.'
            ], 404);
        }
    }

    //luu viecj lam
    public function employee_save_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'job_id' => 'required',
        ], [
            'job_id.required' => 'Vui lòng chọn công việc',
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
        $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
        $save_job_fb = new Employees_save_job_facebook();
        $insert_id = $save_job_fb->insertGetId([
            'id_job_fb' => $request->input('job_id'),
            'employee_id' => $employee_id,
            'status_job' => 1,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
        if (empty($insert_id)) {
            return response()->json([
                'status' => 404,
                'message' => 'Lưu việc làm không thành công'
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Lưu việc làm thành công',
        ], 200);


    }
    //huy luu viecj lam
    public function remove_employee_save_jobs(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'job_id' => 'required',
        ], [
            'job_id.required' => 'Vui lòng chọn công việc',
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
        $employee_id = Employee::where('user_id', $user->id)->value('employee_id');
        $save_job_fb = new Employees_save_job_facebook();

        $delete = $save_job_fb->where('id_job_fb',$request->input('job_id'))
            ->where('employee_id',$employee_id)
            ->where('status_job',1)
            ->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Hủy lưu việc làm thành công',
        ], 200);


    }

    public function get_info_employee($employee_id)
    {
        $employee = Employee::select('employees.employee_id',
            'employees.employee_image',
            'employees.user_id',
            'users.id',
            'users.email',
//            'users.password',
            'users.phone',
            'users.role',
            'users.name'
        )->join('users', 'users.id', 'employees.user_id')
            ->where('users.role', 1)
            ->where('employees.employee_id', $employee_id)
            ->first();
        return response()->json([
            'status' => 200,
            'employee' => $employee,
        ], 200);
    }

    public function update_employee_user(Request $request)
    {

        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'career_category_id' => 'required',
            'time_to_work' => 'required'
        ], [
            'name.required' => 'Họ và tên  không được bỏ trống ,',
            'phone.required' => 'Số điện thọai  không được bỏ trống ,',
            'province_id.required' => 'Vui lòng chọn tỉnh / thành phố ,',
            'district_id.required' => 'Vui lòng chọn quận / huyện ,',
            'career_category_id.required' => 'Vui lòng chọn vị trí công việc ,',
            'time_to_work.required' => 'Năm bắt đầu làm việc không được để trống ,'
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
        $year_day = date("Y");
        $ex_word = $year_day - $request->time_to_work;
        if ($request->time_to_work > $year_day || $ex_word > 50) {
            return response()->json([
                'error' => 400,
                'message' => 'Năm bắt đầu làm việc không thể lớn hơn năm hiện tại và không được quá 50 năm kinh nghiệm làm việc ',
            ], 400);
        }
        $employee = Employee::select('*')->where('user_id', $user->id)->first();
        $link_image = !empty($employee->employee_image) ? $employee->employee_image : '';
        if ($request->hasFile('image')) {
            $upload = new Upload_FileController();
            $link_image = $upload->api_upload_image_employee($employee->email, $employee->user_id, $request);
            if (empty($link_image)) {
                return response()->json([
                    'error' => 400,
                    'message' => 'Vui lòng nhập dịnh đạng image.',
                ], 400);
            }
        }
//        try {
            $update = Employee::where('user_id', $user->id)->update([
                'employee_name' => !empty($request->input('name')) ? $request->input('name') : '',
                'phone' => $request->input('phone'),
                'employee_image' => $link_image,
                'province' => $request->province_id,
                'address' => $request->address,
                'time_to_work' => $request->time_to_work,
                'status' => !empty($request->status) ? $request->status : 0,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $employeeId = $employee->employee_id;
            $employee_slug = str_slug($request->input('name')) . '-' . $employeeId;
            $update = Employee::where('employee_id', $employeeId)->update([
                'employee_slug' => $employee_slug
            ]);
            //danh sách nhóm công việc
            if (!empty($request->input('career_category_id'))) {
                $list_array_career = $request->input('career_category_id');
                //xoa du lieuj cữ
                $delete_carerr = Employee_career_categories::where('employee_id', $employeeId)->delete();
                foreach ($list_array_career as $career) {
                    $insert_career = Employee_career_categories::insert([
                        'employee_id' => $employeeId,
                        'career_category_id' => $career,
                        'created_at' => new \DateTime()
                    ]);
                }

            }
            //danh sách quận / huyện
            if (!empty($request->input('district_id'))) {
                $list_array_district = $request->input('district_id');
                //xoa du lieuj cữ
                $delete_carerr = Employee_district::where('employee_id', $employeeId)->delete();
                foreach ($list_array_district as $district) {
                    $insert_dis = Employee_district::insert([
                        'employee_id' => $employeeId,
                        'district_id' => $district,
                        'created_at' => new \DateTime()
                    ]);
                }
            }

            $employee_model = new Employee();
            $profile_info = $employee_model->get_profile_info($user->id);
            $profile_course = $employee_model->get_profile_course($user->id);

            $profile_employee = $profile_info + $profile_course;
            //cong điểm cho ứng viên
            $update_profile = Employee::where('user_id', $user->id)->update([
                'profile' => $profile_employee
            ]);
            //thêm vào bảng profile
//            check employee_profile đã
            $check_profile = Employee_profile::where('employee_id', $employeeId)->first();
            if (!empty($check_profile)) {
                $insert_employee_profile = Employee_profile::where('employee_id', $employeeId)->update([
                    'profile_info' => $profile_info,
                    'profile_course' => $profile_course,
                    'created_at' => new \DateTime()
                ]);
            } else {
                $insert_employee_profile = Employee_profile::insert([
                    'employee_id' => $employeeId,
                    'profile_info' => $profile_info,
                    'profile_course' => $profile_course,
                    'created_at' => new \DateTime()
                ]);
            }
            //them vao bang employee_coin kiem tien
            //check mã otp
            $status_phone_account = !empty($user->status_phone_account) ? $user->status_phone_account : 0;
            $message_otp = !empty($user->status_phone_account) ? 'Tài khoản này bạn đã xác thực mã OTP rồi' : 'Bạn chưa nhập mã xác thực';
            if (!empty($request->input('otp_code'))) {
                $otp_model = new ApiOtpController();
                $otp_code = $otp_model->verifyOtp($request->input('phone'), $request->input('otp_code'));
                if ($otp_code) {
                    $message_otp = 'Bạn dã xác thực Otp thành công :' . $otp_code;
                    if (empty($status_phone_account)) // nếu chưa xác thực thì sẽ dc cộng 10 xu
                    {
                        $status_phone_account = 1;
                        $user_coin_status = User::where('id', $user->id)->value('user_coin');
                        $update_user = User::where('id', $user->id)->update([
                            'status_email_account' => 1,
                            'user_coin' => $user_coin_status + 10,
                            'updated_at' => new \DateTime()
                        ]);
                        $noti_model = new Forum_notification();
                        $noti_title = 'Bạn được nhận + 10 xu khi xác thực OTP tài khoản trên sanketoan.vn';
                        $create_noti_coin = $noti_model->insertGetId([
                            'noti_title' => $noti_title,
                            'for_post_id' => 0,
                            'for_comment_id' => 0,
                            'user_id' => $user->id,
                            'user_id_comment' => 0,
                            'noti_type' => 'user_pro',
                            'noti_status' => 0,
                            'type_status' => 'plus',
                            'created_at' => new \DateTime()
                        ]);
                    }
                } else {
                    $message_otp = 'Bạn dã xác thực Otp thất bại';
                }
            }

            if ($request->hasFile('file_cv')) {
                $upload_file = new Upload_FileController();
                $result = $upload_file->api_ajax_upload_file_cv($user->id, $_FILES['file_cv']);
                $link_upload_cv = $result[0];
                if (empty($link_upload_cv)) {
                    return response()->json([
                        'status' => 400,
                        'message' => 'File upload phải là pdf và dung lượng file < 10M',
                    ], 400);
                }
                $employee_link_html = ''; //link html
                //convert file
                if ($result[1] == 'pdf') {
                    $this->PdfToHtml($result[0], $user->id);
                    $result_repalce_public = str_replace('public/', '', $result[0]);
                    $string_random = Ultility::create_random_string(15, 25);
                    $link_pdf = '/library_employee_cv/' . $user->id . '/cv' . $string_random . '.pdf';
                    rename(public_path($result_repalce_public), public_path($link_pdf)); //doi ten file pdf de mã hoa xem
                    $employee_link_html = str_replace('.pdf', '-html.html', $result[0]); //link htmk convert
                    $link_upload_cv = '/public' . $link_pdf;
                }
                if ($result[1] == 'docx') {
                    $this->WordToHtml($result[0], $result[1]);
                }
                $check_employee_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->first();
                if (!empty($check_employee_cv)) {
                    //xóa file
                    $move_delete = $upload_file->move_file_cv($check_employee_cv->employee_link_cv);
                    $upload_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->update([
                        'employee_link_cv' => $link_upload_cv,
                        'employee_link_html' => $employee_link_html,
                        'employee_cv_status' => 1,
                        'updated_at' => new \DateTime()
                    ]);
                } else {
                    $insert_cv = Employee_upload_cv::insert([
                        'employee_id' => $employee->employee_id,
                        'employee_link_cv' => $link_upload_cv,
                        'employee_link_html' => $employee_link_html,
                        'employee_cv_status' => 1,
                        'created_at' => new \DateTime()
                    ]);
                }

                // up date luon diem ho so = 40
                $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
                $employee_profile->update([
                    'profile_cv' => 40
                ]);
                $profile_employee_after_update = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_course + $employee_profile->profile_staff + $employee_profile->profile_avg;

                // chuyển hồ sơ
                $employee = Employee::where('employee_id', $employee->employee_id)->update([
                    'status_employee' => 1,
                    'profile' => $profile_employee_after_update,
                    'updated_at' => new \DateTime()
                ]);
            }

            $check_user_code = User_forum_code_intro::where('user_id', $user->id)->where('diendan_code_status', 1)->first();
            if (!empty($check_user_code)) {
                $update_user_code = User::where('id', $user->id)->update([
                    'diendan_code_intro' => $request->input('diendan_code_intro')
                ]);
            } else {
                if (!empty($request->input('diendan_code_intro'))) {
                    $user_code_intro = User::where('diendan_code_intro', $request->input('diendan_code_intro'))->select('id', 'diendan_code_intro', 'name', 'user_coin')->first();
                    if (!empty($user_code_intro)) {
                        $insert_code_intro = User_forum_code_intro::insert([
                            'user_id' => $user->id, //id người đăng ký
                            'user_id_intro' => $user_code_intro->id, //id người giới thiệu
                            'diendan_code_intro' => $user_code_intro->diendan_code_intro, //mã giới thiệu của id giới thiệu
                            'diendan_code_status' => 0, //mã giới thiệu của id giới thiệu
                            'created_at' => new \DateTime()
                        ]);
//                nếu user này xác thực bên saketoan.vn thì mới dc cộng xu
                        //cộng thêm 5xu cho tài khoản giới thiệu
                        $noti_model = new Forum_notification();
                        $noti_title = 'Bạn sẽ được nhận + 5 xu khi ' . $request->input('name') . ' đã nhập mã giới thiệu của bạn và xác thực tài khoản bên sanketoan.vn';
                        $noti_id = $noti_model->insertGetId([
                            'noti_title' => $noti_title,
                            'for_post_id' => 0,
                            'for_comment_id' => 0,
                            'user_id' => $user_code_intro->id,
                            'user_id_comment' => 0,
                            'noti_type' => 'user_pro',
                            'noti_status' => 0,
                            'created_at' => new \DateTime()
                        ]);

                        //push noti cho app
                        $title = 'Sàn kế toán thông báo';
                        $type = 'forum';
                        $note = 'Tặng xu khi nhập mã giới thiệu';
                        $value = $noti_id;
                        $to = $user_code_intro->id;
                        $push_noti_app = new NotificationMobileController();
                        $send_push = $push_noti_app->pushNotification($title, $noti_title, $to, $type, $note, $value);

//                //cọng thêm 5 xu cho user dc giơi thiêu
//                $update_user_coin = User::where('id',$user_code_intro->id)->update([
//                   'user_coin' => $user_code_intro->user_coin + 5
//                ]);
                    }
                }
            }

            $user_model = new User();
            $update = $user_model->where('id', $user->id)->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'status_phone_account' => $status_phone_account,
                'image' => $link_image,
                'step' => 'step3'
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông tin ứng viên thành công',
                'message_otp' => $message_otp,
                'step' => 'step3'
            ], 200);
//        } catch (\Exception $e) {
//            $massage = 'Cập nhật thông tin ứng viên thất bại ! Vui Lòng thử lại';
//            return response()->json([
//                'status' => 400,
//                'message' => $massage
//            ], 400);
//        }
    }

    public function get_info_employee_user(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_slug',
            'employee_image',
            'phone',
            'email',
            'province',
            'address',
            'file_cv',
            'salary_id',
            'information_verifier',
            'status', //trang thai lam viec
            'user_id',
            'created_at',
            'updated_at',
            'gender', //gioi tinh
            'birthday',
            'marry', //ket hon
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'address_stay',
            'my_facebook',
//            'status_employees_experience',
//            'day_status_employees_experience',
//            'status_employee_degree',
//            'day_status_employee_degree',
//            'status_post',
            'employee_level_id',
            'experience_id',
            'code_intro',
            'profile',
            'views',
            'status_employee',
            'user_id_handling',
            'day_handling',
            'time_to_work'
        )
            ->where('user_id', $user->id)
            ->first();
        $employee['employee_image'] = !empty($employee['employee_image']) ? asset($employee['employee_image']) : '';
        $employee['status_email_account'] = $user->status_email_account;
        $employee['status_phone_account'] = $user->status_phone_account;
        $province_name = Province::where('province_id', $employee['province'])->value('province_name');
        $salary_name = Salary::where('salary_id', $employee['salary_id'])->value('description');

        $employee['province_name'] = !empty($province_name) ? $province_name : '';
        $employee['salary_name'] = !empty($salary_name) ? $salary_name : '';

        $gender_name = 'Chưa xác định';
        if ($employee['gender'] == 1) {
            $gender_name = 'Nữ';
        }
        if ($employee['gender'] == 2) {
            $gender_name = 'Nam';
        }
        $employee['gender_name'] = $gender_name;
        $employee['marry_name'] = !empty($employee['marry']) ? 'Đã kết hôn' : 'Độc thân';
        $employee['status_name'] = !empty($employee['status']) ? 'Đã đi làm' : 'Chưa đi làm';
        $employee['status_employee_name'] = !empty($employee['status_employee']) ? 'Hồ sơ đã duyệt' : 'Hô sơ chưa duyệt';
        $year_day = date("Y");
        $ex_word = $year_day - $employee['time_to_work'];
//        $employee['kinh-nghiem-lam-viec'] = $year_day;
        $employee['time_to_work_name'] = !empty($ex_word) ? $ex_word . ' năm' : '0 năm';
        $employee_level_name = Literacy::where('literacy_id', $employee['employee_level_id'])->value('literacy_name');
        $employee['employee_level_name'] = !empty($employee_level_name) ? $employee_level_name : '';
        $career_category_id = Employee_career_categories::select(
            'employee_career_categories.career_category_id',
            'career_categories.career_category_name')
            ->join('career_categories', 'career_categories.career_category_id', '=', 'employee_career_categories.career_category_id')
            ->where('employee_career_categories.employee_id', $employee->employee_id)
            ->get();
        $array_district_id = Employee_district::select(
            'employee_district.district_id',
            'district.district_name')
            ->join('district', 'district.district_id', '=', 'employee_district.district_id')
            ->where('employee_district.employee_id', $employee->employee_id)
            ->get();
        $array_business_type = Employee_business_type::select(
            'employee_business_type.business_type_id',
            'business_type.business_type_name')
            ->join('business_type', 'business_type.business_type_id', '=', 'employee_business_type.business_type_id')
            ->where('employee_business_type.employee_id', $employee->employee_id)
            ->get();
        $employee['array_career_category_id'] = $career_category_id;
        $employee['array_district_id'] = $array_district_id;
        $employee['array_business_type'] = $array_business_type;
        $file_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->value('employee_link_cv');
        if (!empty($file_cv)) {
            $cv_remove_public = str_replace('/public', '', $file_cv);
            $employee['file_cv'] = asset($cv_remove_public);
        }
        //thong baso //noti_status

        $noti_employer_model = new Notification_employer();
        $unread = $noti_employer_model->where('user_id',$user->id)
            ->where('noti_status',0)
            ->count();
        $employee['unread'] = $unread;

        return response()->json([
            'status' => 200,
            'message' => 'Thông tin ứng viên',
            'employee' => $employee,
            'user' => $user,
        ], 200);
    }

    public function update_employee_cv(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }

        $validation = Validator::make($request->all(), [
            'business_type_id' => 'required',
            'salary_id' => 'required',
            'employee_level_id' => 'required',

        ], [
            'business_type_id.required' => 'Vui lòng chọn lính vực có kinh nghiệm ,',
            'salary_id.required' => 'Vui lòng chọn mức lương,',
            'employee_level_id.required' => 'Vui lòng trình độ học vấn ,',
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

        $employee_model = new Employee();
        $employee = $employee_model->where('user_id', $user->id)->first();

        $time = strtotime($request->input('month') . '/' . $request->input('day') . '/' . $request->input('year'));
        $birthday = date('Y-m-d', $time);
        $employee_slug = str_slug($request->input('employee_name')) . '-' . $employee->employee_id;

        $status_employee = $employee_model->where('user_id', $user->id)->value('status');
        $updateem_ployee = $employee_model->where('user_id', $user->id)->update([
            'employee_level_id' => $request->input('employee_level_id'),
            'salary_id' => $request->input('salary_id'),
            'birthday' => $birthday,
            'gender' => $request->input('gender'),
            'marry' => $request->input('marry'),
            'status' => !empty($request->input('status')) ? $request->input('status') : $status_employee
        ]);
        //cap nhat kinh nghiem
        //xoa su lieu cu va them lại
        $business_array = $request->input('business_type_id');
        if (is_array($business_array)) {
            $delete_business = Employee_business_type::where('employee_id', $employee->employee_id)
                ->delete();
            foreach ($business_array as $business) {
                $insert_business = Employee_business_type::insert([
                    'employee_id' => $employee->employee_id,
                    'business_type_id' => $business,
                    'created_at' => new \DateTime()
                ]);
            }
        }
        if ($request->hasFile('file_cv')) {
            $upload_file = new Upload_FileController();
            $result = $upload_file->api_ajax_upload_file_cv($user->id, $_FILES['file_cv']);
            $link_upload_cv = $result[0];
            if (empty($link_upload_cv)) {
                return response()->json([
                    'status' => 400,
                    'message' => 'File upload phải là pdf và dung lượng file < 10M',
                ], 400);
            }
            $employee_link_html = ''; //link html
            //convert file
            if ($result[1] == 'pdf') {
                $this->PdfToHtml($result[0], $user->id);
                $result_repalce_public = str_replace('public/', '', $result[0]);
                $string_random = Ultility::create_random_string(15, 25);
                $link_pdf = '/library_employee_cv/' . $user->id . '/cv' . $string_random . '.pdf';
                rename(public_path($result_repalce_public), public_path($link_pdf)); //doi ten file pdf de mã hoa xem
                $employee_link_html = str_replace('.pdf', '-html.html', $result[0]); //link htmk convert
                $link_upload_cv = '/public' . $link_pdf;
            } else {
                return response()->json([
                    'status' => 400,
                    'message' => 'File upload phải là pdf và dung lượng file < 10M',
                ], 400);
            }
//            if ($result[1] == 'docx') {
//                $this->WordToHtml($result[0], $result[1]);
//            }
            $check_employee_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->first();
            if (!empty($check_employee_cv)) {
                //xóa file
                $move_delete = $upload_file->move_file_cv($check_employee_cv->employee_link_cv);
                $upload_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->update([
                    'employee_link_cv' => $link_upload_cv,
                    'employee_link_html' => $employee_link_html,
                    'employee_cv_status' => 1,
                    'updated_at' => new \DateTime()
                ]);
            } else {
                $insert_cv = Employee_upload_cv::insert([
                    'employee_id' => $employee->employee_id,
                    'employee_link_cv' => $link_upload_cv,
                    'employee_link_html' => $employee_link_html,
                    'employee_cv_status' => 1,
                    'created_at' => new \DateTime()
                ]);
            }

            // up date luon diem ho so = 40
            $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
            $employee_profile->update([
                'profile_cv' => 40
            ]);
            $profile_employee_after_update = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_course + $employee_profile->profile_staff + $employee_profile->profile_avg;
            // chuyển hồ sơ
            $employee = Employee::where('employee_id', $employee->employee_id)->update([
                'status_employee' => 1,
                'profile' => $profile_employee_after_update,
                'updated_at' => new \DateTime()
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật CV ứng viên thành công',
            'employee' => $employee,
            'step' => 'step3',
        ], 200);

    }

    private function PdfToHtml($link_pdf, $id)
    {
        $public_full = public_path();
        $public_html = str_replace('public', '', $public_full);
        $public = str_replace('_html', 'public_html', $public_html);

        //        Config::setBinDirectory($public . 'vendor/bin/poppler');
        // set Poppler utils binary location
        Config::setBinDirectory($public . 'public/custom_vendor_PDF/bin/poppler');
        // set output directory
        Config::setOutputDirectory(public_path() . '/library_employee_cv/' . $id);


        $pdfToHtml = new PdfToHtml($public . $link_pdf);
        $pdfToHtml->setZoomRatio(1.8);
        $pdfToHtml->exchangePdfLinks();
        $pdfToHtml->startFromPage(1)->stopAtPage(5);
        $pdfToHtml->generateSingleDocument();
        $pdfToHtml->generate();
    }

    private function WordToHtml($link_pdf, $type_file)
    {
        $link_pdf_no = str_replace('public/', '', $link_pdf);
        $array = explode('/', $link_pdf);
        $name = end($array);
        $array_name = explode('.', $name);
        $name_file = current($array_name);
        $domPdfPath = base_path('vendor/dompdf/dompdf');
//        $domPdfPath = base_path('public/custom_vendor_PDF/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);
        \PhpOffice\PhpWord\Settings::setPdfRendererName('HTML');
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        if ($type_file == 'doc') {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(public_path() . $link_pdf_no, 'MsDoc');
        } else {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(public_path() . $link_pdf_no);
        }

        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $PDFWriter->save(public_path() . '/library_employee_cv/' . Auth::id() . '/' . $name_file . '-html.html');

        // $docPath = public_path() . $link_pdf_no;
        // $Word = new \PhpOffice\PhpWord\PhpWord();
        // $document = $Word->loadTemplate($docPath);
        //     $document =   \PhpOffice\PhpWord\IOFactory::load($docPath,'MsDoc');

        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($document,'Word2007');
        // $docxPath = public_path() . '/library_employee_cv/' . Auth::id() . '/' . $name_file . '.docx';
        // $objWriter->save($docxPath);

    }

    public function show_info_detail_employee(Request $request)
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
        $employer = $employer->select('employer_id', 'enterprise_name', 'email', 'profile',
            'employer_coin', // Số dư xu
            'total_employer_coin', // Tổng số xu
            'total_money_coin' // Số tiền đã nạp
        )->where('user_id', $user->id)
            ->first();
        $employee_id = $request->input('employee_id');
        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        $message = 'Ứng viên này bạn đã xem thông tin liên lạc trước đó nên không bị mất điểm nữa';
        if (empty($check_show_employee)) {
            //tru xu theo nganh nghe cua ugn vien
            $coin_caree = \App\Entity\Employee_career_categories::get_coin_view_profile($employee_id);

            //kiem tra xu của nhà tuyển dụng
            $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
//            $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
//            $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
//            $coin_surplus = $coin_free - $history_coin;
//            $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
//            if (empty($employer->total_employer_coin) && $employer->total_employer_coin < $coin_caree) {
//                return response()->json([
//                    'status' => 400,
//                    'message' => 'Số điểm miễn phí của bạn không đủ để xem thông tin liên hệ của ứng viên này'
//                ], 400);
//            }
            if (!empty($employer->total_employer_coin) && $employer->employer_coin < $coin_caree) {
                return response()->json([
                    'status' => 400,
                    'message' => 'Số điểm còn lại không đủ để xem thông tin liên hệ của ứng viên nà'
                ], 400);
            }
            $message = 'Số diểm để xem thông tin của ứng viên này là ' . $coin_caree . ' điểm';
            //tiến hành trừ điểm
            DB::beginTransaction();
            if (!empty($employer->total_employer_coin)) {
                //trường họp trừ xu của ntd
                $coin_history_status = 1;
                $employer_coin = $employer->employer_coin - $coin_caree;
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
                'coin' => $coin_caree,
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
            DB::commit();
        }
        $employee_model = new Employee();
        $employee = $employee_model->select('employees.employee_id',
            'employees.employee_name',
            'employees.email',
            'employees.phone',
            'employees.employee_slug',
            'employees.employee_image',
            'employees.employee_level_id',
            'employees.time_to_work',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.user_id',
            'employees.status',
            'employees.views',
            'employees.marry',
            'employees.profile',
            'province.province_name',
            'salary.description as salary_description', 'experience.experience_name'
        )
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('experience', 'experience.experience_id', 'employees.experience_id')
//            ->where('employees.status_employee', 1)
//            ->where('employees.show_hidden_profile', 0)
            ->where('employee_id', $employee_id);
        $employee = $employee->first();

//         echo '<pre>';
//         print_r($employee);die;
        $employee['employee_image'] = !empty($employee['employee_image']) ? asset($employee['employee_image']) : '';
        $employee_level = \App\Entity\Literacy::get_literacy_name(!empty($employee->employee_level_id) ? $employee->employee_level_id : 0);
        $employee['trinh-do'] = !empty($employee_level->literacy_name) ? $employee_level->literacy_name : 'Đang cập nhật';
        //danh sach quan huyen cua ung vien
        $list_district_name = \App\Entity\Employee_district::get_district_name($employee->employee_id);
        $employee['quan-huyen'] = $list_district_name;
        //danh sach cong viec can tim
        $list_career_name = \App\Entity\Employee_career_categories::get_array_name($employee->employee_id);
        $employee['cong-viec-can-tim'] = $list_career_name;
        //kinh nghiem lam viec
        $date_day = date_create();
        $year_day = date_format($date_day, "Y") - $employee->time_to_work;
        $employee['kinh-nghiem-lam-viec'] = $year_day;
        //kinh nghiem trong linh vuc
        $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
        $employee['kinh-nghiem-trong-linh-vuc'] = $list_business_name;

        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        $employee['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee_id]) . '?employer_id=' . $employer->employer_id;

        $employee['linh-cv'] = '';
        if (!empty($check_show_employee)) {
            $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee_id);
            if (!empty($cv_upload->employee_cv_status)) {
                $employee['linh-cv'] = asset($cv_upload->employee_link_cv);
            } else {
                $user_id = Employee::where('employee_id', $employee->employee_id)->value('user_id');
                $employee['linh-cv'] = route('employer_exportpdf_cv_user_id', ['user_id' => $user_id]);
            }
        }
        return response()->json([
            'status' => 200,
            'cv_upload' => $cv_upload,
            'massage' => $message,
            'employee' => $employee,
            'employer' => $employer
        ], 200);
    }

    public function report_info_employee(Request $request)
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
        $employer = Employer::where('user_id', $user->id)->first();
        $employee_id = $request->input('employee_id');
        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        if (empty($check_show_employee)) {
            return response()->json([
                'status' => 400,
                'massage' => 'Bạn phải xem thông tin liên hệ của ứng viên mới được phản hồi về CV ứng viên .',
                'employer' => $employer
            ], 400);

        }
        $response = $request->response;
        $response_diff = $request->response_diff;
        $employer_response_cv_id = Employer_response_cv::insertGetId([
            'employer_id' => $employer->employer_id,
            'employee_id' => $employee_id,
            'response_diff' => $response_diff,
            'created_at' => new \Datetime()
        ]);
        foreach ($response as $res) {
            $insert = Employer_select_response_cv::insert([
                'employer_select_response_id' => $res,
                'employer_response_cv_id' => $employer_response_cv_id,
                'created_at' => new \Datetime()
            ]);
        }
        return response()->json([
            'status' => 200,
            'massage' => 'Phản hồi chất lượng CV thành công.',
            'employer' => $employer
        ], 200);

    }

    public function send_otp(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $user_model = new User();
        $update = $user_model->where('id', $user->id)->update([
            'phone' => $request->phone,
        ]);
        $otp_model = new ApiOtpController();
        $send_otp = $otp_model->sendOtp($request->phone);
//        $send_otp = $otp_model->sendsms_otp($request->phone);
        if ($send_otp) {
            return response()->json([
                'status' => 200,
                'massage' => 'Gửi mã xác thực thành công',
            ], 200);
        }
        return response()->json([
            'status' => 400,
            'massage' => 'Gửi mã xác thực thất bại',
        ], 400);

    }

    //more update cv
    public function more_detail_employee(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 1) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng dành cho ứng viên'
            ], 400);
        }
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_slug',
            'employee_image',
            'phone',
            'email',
            'province',
            'address',
            'file_cv',
            'salary_id',
            'information_verifier',
            'status', //trang thai lam viec
            'user_id',
            'created_at',
            'updated_at',
            'gender', //gioi tinh
            'birthday',
            'marry', //ket hon
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'address_stay',
            'my_facebook',
//            'status_employees_experience',
//            'day_status_employees_experience',
//            'status_employee_degree',
//            'day_status_employee_degree',
//            'status_post',
            'employee_level_id',
            'experience_id',
            'code_intro',
            'profile',
            'views',
            'status_employee',
            'user_id_handling',
            'day_handling',
            'time_to_work'
        )
            ->where('user_id', $user->id)
            ->first();

        $employee['employee_image'] = !empty($employee['employee_image']) ? asset($employee['employee_image']) : '';
        $employee['status_email_account'] = $user->status_email_account;
        $employee['status_phone_account'] = $user->status_phone_account;
        $province_name = Province::where('province_id', $employee['province'])->value('province_name');
        $salary_name = Salary::where('salary_id', $employee['salary_id'])->value('description');
        $employee['province_name'] = !empty($province_name) ? $province_name : '';
        $employee['salary_name'] = !empty($salary_name) ? $salary_name : '';

        $gender_name = 'Chưa xác định';
        if ($employee['gender'] == 1) {
            $gender_name = 'Nữ';
        }
        if ($employee['gender'] == 2) {
            $gender_name = 'Nam';
        }
        $employee['gender_name'] = $gender_name;
        $employee['marry_name'] = !empty($employee['marry']) ? 'Đã kết hôn' : 'Độc thân';
        $employee['status_name'] = !empty($employee['status']) ? 'Đã đi làm' : 'Chưa đi làm';
        $employee['status_employee_name'] = !empty($employee['status_employee']) ? 'Hồ sơ đã duyệt' : 'Hô sơ chưa duyệt';
        $year_day = date("Y");
        $ex_word = $year_day - $employee['time_to_work'];
//        $employee['kinh-nghiem-lam-viec'] = $year_day;
        $employee['time_to_work_name'] = !empty($ex_word) ? $ex_word . ' năm' : '0 năm';
        $employee_level_name = Literacy::where('literacy_id', $employee['employee_level_id'])->value('literacy_name');
        $employee['employee_level_name'] = !empty($employee_level_name) ? $employee_level_name : '';
        $career_category_id = Employee_career_categories::select(
            'employee_career_categories.career_category_id',
            'career_categories.career_category_name')
            ->join('career_categories', 'career_categories.career_category_id', '=', 'employee_career_categories.career_category_id')
            ->where('employee_career_categories.employee_id', $employee->employee_id)
            ->get();
        $array_district_id = Employee_district::select(
            'employee_district.district_id',
            'district.district_name')
            ->join('district', 'district.district_id', '=', 'employee_district.district_id')
            ->where('employee_district.employee_id', $employee->employee_id)
            ->get();
        $array_business_type = Employee_business_type::select(
            'employee_business_type.business_type_id',
            'business_type.business_type_name')
            ->join('business_type', 'business_type.business_type_id', '=', 'employee_business_type.business_type_id')
            ->where('employee_business_type.employee_id', $employee->employee_id)
            ->get();
        $employee['array_career_category_id'] = $career_category_id;
        $employee['array_district_id'] = $array_district_id;
        $employee['array_business_type'] = $array_business_type;


        $user_munis_coin = Forum_minus_coin_user::where('user_id', $user->id)->first();
        //tổng số xu dc tặng
        $total_coin = Forum_post::where('for_user_id', $user->id)->sum('total_coin');
        $total_comment_coin = Forum_post_comment::where('user_id', $user->id)->sum('total_comment_coin');
        $employee['user_coin'] = $user->user_coin;
        $employee['tang-xu-cho-bai-viet'] = '-' . (!empty($user_munis_coin->forum_post_coin) ? $user_munis_coin->forum_post_coin : 0);
        $employee['tang-xu-cho-binh-luan'] = '-' . (!empty($user_munis_coin->forum_comment_coin) ? $user_munis_coin->forum_comment_coin : 0);
        $employee['so-xu-da-tai-lieu'] = '-' . (!empty($user_munis_coin->forum_voucher_coin) ? $user_munis_coin->forum_voucher_coin : 0);
        $employee['so-xu-duoc-tang-tu-bai-viet'] = '+' . (!empty($total_coin) ? intval($total_coin) : 0);
        $employee['so-xu-duoc-tang-binh-luan'] = '+' . (!empty($total_comment_coin) ? intval($total_comment_coin) : 0);

//       $employee['diendan_image'] = !empty($user->diendan_image) ? asset($user->diendan_image) : '';


        return response()->json([
            'status' => 200,
            'message' => 'Thông tin ứng viên',
            'employee' => $employee,
        ], 200);
    }

    public function more_update_employee(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        if ($user->role != 1) {
            return response()->json([
                'status' => 400,
                'message' => 'Chức năng dành cho ứng viên'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'time_to_work' => 'required',
            'employee_level_id' => 'required',
            'salary_id' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'gender' => 'required',
            'address' => 'required',
            'business_type_id' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'career_category_id' => 'required'
        ], [
            'time_to_work.required' => 'Năm bắt đầu làm việc không được để trống',
            'employee_level_id.required' => 'Vui lòng chọn trình độ cao nhất ,',
            'salary_id.required' => 'Vui lòng chọn mức lương mong muốn ,',
            'day.required' => 'Vui lòng nhập ngày sinh,',
            'month.required' => 'Vui lòng nhập tháng sinh ,',
            'year.required' => 'Vui lòng nhập năm sinh ,',
            'gender.required' => 'Vui lòng chọn giới tính ,',
            'address.required' => 'Vui lòng nhập địa chỉ,',
            'province_id.required' => 'Vui lòng chọn tỉnh / thành phố ,',
            'district_id.required' => 'Vui lòng chọn quận / huyện ,',
            'career_category_id.required' => 'Vui lòng chọn vị trí công việc ,'

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
        $year_day = date("Y");
        $ex_word = $year_day - $request->time_to_work;
        if ($request->time_to_work > $year_day || $ex_word > 50) {
            return response()->json([
                'error' => 400,
                'message' => 'Năm bắt đầu làm việc không thể lớn hơn năm hiện tại và không được quá 50 năm kinh nghiệm làm việc ',
            ], 400);
        }
        $employee = Employee::select('*')->where('user_id', $user->id)->first();
        $link_image = !empty($employee->employee_image) ? $employee->employee_image : '';
        if ($request->hasFile('image')) {
            $upload = new Upload_FileController();
            $link_image = $upload->api_upload_image_employee($employee->email, $employee->user_id, $request);
            if (empty($link_image)) {
                return response()->json([
                    'error' => 400,
                    'message' => 'Vui lòng nhập dịnh đạng image.',
                ], 400);
            }
        }
        $status_employee = Employee::where('user_id', $user->id)->value('status');
        try {
            $update = Employee::where('user_id', $user->id)->update([
                'employee_name' => !empty($request->input('name')) ? $request->input('name') : '',
                'phone' => $request->input('phone'),
                'employee_image' => $link_image,
                'status' => !empty($request->input('status')) ? $request->input('status') : $status_employee,
                'salary_id' => 6,
                'province' => $request->province_id,
                'address' => $request->address,
                'time_to_work' => $request->time_to_work,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $employeeId = $employee->employee_id;
            $employee_slug = str_slug($request->input('name')) . '-' . $employeeId;
            $update = Employee::where('employee_id', $employeeId)->update([
                'employee_slug' => $employee_slug
            ]);
            //danh sách nhóm công việc
            if (!empty($request->input('career_category_id'))) {
                $list_array_career = $request->input('career_category_id');
                //xoa du lieuj cữ
                $delete_carerr = Employee_career_categories::where('employee_id', $employeeId)->delete();
                foreach ($list_array_career as $career) {
                    $insert_career = Employee_career_categories::insert([
                        'employee_id' => $employeeId,
                        'career_category_id' => $career,
                        'created_at' => new \DateTime()
                    ]);
                }

            }
            //danh sách quận / huyện
            if (!empty($request->input('district_id'))) {
                $list_array_district = $request->input('district_id');
                //xoa du lieuj cữ
                $delete_carerr = Employee_district::where('employee_id', $employeeId)->delete();
                foreach ($list_array_district as $district) {
                    $insert_dis = Employee_district::insert([
                        'employee_id' => $employeeId,
                        'district_id' => $district,
                        'created_at' => new \DateTime()
                    ]);
                }
            }

            $employee_model = new Employee();
            $profile_info = $employee_model->get_profile_info($user->id);
            $profile_course = $employee_model->get_profile_course($user->id);

            $profile_employee = $profile_info + $profile_course;
            //cong điểm cho ứng viên
            $update_profile = Employee::where('user_id', $user->id)->update([
                'profile' => $profile_employee
            ]);
            //thêm vào bảng profile
//            check employee_profile đã
            $check_profile = Employee_profile::where('employee_id', $employeeId)->first();
            if (!empty($check_profile)) {
                $insert_employee_profile = Employee_profile::where('employee_id', $employeeId)->update([
                    'profile_info' => $profile_info,
                    'profile_course' => $profile_course,
                    'created_at' => new \DateTime()
                ]);
            } else {
                $insert_employee_profile = Employee_profile::insert([
                    'employee_id' => $employeeId,
                    'profile_info' => $profile_info,
                    'profile_course' => $profile_course,
                    'created_at' => new \DateTime()
                ]);
            }
            //them vao bang employee_coin kiem tien
            //check mã otp
            $status_phone_account = !empty($user->status_phone_account) ? $user->status_phone_account : 0;
            $message_otp = !empty($user->status_phone_account) ? 'Tài khoản này bạn đã xác thực mã OTP rồi' : 'Bạn chưa nhập mã xác thực';
            if (!empty($request->input('otp_code'))) {
                $otp_model = new ApiOtpController();
                $otp_code = $otp_model->verifyOtp($request->input('phone'), $request->input('otp_code'));
                if ($otp_code) {
                    $message_otp = 'Bạn dã xác thực Otp thành công :' . $otp_code;
                    $status_phone_account = 1;
                } else {
                    $message_otp = 'Bạn dã xác thực Otp thất bại';
                }
            }
            $user_model = new User();
            $update = $user_model->where('id', $user->id)->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'status_phone_account' => $status_phone_account,
                'image' => $link_image,
                'step' => 'step3'
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông tin ứng viên thành công',
                'message_otp' => $message_otp,
                'step' => 'step3'
            ], 200);
        } catch (\Exception $e) {
            $massage = 'Cập nhật thông tin ứng viên thất bại ! Vui Lòng thử lại';
            return response()->json([
                'status' => 400,
                'message' => $massage
            ], 400);
        }

    }

    public function more_status_employee(Request $request)
    {

        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'status' => 'required',
        ], [
            'status.required' => 'Vui lòng chọn trạng thái làm việc',
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
//        $time = strtotime($request->input('month') . '/' . $request->input('day') . '/' . $request->input('year'));
//        $birthday = date('Y-m-d', $time);
        try {
            $update = Employee::where('user_id', $user->id)->update([
                'status' => $request->input('status'),
                'updated_at' => new \DateTime()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật trạng thái ứng viên thành công',
            ], 200);
        } catch (\Exception $e) {
            $massage = 'Cập nhật trạng thái ứng viên thất bại';
            return response()->json([
                'status' => 400,
                'message' => $massage
            ], 400);
        }
    }

    public function status_employee(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'status ' => 'required'
        ], [
            'status.required' => 'Vui lòng chọn trạng thái làm việc'
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
            $update = Employee::where('user_id', $user->id)->update([
                'status' => $request->input('status'),
                'updated_at' => new \DateTime()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật trạng thái ứng viên thành công',
            ], 200);
        } catch (\Exception $e) {
            $massage = 'Cập nhật trạng thái ứng viên thất bại';
            return response()->json([
                'status' => 400,
                'message' => $massage
            ], 400);
        }
    }

    public function more_status_employee2(Request $request)
    {

        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'district_id' => 'required',
            'career_category_id' => 'required',
            'time_to_work' => 'required',
            'employee_level_id' => 'required',
            'salary_id' => 'required',
            'day' => 'required',
            'month' => 'required',
            'year' => 'required',
            'gender' => 'required'
        ], [
            'name.required' => 'Họ và tên  không được bỏ trống ,',
            'phone.required' => 'Số điện thọai  không được bỏ trống ,',
            'province_id.required' => 'Vui lòng chọn tỉnh / thành phố ,',
            'district_id.required' => 'Vui lòng chọn quận / huyện ,',
            'career_category_id.required' => 'Vui lòng chọn vị trí công việc ,',
            'time_to_work.required' => 'Năm bắt đầu làm việc không được để trống ,',
            'employee_level_id.required' => 'Vui lòng chọn trình độ cao nhất ,',
            'salary_id.required' => 'Vui lòng chọn mức lương',
            'day.required' => 'Vui lòng nhập ngày thắng năm sinh',
            'month.required' => 'Vui lòng nhập ngày thắng năm sinh',
            'year.required' => 'Vui lòng nhập ngày thắng năm sinh',
            'gender.required' => 'Vui lòng chọn giới tính'
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
        $year_day = date("Y");
        $ex_word = $year_day - $request->time_to_work;
        if ($request->time_to_work > $year_day || $ex_word > 50) {
            return response()->json([
                'error' => 400,
                'message' => 'Năm bắt đầu làm việc không thể lớn hơn năm hiện tại và không được quá 50 năm kinh nghiệm làm việc ',
            ], 400);
        }
        $employee = Employee::select('*')->where('user_id', $user->id)->first();
        $link_image = !empty($employee->employee_image) ? $employee->employee_image : '';
        if ($request->hasFile('image')) {
            $upload = new Upload_FileController();
            $link_image = $upload->api_upload_image_employee($employee->email, $employee->user_id, $request);
            if (empty($link_image)) {
                return response()->json([
                    'error' => 400,
                    'message' => 'Vui lòng nhập dịnh đạng image.',
                ], 400);
            }
        }


        $time = strtotime($request->input('month') . '/' . $request->input('day') . '/' . $request->input('year'));
        $birthday = date('Y-m-d', $time);
        $employeeId = $employee->employee_id;
        $employee_slug = str_slug($request->input('name')) . '-' . $employeeId;
        try {
            $update = Employee::where('user_id', $user->id)->update([
                'employee_name' => !empty($request->input('name')) ? $request->input('name') : '',
                'employee_slug' => $employee_slug,
                'phone' => $request->input('phone'),
                'employee_image' => $link_image,
                'status' => 0,
                'salary_id' => 6,
                'province' => $request->province_id,
                'address' => $request->address,
                'time_to_work' => $request->time_to_work,
                'employee_level_id' => $request->input('employee_level_id'),
                'salary_id' => $request->input('salary_id'),
                'birthday' => $birthday,
                'gender' => $request->input('gender'),
                'marry' => $request->input('marry'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            //cap nhat kinh nghiem
            //xoa su lieu cu va them lại
            $business_array = $request->input('business_type_id');
            if (is_array($business_array)) {
                $delete_business = Employee_business_type::where('employee_id', $employee->employee_id)
                    ->delete();
                foreach ($business_array as $business) {
                    $insert_business = Employee_business_type::insert([
                        'employee_id' => $employee->employee_id,
                        'business_type_id' => $business,
                        'created_at' => new \DateTime()
                    ]);
                }
            }
            //danh sách nhóm công việc
            if (!empty($request->input('career_category_id'))) {
                $list_array_career = $request->input('career_category_id');
                //xoa du lieuj cữ
                $delete_business = Employee_career_categories::where('employee_id', $employee->employee_id)
                    ->delete();
                foreach ($list_array_career as $career) {
                    $insert_career = Employee_career_categories::insert([
                        'employee_id' => $employee->employee_id,
                        'career_category_id' => $career,
                        'created_at' => new \DateTime()
                    ]);
                }

            }
            //danh sách quận / huyện
            if (!empty($request->input('district_id'))) {
                $list_array_district = $request->input('district_id');
                //xoa du lieuj cữ
                $delete_carerr = Employee_district::where('employee_id', $employee->employee_id)->delete();
                foreach ($list_array_district as $district) {
                    $insert_dis = Employee_district::insert([
                        'employee_id' => $employee->employee_id,
                        'district_id' => $district,
                        'created_at' => new \DateTime()
                    ]);
                }
            }

            $employee_model = new Employee();
            $profile_info = $employee_model->get_profile_info($user->id);
            $profile_course = $employee_model->get_profile_course($user->id);

            $profile_employee = $profile_info + $profile_course;
            //cong điểm cho ứng viên
            $update_profile = Employee::where('user_id', $user->id)->update([
                'profile' => $profile_employee
            ]);
            //thêm vào bảng profile
//            check employee_profile đã
            $check_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
            if (!empty($check_profile)) {
                $insert_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->update([
                    'profile_info' => $profile_info,
                    'profile_course' => $profile_course,
                    'created_at' => new \DateTime()
                ]);
            } else {
                $insert_employee_profile = Employee_profile::insert([
                    'employee_id' => $employee->employee_id,
                    'profile_info' => $profile_info,
                    'profile_course' => $profile_course,
                    'created_at' => new \DateTime()
                ]);
            }
            //them vao bang employee_coin kiem tien
            //check mã otp
            $status_phone_account = !empty($user->status_phone_account) ? $user->status_phone_account : 0;
            $message_otp = !empty($user->status_phone_account) ? 'Tài khoản này bạn đã xác thực mã OTP rồi' : 'Bạn chưa nhập mã xác thực';
            if (!empty($request->input('otp_code'))) {
                $otp_model = new ApiOtpController();
                $otp_code = $otp_model->verifyOtp($request->input('phone'), $request->input('otp_code'));
                if ($otp_code) {
                    $message_otp = 'Bạn dã xác thực Otp thành công :' . $otp_code;
                    $status_phone_account = 1;
                } else {
                    $message_otp = 'Bạn dã xác thực Otp thất bại';
                }
            }
            $user_model = new User();
            $update = $user_model->where('id', $user->id)->update([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'status_phone_account' => $status_phone_account,
                'image' => $link_image
            ]);

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông tin ứng viên thành công',
                'message_otp' => $message_otp,
                'step' => 'step3'
            ], 200);
        } catch (\Exception $e) {
            $massage = 'Cập nhật thông tin ứng viên thất bại ! Vui Lòng thử lại';
            return response()->json([
                'status' => 400,
                'message' => $massage
            ], 400);
        }
    }

    //xóa tài khoản
    public function delete_user(Request $request)
    {
//        echo $request->token;die;
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        try {
            //xoa ứng viên
            if ($user->role == 1) {
                Employee::where('user_id', $user->id)->delete();
            }
            if ($user->role == 2) {

                $employer = Employer::select('employer_id', 'user_id')->where('user_id', $user->id)->first();
                //xóa tin tuyển dụng
                $delete = Job::where('employer_id', $employer->employer_id)->delete();
                $delete = JobFacebook::where('employer_id', $employer->employer_id)->delete();
                Employer::where('user_id', $user->id)->delete();
            }
            if ($user->role == 3) {
                Teacher::where('user_id', $user->id)->delete();
            }
            $delete_forum_post = Forum_post::where('for_user_id', $user->id)->delete();
            $delete_forum_comment = Forum_post_comment::where('user_id', $user->id)->delete();
            $delete_forum_noti = Forum_notification::where('user_id', $user->id)->delete();
            User::where('id', $user->id)->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa tài khoản thành công'
            ], 200);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Xóa tài khoản thất bại vui lòng kiểm tra lại'
            ], 400);
        }
    }

}
