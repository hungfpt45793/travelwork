<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 6/10/2019
 * Time: 1:47 PM
 */

namespace App\Http\Controllers\Site;

use App\Course\Course_order;
use App\Course\Courses;
use App\Entity\Cv_employee;
use App\Entity\District;
use App\Entity\Employee_coins;
use App\Entity\Employee_submit_job_faacebook;
use App\Entity\Employer_response_cv;
use App\Entity\Cv_experience;
use App\Entity\Employee_career_categories;
use App\Entity\Notification_employer;
use App\Entity\User_forum_code_intro;
use App\Entity\Employee_district;
use App\Entity\Coin_show_employee;
use App\Entity\Employee_profile;
use App\Entity\Employer_select_response;
use App\Entity\Employee_specialize;
use App\Entity\Employee_experience;
use App\Entity\Cv_info;
use App\Entity\Cv_note_template;
use App\Entity\Cv_project;
use App\Entity\Cv_skills;
use App\Entity\Cv_specialize;
use App\Entity\Cv_template;
use App\Entity\Cv_work;
use App\Entity\Employee;
use App\Entity\Employee_curriculum;
use App\Entity\Employee_curriculum_extend;
use App\Entity\Employee_follow_employer;
use App\Entity\Employee_upload_cv;
use App\Entity\Employer;
use App\Entity\Forum_notification;
use App\Entity\HistoryWork;
use App\Entity\Job;
use App\Entity\JobGroup;
use App\Entity\NotificationWindow;
use App\Entity\Order;
use App\Entity\Invite;
use App\Entity\Province;
use App\Entity\Send_user_email_marketting;
use App\Entity\SettingGetfly;
use App\Entity\Template_email;
use App\Entity\User;
use App\Entity\Workplace;
use App\Exam\Questions;
use App\Exam\Result_job_exam;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Http\Controllers\Site\Course\CourseEmployeeController;
use App\Ultility\CallApi;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Entity\MailConfig;
use App\Ultility\Error;
use Illuminate\View\View;
use Prophecy\Call\Call;
use App\Entity\Software;
use App\Entity\Career;
use App\Entity\Salary;
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

class EmployeeController extends SiteController
{

    //cap nhat cv employee
    public function get_all_update_cv_employee($star, $limit)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('*')
            ->orderBy('profile', 'desc')
            ->orderBy('updated_at', 'desc')
            ->skip($star)->take($limit)
            ->get();


        $status_update = 1;
        $cv_template_id = 1;
        $cv_color = 64;
//    $cv_title = 1;
//    $cv_name = 1;
//    $cv_title_job= '';
//    $cv_image= '';
//    $cv_email= '';
//    $cv_phone= '';
//    $cv_birthday= '';
//    $cv_address= '';
//    $cv_facebook= '';
        $cv_title_career_goals = 'MỤC TIÊU NGHỀ NGHIỆP';
        $cv_career_goals = '';
        $cv_title_prize = 'GIẢI THƯỞNG';
        $cv_prize = '';
        $cv_title_card = 'Chứng chỉ';
        $cv_card = '';
        $cv_title_interests = 'Sở thích';
        $cv_interests = '';
        $cv_title_reference_person = 'Người tham chiếu';
        $cv_reference_person = '';
        $title_cv_skills = 'Kỹ năng';
        $title_cv_specialize = 'Trình độ học vấn';
        $title_cv_experience = 'Kinh nghiệm làm việc';
        $title_cv_work = 'Hoạt động';
        $title_cv_project = 'Dự án tham gia';
        $title_cv_info = 'Thông tin thêm';
        $cv_order = '1,2,3,4,5,6';
        $show_hidden_cv_order = 0;
        $cv_order_join = '1,2,3,4,5';
        $show_hidden_cv_order_join = 0;
        foreach ($employee as $e) {
            $cv_employee = new Cv_employee();
            $check_cv = $cv_employee->where('employee_id', $e->employee_id)->count();
//        nếu chưa tạo cv thì hệ thống sẽ tạo
            if (empty($check_cv)) {
                $cv_title = 'CV' . !empty($e->employee_name) ? $e->employee_name : '';
                $cv_name = !empty($e->employee_name) ? $e->employee_name : '';
                $carre = \App\Entity\Career::getIdCareer($e->career_category_id);
                $cv_title_job = !empty($carre->career_category_name) ? $carre->career_category_name : '';
                $cv_image = !empty($e->employee_image) ? $e->employee_image : '';
                $cv_email = !empty($e->email) ? $e->email : '';
                $cv_phone = !empty($e->phone) ? $e->phone : '';
                $cv_birthday = '';
                if (!empty($e->birthday)) {
                    $date_birthday = date_create($e->birthday);
                    $cv_birthday = date_format($date_birthday, "d/m/Y");
                }

                $cv_address = !empty($e->address) ? $e->address : '';
                $cv_facebook = !empty($e->my_facebook) ? $e->my_facebook : '';
                $get_cv_id = $cv_employee->insertGetId([
                    'status_update' => $status_update,
                    'employee_id' => $e->employee_id,
                    'cv_template_id' => $cv_template_id,
                    'cv_color' => $cv_color,
                    'cv_title' => $cv_title,
                    'cv_name' => $cv_name,
                    'cv_title_job' => $cv_title_job,
                    'cv_image' => $cv_image,
                    'cv_email' => $cv_email,
                    'cv_phone' => $cv_phone,
                    'cv_birthday' => $cv_birthday,
                    'cv_address' => $cv_address,
                    'cv_facebook' => $cv_facebook,
                    'cv_title_career_goals' => $cv_title_career_goals,
                    'cv_career_goals' => $cv_career_goals,
                    'cv_title_prize' => $cv_title_prize,
                    'cv_prize' => $cv_prize,
                    'cv_title_card' => $cv_title_card,
                    'cv_card' => $cv_card,
                    'cv_title_interests' => $cv_title_interests,
                    'cv_interests' => $cv_interests,
                    'cv_title_reference_person' => $cv_title_reference_person,
                    'cv_reference_person' => $cv_reference_person,
                    'title_cv_skills' => $title_cv_skills,
                    'title_cv_specialize' => $title_cv_specialize,
                    'title_cv_experience' => $title_cv_experience,
                    'title_cv_work' => $title_cv_work,
                    'title_cv_project' => $title_cv_project,
                    'title_cv_info' => $title_cv_info,
                    'cv_order' => $cv_order,
                    'show_hidden_cv_order' => $show_hidden_cv_order,
                    'cv_order_join' => $cv_order_join,
                    'show_hidden_cv_order_join' => $show_hidden_cv_order_join,
                    'created_at' => new \DateTime()
                ]);

                //insert table skill
                $skils_model = new Cv_skills();
                //input mảng post lên
                $insert = $skils_model->insertGetId([
                    'cv_id' => $get_cv_id,
                    'cv_skill_title' => '',
                    'cv_skill_value' => '',
                    'created_at' => new \DateTime(),
                ]);
                //insert cv_specialize
                //show trinh độ ứng viên
                $count_spec = Employee_specialize::select('*')->where('employee_id', $e->employee_id)->count();
                $list_spec = Employee_specialize::select('*')->where('employee_id', $e->employee_id)->get();
                $cv_specialize_model = new Cv_specialize();
                //input mảng post lên
                if (!empty($count_spec)) {
                    foreach ($list_spec as $id_spe => $spec) {
                        $school = isset($spec->school) ? $spec->school : '';
                        $star_specialize_time = isset($spec->star_specialize_time) ? $spec->star_specialize_time : '';
                        $end_specialize_time = isset($spec->end_specialize_time) ? $spec->end_specialize_time : '';
                        $cv_spec_title = $school . ' (' . $star_specialize_time . '-' . $end_specialize_time . ')';
                        $majors = isset($spec->majors) ? $spec->majors : '';
                        $cv_spec_name = 'Chuyên ngành : ' . $majors;
                        $cv_spec_desc = 'Bằng tốt nghiệp : đang cập nhật';
                        if (!empty($spec->leve)) {
                            $level = \App\Entity\Literacy::getIdLi($spec->leve);
                            $literacy_name = isset($level->literacy_name) ? $level->literacy_name : '';
                            $cv_spec_desc = 'Bằng tốt nghiệp : ' . $literacy_name;
                        }
                        $insert = $cv_specialize_model->insertGetId([
                            'cv_id' => $get_cv_id,
                            'cv_spec_title' => $cv_spec_title,
                            'cv_spec_name' => $cv_spec_name,
                            'cv_spec_desc' => $cv_spec_desc,
                            'created_at' => new \DateTime(),
                        ]);
                        echo $cv_spec_title . '-----' . $cv_spec_name . '----' . $cv_spec_desc;
                    }
                }

                //insert Cv_experience
                $cv_ex_model = new Cv_experience();
                //input mảng post lên
                $count_ex = Employee_experience::select('*')->where('employee_id', $e->employee_id)->count();
                $list_ex = Employee_experience::select('*')->where('employee_id', $e->employee_id)->get();
                if (!empty($count_ex)) {

                    foreach ($list_ex as $id_ex => $ex) {
                        $company = isset($ex->company) ? $ex->company : '';
                        $star_working_time = isset($ex->star_working_time) ? $ex->star_working_time : '';
                        $end_working_time = isset($ex->end_working_time) ? '-' . $ex->end_working_time : '';
                        $cv_ex_title = $company . ' (' . $star_working_time . $end_working_time . ')';
                        $position = isset($ex->position) ? $ex->position : '';
                        $cv_ex_name = 'Vị trí : ' . $position;
                        $cv_desc = 'Mô tả công việc : Đang cập nhật';
                        if (!empty($ex->des_position)) {
                            $cv_desc_re = strip_tags($ex->des_position, '<br><p><li>');
                            $cv_desc_re = preg_replace('/<[^>]*>/', PHP_EOL, $cv_desc_re);
                            $cv_desc = 'Mô tả công việc : ' . $cv_desc_re;
                        }
                        $insert = $cv_ex_model->insertGetId([
                            'cv_id' => $get_cv_id,
                            'cv_ex_title' => $cv_ex_title,
                            'cv_ex_name' => $cv_ex_name,
                            'cv_ex_desc' => $cv_desc,
                            'created_at' => new \DateTime(),
                        ]);
                        echo $cv_ex_title . '-----' . $cv_ex_name . '----' . $cv_desc;
                    }
                }

                //insert Cv_project
                $cv_work_model = new Cv_work();

                $insert = $cv_work_model->insertGetId([
                    'cv_id' => $get_cv_id,
                    'cv_work_title' => '',
                    'cv_work_name' => '',
                    'cv_work_desc' => '',
                    'created_at' => new \DateTime(),
                ]);

                //insert Cv_project
                $cv_project_model = new Cv_project();
                //input mảng post lên
                $insert = $cv_project_model->insertGetId([
                    'cv_id' => $get_cv_id,
                    'cv_project_title' => '',
                    'cv_project_name' => '',
                    'cv_project_des' => '',
                    'created_at' => new \DateTime(),
                ]);
                //insert Cv_project
                $cv_info_model = new Cv_info();
                //input mảng post lên
                $insert = $cv_info_model->insertGetId([
                    'cv_id' => $get_cv_id,
                    'cv_info_title' => '',
                    'cv_info_name' => '',
                    'cv_info_des' => '',
                    'created_at' => new \DateTime(),
                ]);
            }
        }

    }

    public function get_all_update_syll_employee($star, $limit)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('*')
            ->orderBy('profile', 'desc')
            ->orderBy('updated_at', 'desc')
            ->skip($star)->take($limit)
            ->get();


