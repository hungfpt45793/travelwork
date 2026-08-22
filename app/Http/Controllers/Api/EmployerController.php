<?php

namespace App\Http\Controllers\Api;

use App\Entity\Employee;
use App\Entity\Employer;
use App\Entity\EmployerRepresentative;
use App\Entity\Forum_notification;
use App\Entity\Invite;
use App\Entity\Job;
use App\Entity\Notification_employer;
use App\Entity\User;
use App\Entity\User_forum_code_intro;
use App\Http\Controllers\Site\MailConfigController;
use App\Http\Controllers\Site\Upload_FileController;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Validator;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class EmployerController extends Controller
{
    public function create_employer(Request $request)
    {
        // check xem là dữ liệu hợp lệ không
        $validation = $this->validateEmployer($request);

        if ($validation->fails()) {
            return response()->json([
                'status' => 404,
                'descript' => 'Dữ liệu không hợp lệ',
                'validation' => $validation->errors(),
            ], 404);
        }
        try {
            DB::beginTransaction();
            // Tạo dữ liệu cho bảng user với role = 2 để đăng nhập nhà tuyển dụng
            $userWithPhone = $this->createUser($request);
            // Lưu thông tin nhà tuyển dụng vào bảng employer.
            $createEmployer = $this->createNewEmployer($request, $userWithPhone);
            // Đẩy thông tin lên getfly
//            $this->addNewCampaignGetfly($request);
            if ($createEmployer) {
                $email = $userWithPhone->email;
                // gui email thong bao
                MailConfigController::send_email_employer_confirm($userWithPhone);
                DB::commit();
                return response()->json([
                    'status' => 200,
                    'descript' => 'Bạn đã đăng kí tài khoản nhà tuyển dụng thành công',
                ], 200);
            }
            return false;


        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => 400,
                'descript' => 'Bạn đã đăng kí tài khoản nhà tuyển dụng thất bại',
            ], 400);
        }
    }

    // check điều kiện submit form
    private function validateEmployer($request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users|unique:employees|unique:employer|unique:teacher,teacher_email|email',
            'password' => 'required|min:8',
            'name' => 'required',
            'address' => 'required',
            'district' => 'required',
            'province' => 'required',
            'employer_name' => 'required',
            'phone' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'email.email' => 'Vui lòng nhập đúng định dạng email.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'name.required' => 'Tên công ty không được bỏ trống',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'district.required' => 'Vui lòng chọn quận huyện',
            'province.required' => 'Vui lòng chọn tỉnh / thành phố',
            'employer_name.required' => 'Tên người phụ trách không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
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
            'role' => 2,
            'status_email_account' => 0,
        ]);
        $link_confirm_account = str_random(10) . $insert_id;
        $update = $userModel->where('id', $insert_id)->update([
            'link_confirm_account' => $link_confirm_account
        ]);
        $userWithPhone = $userModel->select('name', 'email', 'password', 'phone', 'status_email_account', 'id', 'link_confirm_account')->where('id', $insert_id)->first();
        return $userWithPhone;
    }

    // tao moi nha tuyen dung
    private function createNewEmployer($request, $userWithPhone)
    {
        try {
            $employerModel = new Employer();
            // thêm mới nhà tuyển dụng
            $employerID = $employerModel->insertGetId([
                'enterprise_name' => $request->input('name'),
                'address' => $request->input('address'),
                'user_id' => $userWithPhone->id,
                'district' => $request->input('district'),
                'province' => $request->input('province'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
            ]);
            $slug = Ultility::createSlug($request->input('name'));
            if (!empty(Employer::where('slug', $slug)->first())) {
                $slug .= '-' . $employerID;
            }
//        $employer_id = $employerID.'NTD'.$userWithPhone->id;
//        'employer_id' => $employer_id
            Employer::where('employer_id', $employerID)->update([
                'slug' => $slug
            ]);
            // thêm mới người liên hệ
            $employerRelative = new EmployerRepresentative();
            $relative = $employerRelative->insert([
                'employer_id' => $employerID,
                'representative_name' => $request->input('employer_name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $update_profile = \App\Entity\Employer::get_user_id_Profile($userWithPhone->id);
            return true;
        } catch (\Exception $e) {
            return false;
        }


    }

    //gửi email thông báo và kích hoạt tài khoản


    //code cu
    public function inforEmployer(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $employer = Employer::where('employer_user_id', $user->id)->first();
            if (empty($user)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Bạn cần phải đăng nhập để có thể xem được thông tin của mình.'
                ]);
            }

            return response()->json([
                'status' => 200,
                'employer' => $employer
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Bạn cần phải đăng nhập để có thể xem được thông tin của mình.'
            ]);
        }
    }

    public function invited_candidates(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $employer = Employer::where('employer_user_id', $user->id)->first();
            $invites = Invite::leftJoin('employees', 'employees.employee_id', '=', 'invite.employee_id')
                ->leftJoin('jobs', 'jobs.job_id', '=', 'invite.job_id')
                ->where('invite.employer_id', $employer->employer_id)
                ->select(
                    'employees.employee_name',
                    'jobs.title',
                    'employees.employee_id'
                )->paginate(10);
            return response()->json([
                'status' => 200,
                'invite_list' => $invites
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Bạn cần phải đăng nhập để có thể lấy thông tin.'
            ]);
        }
    }

    public function invite(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->input('token'));
            $employer = Employer::where('employer_user_id', $user->id)->first();
            $jobs = Job::where('employer_id', $employer->employer_id)
                ->select(
                    'job_id',
                    'title',
                    'content',
                    'description'
                )->paginate(10);
            return response()->json([
                'status' => 200,
                'jobs' => $jobs
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Bạn phải đăng nhập để có thể mời ứng viên'
            ]);
        }
    }

    public function list_intership(Request $request)
    {
        try {
            $employer = new Employer();
            $employers = $employer->select('employer.employer_id', 'employer.view', 'employer.image', 'employer.province', 'employer.district', 'employer.enterprise_name', 'employer.status_intership', 'employer.slug', 'employer.banner_intership', 'employer.type_of_business_id', 'employer.business', 'province.province_id', 'province.province_name', 'district.district_id', 'district.district_name');
            $employers = $employers->leftJoin('province', 'province.province_id', '=', 'employer.province');
            $employers = $employers->leftJoin('district', 'district.district_id', '=', 'employer.district');
            $employers = $employers->where('status_intership', 1);
            $employers = $employers->limit(15)->get();

            if (empty($employers)) {
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy nhà tuyển dụng.'
                ]);
            }
            return response()->json([
                'status' => 200,
                'employers' => $employers
            ]);

        } catch (JWTException $exception) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy nhà tuyển dụng'
            ]);
        }
    }

    public function update_employer_user(Request $request)
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
            'enterprise_name' => 'required',
            'address' => 'required',
            'province_id' => 'required',
            'district_id' => 'required',
            'address' => 'required',
            'type_of_business_id' => 'required',
            'business_type_id' => 'required'
        ], [
            'employer_name.required' => 'Tên người phụ trách không được bỏ trống',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'province_id.required' => 'Vui lòng chọn tỉnh / thành phố ,',
            'district_id.required' => 'Vui lòng chọn quận / huyện ,',
            'introduction.required' => 'Giới thiệu về công ty không được để trống ,',
            'type_of_business_id.required' => 'Vui lòng chọn loại hình doanh nghiệp',
            'business_type_id.required' => 'Vui lòng chọn loại hình kinh doanh'
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

        $employers = Employer::select('*')->where('user_id', $user->id)->first();
        $link_image = !empty($employers->image) ? $employers->image : '';
        if ($request->hasFile('image')) {
            $upload = new Upload_FileController();
            $link_image = $upload->api_upload_image_employer($employers->email, $employers->user_id, $request);
            if (empty($link_image)) {
                return response()->json([
                    'error' => 400,
                    'message' => 'Vui lòng nhập dịnh đạng image.',
                ], 400);
            }
        }
//        echo  $link_image;die;
//        echo $link_image;die;
        //danh sach hinh ảnh
        $list_link_image = !empty($employers->images_list) ? $employers->images_list : '';
        if ($request->hasFile('images_list')) {
            $upload = new Upload_FileController();
            $list_link_image = $upload->api_upload_list_image_employer($employers->email);
            if (empty($list_link_image)) {
                return response()->json([
                    'error' => 400,
                    'message' => 'Vui lòng nhập dịnh đạng ảnh và dung lượng file không nên vượt quá 10MB.',
                ], 400);
            }
        }
        try {
            $employer = new Employer();
            $update = $employer->where('user_id', $user->id)->update([
                'enterprise_name' => $request->input('enterprise_name'),
                'address' => $request->input('address'),
                'phone' => $request->input('phone'),
                'province' => $request->input('province_id'),
                'district' => $request->input('district_id'),
                'introduction' => $request->input('introduction'),
                'type_of_business_id' => $request->input('type_of_business_id'),
                'business' => $request->input('business_type_id'),
                'website' => $request->input('website'),
                'tax_code' => $request->input('tax_code'),
                'image' => $link_image,
                'images_list' => $list_link_image,
                'updated_at' => new \DateTime()
            ]);
            // insert slug
            $slug = Ultility::createSlug($request->input('enterprise_name'));
            $postWithSlug = $employer->where('slug', $employers->slug)->first();
            if (empty($postWithSlug)) {
                $employer->where('employer_id', '=', $employers->employer_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $employer->where('employer_id', '=', $employers->employer_id)
                    ->update([
                        'slug' => $slug . '-' . $employers->employer_id
                    ]);
            }
            $user_model = new User();
            $update = $user_model->where('id', $user->id)->update([
                'name' => $request->input('enterprise_name'),
                'phone' => $request->input('phone'),
                'image' => $link_image,
                'step' => 'step3',
            ]);
            $update_profile = \App\Entity\Employer::get_user_id_Profile($user->id);
            //cap nhat them ma gioi thieu
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
                    }
//                //cọng thêm 5 xu cho user dc giơi thiêu
//                $update_user_coin = User::where('id',$user_code_intro->id)->update([
//                   'user_coin' => $user_code_intro->user_coin + 5
//                ]);
                }
            }

            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật thông tin nhà tuyển dụng thành công',
                'employer' => $employers,
                'step' => 'step3',
            ], 200);
        } catch (\Exception $e) {
            $massage = 'Cập nhật thông tin nhà tuyển dụng thất bại ! Vui Lòng thử lại';
            return response()->json([
                'status' => 400,
                'message' => $massage,
            ], 400);
        }
    }

    public function get_info_employer_user(Request $request)
    {
        try {
            $user = JWTAuth::toUser($request->token);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 400,
                'message' => 'Vui lòng kiểm tra lại token !'
            ], 400);
        }
        $employers = Employer::select('employer.*')->where('user_id', $user->id)->first();