//        $check xem da ton tao syll chưa
        foreach ($employee as $emp) {
            $employee_cur = new Employee_curriculum();
            $check_employee_cur = $employee_cur->select('*')->where('employee_id', $emp->employee_id)->count();
            if (empty($check_employee_cur)) {
                //insert syll
                $gender = '';
                if ($emp->gender == 1) {
                    $gender = 'Nữ';
                }
                if ($emp->gender == 2) {
                    $gender = 'Nam';
                }
                $ns_ngay = '';
                $ns_thang = '';
                $ns_nam = '';
                if (!empty($emp->birthday)) {
                    $date_birthday = date_create($emp->birthday);
                    $ns_ngay = date_format($date_birthday, "d");
                    $ns_thang = date_format($date_birthday, "m");
                    $ns_nam = date_format($date_birthday, "Y");
                }
                $cm_ngay = '';
                $cm_thang = '';
                $cm_nam = '';
                if (!empty($emp->cmt_date)) {
                    $date_cmt_date = date_create($emp->cmt_date);
                    $cm_ngay = date_format($date_cmt_date, "d");
                    $cm_thang = date_format($date_cmt_date, "m");
                    $cm_nam = date_format($date_cmt_date, "Y");
                }
                $insert_curriculum = Employee_curriculum::insertGetId([
                    'employee_id' => $emp->employee_id,
                    'user_id_handing' => $emp->user_id,
                    'created_at' => new \DateTime(),
                    'anh4x6' => !empty($emp->employee_image) ? $emp->employee_image : '',
                    'hoten' => !empty($emp->employee_name) ? $emp->employee_name : '',
                    'gioitinh' => $gender,
                    'ns_ngay' => $ns_ngay,
                    'ns_thang' => $ns_thang,
                    'ns_nam' => $ns_nam,
                    'dk_tt' => '',
                    'cmtnd' => !empty($emp->cmt) ? $emp->cmt : '',
                    'noicap' => !empty($emp->cmt_local) ? $emp->cmt_local : '',
                    'cm_ngay' => $cm_ngay,
                    'cm_thang' => $cm_thang,
                    'cm_nam' => $cm_nam,
                    'dt_home' => '',
                    'mobile' => !empty($emp->phone) ? $emp->phone : '',
                ]);
                $insert_curriculum_extend = Employee_curriculum_extend::insertGetId([
                    'employee_id' => $emp->employee_id,
                ]);
                echo '----';
                echo $emp->cmt_date;
                echo $cm_ngay;
                echo $cm_thang;
                echo $cm_nam;
                echo '*****1---' . $emp->employee_id . '---1*****';
            }

        }


    }

    public function get_update_time_word_employee($star, $limit)
    {
        $employee_model = new Employee();
        $employee = $employee_model->select('*')
            ->orderBy('profile', 'desc')
            ->orderBy('updated_at', 'desc')
            ->skip($star)->take($limit)
            ->get();

//        $check xem da ton tao syll chưa
        foreach ($employee as $emp) {
            if ($emp->experience_id != '') {
                $time_to_work = '';
                if ($emp->experience_id == 0) {
                    $time_to_work = 2020;
                }
                if ($emp->experience_id == 1) {
                    $time_to_work = 2019;
                }
                if ($emp->experience_id == 2) {
                    $time_to_work = 2018;
                }
                if ($emp->experience_id == 3) {
                    $time_to_work = 2017;
                }
                if ($emp->experience_id == 4) {
                    $time_to_work = 2016;
                }
                if ($emp->experience_id == 5) {
                    $time_to_work = 2015;
                }
                if ($emp->experience_id == 6) {
                    $time_to_work = 2014;
                }
                $update = $employee_model->where('employee_id', $emp->employee_id)->update([
                    'time_to_work' => $time_to_work
                ]);
                echo $emp->experience_id . '******';
            }

        }

    }

    public function createEmployee(Request $request)
    {
        // check xem là dữ liệu hợp lệ không
        $validation = $this->validateEmployee($request);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Đăng ký ứng viên lỗi !')
                ->withInput();
        }
        try {
            DB::beginTransaction();
//            Tạo tài khoản để login trong bang user
            $userWithPhone = $this->createUser($request);
            //Tạo ứng viên trong bảng employee
            $this->createNewEmployee($request, $userWithPhone);
            // Đẩy thông tin lên getfly
//            $this->addNewCampaignGetfly($request);
            Auth::guard()->login($userWithPhone);

            if ($request->session()->has('activation_code') && $request->session()->has('status_select_active_code')) {
                $activation_code = $request->session()->get('activation_code');
                $status_select_active_code = $request->session()->get('status_select_active_code');

                $course_id = 0;
                if ($status_select_active_code == 0) {
                    $course_id = Courses::where('activation_code', $activation_code)->value('course_id');
                }
                if ($status_select_active_code == 1) {
                    $course_id = Course_order::where('activation_code', $activation_code)->value('course_id');
                }
                if ($status_select_active_code == 2) {
                    $course_id = Course_teacher_active::where('activation_code', $activation_code)->value('course_id');
                }
                if (!empty($course_id)) {
                    $course_employee = new CourseEmployeeController();
                    $active_employee = $course_employee->get_active_employee($userWithPhone->id, $course_id, $activation_code, $status_select_active_code);
                }
                //xóa session
                $request->session()->forget('activation_code');
                $request->session()->forget('status_select_active_code');
            }

            $employee_model = new Employee();
            $employee_id = $employee_model->where('user_id', $userWithPhone->id)->value('employee_id');
            $profile_info = $employee_model->get_profile_info($userWithPhone->id);
            $profile_course = $employee_model->get_profile_course($userWithPhone->id);

            $profile_employee = $profile_info + $profile_course;
            //cong điểm cho ứng viên
            $update_profile = Employee::where('user_id', $userWithPhone->id)->update([
                'profile' => $profile_employee
            ]);
            //thêm vào bảng profile
            $insert_employee_profile = Employee_profile::insert([
                'employee_id' => $employee_id,
                'profile_info' => $profile_info,
                'profile_course' => $profile_course,
                'created_at' => new \DateTime()
            ]);

            DB::commit();
            //Gửi email thông báo và kích hoạt tài khoản
            MailConfigController::send_email_employee_confirm($userWithPhone);
        } catch (\Exception $e) {
            Error::setErrorMessage("Không thể Đăng ký tài khoản. Vui lòng thử lại ");
            DB::rollBack();
            return redirect(route('employer_register'))->with('error', 'Đăng kí ứng viên thất bại ! Vui lòng thử lại');
        } finally {

            $html = '<h5 class="mgb10 text-center">Chúc mừng bạn đã tạo thành công tài khoản ứng viên.</h5>';
            $html .= '<p class="mgb10">Bước 1: Mời bạn kiểm tra Email để xác thực.</p>';
            $html .= ' <p class="mgb10">Bước 2: Mời bạn cập nhật bổ sung thêm các thông tin, hình ảnh để hồ sơ của bạn nổi bật hơn</p>';
            $html .= ' <p class="mgb10">Bước 3: Mời bạn cập nhật bổ sung CV để hồ sơ của bạn nổi bật hơn</p>';
            $html .= '<p class="mgb10 text-right"><a class="button_res_employer" href="' . route('show_step_profile_employee') . '">Đồng ý</a></p>';
            return redirect(route('list_job_face'))->with('mesage_modal', $html);
        }
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
            'district' => 'required'
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu',
            'email.required' => 'Bạn chưa nhập email',
            'email.unique' => 'Email đã tồn tại',
            'email.email' => 'Vui lòng nhập đúng định dạng email',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'name.required' => 'Họ và tên không được để trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'career_category_id.required' => 'Công việc cần tìm không được để trống',
            'province.required' => 'Thành phố không được để trống',
            'district.required' => 'Quận huyện không được để trống'
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
            'updated_at' => new \DateTime()
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
        $date_today = date_create();
        $year_today = date_format($date_today, "Y");
        $employeeId = Employee::insertGetId([
            'employee_name' => $userWithPhone['name'],
            'phone' => $userWithPhone['phone'],
            'email' => $userWithPhone['email'],
            'user_id' => $userWithPhone['id'],
            'status' => 0,
            'salary_id' => 6,
            'province' => $request->province,
            'time_to_work' => $year_today,
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);
        $employee_slug = str_slug($userWithPhone['name']) . '-' . $employeeId;
        $update = Employee::where('employee_id', $employeeId)->update([
            'employee_slug' => $employee_slug
        ]);
        //danh sách nhóm công việc
        if (!empty($request->input('career_category_id'))) {
            $list_array_career = $request->input('career_category_id');
            foreach ($list_array_career as $career) {
                $insert_career = Employee_career_categories::insert([
                    'employee_id' => $employeeId,
                    'career_category_id' => $career,
                    'created_at' => new \DateTime()
                ]);
            }
        }
        //danh sách quận / huyện
        if (!empty($request->input('district'))) {
            $list_array_district = $request->input('district');
            foreach ($list_array_district as $district) {
                $insert_dis = Employee_district::insert([
                    'employee_id' => $employeeId,
                    'district_id' => $district,
                    'created_at' => new \DateTime()
                ]);
            }
        }
        //them vao bang employee_coin kiem tien
        $insert_employee_coin = Employee_coins::insertGetId([
            'employee_id' => $employeeId,
            'created_at' => new \DateTime()
        ]);
    }
    //gửi email thông báo và kích hoạt tài khoản