//        $employers->image = '';

        $employers['src_image'] = !empty($employers['image']) ? asset($employers['image']) : '';
//        $employers['src_image'] = $employers['image'];
        $list_employer_image = array();
        if (!empty($employers->images_list)) {
            $list_employer_image_array = explode(',', $employers->images_list);
            foreach ($list_employer_image_array as $id_b => $block_img) {
                $list_employer_image[] = !empty($block_img) ? asset($block_img) : '';
            }
        }
        $employers['src_list_image'] = $list_employer_image;
        $noti_employer_model = new Notification_employer();
        $unread = $noti_employer_model->where('user_id', $user->id)
            ->where('noti_status', 0)
            ->count();
        $employers['unread'] = $unread;
        return response()->json([
            'status' => 200,
            'message' => 'Thông tin nhà tuyển dụng',
            'employer' => $employers,
            'user' => $user,
            'step' => 'step3',
        ], 200);
    }

    public function detail_employer_jobs($employer_slug)
    {
        $employerModel = new Employer();
        $employer = $employerModel->select([
            'employer_id',
            'employer_code',
            'enterprise_name',
            'phone',
            'email',
            'address',
            'introduction',
            'image',
            'website',
            'slug',
            'status_intership',
            'my_facebook',
            'my_zalo',
        ])
            ->where('slug', $employer_slug)
            ->first();
        $employer['image'] = !empty($employer['image']) ? asset($employer['image']) : asset('assets/image/avatarEmployer.png');
        if (!empty($employer)) {
            return response()->json([
                'status' => 200,
                'message' => 'Thông tin nhà tuyển dụng',
                'employers' => $employer
            ]);
        }
        return response()->json([
            'status' => 400,
            'message' => 'Không tìm thấy thông tin nhà tuyển dụng'
        ], 400);

    }

    public function list_coin_user_show_employee(Request $request)
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
                'message' => 'Chức năng này dành cho nhà tuyển dụng'
            ], 400);
        }
        $user_id = $user->id;
//        return view('site.jobs.list_jobs', compact('jobs', 'total_job', 'user'));
        $employer = Employer::select('employer_id',
            'enterprise_name',
            'phone',
            'email',
            'user_id',
            'employer_coin',
            'total_employer_coin',
            'total_money_coin')->where('user_id', $user_id)->first();
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
            ->join('coin_show_employee', 'coin_show_employee.employee_id', 'employees.employee_id')
            ->where('coin_show_employee.employer_id', $employer->employer_id)
            ->where('employees.status_employee', 1)
            ->where('employees.show_hidden_profile', 0);
        $list_employee = $list_employee->whereNotNull('employees.email');
        $list_employee = $list_employee->orderBy('employees.updated_at', 'desc');
        $list_employee = $list_employee->paginate(20);

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
            $list_employee[$id]['link_preview_cv'] = route('link_preview_cv', ['employee_id' => $employee->employee_id]) . '?employer_id=' . $employer->employer_id;

        }

        if (empty($list_employee)) {
            return response([
                'status' => 404,
                'message' => 'Không tìm thấy dữ liệu'
            ], 404);
        }
        return response([
            'status' => 200,
            'list_employee' => $list_employee,
        ], 200);

    }


}