//send_email_confirm

    public function link_confirm_account($link)
    {
//        try {
        $user_model = new User();
        $user_link_active = $user_model->select('link_confirm_account', 'status_email_account', 'name', 'id', 'email', 'role')
            ->where('link_confirm_account', $link)
            ->where('status_email_account', 0)
            ->first();

        if (empty($user_link_active)) {
            return view('site.default.show_confirm_account_404', compact('user_link_active'));
        }
        //cong thêm 10 xu
        $user_coin_status = $user_model->where('id', $user_link_active->id)->value('user_coin');
        $update_user = $user_model->where('id', $user_link_active->id)->update([
            'status_email_account' => 1,
            'link_confirm_account' => '',
            'user_coin' => $user_coin_status + 10,
            'updated_at' => new \DateTime()
        ]);
        $noti_model = new Forum_notification();
        $noti_title = 'Bạn được nhận + 10 xu khi xác thực tài khoản trên sanketoan.vn';
        $create_noti_coin = $noti_model->insertGetId([
            'noti_title' => $noti_title,
            'for_post_id' => 0,
            'for_comment_id' => 0,
            'user_id' => $user_link_active->id,
            'user_id_comment' => 0,
            'noti_type' => 'user_pro',
            'noti_status' => 0,
            'type_status' => 'plus',
            'created_at' => new \DateTime()
        ]);


        if ($user_link_active->role == 1) {
            $employee_model = new Employee();
            $employee = $employee_model->select('employee_id', 'user_id', 'profile')->where('user_id', $user_link_active->id)->first();

            if(!empty($_GET['job_id']))
            {
                $job_id = $_GET['job_id'];
                //show cv để upload cv
                $status_show_cv = Employee_submit_job_faacebook::where('employee_id',$employee->employee_id)
                    ->where('id_job_fb',$job_id)
                    ->value('status_show_cv');
                if(empty($status_show_cv))
                {
                    $job_submit = Employee_submit_job_faacebook::where('employee_id',$employee->employee_id)
                        ->where('id_job_fb',$job_id)
                        ->update([
                            'status_show_cv' => 1
                        ]);
                    //guie thông báo đến ntd
                    $this->show_cv_notication($job_id,$employee);
                }
            }
            else
            {
                $job_submit = Employee_submit_job_faacebook::where('employee_id',$employee->employee_id)
                    ->update([
                        'status_show_cv' => 1
                    ]);
            }


            $profile_info = Employee::get_profile_info($user_link_active->id);
            //update diểm lại cho 2 bảng
            $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
            //công điểm cho ứng viên

            //cộng lại điểm cho employee_profile
            $update_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->update([
                'profile_info' => $profile_info,
                'updated_at' => new \DateTime()
            ]);
            $profile = $profile_info + $employee_profile->profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;
            $update_employee = $employee_model->where('employee_id', $employee->employee_id)->update([
                'profile' => $profile,
                'status_employee' => $profile >= 40 ? 1 : 0,
                'updated_at' => new \DateTime()
            ]);
        }
        if (!empty($user_link_active)) {
            Auth::login($user_link_active, true);
            //gửi email thong báo cho admin
        }
//        MailConfigController::send_email_confirm_admin($user_link_active->email,'hotro@sanketoan.vn');
        //gửi thong báo trên window cho admin
        $list_user_admin = $user_model->select('name', 'id', 'email', 'role')->where('role', 4)->get();
        $noti_window_model = new NotificationWindow();
        foreach ($list_user_admin as $user_admin) {
            $insert = $noti_window_model->insert([
                'title_noti' => 'Sàn kế toán thông báo',
                'user_id' => $user_admin->id,
                'des_noti' => 'Có tài khoản vừa xác thực tại sanketoan.vn',
                'link_noti' => 'https://sanketoan.vn/admin/users?role=1&status_email_account=1&email=',
                'status_noti' => 0,
                'view_noti' => 0,
                'created_at' => new \DateTime()
            ]);
        }
        //noti thông báo cho diendan
        //công xu cho user ben diendan
        $user_intro = User_forum_code_intro::where('user_id', $user_link_active->id)->first();
        if (!empty($user_intro)) {
            //update trang thai ho sơ
            if (empty($user_intro->diendan_code_status)) {
                $update_intro = User_forum_code_intro::where('user_id', $user_link_active->id)->update([
                    'diendan_code_status' => 1
                ]);
                $user_coin = User::where('id', $user_intro->user_id_intro)->value('user_coin');
                $update_user_coin = User::where('id', $user_intro->user_id_intro)->update([
                    'user_coin' => $user_coin + 5
                ]);
                $noti_model = new Forum_notification();
                $noti_title = 'Bạn được nhận + 5 xu khi tài khoản ' . '<strong>' . $user_link_active->name . '</strong>' . ' xác thực tài khoản bên sanketoan.vn';
                $create_noti = $noti_model->insertGetId([
                    'noti_title' => $noti_title,
                    'for_post_id' => 0,
                    'for_comment_id' => 0,
                    'user_id' => $user_intro->user_id_intro,
                    'user_id_comment' => 0,
                    'noti_type' => 'user_pro',
                    'noti_status' => 0,
                    'type_status' => 'plus',
                    'created_at' => new \DateTime()
                ]);
            }
        }
        return view('site.default.show_confirm_account', compact('user_link_active'));
//        } catch (\Exception $e) {
//            $user_link_active = '';
//            return view('site.default.show_confirm_account', compact('user_link_active'));
//        }


    }
    //gửi thông báo cho ntd va show cv
    public function show_cv_notication($id_job_fb,$employee)
    {
        $job = new Job();
        $job = $job->select('*')->where('job_id', $id_job_fb)->first();
        if(!empty($job))
        {
            $employer = new Employer();
            $employer = $employer->select('employer_id', 'email','user_id')->where('employer_id', $job->employer_id)->first();
            //email nhận hồ sơ  của ứng viên úng tuyển
            $email_to_profile_employer = !empty($job->email_to_profile) ? $job->email_to_profile : $employer->email;
//                gủi email thông báo cho ugn vien
            MailConfigController::send_submit_job_email(1,$job,$employee,$employee->email,1);
//                $this->send_submit_job_email(1,$job,$emplo,$emplo->email);
//                gủi email thông báo cho ntd
            MailConfigController::send_submit_job_email(2,$job,$employee,$email_to_profile_employer,1);
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
        }
    }

    public function update(Request $request)
    {
        // try {
        DB::beginTransaction();
        // check user
        $user = Auth::user();
        // thêm mới vào bảng ứng viên
        $employeeId = $this->updateCandidate($request, $user->id);
        DB::commit($user);

        return redirect()->back();
        // } catch (\Exception $exception) {

        // } finally {
        //     return redirect()->back();
        // }
    }

    public function checkRoleUser()
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role == 2) {
                return true;
            } else {
                return false;
            }
        }
        return false;

    }

    public function show_employee(Request $request)
    {
//        if (!$this->checkRoleUser()) {
//            return redirect(route('portEmployer'))->with('error_login', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin ứng viên !');
//        }
        $user = Auth::user();
        $employees = new Employee();
        //sap xep theo so tien
        $vip_employee = $employees->select('employees.employee_id',
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
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->where('employees.status_employee', 1)
            ->where('employees.show_hidden_profile', 0);
        $vip_employee = $vip_employee->whereNotNull('employees.email');
        $vip_employee = $vip_employee->orderBy('employees.updated_at', 'desc');
        $vip_employee = $vip_employee->paginate(20);
        $vip_employee->appends(request()->query());
        return view('site.employee_site.list_employee', compact('vip_employee', 'user'));
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
        return view('site.employee_site.search_employee', compact('list_employee', 'count'));
    }

    public function detail_employee_show($employee_slug)
    {
        $employee = Employee::select(
            'employees.*',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->where('employees.employee_slug', $employee_slug)
            ->first();
        if (empty($employee)) {
            return redirect(route('home'));
        }
        $view = $employee->views + 1;
        $update_view = Employee::where('employees.employee_slug', $employee_slug)->update([
            'views' => $view
        ]);
        if ($view == 50) {
            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
        }
        if ($view == 100) {
            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
        }
        if ($view == 150) {
            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
        }
        //điểm của ứng viên
        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();

        return view('site.employee_site.detail_employee', compact('employee', 'employee_profile'));
    }
    public function test_detail_employee_show($employee_slug)
    {
        $employee = Employee::select(
            'employees.*',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->where('employees.employee_slug', $employee_slug)
            ->first();
//        if (empty($employee)) {
//            return redirect(route('home'));
//        }
//        $view = $employee->views + 1;
//        $update_view = Employee::where('employees.employee_slug', $employee_slug)->update([
//            'views' => $view
//        ]);
//        if ($view == 50) {
//            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
//        }
//        if ($view == 100) {
//            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
//        }
//        if ($view == 150) {
//            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
//        }
        //điểm của ứng viên
        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();

        return view('site.employee_site.test_detail_employee', compact('employee', 'employee_profile'));
    }

    public function link_preview_cv($employee_id ,Request $request)
    {
        $employee = Employee::select(
            'employees.*',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->where('employees.employee_id', $employee_id)
            ->first();
        $employer_id  = !empty($request->employer_id) ? $request->employer_id : 0;
        return view('site.employee_site.link_preview_cv', compact('employee','employer_id'));
    }
    public function link_preview_cv_full($employee_id ,Request $request)
    {
        $employee = Employee::select(
            'employees.*',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->where('employees.employee_id', $employee_id)
            ->first();
        $employer_id  = !empty($request->employer_id) ? $request->employer_id : 0;
        return view('site.employee_site.link_preview_cv_full', compact('employee','employer_id'));
    }

    //show item box cv
    public function box_detail_employee_show($employee_slug)
    {
        $employee = Employee::select(
            'employees.*',
            'salary.description',
            'province.province_name')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->where('employees.employee_slug', $employee_slug)
            ->first();
        if (empty($employee)) {
            return redirect(route('home'));
        }
        $view = $employee->views + 1;
        $update_view = Employee::where('employees.employee_slug', $employee_slug)->update([
            'views' => $view
        ]);
        if ($view == 50) {
            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
        }
        if ($view == 100) {
            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
        }
        if ($view == 150) {
            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
        }
        //điểm của ứng viên
        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();

        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();

        $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
        return view('site.employee_site.box_detail_employee', compact('employee'));
    }

    public function delete_file_html_employee($employee_slug)
    {
        $employee = Employee::select('employee_id', 'user_id')->where('employees.employee_slug', $employee_slug)
            ->first();

        $cv_upload = \App\Entity\Employee_upload_cv::get_employee_link_cv($employee->employee_id);
        $link_cv_upload = str_replace('/public', '', $cv_upload->employee_link_cv);
        $array = explode('/', $link_cv_upload);
        $array1 = explode('/', $link_cv_upload);
        $array_delete = array_pop($array1);
        $pre_link = implode('/', $array1);
        $name = end($array);
        $array_name = explode('.', $name);
        $name_file = current($array_name) . '-html';
        $link_html = $pre_link . '/' . $name_file . '.html';
        if (file_exists(public_path($link_html))) {
            unlink(public_path($link_html));
        }
        return back();
    }

    public function ajax_get_total_employee_carrer()
    {
        $list_carrer = Career::select('career_category_id')->get();
//        $count_employee = array();
        foreach ($list_carrer as $id => $carrer) {
            $employees = new Employee();
            $count_employee[$carrer->career_category_id] = $employees->join('employee_career_categories', 'employee_career_categories.employee_id', '=', 'employees.employee_id')
                ->where('employee_career_categories.career_category_id', $carrer->career_category_id)
                ->where('employees.status_employee', 1)
                ->where('employees.show_hidden_profile', 0)
                ->count();
        }
        return response([
            'status' => 200,
            'count_employee' => $count_employee,
        ])->header('Content-Type', 'text/plain');

    }

    public function ajax_get_total_employee_province()
    {
        $list_province = Province::select('province_id')->get();
//        $count_employee = array();
        foreach ($list_province as $id => $province) {
            $employees = new Employee();
            $count_employee[$province->province_id] = $employees->where('employees.province', $province->province_id)
                ->where('employees.status_employee', 1)
                ->where('employees.show_hidden_profile', 0)
                ->count();
        }
        return response([
            'status' => 200,
            'count_employee' => $count_employee,
        ])->header('Content-Type', 'text/plain');

    }

    public function search_employee_view_mobile(Request $request)
    {
        $list_employee = array();
        if (!empty($request->input())) {

            $user = Auth::user();
            $employees = new Employee();
            $list_employee = $employees->select('employees.employee_id',
                'employees.employee_name',
                'employees.employee_image',
                'employees.updated_at as date_update',
                'employees.created_at as date_create',
                'employees.status',
                'employees.profile',
                'career_categories.career_category_name',
                'salary.description',
                'employees.gender',
                'employees.birthday',
                'province.province_name',
                'district.district_name')
                ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id')
                ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
                ->leftJoin('province', 'province.province_id', '=', 'employees.province')
                ->leftJoin('district', 'district.district_id', '=', 'employees.district');
//            ->where('employees.status_employee', 1);

            if (!empty($request->input('career'))) {
                $career = $request->input('career');
                $list_employee = $list_employee->where('employees.career_category_id', $career);
            }
            if (!empty($request->input('array_career'))) {
                $array_career = $request->input('array_career');
                $list_employee = $list_employee->whereIn('employees.career_category_id', $array_career);
            }
            if (!empty($request->input('province'))) {
                $province = $request->input('province');
                $list_employee = $list_employee->where('employees.province', $province);
            }
            if (!empty($request->input('district'))) {
                $district = $request->input('district');
                $list_employee = $list_employee->where('employees.district', $district);
            }
            if (!empty($request->input('salary_id'))) {
                $salary_id = $request->input('salary_id');
                $list_employee = $list_employee->where('employees.salary_id', $salary_id);
            }
            if (!empty($request->input('array_salary'))) {
                $array_salary_id = $request->input('array_salary');
                $list_employee = $list_employee->whereIn('employees.salary_id', $array_salary_id);
            }

            if (!empty($request->input('word'))) {
                $word = $request->input('word');
                $list_employee = $list_employee->where('employees.employee_name', 'like', '%' . $word . '%');
            }

            if (!empty($request->input('employee_level_id'))) {
                $employee_level_id = $request->input('employee_level_id');
                $list_employee = $list_employee->where('employees.employee_level_id', $employee_level_id);
            }
            if (!empty($request->input('experience_id'))) {
                $experience_id = $request->input('experience_id');
                $list_employee = $list_employee->where('employees.experience_id', $experience_id);
            }
            if (!empty($request->input('email'))) {
                $email = $request->input('email');
                $list_employee = $list_employee->where('employees.email', $email);
            }
            if ($request->has('status')) {
                $status = $request->input('status');
                $list_employee = $list_employee->where('employees.status', $status);
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
                    $list_employee = $list_employee->where('employees.time_to_work', '>', 0);
                } else {
                    $list_employee = $list_employee->where('employees.time_to_work', '=', $time_ex);
                    $list_employee = $list_employee->where('employees.time_to_work', '>', 0);
                }
            }
            $list_employee = $list_employee->whereNotNull('employees.email');
            $list_employee = $list_employee->orderBy('employees.updated_at', 'desc');
            $list_employee = $list_employee->paginate(21);
            $list_employee->appends(request()->query());
            return view('site.employee.search_employee_view_mobile', compact('list_employee', 'user'));
        } else {
            return view('site.employee.search_employee_view_mobile', compact('list_employee', 'user'));
        }

    }

    private function updateCandidate($request, $userId)
    {
        // try {
        if ($request->hasFile('fuFileAttach')) {
            $file = $request->file('fuFileAttach');
            $name = $file->getClientOriginalName();
            $file->move('/CV/', $name);
        }
        $employee = '';
        if (Auth::check()) {
            $employee = Employee::where('employee_user_id', Auth::user()->id)->first();
        }

        // Nếu chưa tồn tại ứng viên thì thêm mới
        if (empty($employee)) {
            return $this->addEmployee($request, $userId);
        }

        //Nếu đã tồn tại employee
        return $this->updateEmployee($request, $employee->employee_id);
        //cập nhật user

        return $this->updateUser($request);

        // } catch (\Exception $e) {
        //     return 0;
        // }
    }


    private function updateEmployee($request, $employeeId)
    {

        Employee::where('employee_id', $employeeId)
            ->update([
                'employee_name' => $request->input('employee_name'),
                'phone' => $request->input('phone'),
                'email' => $request->has('email') ? $request->input('email') : '',
                'gender' => $request->input('gender'),
                'marry' => $request->input('marry'),
                'birthday' => $request->input('birthday'),
                'province' => $request->input('province'),
                'district' => $request->input('district'),
                'address' => $request->input('address'),
                'information_verifier' => $request->input('information_verifier'),
                'address_stay' => $request->input('address_stay'),
                'school' => $request->input('school'),
                'majors' => $request->input('majors'),
                'my_facebook' => $request->input('my_facebook'),
                'literacy' => $request->input('literacy'),
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

    public function ajax_employee_follow_employer(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employer_id = $request->input('employer_id');
        $employee_follow_employer_model = new Employee_follow_employer();
        $check_employee_folloew_employer = $employee_follow_employer_model->select('*')->where('employee_id', $employee_id)
            ->where('employer_id', $employer_id)
            ->first();
        if (empty($check_employee_folloew_employer)) {
            $insert_id = $employee_follow_employer_model->insertGetId([
                'employee_id' => $employee_id,
                'employer_id' => $employer_id,
                'created_at' => new \DateTime()
            ]);
            if (!empty($insert_id)) {
                return response([
                    'status' => 200,
                ])->header('Content-Type', 'text/plain');
            } else {
                return response('Error', 404)
                    ->header('Content-Type', 'text/plain');
            }
        } else {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }

    }

    public function ajax_delete_employee_follow_employer(Request $request)
    {
        try {
            $employee_id = $request->input('employee_id');
            $employer_id = $request->input('employer_id');
            $delete = Employee_follow_employer::where('employee_id', $employee_id)
                ->where('employer_id', $employer_id)
                ->delete();
            return response([
                'status' => 200,
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function updateUser($request)
    {
        $user = Auth()->user();
        $user->update([
            'users' => $request->input('image')
        ]);
        return $user;
    }


    public function showJob()
    {

        $user = Auth::user();
        $employeeModel = new Employee();
        $employee = $employeeModel->select(
            'employees.*'
        )
            ->where('employees.user_id', $user->id)
            ->first();

        if (empty($employee)) {
            return redirect()->back()->with('error', 'Không tìm thấy hồ sơ ứng viên');
        }

        $historyCompanies = HistoryWork::where('employee_id', $employee->employee_id)->get();
        if ($historyCompanies->isEmpty()) {
            $historyCompanies = '';
        }
        return view('site.infomation.employee.listJob', compact('user', 'employee', 'historyCompanies'));

    }

    public function showJobRecruitment()
    {
        $user = Auth::user();
        $employeeModel = new Employee();
        $employee = $employeeModel->select(
            'employees.*'
        )
            ->where('employees.employee_user_id', $user->id)
            ->first();

        $historyCompanies = HistoryWork::where('employee_id', $employee->employee_id)->get();
        if ($historyCompanies->isEmpty()) {
            $historyCompanies = '';
        }
        return view('site.infomation.employee.listJobInvited', compact('user', 'employee', 'historyCompanies'));
    }


    public function acceptJob(Request $request, $jobId)
    {
        $job = Job::where('job_id', $jobId)->first();
        $employee = '';
        $historyCompanies = '';
        if (Auth::check()) {
            $employee = Employee::where('employee_user_id', Auth::user()->id)->first();
            if (!empty($employee)) {
                // $historyCompanies = HistoryWork::where('employee_id', $employee->employee_id)->get();
                // if ($historyCompanies->isEmpty()) {
                // $historyCompanies = '';
                // }

                // tạo đơn hàng
                $this->createOrder($request, $employee->employee_id, $job->job_id);
                // thay đổi trạng thái đơn lời mời

                $this->updateInvite($request, $jobId, $employee->employee_id);


                //gửi lên chiến dịch getfly
                $this->addNewCampaignGetfly($request, $employee, $job->job_id);

                DB::commit();

                return redirect()->back()->with('success', 'Nộp hồ sơ thành công ');

            }
        }
        return redirect()->back()->with('job', 'employee', 'historyCompanies');

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

    private function updateInvite($request, $jobId, $employeeId)
    {
        $inviteModel = new Invite();
        $inviteChange = $inviteModel->where('invite.employee_id', $employeeId)
            ->where('invite.job_id', $jobId)
            ->update([
                //đổi trạng thái stt
                'invite.status' => 1,
                'updated_at' => new \DateTime()
            ]);
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

    public function update_profile_employee()
    {
        $list_employee = Employee::select('*')->get();
        foreach ($list_employee as $employee) {
            $update = \App\Entity\Employee::get_user_id_Profile($employee->user_id);
        }
    }

    //xxem hồ so thi
    public function detail_exam_employee($employee_id, $job_facebook_id)
    {
        $result_job_exam = new Result_job_exam();
        $result_job_exam = $result_job_exam->select('*')
            ->where('job_id', $job_facebook_id)
            ->where('employee_id', $employee_id)
            ->first();
        if (empty($result_job_exam)) {
            return redirect(route('list_Job_Candidate_Employee'))->with('error_job', 'Ứng viên này chưa làm đề thi');
        }
        $id_exam = $result_job_exam->id_exam;
        $question = new Questions();
//        câu hỏi trắc nghiệm
        $question_1 = $question->select('*')
            ->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', 0)
            ->get();
        $question_2 = $question->select('*')
            ->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', 1)
            ->get();
        $question_3 = $question->select('*')
            ->where('id_exam', '=', $id_exam)
            ->where('type_ques', '=', 2)
            ->get();

        return view('site.job_facebook.show_result_exam_job', compact('id_exam', 'employee_id', 'result_id', 'question_1', 'question_2', 'question_3', 'result_job_exam'));
    }

    public function updateImage()
    {
        $employee_model = new Employee();
        $list_employee = $employee_model->select('employee_id', 'employee_image', 'user_id')
            ->whereNull('employee_image');
        $total = $list_employee->count();
        $list_employee = $list_employee->get();

        foreach ($list_employee as $employee) {
            $update = $employee_model->where('employee_id', $employee->employee_id)->update([
                'employee_image' => '/CV/Profile.jpg',
            ]);
        }
        echo $total;
        echo '<pre>';
        print_r($list_employee);
        die();
//        GetImageSize
    }

    public function listImage64()
    {
        $employee_model = new Employee();
        $list_employee = $employee_model->select('employee_id', 'employee_image', 'user_id')
            ->whereNotNull('employee_image');
        $total = $list_employee->count();
        $list_employee = $list_employee->get();
        $total_image = 0;
        foreach ($list_employee as $employee) {
            if (strlen($employee->employee_image) > 200) {
                echo '<pre>';
//                echo $employee->employee_image;
                echo $employee->employee_id;
                echo '<img src="' . $employee->employee_image . '" style="width:50px;" />';
                $total_image = $total_image + 1;
            }
        }
        echo '--------------';
        echo $total_image;
    }

    public function employee_curriculum_vitae()
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $user_id = Auth::user()->id;
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();
        $employee_curriculum = '';
        $employee_curriculum = Employee_curriculum::select('employee_curriculum.*', 'employee_curriculum_extend.*')
            ->leftJoin('employee_curriculum_extend', 'employee_curriculum_extend.employee_id', 'employee_curriculum.employee_id')
            ->where('employee_curriculum.employee_id', $employee->employee_id)
            ->first();
        return view('site.employee.employee_curriculum_vitae ', compact('employee', 'employee_curriculum'));
    }

    public function post_employee_curriculum_vitae(Request $request)
    {
        try {
            if (!Auth::check() || Auth::user()->role != 1) {
                return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
            }
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $ckeditor = new CkedittorController();
            $session_image = $ckeditor->checkImage();
            $user_id = Auth::user()->id;
            $employee = Employee::select('employee_id',
                'employee_code',
                'employee_name',
                'employee_image',
                'phone',
                'email',
                'province',
                'district',
                'address',
                'file_cv',
                'gender',
                'birthday',
                'marry',
                'school',
                'majors',
                'cmt',
                'cmt_date',
                'cmt_local',
                'user_id'
            )->where('user_id', $user_id)->first();
            $check_employee_curri = '';
            $check_employee_curri = Employee_curriculum::where('employee_id', $employee->employee_id)->count();
            //isert lý lịch
            if (empty($check_employee_curri)) {
                $this->insert_curriculum_vitae($employee, $request);
            } //update lý lịch
            else {
                $this->update_curriculum_vitae($employee, $request);
                if ($request->export == 'export') {
                    return redirect()->route('exportpdf_ll');
                }
            }
            $update = \App\Entity\Employee::get_user_id_Profile($user_id);
            return redirect()->back()->with('success', 'Cập nhật sơ yếu lý lịch thành công');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Cập nhật sơ yếu lý lịch thất bại ');
        }

    }

    public function insert_curriculum_vitae($employee, $request)
    {
        $user_id = Auth::user()->id;
        $insert_curriculum = Employee_curriculum::insertGetId([
            'employee_id' => $employee->employee_id,
            'user_id_handing' => $user_id,
            'created_at' => new \DateTime(),
            'anh4x6' => $request->input('anh4x6'),
            'hoten' => $request->input('hoten'),
            'gioitinh' => $request->input('gioitinh'),
            'ns_ngay' => $request->input('ns_ngay'),
            'ns_thang' => $request->input('ns_thang'),
            'ns_nam' => $request->input('ns_nam'),
            'dk_tt' => $request->input('dk_tt'),
            'cmtnd' => $request->input('cmtnd'),
            'noicap' => $request->input('noicap'),
            'cm_ngay' => $request->input('cm_ngay'),
            'cm_thang' => $request->input('cm_thang'),
            'cm_nam' => $request->input('cm_nam'),
            'dt_home' => $request->input('dt_home'),
            'mobile' => $request->input('mobile'),
            'baotin' => $request->input('baotin'),
            'sohieu' => $request->input('sohieu'),
            'kyhieu' => $request->input('kyhieu'),
            'hoten_p2' => $request->input('hoten_p2'),
            'bidanh' => $request->input('bidanh'),
            'tenthuonggoi' => $request->input('tenthuonggoi'),
            'ns_ngay_p2' => $request->input('ns_ngay_p2'),
            'ns_thang_p2' => $request->input('ns_thang_p2'),
            'ns_nam_p2' => $request->input('ns_nam_p2'),
            'tai_p2' => $request->input('tai_p2'),
            'nguyenquan' => $request->input('nguyenquan'),
            'dk_tt_p2' => $request->input('dk_tt_p2'),
            'dantoc' => $request->input('dantoc'),
            'tongiao' => $request->input('tongiao'),
            'thanhphan_bt' => $request->input('thanhphan_bt'),
            'vanhoa' => $request->input('vanhoa'),
            'ngoaingu' => $request->input('ngoaingu'),
            'chuyenmon' => $request->input('chuyenmon'),
            'loaihinh_dt' => $request->input('loaihinh_dt'),
            'chuyennganh_dt' => $request->input('chuyennganh_dt'),
            'dang_ngay' => $request->input('dang_ngay'),
            'dang_thang' => $request->input('dang_thang'),
            'dang_nam' => $request->input('dang_nam'),
            'dang_ketnap' => $request->input('dang_ketnap'),
            'doan_ngay' => $request->input('doan_ngay'),
            'doan_thang' => $request->input('doan_thang'),
            'doan_nam' => $request->input('doan_nam'),
            'doan_ketnap' => $request->input('doan_ketnap'),
            'suckhoe' => $request->input('suckhoe'),
            'cao' => $request->input('cao'),
            'can_nang' => $request->input('can_nang'),
            'nghenghiep_chuyenmon' => $request->input('nghenghiep_chuyenmon'),
            'capbac' => $request->input('capbac'),
            'luongchinh' => $request->input('luongchinh'),
            'ngaynhapngu' => $request->input('ngaynhapngu'),
            'ngayxuatngu' => $request->input('ngayxuatngu'),
            'lydo_p2' => $request->input('lydo_p2'),
        ]);
//        insert_employee_culum_exntend
        $insert_curriculum_extennt = Employee_curriculum_extend::insert([
            'curri_id' => $insert_curriculum,
            'employee_id' => $employee->employee_id,
            'htbo' => $request->input('htbo'),
            'tuoibo' => $request->input('tuoibo'),
            'nn_bo' => $request->input('nn_bo'),
            'bo_thang8' => $request->input('bo_thang8'),
            'bo_khangphap' => $request->input('bo_khangphap'),
            'bo_1955' => $request->input('bo_1955'),
            'htme' => $request->input('htme'),
            'tuoime' => $request->input('tuoime'),
            'nn_me' => $request->input('nn_me'),
            'me_thang8' => $request->input('me_thang8'),
            'me_khangphap' => $request->input('me_khangphap'),
            'me_1955' => $request->input('me_1955'),
            'giadinh' => $request->input('giadinh'),
            'hotenvc' => $request->input('hotenvc'),
            'tuoivc' => $request->input('tuoivc'),
            'nn_vc' => $request->input('nn_vc'),
            'noi_nn_vc' => $request->input('noi_nn_vc'),
            'noio_vc' => $request->input('noio_vc'),
            'tencon1' => $request->input('tencon1'),
            'tuoicon1' => $request->input('tuoicon1'),
            'nn_con1' => $request->input('nn_con1'),
            'tencon2' => $request->input('tencon2'),
            'tuoicon2' => $request->input('tuoicon2'),
            'nn_con2' => $request->input('nn_con2'),
            'tencon3' => $request->input('tencon3'),
            'tuoicon3' => $request->input('tuoicon3'),
            'nn_con3' => $request->input('nn_con3'),
            'tencon4' => $request->input('tencon4'),
            'tuoicon4' => $request->input('tuoicon4'),
            'nn_con4' => $request->input('nn_con4'),
            'tencon5' => $request->input('tencon5'),
            'tuoicon5' => $request->input('tuoicon5'),
            'nn_con5' => $request->input('nn_con5'),
            'ht_day' => $request->input('ht_day'),
            'ht_congtac' => $request->input('ht_congtac'),
            'ht_odau' => $request->input('ht_odau'),
            'ht_chucvu' => $request->input('ht_chucvu'),
            'khenthuong' => $request->input('khenthuong'),
            'kyluat' => $request->input('kyluat'),
            'xacnhan' => $request->input('xacnhan'),
            'local' => $request->input('local'),
            'local_ngay' => $request->input('local_ngay'),
            'local_thang' => $request->input('local_thang'),
            'local_nam' => $request->input('local_nam'),
            'created_at' => new \DateTime(),
        ]);
        return true;

    }

    public function update_curriculum_vitae($employee, $request)
    {
        $user_id = Auth::user()->id;
        $insert_curriculum = Employee_curriculum::where('employee_id', $employee->employee_id)->update([
            'user_id_handing' => $user_id,
            'updated_at' => new \DateTime(),
            'anh4x6' => $request->input('anh4x6'),
            'hoten' => $request->input('hoten'),
            'gioitinh' => $request->input('gioitinh'),
            'ns_ngay' => $request->input('ns_ngay'),
            'ns_thang' => $request->input('ns_thang'),
            'ns_nam' => $request->input('ns_nam'),
            'dk_tt' => $request->input('dk_tt'),
            'cmtnd' => $request->input('cmtnd'),
            'noicap' => $request->input('noicap'),
            'cm_ngay' => $request->input('cm_ngay'),
            'cm_thang' => $request->input('cm_thang'),
            'cm_nam' => $request->input('cm_nam'),
            'dt_home' => $request->input('dt_home'),
            'mobile' => $request->input('mobile'),
            'baotin' => $request->input('baotin'),
            'sohieu' => $request->input('sohieu'),
            'kyhieu' => $request->input('kyhieu'),
            'hoten_p2' => $request->input('hoten_p2'),
            'bidanh' => $request->input('bidanh'),
            'tenthuonggoi' => $request->input('tenthuonggoi'),
            'ns_ngay_p2' => $request->input('ns_ngay_p2'),
            'ns_thang_p2' => $request->input('ns_thang_p2'),
            'ns_nam_p2' => $request->input('ns_nam_p2'),
            'tai_p2' => $request->input('tai_p2'),
            'nguyenquan' => $request->input('nguyenquan'),
            'dk_tt_p2' => $request->input('dk_tt_p2'),
            'dantoc' => $request->input('dantoc'),
            'tongiao' => $request->input('tongiao'),
            'thanhphan_bt' => $request->input('thanhphan_bt'),
            'vanhoa' => $request->input('vanhoa'),
            'ngoaingu' => $request->input('ngoaingu'),
            'chuyenmon' => $request->input('chuyenmon'),
            'loaihinh_dt' => $request->input('loaihinh_dt'),
            'chuyennganh_dt' => $request->input('chuyennganh_dt'),
            'dang_ngay' => $request->input('dang_ngay'),
            'dang_thang' => $request->input('dang_thang'),
            'dang_nam' => $request->input('dang_nam'),
            'dang_ketnap' => $request->input('dang_ketnap'),
            'doan_ngay' => $request->input('doan_ngay'),
            'doan_thang' => $request->input('doan_thang'),
            'doan_nam' => $request->input('doan_nam'),
            'doan_ketnap' => $request->input('doan_ketnap'),
            'suckhoe' => $request->input('suckhoe'),
            'cao' => $request->input('cao'),
            'can_nang' => $request->input('can_nang'),
            'nghenghiep_chuyenmon' => $request->input('nghenghiep_chuyenmon'),
            'capbac' => $request->input('capbac'),
            'luongchinh' => $request->input('luongchinh'),
            'ngaynhapngu' => $request->input('ngaynhapngu'),
            'ngayxuatngu' => $request->input('ngayxuatngu'),
            'lydo_p2' => $request->input('lydo_p2'),
        ]);
        $update = Employee_curriculum_extend::where('employee_id', $employee->employee_id)->update([
            'employee_id' => $employee->employee_id,
            'htbo' => $request->input('htbo'),
            'tuoibo' => $request->input('tuoibo'),
            'nn_bo' => $request->input('nn_bo'),
            'bo_thang8' => $request->input('bo_thang8'),
            'bo_khangphap' => $request->input('bo_khangphap'),
            'bo_1955' => $request->input('bo_1955'),
            'htme' => $request->input('htme'),
            'tuoime' => $request->input('tuoime'),
            'nn_me' => $request->input('nn_me'),
            'me_thang8' => $request->input('me_thang8'),
            'me_khangphap' => $request->input('me_khangphap'),
            'me_1955' => $request->input('me_1955'),
            'giadinh' => $request->input('giadinh'),
            'hotenvc' => $request->input('hotenvc'),
            'tuoivc' => $request->input('tuoivc'),
            'nn_vc' => $request->input('nn_vc'),
            'noi_nn_vc' => $request->input('noi_nn_vc'),
            'noio_vc' => $request->input('noio_vc'),
            'tencon1' => $request->input('tencon1'),
            'tuoicon1' => $request->input('tuoicon1'),
            'nn_con1' => $request->input('nn_con1'),
            'tencon2' => $request->input('tencon2'),
            'tuoicon2' => $request->input('tuoicon2'),
            'nn_con2' => $request->input('nn_con2'),
            'tencon3' => $request->input('tencon3'),
            'tuoicon3' => $request->input('tuoicon3'),
            'nn_con3' => $request->input('nn_con3'),
            'tencon4' => $request->input('tencon4'),
            'tuoicon4' => $request->input('tuoicon4'),
            'nn_con4' => $request->input('nn_con4'),
            'tencon5' => $request->input('tencon5'),
            'tuoicon5' => $request->input('tuoicon5'),
            'nn_con5' => $request->input('nn_con5'),
            'ht_day' => $request->input('ht_day'),
            'ht_congtac' => $request->input('ht_congtac'),
            'ht_odau' => $request->input('ht_odau'),
            'ht_chucvu' => $request->input('ht_chucvu'),
            'khenthuong' => $request->input('khenthuong'),
            'kyluat' => $request->input('kyluat'),
            'xacnhan' => $request->input('xacnhan'),
            'local' => $request->input('local'),
            'local_ngay' => $request->input('local_ngay'),
            'local_thang' => $request->input('local_thang'),
            'local_nam' => $request->input('local_nam'),
            'created_at' => new \DateTime(),
        ]);
        return true;
    }

    public function setting_profile_employee(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        $id = Auth::user()->id;
        $role = Auth::user()->role;
        $employees = new Employee();
        $employee = $employees->select('*')->where('user_id', $id)->first();

        return view('site.employee.setting_profile_employee', compact('employee'));

    }

    public function update_setting_profile_employee(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
        }
        $user = Auth::user();
        $id = Auth::user()->id;
        $role = Auth::user()->role;
        $employees = new Employee();
        $update_show_hidden = $employees->where('user_id', $id)->update([
            'show_hidden_profile' => $request->input('show_hidden_profile'),
            'show_hidden_syll' => $request->input('show_hidden_syll'),
            'status' => $request->input('status'),
            'updated_at' => new \DateTime()
        ]);
        return redirect()->back()->with('suscess', 'Lưu cài đặt thành công');
    }

    public function create_emplyee_cv(Request $request)
    {
        $user_id = Auth::user()->id;
        $employees = new Employee();
        $employee = $employees->select('*')->where('user_id', $user_id)->first();
        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        //kiem tra xem ứng viên đã hoàn thiện hồ sơ chưa

        $profile_info_account = !empty(Auth::user()->status_email_account) ? 5 : 0;
        if (($employee_profile->profile_info - $profile_info_account) < 12) {
            return redirect(route('show_file_job_facebook'))->with('error', 'Vui lòng hòan thiện hồ sơ trước khi tạo CV');
        }
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id', 'my_facebook'
        )->where('user_id', $user_id)->first();
        $cv_template = Cv_template::select('*')->first();
        $cv_note_template = Cv_note_template::select('*')->where('cv_template_id', $cv_template->cv_template_id)->first();

        $check_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->count();
        if (!empty($check_employee)) {
            $cv_employee = Cv_employee::select('*')->where('employee_id', $employee->employee_id)->first();
//            echo '<pre>';
//            print_r($cv_employee);die();
            return view('site.employee.edit_employee_cv', compact('employee', 'cv_template', 'cv_note_template', 'cv_employee'));
        }
        return view('site.employee.employee_cv', compact('employee', 'cv_template', 'cv_note_template'));
    }

    private function disable_cv_upload()
    {
        $employee = Employee::where('user_id', Auth::id())->first();
        $employee_upload_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)
            ->where('employee_cv_status', 1)
            ->first();
        if (!empty($employee_upload_cv)) {
            $employee_upload_cv->update([
                'employee_cv_status' => 0
            ]);
        }
    }

    public function store_update_cv(Request $request)
    {

        $user_id = Auth::id();
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'profile',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();
//        insert table cv_employee
        $cv_employee_model = new Cv_employee();
        $check_employee_cv = $cv_employee_model->where('employee_id', $employee->employee_id)->count();
//        $cv_color = $request->input('cv_color');echo $cv_color;die();

        $this->note_update_profile($employee);

        if ($check_employee_cv > 0) {
//            update cv
            $this->update_cv($request, $employee);
            $employee_model = new Employee();

            //diểm của cv
            $profile_cv = $employee_model->check_profile_cv($user_id);
            //cập nhật điểm cho ứng viên
            $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
            $update_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->update([
                'profile_cv' => $profile_cv,
                'updated_at' => new \DateTime()
            ]);
            $profile = $employee_profile->profile_info + $profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;
            $update_employee = $employee_model->where('employee_id', $employee->employee_id)->update([
                'profile' => $profile,
                'status_employee' => $profile >= 40 ? 1 : 0,
                'updated_at' => new \DateTime()
            ]);
            //tieens hang gui email marketting
//            if ($profile > 40) {
//                $this->send_email_employer($employee->employee_id);
//            }
            //cập nhật lại điểm cho employee_profile

            if ($request->export == 'export') {
                return redirect()->route('exportpdf_cv');
            }
            if ($request->export == 'save_next') {
                return redirect(route('employee_curriculum_vitae'))->with('success', 'Lưu CV thành công');
            }
        } else {
            $this->store_cv($request, $employee);
            $employee_model = new Employee();
            //diểm của cv
            $profile_cv = $employee_model->check_profile_cv($user_id);
            //cập nhật điểm cho ứng viên

            $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
            $update_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->update([
                'profile_cv' => $profile_cv,
                'updated_at' => new \DateTime()
            ]);
            $profile = $employee_profile->profile_info + $profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;
            $update_employee = $employee_model->where('employee_id', $employee->employee_id)->update([
                'profile' => $profile,
                'status_employee' => $profile >= 40 ? 1 : 0,
                'updated_at' => new \DateTime()
            ]);
            //tieens hang gui email marketting
//            if ($profile > 40) {
//                $this->send_email_employer($employee->employee_id);
//            }
            if ($request->export == 'export') {
                return redirect()->route('exportpdf_cv');
            }
            if ($request->export == 'save_next') {
                return redirect(route('employee_curriculum_vitae'))->with('success', 'Lưu CV thành công');
            }
        }
        //diểm của cv
        $employee_model = new Employee();
        $profile_cv = $employee_model->check_profile_cv($user_id);
        //cập nhật điểm cho ứng viên
        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
        $update_employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->update([
            'profile_cv' => $profile_cv,
            'updated_at' => new \DateTime()
        ]);
        $profile = $employee_profile->profile_info + $profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;
        $update_employee = $employee_model->where('employee_id', $employee->employee_id)->update([
            'profile' => $profile,
            'status_employee' => $profile >= 40 ? 1 : 0,
            'updated_at' => new \DateTime()
        ]);
        //tieens hang gui email marketting
//        if ($profile > 40) {
//            $this->send_email_employer($employee->employee_id);
//        }

        //guii thong bao

        return redirect(route('create_emplyee_cv'))->with('success', 'Lưu CV thành công');
    }

    public function note_update_profile($employee)
    {
        //gửi thông báo info den ứng viên
        $noti_model = new Notification_employer();
        $employeeRecord = Employee::select('employee_id', 'employee_name', 'employee_slug')
            ->where('employee_id', $employee->employee_id)
            ->first();

        if (empty($employeeRecord)) {
            return;
        }

        $employeeSlug = trim((string) $employeeRecord->employee_slug);
        if ($employeeSlug === '') {
            $slugBase = Str::slug((string) $employeeRecord->employee_name);
            $employeeSlug = ($slugBase !== '' ? $slugBase : 'ung-vien')
                . '-' . $employeeRecord->employee_id;

            $employeeRecord->update([
                'employee_slug' => $employeeSlug,
                'updated_at' => new \DateTime(),
            ]);
        }

        $link_noti = route('detail_employee_show', ['employee_slug' => $employeeSlug]);

        //danh sach cong viec can tim  career_category_id
        $list_carrer = Employee_career_categories::where('employee_id', $employee->employee_id)->get();
        $career_category_id = array();
        foreach($list_carrer as $carrer)
        {
            $career_category_id[] = $carrer->career_category_id;
        }
//        $list_employer = Employer::where('province',$employee->province);
        $jobModel = new Job();
        $list_jobs = $jobModel->select('employer_id','job_id','title');
        $list_jobs = $list_jobs->whereDate('jobs.deadline_submit_profile', '>=', date('Y-m-d'));
        $list_jobs = $list_jobs->where('jobs.active_job', 1);
        $list_jobs = $list_jobs->where('jobs.province', $employee->province);
        $list_jobs = $list_jobs->whereIn('jobs.career_category_id', $career_category_id);
        $list_jobs = $list_jobs->orderBy('jobs.vip', 'desc');
        $list_jobs = $list_jobs->orderBy('jobs.updated_at', 'desc');
        $list_jobs = $list_jobs->skip(0)->take(20)->get();
        foreach($list_jobs as $job)
        {
            $user_id = Employer::where('employer_id',$job->employer_id)->value('user_id');
            $noti_insert =  $noti_model->insert([
                'title_noti' => 'Sanketoan.vn thông báo',
                'user_id' => $user_id,
                'employee_id' => $employee->employee_id,
                'job_id' => $job->job_id,
                'des_noti' => 'Có ứng viên mới phù hợp với công việc '.$job->title ,
                'link_noti' => $link_noti,
                'type_noti' => 'detail_employee',
                'created_at' => new \DateTime()
            ]);
//                    gui api thong bao tren mobile
            $api_push_noti = new NotificationMobileController();
            $title = 'Sàn kế toán thông báo';
            $body =  'Có ứng viên mới phù hợp với công việc '.$job->title;
            $type = 'jobs';
            $note = 'Ứng viên trên  sanketoan $value đã id của ứng viên';
            $value = $employee->employee_id;
            $to = $user_id;
            $send_noti = $api_push_noti->pushNotification( $title, $body, $to,$type,$note,$value);
        }
    }

    //gửi email marketting
    public function send_email_employer($employee_id)
    {
        $province = Employee::where('employee_id', $employee_id)->value('province');
        $district_array_id = Employee_district::get_array_district_id($employee_id);

        $employer_model = new Employer();
        $list_employer = $employer_model->select('employer.email as employer_email', 'send_user_email_marketting.email as send_email')->where('province', $province);
        if (!empty($district_array_id)) {
            $list_employer = $list_employer->whereIn('district', $district_array_id);
        }
        $list_employer = $list_employer->leftJoin('send_user_email_marketting', 'send_user_email_marketting.email', '=', 'employer.email');
        $list_employer = $list_employer->whereNull('send_user_email_marketting.email')
            ->limit(10)->get();
        if (!empty($list_employer)) {
            foreach ($list_employer as $employer) {
                MailConfigController::send_email_profile_job($employee_id, $employer->employer_email);
            }
        }
    }

    public function update_cv($request, $employee)
    {
        try {
//        echo  $request->images;die();
            //sắp xếp các khối bên trái với id="box01" tương ứng
            //sắp xếp từ vị trí thứ 2
            $cv_order = implode(',', $request->cv_order);
            // ẩn hiện của các khối
            $show_hidden_cv_order = implode(',', $request->show_hidden_cv_order);
            //sắp xếp các khối bên phải với id="block01" tương ứng
            // sắp xếp từ vị trí thứ 1
            $cv_order_join = implode(',', $request->cv_order_join);
            // ẩn hiện của các khối
            $show_hidden_cv_order_join = implode(',', $request->show_hidden_cv_order_join);


            $cv_employee_model = new Cv_employee();
            $cv_employee = $cv_employee_model->select('cv_id', 'employee_id')
                ->where('employee_id', $employee->employee_id)
                ->first();
//        update table cv_employee
            $insert_id_cv_employee = $cv_employee->cv_id;
            $update_id_cv_employee = $cv_employee_model->where('cv_id', $insert_id_cv_employee)->update([
//            'cv_template_id' => 1,
                'cv_title' => $request->cv_title,
                'status_update' => 0,
                'cv_template_id' => $request->cv_template_id,
                'cv_color' => $request->cv_color,
                'cv_name' => $request->cv_name,
                'cv_title_job' => $request->cv_title_job,
                'cv_image' => $request->images,
                'cv_email' => $request->cv_email,
                'cv_phone' => $request->cv_phone,
                'cv_birthday' => $request->cv_birthday,
                'cv_address' => $request->cv_address,
                'cv_facebook' => $request->cv_facebook,
                'cv_title_career_goals' => $request->cv_title_career_goals,
                'cv_career_goals' => $request->cv_career_goals,
                'cv_title_prize' => $request->cv_title_prize,
                'cv_prize' => $request->cv_prize,
                'cv_title_card' => $request->cv_title_card,
                'cv_card' => $request->cv_card,
                'cv_title_interests' => $request->cv_title_interests,
                'cv_interests' => $request->cv_interests,
                'cv_title_reference_person' => $request->cv_title_reference_person,
                'cv_reference_person' => $request->cv_reference_person,
                'title_cv_skills' => $request->title_cv_skills,
                'title_cv_specialize' => $request->title_cv_specialize,
                'title_cv_experience' => $request->title_cv_experience,
                'title_cv_work' => $request->title_cv_work,
                'title_cv_project' => $request->title_cv_project,
                'title_cv_info' => $request->title_cv_info,
                'cv_order' => $cv_order,
                'show_hidden_cv_order' => $show_hidden_cv_order,
                'cv_order_join' => $cv_order_join,
                'show_hidden_cv_order_join' => $show_hidden_cv_order_join,
                'updated_at' => new \DateTime(),
            ]);
            //update table skill
            $skils_model = new Cv_skills();

            $delete = $skils_model->where('cv_id', $insert_id_cv_employee)->delete();
            //input mảng post lên
            $cv_skill_title_array = $request->cv_skill_title;
            $cv_skill_value_array = $request->cv_skill_value;
            foreach ($cv_skill_title_array as $id_skill => $skill) {
                $insert = $skils_model->insertGetId([
                    'cv_id' => $insert_id_cv_employee,
                    'cv_skill_title' => $skill,
                    'cv_skill_value' => $cv_skill_value_array[$id_skill],
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime(),
                ]);
            }
            //update cv_specialize
            $cv_specialize_model = new Cv_specialize();
            //xoa du liệu cũ
            $delete = $cv_specialize_model->where('cv_id', $insert_id_cv_employee)->delete();
            if (!empty($request->cv_spec_title)) {

                //input mảng post lên
                $cv_spec_title_array = $request->cv_spec_title;
                $cv_spec_name_array = $request->cv_spec_name;
                $cv_spec_desc_array = $request->cv_spec_desc;
                foreach ($cv_spec_title_array as $id_spe => $spec) {
                    $insert = $cv_specialize_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_spec_title' => $spec,
                        'cv_spec_name' => $cv_spec_name_array[$id_spe],
                        'cv_spec_desc' => $cv_spec_desc_array[$id_spe],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update Cv_experience
            $cv_ex_model = new Cv_experience();
            $delete = $cv_ex_model->where('cv_id', $insert_id_cv_employee)->delete();
            if (!empty($request->cv_ex_title)) {

                //input mảng post lên
                $cv_ex_title_array = $request->cv_ex_title;
                $cv_ex_name_array = $request->cv_ex_name;
                $cv_ex_desc_array = $request->cv_ex_desc;
                foreach ($cv_ex_title_array as $id_ex => $ex) {
                    $insert = $cv_ex_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_ex_title' => $ex,
                        'cv_ex_name' => $cv_ex_name_array[$id_ex],
                        'cv_ex_desc' => $cv_ex_desc_array[$id_ex],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update Cv_project
            $cv_work_model = new Cv_work();
            $delete = $cv_work_model->where('cv_id', $insert_id_cv_employee)->delete();
            if (!empty($request->cv_work_title)) {

                //input mảng post lên
                $cv_work_title_array = $request->cv_work_title;
                $cv_work_name_array = $request->cv_work_name;
                $cv_work_desc_array = $request->cv_work_desc;
                foreach ($cv_work_title_array as $id_work => $work) {
                    $insert = $cv_work_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_work_title' => $work,
                        'cv_work_name' => $cv_work_name_array[$id_work],
                        'cv_work_desc' => $cv_work_desc_array[$id_work],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update Cv_project
            $cv_project_model = new Cv_project();
            $delete = $cv_project_model->where('cv_id', $insert_id_cv_employee)->delete();
            if (!empty($request->cv_project_title)) {

                //input mảng post lên
                $cv_project_title_array = $request->cv_project_title;
                $cv_project_name_array = $request->cv_project_name;
                $cv_project_des_array = $request->cv_project_des;
                foreach ($cv_project_title_array as $id_project => $project) {
                    $insert = $cv_project_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_project_title' => $project,
                        'cv_project_name' => $cv_project_name_array[$id_project],
                        'cv_project_des' => $cv_project_des_array[$id_project],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update Cv_project
            $cv_info_model = new Cv_info();
            $delete = $cv_info_model->where('cv_id', $insert_id_cv_employee)->delete();
            if (!empty($request->cv_info_title)) {

                //input mảng post lên
                $cv_info_title_array = $request->cv_info_title;
                $cv_info_name_array = $request->cv_info_name;
                $cv_info_des_array = $request->cv_info_des;
                foreach ($cv_info_title_array as $id_info => $info) {
                    $insert = $cv_info_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_info_title' => $info,
                        'cv_info_name' => $cv_info_name_array[$id_info],
                        'cv_info_des' => $cv_info_des_array[$id_info],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update duyet ho so va diem profile khi update cv
            $employeeController = new EmployeeController();
            $employeeController->disable_cv_upload();
            return redirect()->back()->with('success', 'Cập nhật CV thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra ! Vui lòng thử lại');
        }
    }

    public function store_cv($request, $employee)
    {
        $cv_order = implode(',', $request->cv_order);
        // ẩn hiện của các khối
        $show_hidden_cv_order = implode(',', $request->show_hidden_cv_order);
        //sắp xếp các khối bên phải với id="block01" tương ứng
        // sắp xếp từ vị trí thứ 1
        $cv_order_join = implode(',', $request->cv_order_join);
        // ẩn hiện của các khối
        $show_hidden_cv_order_join = implode(',', $request->show_hidden_cv_order_join);

        $cv_employee_model = new Cv_employee();
        $insert_id_cv_employee = $cv_employee_model->insertGetId([
            'employee_id' => $employee->employee_id,
            'status_update' => 0,
            'cv_template_id' => $request->cv_template_id,
            'cv_color' => $request->cv_color,
            'cv_title' => $request->cv_title,
            'cv_name' => $request->cv_name,
            'cv_title_job' => $request->cv_title_job,
            'cv_image' => $request->images,
            'cv_email' => $request->cv_email,
            'cv_phone' => $request->cv_phone,
            'cv_birthday' => $request->cv_birthday,
            'cv_address' => $request->cv_address,
            'cv_facebook' => $request->cv_facebook,
            'cv_title_career_goals' => $request->cv_title_career_goals,
            'cv_career_goals' => $request->cv_career_goals,
            'cv_title_prize' => $request->cv_title_prize,
            'cv_prize' => $request->cv_prize,
            'cv_title_card' => $request->cv_title_card,
            'cv_card' => $request->cv_card,
            'cv_title_interests' => $request->cv_title_interests,
            'cv_interests' => $request->cv_interests,
            'cv_title_reference_person' => $request->cv_title_reference_person,
            'cv_reference_person' => $request->cv_reference_person,
            'title_cv_skills' => $request->title_cv_skills,
            'title_cv_specialize' => $request->title_cv_specialize,
            'title_cv_experience' => $request->title_cv_experience,
            'title_cv_work' => $request->title_cv_work,
            'title_cv_project' => $request->title_cv_project,
            'title_cv_info' => $request->title_cv_info,
            'cv_order' => $cv_order,
            'show_hidden_cv_order' => $show_hidden_cv_order,
            'cv_order_join' => $cv_order_join,
            'show_hidden_cv_order_join' => $show_hidden_cv_order_join,
            'created_at' => new \DateTime(),
        ]);
        //insert table skill
        $skils_model = new Cv_skills();
        //input mảng post lên
        $cv_skill_title_array = $request->cv_skill_title;
        $cv_skill_value_array = $request->cv_skill_value;
        if (!empty($cv_skill_title_array)) {
            foreach ($cv_skill_title_array as $id_skill => $skill) {
                $insert = $skils_model->insertGetId([
                    'cv_id' => $insert_id_cv_employee,
                    'cv_skill_title' => $skill,
                    'cv_skill_value' => $cv_skill_value_array[$id_skill],
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        //insert cv_specialize
        $cv_specialize_model = new Cv_specialize();
        //input mảng post lên
        $cv_spec_title_array = $request->cv_spec_title;
        $cv_spec_name_array = $request->cv_spec_name;
        $cv_spec_desc_array = $request->cv_spec_desc;
        if (!empty($cv_spec_title_array)) {
            foreach ($cv_spec_title_array as $id_spe => $spec) {
                $insert = $cv_specialize_model->insertGetId([
                    'cv_id' => $insert_id_cv_employee,
                    'cv_spec_title' => $spec,
                    'cv_spec_name' => $cv_spec_name_array[$id_spe],
                    'cv_spec_desc' => $cv_spec_desc_array[$id_spe],
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        //insert Cv_experience
        $cv_ex_model = new Cv_experience();
        //input mảng post lên
        $cv_ex_title_array = $request->cv_ex_title;
        $cv_ex_name_array = $request->cv_ex_name;
        $cv_ex_desc_array = $request->cv_ex_desc;
        if (!empty($cv_ex_title_array)) {
            foreach ($cv_ex_title_array as $id_ex => $ex) {
                $insert = $cv_ex_model->insertGetId([
                    'cv_id' => $insert_id_cv_employee,
                    'cv_ex_title' => $ex,
                    'cv_ex_name' => $cv_ex_name_array[$id_ex],
                    'cv_ex_desc' => $cv_ex_desc_array[$id_ex],
                    'created_at' => new \DateTime(),
                ]);
            }
        }

        //insert Cv_project
        $cv_work_model = new Cv_work();
        //input mảng post lên
        $cv_work_title_array = $request->cv_work_title;
        $cv_work_name_array = $request->cv_work_name;
        $cv_work_desc_array = $request->cv_work_desc;
        if (!empty($cv_work_title_array)) {
            foreach ($cv_work_title_array as $id_work => $work) {
                $insert = $cv_work_model->insertGetId([
                    'cv_id' => $insert_id_cv_employee,
                    'cv_work_title' => $work,
                    'cv_work_name' => $cv_work_name_array[$id_work],
                    'cv_work_desc' => $cv_work_desc_array[$id_work],
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        //insert Cv_project
        $cv_project_model = new Cv_project();
        //input mảng post lên
        $cv_project_title_array = $request->cv_project_title;
        $cv_project_name_array = $request->cv_project_name;
        $cv_project_des_array = $request->cv_project_des;
        if (!empty($cv_project_title_array)) {
            foreach ($cv_project_title_array as $id_project => $project) {
                $insert = $cv_project_model->insertGetId([
                    'cv_id' => $insert_id_cv_employee,
                    'cv_project_title' => $project,
                    'cv_project_name' => $cv_project_name_array[$id_project],
                    'cv_project_des' => $cv_project_des_array[$id_project],
                    'created_at' => new \DateTime(),
                ]);
            }
        }

        //insert Cv_project
        $cv_info_model = new Cv_info();
        //input mảng post lên
        $cv_info_title_array = $request->cv_info_title;
        $cv_info_name_array = $request->cv_info_name;
        $cv_info_des_array = $request->cv_info_des;
        if (!empty($cv_info_title_array)) {
            foreach ($cv_info_title_array as $id_info => $info) {
                $insert = $cv_info_model->insertGetId([
                    'cv_id' => $insert_id_cv_employee,
                    'cv_info_title' => $info,
                    'cv_info_name' => $cv_info_name_array[$id_info],
                    'cv_info_des' => $cv_info_des_array[$id_info],
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        //update duyet ho so va diem profile khi update cv
        $employeeController = new EmployeeController();
        $employeeController->disable_cv_upload();

    }

    public function edit_emplyee_cv($cv_id)
    {
        $user_id = Auth::user()->id;
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'career_category_id',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();
        $cv_employee_model = new Cv_employee();
        $cv_employee = $cv_employee_model->select('*')
            ->where('cv_id', $cv_id)
            ->where('employee_id', $employee->employee_id)
            ->first();
        return view('site.employee.edit_employee_cv', compact('employee', 'cv_employee'));
        //bang phu se lay ra khi vao trang sua
    }

    public function update_edit_cv(Request $request)//tam dungq
    {
        try {
//        echo  $request->images;die();
            //sắp xếp các khối bên trái với id="box01" tương ứng
            //sắp xếp từ vị trí thứ 2
            $cv_order = implode(',', $request->cv_order);
            // ẩn hiện của các khối
            $show_hidden_cv_order = implode(',', $request->show_hidden_cv_order);
            //sắp xếp các khối bên phải với id="block01" tương ứng
            // sắp xếp từ vị trí thứ 1
            $cv_order_join = implode(',', $request->cv_order_join);
            // ẩn hiện của các khối
            $show_hidden_cv_order_join = implode(',', $request->show_hidden_cv_order_join);

            $user_id = Auth::user()->id;
            $employee = Employee::select('employee_id',
                'employee_code',
                'employee_name',
                'employee_image',
                'career_category_id',
                'phone',
                'email',
                'province',
                'district',
                'address',
                'file_cv',
                'gender',
                'birthday',
                'marry',
                'school',
                'majors',
                'cmt',
                'cmt_date',
                'cmt_local',
                'user_id'
            )->where('user_id', $user_id)->first();
            $cv_id = $request->input('cv_id');
            $cv_employee_model = new Cv_employee();
            $cv_employee = $cv_employee_model->select('cv_id', 'employee_id')
                ->where('cv_id', $cv_id)
                ->where('employee_id', $employee->employee_id)
                ->first();
//        update table cv_employee
            $insert_id_cv_employee = $cv_employee->cv_id;
            $update_id_cv_employee = $cv_employee_model->where('cv_id', $insert_id_cv_employee)->update([
//            'cv_template_id' => 1,
                'cv_title' => $request->cv_title,
                'cv_name' => $request->cv_name,
                'cv_title_job' => $request->cv_title_job,
                'cv_image' => $request->images,
                'cv_email' => $request->cv_email,
                'cv_phone' => $request->cv_phone,
                'cv_birthday' => $request->cv_birthday,
                'cv_address' => $request->cv_address,
                'cv_facebook' => $request->cv_facebook,
                'cv_title_career_goals' => $request->cv_title_career_goals,
                'cv_career_goals' => $request->cv_career_goals,
                'cv_title_prize' => $request->cv_title_prize,
                'cv_prize' => $request->cv_prize,
                'cv_title_card' => $request->cv_title_card,
                'cv_card' => $request->cv_card,
                'cv_title_interests' => $request->cv_title_interests,
                'cv_interests' => $request->cv_interests,
                'cv_title_reference_person' => $request->cv_title_reference_person,
                'cv_reference_person' => $request->cv_reference_person,
                'title_cv_skills' => $request->title_cv_skills,
                'title_cv_specialize' => $request->title_cv_specialize,
                'title_cv_experience' => $request->title_cv_experience,
                'title_cv_work' => $request->title_cv_work,
                'title_cv_project' => $request->title_cv_project,
                'title_cv_info' => $request->title_cv_info,
                'cv_order' => $cv_order,
                'show_hidden_cv_order' => $show_hidden_cv_order,
                'cv_order_join' => $cv_order_join,
                'show_hidden_cv_order_join' => $show_hidden_cv_order_join,
                'updated_at' => new \DateTime(),
            ]);
            //update table skill
            $skils_model = new Cv_skills();
            if (!empty($request->cv_skill_value)) {
                $delete_skill = $skils_model->where('cv_id', $insert_id_cv_employee)->delete();
                //input mảng post lên
                $cv_skill_title_array = $request->cv_skill_title;
                $cv_skill_value_array = $request->cv_skill_value;
                foreach ($cv_skill_title_array as $id_skill => $skill) {
                    $insert = $skils_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_skill_title' => $skill,
                        'cv_skill_value' => $cv_skill_value_array[$id_skill],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }
            //update cv_specialize
            $cv_specialize_model = new Cv_specialize();
            //xoa du liệu cũ
            if (!empty($request->cv_spec_title)) {

                $delete_specialize = $cv_specialize_model->where('cv_id', $insert_id_cv_employee)->delete();
                //input mảng post lên
                $cv_spec_title_array = $request->cv_spec_title;
                $cv_spec_name_array = $request->cv_spec_name;
                $cv_spec_desc_array = $request->cv_spec_desc;
                foreach ($cv_spec_title_array as $id_spe => $spec) {
                    $insert = $cv_specialize_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_spec_title' => $spec,
                        'cv_spec_name' => $cv_spec_name_array[$id_spe],
                        'cv_spec_desc' => $cv_spec_desc_array[$id_spe],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update Cv_experience
            $cv_ex_model = new Cv_experience();
            if (!empty($request->cv_ex_title)) {
                $delete_exx = $cv_ex_model->where('cv_id', $insert_id_cv_employee)->delete();
                //input mảng post lên
                $cv_ex_title_array = $request->cv_ex_title;
                $cv_ex_name_array = $request->cv_ex_name;
                $cv_ex_desc_array = $request->cv_ex_desc;
                foreach ($cv_ex_title_array as $id_ex => $ex) {
                    $insert = $cv_ex_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_ex_title' => $ex,
                        'cv_ex_name' => $cv_ex_name_array[$id_ex],
                        'cv_ex_desc' => $cv_ex_desc_array[$id_ex],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update Cv_project
            $cv_work_model = new Cv_work();
            if (!empty($request->cv_work_title)) {
                $delete_work = $cv_work_model->where('cv_id', $insert_id_cv_employee)->delete();
                //input mảng post lên
                $cv_work_title_array = $request->cv_work_title;
                $cv_work_name_array = $request->cv_work_name;
                $cv_work_desc_array = $request->cv_work_desc;
                foreach ($cv_work_title_array as $id_work => $work) {
                    $insert = $cv_work_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_work_title' => $work,
                        'cv_work_name' => $cv_work_name_array[$id_work],
                        'cv_work_desc' => $cv_work_desc_array[$id_work],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }
            //update Cv_project
            $cv_project_model = new Cv_project();
            if (!empty($request->cv_project_title)) {
                $delete_project = $cv_project_model->where('cv_id', $insert_id_cv_employee)->delete();
                //input mảng post lên
                $cv_project_title_array = $request->cv_project_title;
                $cv_project_name_array = $request->cv_project_name;
                $cv_project_des_array = $request->cv_project_des;
                foreach ($cv_project_title_array as $id_project => $project) {
                    $insert = $cv_project_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_project_title' => $project,
                        'cv_project_name' => $cv_project_name_array[$id_project],
                        'cv_project_des' => $cv_project_des_array[$id_project],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }

            //update Cv_project
            $cv_info_model = new Cv_info();
            if (!empty($request->cv_info_title)) {
                $delete_info = $cv_info_model->where('cv_id', $insert_id_cv_employee)->delete();
                //input mảng post lên
                $cv_info_title_array = $request->cv_info_title;
                $cv_info_name_array = $request->cv_info_name;
                $cv_info_des_array = $request->cv_info_des;
                foreach ($cv_info_title_array as $id_info => $info) {
                    $insert = $cv_info_model->insertGetId([
                        'cv_id' => $insert_id_cv_employee,
                        'cv_info_title' => $info,
                        'cv_info_name' => $cv_info_name_array[$id_info],
                        'cv_info_des' => $cv_info_des_array[$id_info],
                        'created_at' => new \DateTime(),
                        'updated_at' => new \DateTime(),
                    ]);
                }
            }
            return redirect()->back()->with('success', 'Cập nhật CV thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Có lỗi xảy ra ! Vui lòng thử lại');
        }
    }


    //khong su dung ma su dung PDFcontroller
    public function exportpdf_cv(Request $request)
    {
//        $pdf = App::make('dompdf.wrapper');
//        $pdf->loadHTML('<h1>Test</h1>');
//            $pdf = PDF::loadView('site.employee.test_cv');
//        return $pdf->stream();

        if (!Auth::check() || Auth::user()->role != 1) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập tài khoản ứng viên để sử dụng chức năng này');
        }
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $ckeditor = new CkedittorController();
        $session_image = $ckeditor->checkImage();
        $user_id = Auth::user()->id;
        $employee = Employee::select('employee_id',
            'employee_code',
            'employee_name',
            'employee_image',
            'phone',
            'email',
            'province',
            'district',
            'address',
            'file_cv',
            'gender',
            'birthday',
            'marry',
            'school',
            'majors',
            'cmt',
            'cmt_date',
            'cmt_local',
            'user_id'
        )->where('user_id', $user_id)->first();
        $employee_curriculum = '';
        $employee_curriculum = Employee_curriculum::select('*')->where('employee_id', $employee->employee_id)->first();
//        return view('site.employee.test_cv',compact('employee','employee_curriculum'));
        $pdf = PDF::loadView('site.employee.test_cv', compact('employee', 'employee_curriculum'));
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        return $pdf->stream();
//        return $pdf->download('cv.pdf');
    }

    public function modal_detail_cv(Request $request)
    {
        $employee_id = $request->employee_id;
        $employer_id = Employer::where('user_id', Auth::id())->value('employer_id');
        // update view uv
        $employee_view = Employee::where('employee_id', $employee_id)->value('views');
        Employee::where('employee_id', $employee_id)->update([
            'views' => ++$employee_view
        ]);
        // danh sach phan hoi chat luong cv
        $list_response = new Employer_response_cv();
        $list_response = $list_response->select(
            'employer_response_cv.created_at',
            'employer_response_cv.employer_response_cv_id',
            'employer_response_cv.response_diff'
        )
            ->where('employee_id', $employee_id)
            ->where('employer_id', $employer_id)
            ->orderBy('created_at', 'desc')->get();
        foreach ($list_response as $response) {
            $select_responses = new Employer_select_response();
            $select_responses = $select_responses
                ->join('employer_select_response_cv', 'employer_select_response_cv.employer_select_response_id', 'employer_select_response.employer_select_response_id')
                ->where('employer_select_response_cv.employer_response_cv_id', $response->employer_response_cv_id)
                ->pluck('employer_select_response.response')->toArray();
            $response->responses = $select_responses;
        }
        // het danh sach phan hoi chat luong cv
        $employee = Employee::select(
            'employees.employee_id',
            'employees.user_id',
            'employees.marry',
            'employees.views',
            'employees.time_to_work',
            'employees.status_employee',
            'employees.employee_name',
            'employees.salary_id',
            'employees.province',
            'employees.profile',
            'employees.status',
            'employees.show_hidden_profile',
            'employees.created_at',
            'employees.updated_at',
            'salary.description as salary'
        )
            ->join('salary', 'salary.salary_id', 'employees.salary_id')
            ->where('employees.employee_id', $employee_id)->first();
        // tinh so nawm kinnh nghiem
        // $date_day = date_create();
        // $year_day = date_format($date_day, "Y") - $employee->time_to_work;
        // if(!empty($year_day)){
        //     $employee->year_work = $year_day;
        // }
        // else {
        //     $employee->year_work = 1;
        // }
        // kinh nghiem trong linh vuc gi
        // $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
        // $business_exp = '';
        // foreach($list_business_name as $id_b=>$business){
        //     if($id_b == 0){
        //         $business_exp = $business_exp . $business->business_type_name;
        //     }
        //     else{
        //         $business_exp = $business_exp . '|' . $business->business_type_name;
        //     }
        // }
        // $employee->business_exp = $business_exp;
        // kiem tra ung vien co cv upload chua
        $cv_upload = Employee_upload_cv::where('employee_id', $employee_id)->where('employee_cv_status', 1)->first();
        if ($cv_upload) {
            $link_cv_upload = str_replace('/public', '', $cv_upload->employee_link_cv);
            $link_cv_upload = asset($link_cv_upload);
        } else {
            $link_cv_upload = null;
        }
        // kiem tra ung vien co cv tao chua
        $check_employee_cv = Cv_employee::where('employee_id', $employee_id)->value('cv_id');

        $user = User::where('id', Auth::id())->first();
        //kiem tra xem ntd da xem uv chua
        if (Auth::check() && Auth::user()->role == 2) {
            $employer = Employer::where('user_id', Auth::id())->first();
            $coin_show_employee = Coin_show_employee::where('employee_id', $employee_id)
                ->where('employer_id', $employer->employer_id)->first();
            //trường hợp mà nhà tuyển dụng đã xem ứng viên này rồi
            $coin_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
            if ($coin_show_employee) {
                $employee = Employee::select(
                    'employees.user_id',
                    'employees.employee_id',
                    'employees.marry',
                    'employees.views',
                    'employees.time_to_work',
                    'employees.status_employee',
                    'employees.employee_name',
                    'employees.phone',
                    'employees.salary_id',
                    'employees.email',
                    'employees.province',
                    'employees.profile',
                    'employees.status',
                    'employees.show_hidden_profile',
                    'employees.created_at',
                    'employees.updated_at',
                    'salary.description as salary'
                )
                    ->join('salary', 'salary.salary_id', 'employees.salary_id')
                    ->where('employees.employee_id', $employee_id)->first();
                // tinh so nawm kinnh nghiem
                // $date_day = date_create();
                // $year_day = date_format($date_day, "Y") - $employee->time_to_work;
                // if(!empty($year_day)){
                //     $employee->year_work = $year_day;
                // }
                // else {
                //     $employee->year_work = 1;
                // }
                // kinh nghiem trong linh vuc gi
                // $list_business_name = \App\Entity\Employee_business_type::get_array_name($employee->employee_id);
                // $business_exp = '';
                // foreach($list_business_name as $id_b=>$business){
                //     if($id_b == 0){
                //         $business_exp = $business_exp . $business->business_type_name;
                //     }
                //     else{
                //         $business_exp = $business_exp . '|' . $business->business_type_name;
                //     }
                // }
                // $employee->business_exp = $business_exp;
            }
        }
        // lay so ntd xem
        // $show_contact = Coin_show_employee::where('employee_id', $employee_id)->count();
        // $employee->show_contact = $show_contact;

        //lấy các công việc mong muốn của ứng viên
        // $careers_array = Employee_career_categories::where('employee_career_categories.employee_id', $employee_id)
        //     ->join('career_categories', 'career_categories.career_category_id', 'employee_career_categories.career_category_id')
        //     ->pluck('career_categories.career_category_name')->toArray();

        // $careers = implode(" | ", $careers_array);
        // $employee->careers = $careers;

        //Lấy danh sách khu vực uv cần tìm việc
        // $district_array = Employee_district::where('employee_district.employee_id', $employee_id)
        //     ->join('district', 'district.district_id', 'employee_district.district_id')->pluck('district_name')->toArray();
        // $districts = implode(', ', $district_array);
        // $province_name = \App\Entity\Province::where('province_id', $employee->province)->value('province_name');
        // $areas = $province_name . ' - ' . $districts;
        // $employee->areas = $areas;

        //điểm ho sơ ứng viên
        $employee_profile = Employee_profile::select(
            'profile_info',
            'profile_cv',
            'profile_course',
            'profile_avg',
            'profile_staff'
        )->where('employee_id', $employee_id)->first();


        //diem xem tt lien lac moi ung tuyen
        $view_profile = 2;
        $view_apply = 1;
        $carra = \App\Entity\Career::check_view_coint($employee_id);
        if (!empty($carra)) {
            $view_profile = $carra->view_profile;
            $view_apply = $carra->view_apply;
        }
        if (Auth::check() && Auth::user()->role == 2) {
            return response()->json([
                'employee' => $employee,
                'cv_upload' => $cv_upload,
                'link_cv_upload' => $link_cv_upload,
                'check_employee_cv' => $check_employee_cv,
                'employee_profile' => $employee_profile,
                'coin_show_employee' => $coin_show_employee,
                'user' => $user,
                'view_profile' => $view_profile,
                'view_apply' => $view_apply,
                'coin_show_employee' => $coin_show_employee,
                'list_response' => $list_response
            ]);
        } else {
            return response()->json([
                'employee' => $employee,
                'cv_upload' => $cv_upload,
                'check_employee_cv' => $check_employee_cv,
                'employee_profile' => $employee_profile,
                'view_profile' => $view_profile,
                'view_apply' => $view_apply
            ]);
        }

    }

    public function modal_detail_coin(Request $request)
    {
        $employee_id = $request->employee_id;
        $employee_view = Employee::where('employee_id', $employee_id)->value('views');
        Employee::where('employee_id', $employee_id)->update([
            'views' => ++$employee_view
        ]);

        //điểm ho sơ ứng viên
        $employee_profile = Employee_profile::select(
            'profile_info',
            'profile_cv',
            'profile_course',
            'profile_avg',
            'profile_staff'
        )->where('employee_id', $employee_id)->first();
        return response()->json([
            'view_profile' => $employee_profile,
        ]);
    }
    //Hiển thị Tải CV
    //dang suw dung view nay
    public function view_emplyee_cv_test()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $employees = new Employee();
        $employee = $employees->select('*')->where('user_id', $id)->first();
        $employee_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->first();

        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
        $profile_info_account = !empty(Auth::user()->status_email_account) ? 5 : 0;
        if (($employee_profile->profile_info - $profile_info_account) < 12) {
            return redirect(route('show_file_job_facebook'))->with('error', 'Vui lòng hòan thiện hồ sơ trước khi tải CV');
        }

        return view('site.employee_site.view_emplyee_cv_test', compact('employee', 'employee_cv'));
    }

//Hiển thị Tải CV
    public function view_emplyee_cv()
    {
        $user = Auth::user();
        $id = Auth::user()->id;
        $employees = new Employee();
        $employee = $employees->select('*')->where('user_id', $id)->first();
        $employee_cv = Employee_upload_cv::where('employee_id', $employee->employee_id)->first();

        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
        $profile_info_account = !empty(Auth::user()->status_email_account) ? 5 : 0;
        if (($employee_profile->profile_info - $profile_info_account) < 12) {
            return redirect(route('show_file_job_facebook'))->with('error', 'Vui lòng hòan thiện hồ sơ trước khi tải CV');
        }

        return view('site.employee_site.view_emplyee_cv', compact('employee', 'employee_cv'));
    }

//Upload CV
    public function upload_emplyee_cv(Request $request)
    {
        $id = Auth::user()->id;
        $employee_id = Employee::where('user_id', $id)->value('employee_id');
        if ($request->hasFile('file_cv')) {
            $upload_file = new Upload_FileController();
            $link_upload_cv = $upload_file->upload_file_cv($id, $request, 'file_cv');
//            echo $link_upload_cv;die;
            if (empty($link_upload_cv)) {
                return redirect()->back()->with('error', 'File upload phải là file docx hoặc là pdf và dung lượng file < 10M');
            }
            $check_employee_cv = Employee_upload_cv::where('employee_id', $employee_id)->first();
            if (!empty($check_employee_cv)) {
                //xóa file
                $move_delete = $upload_file->move_file_cv($check_employee_cv->employee_link_cv);
                $upload_cv = Employee_upload_cv::where('employee_id', $employee_id)->update([
                    'employee_link_cv' => $link_upload_cv,
                    'employee_cv_status' => 1,
                    'updated_at' => new \DateTime()
                ]);
            } else {
                $insert_cv = Employee_upload_cv::insert([
                    'employee_id' => $employee_id,
                    'employee_link_cv' => $link_upload_cv,
                    'employee_cv_status' => 1,
                    'created_at' => new \DateTime()
                ]);
            }
            // up date luon diem ho so = 40
            $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
            $employee_profile->update([
                'profile_cv' => 40
            ]);
            $profile_employee_after_update = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_course + $employee_profile->profile_staff + $employee_profile->profile_avg;

            // chuyển hồ sơ
            $employee = Employee::where('employee_id', $employee_id)->update([
                'status_employee' => 1,
                'profile' => $profile_employee_after_update,
                'updated_at' => new \DateTime()
            ]);
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn CV để upload');
        }
        return redirect()->back()->with('suscess', 'Upload CV thành công,Vui lòng chờ admin sanketoan duyệt đẻ hiển thị cv trên hồ sơ');

    }

    public function upload_new_emplyee_cv(Request $request)
    {
        $id = Auth::user()->id;
        $employee_id = Employee::where('user_id', $id)->value('employee_id');
        if ($request->hasFile('file')) {
            $upload_file = new Upload_FileController();
            $link_upload_cv = $upload_file->upload_file_cv($id, $request, 'file');
//            echo $link_upload_cv;die;
//            echo $link_upload_cv;die;
            if (empty($link_upload_cv)) {
                return redirect()->back()->with('error', 'File upload phải là file docx hoặc là pdf và dung lượng file < 10M');
            }
            $check_employee_cv = Employee_upload_cv::where('employee_id', $employee_id)->first();
            if (!empty($check_employee_cv)) {
                //xóa file
                $move_delete = $upload_file->move_file_cv($check_employee_cv->employee_link_cv);
                $upload_cv = Employee_upload_cv::where('employee_id', $employee_id)->update([
                    'employee_link_cv' => $link_upload_cv,
                    'employee_cv_status' => 1,
                    'updated_at' => new \DateTime()
                ]);
            } else {
                $insert_cv = Employee_upload_cv::insert([
                    'employee_id' => $employee_id,
                    'employee_link_cv' => $link_upload_cv,
                    'employee_cv_status' => 1,
                    'created_at' => new \DateTime()
                ]);
            }
            // up date luon diem ho so = 40
            $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
            $employee_profile->update([
                'profile_cv' => 40
            ]);
            $profile_employee_after_update = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_course + $employee_profile->profile_staff + $employee_profile->profile_avg;

            // chuyển hồ sơ
            $employee = Employee::where('employee_id', $employee_id)->update([
                'status_employee' => 1,
                'profile' => $profile_employee_after_update,
                'updated_at' => new \DateTime()
            ]);
        } else {
            return redirect()->back()->with('error', 'Vui lòng chọn CV để upload');
        }
        return redirect(route('view_emplyee_cv'))->with('suscess', 'Upload CV thành công,Vui lòng chờ admin sanketoan duyệt đẻ hiển thị cv trên hồ sơ');

    }

    //su dung ham nay
    public function ajax_upload_emplyee_cv(Request $request)
    {
        $id = Auth::user()->id;
        $employee_id = Employee::where('user_id', $id)->value('employee_id');
        $upload_file = new Upload_FileController();
        $result = $upload_file->ajax_upload_file_cv($id, $_FILES['file']);
        $link_upload_cv = $result[0];
        if (empty($link_upload_cv)) {
            return redirect(route('view_emplyee_cv'))->with('error', 'File upload phải là pdf và dung lượng file < 10M');
        }
        $employee_link_html = ''; //link html
        //convert file
        if ($result[1] == 'pdf') {
            $this->PdfToHtml($result[0]);
            $result_repalce_public = str_replace('public/', '', $result[0]);
            $string_random = Ultility::create_random_string(15,25);
            $link_pdf = '/library_employee_cv/'.$id.'/cv'.$string_random.'.pdf';
            rename(public_path($result_repalce_public), public_path($link_pdf)); //doi ten file pdf de mã hoa xem
            $employee_link_html = str_replace('.pdf', '-html.html', $result[0]); //link htmk convert
            $link_upload_cv = '/public'.$link_pdf;
        }
        else
        {
            return redirect(route('view_emplyee_cv'))->with('error', 'File upload phải là pdf và dung lượng file < 10M');
        }
//        if ($result[1] == 'docx') {
//            $this->WordToHtml($result[0], $result[1]);
//        }
        $check_employee_cv = Employee_upload_cv::where('employee_id', $employee_id)->first();
        if (!empty($check_employee_cv)) {
            //xóa file
            $move_delete = $upload_file->move_file_cv($check_employee_cv->employee_link_cv);
            $upload_cv = Employee_upload_cv::where('employee_id', $employee_id)->update([
                'employee_link_cv' => $link_upload_cv,
                'employee_link_html' => $employee_link_html,
                'employee_cv_status' => 1,
                'updated_at' => new \DateTime()
            ]);
        } else {
            $insert_cv = Employee_upload_cv::insert([
                'employee_id' => $employee_id,
                'employee_link_cv' => $link_upload_cv,
                'employee_link_html' => $employee_link_html,
                'employee_cv_status' => 1,
                'created_at' => new \DateTime()
            ]);
        }
        // up date luon diem ho so = 40
        $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
        $employee_profile->update([
            'profile_cv' => 40
        ]);
        $profile_employee_after_update = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_course + $employee_profile->profile_staff + $employee_profile->profile_avg;

        // chuyển hồ sơ
        $employee_update = Employee::where('employee_id', $employee_id)->update([
            'status_employee' => 1,
            'profile' => $profile_employee_after_update,
            'updated_at' => new \DateTime()
        ]);

        //thong bao
        $employee = Employee::where('user_id', $id)->first();
        $this->note_update_profile($employee);
        return redirect(route('view_emplyee_cv'))->with('suscess', 'Upload CV thành công,Vui lòng chờ admin sanketoan duyệt đẻ hiển thị cv trên hồ sơ');
//        return redirect(route('view_emplyee_cv_test'))->with('suscess', 'Upload CV thành công,Vui lòng chờ admin sanketoan.vn duyệt để hiển thị cv trên hồ sơ');
//        return response()->json([
//            'status' => 'suscess',
//            'typeFile' => $result[1],
//            'message' => 'Upload CV thành công,Vui lòng chờ admin sandev duyệt để hiển thị cv trên hồ sơ',
//            'link' => asset($link_upload_cv)
//        ]);
    }
    public function html_remove_email_phone($link_html)
    {
        $myfile = fopen($link_html, "r+");
        $data = null;
        while (!feof($myfile))
        {
            $data .= fread($myfile, 4000);
        }
        fclose($fImage);
        print_r($data);die;
        fclose($link_html);
    }

    private function PdfToHtml($link_pdf)
    {
        $public_full = public_path();
        $public_html = str_replace('public', '', $public_full);
        $public = str_replace('_html', 'public_html', $public_html);

        //        Config::setBinDirectory($public . 'vendor/bin/poppler');
        // set Poppler utils binary location
        Config::setBinDirectory($public . 'public/custom_vendor_PDF/bin/poppler');
        // set output directory
        Config::setOutputDirectory(public_path() . '/library_employee_cv/' . Auth::id());


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

    private function PdfToHtml1($link_pdf, $user_id)
    {
        $public_full = public_path();
        $public_html = str_replace('public', '', $public_full);
        $public = str_replace('_html', 'public_html', $public_html);
        // set Poppler utils binary location
        Config::setBinDirectory($public . 'vendor/bin/poppler');
        // set output directory
        Config::setOutputDirectory(public_path() . '/library_employee_cv/' . $user_id);

        $pdfToHtml = new PdfToHtml($public . $link_pdf);
        $pdfToHtml->setZoomRatio(1.8);
        $pdfToHtml->exchangePdfLinks();
        $pdfToHtml->startFromPage(1)->stopAtPage(5);
        $pdfToHtml->generateSingleDocument();
        $pdfToHtml->generate();

        // Config::setOutputDirectory(public_path() . '/library_employee_cv/' . $user_id . '/img');

        // $cairo1 = new PdfToCairo($public . $link_pdf);
        // $cairo1->generatePNG();
    }

    private function WordToHtml1($link_pdf, $type_file, $user_id)
    {
        $link_pdf_no = str_replace('public/', '', $link_pdf);
        $array = explode('/', $link_pdf);
        $name = end($array);
        $array_name = explode('.', $name);
        $name_file = current($array_name);
        $domPdfPath = base_path('vendor/dompdf/dompdf');
        \PhpOffice\PhpWord\Settings::setPdfRendererPath($domPdfPath);

        \PhpOffice\PhpWord\Settings::setPdfRendererName('HTML');
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);
        if ($type_file == 'doc') {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(public_path() . $link_pdf_no, 'MsDoc');
        } else {
            $phpWord = \PhpOffice\PhpWord\IOFactory::load(public_path() . $link_pdf_no);
        }

        $PDFWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'HTML');
        $PDFWriter->save(public_path() . '/library_employee_cv/' . $user_id . '/' . $name_file . '-html.html');

        // $docPath = public_path() . $link_pdf_no;
        // $Word = new \PhpOffice\PhpWord\PhpWord();
        // $document = $Word->loadTemplate($docPath);
        //     $document =   \PhpOffice\PhpWord\IOFactory::load($docPath,'MsDoc');

        // $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($document,'Word2007');
        // $docxPath = public_path() . '/library_employee_cv/' . Auth::id() . '/' . $name_file . '.docx';
        // $objWriter->save($docxPath);

    }

    public function pdf_test(Request $request)
    {

        $files = Employee_upload_cv::select(
            'employee_upload_cv.employee_link_cv',
            'employees.user_id',
            'employee_upload_cv.employee_id'
        )
            ->leftJoin('employees', 'employees.employee_id', 'employee_upload_cv.employee_id')
            ->where('employee_upload_cv.employee_cv_status', 1)->get();
        foreach ($files as $file) {
            $link = $file->employee_link_cv;
            $array = explode('/', $link);
            $end_of_array = end($array);
            $array1 = explode('.', $end_of_array);
            $end_of_array1 = end($array1);
            if ($end_of_array1 == 'pdf') {
                // $path_forder_images_img = public_path('/library_employee_cv/'.$file->user_id.'/img');
                // if (!is_dir($path_forder_images_img) && !empty($file->user_id)) {
                //     mkdir($path_forder_images_img, 0777, true);
                // }

                if (file_exists(public_path(str_replace('/public', '', $link)))) {
                    $this->PdfToHtml1($link, $file->user_id);
                }
            }
            if ($end_of_array1 == 'docx') {
                if (file_exists(public_path(str_replace('/public', '', $link)))) {
                    $this->WordToHtml1($link, 'docx', $file->user_id);
                }
            }
        }
        return view('site.default_site.pdf_test');
    }

    public function videotest(Request $request)
    {
        return view('site.default_site.video');
    }
}
