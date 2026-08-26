<?php

namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\Coin_apply_employee;
use App\Entity\Coin_history_employer;
use App\Entity\Coin_history_money_employer;
use App\Entity\Coin_show_employee;
use App\Entity\Employee;
use App\Entity\Employee_upload_cv;
use App\Entity\Employer_response_cv;
use App\Entity\Employer_select_response;
use App\Entity\Employee_coins;
use App\Entity\Employee_intro_employer;
use App\Entity\Employer_select_response_cv;
use App\Entity\Notification_employer;
use App\Entity\Service_price;
use App\Entity\Hunter_time;
use App\Entity\Hunter_pos;
use App\Entity\Employee_profile;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\EmployerEmployee;
use App\Entity\EmployerIntership;
use App\Entity\EmployerTransfer;
use App\Entity\Employer_rating_employee;
use App\Entity\InformationService;
use App\Entity\Input;
use App\Entity\Invite;
use App\Entity\Job;
use App\Entity\Service_comment;
use App\Entity\Service_table_price;
use App\Entity\NotificationWindow;
use App\Entity\Post;
use App\Entity\Province;
use App\Entity\SettingGetfly;
use App\Entity\StarEmployer;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Ultility\CallApi;
use Illuminate\Http\Request;
use App\Entity\Business;
use App\Entity\District;
use App\Entity\Employer;
use App\Entity\EmployerRepresentative;
use App\Entity\TypeOfBusiness;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Entity\Post_sale_statistical;
use Illuminate\Support\Facades\View;

class EmployerController extends SiteController
{
    public function createEmployer(Request $request)
    {
        // check xem là dữ liệu hợp lệ không
        $validation = $this->validateEmployer($request);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Đăng ký nhà tuyển dụng lỗi!')
                ->withInput();
        }
        try {
            DB::beginTransaction();
            // Tạo dữ liệu cho bảng user với role = 2 để đăng nhập nhà tuyển dụng
            $userWithPhone = $this->createUser($request);
            // Lưu thông tin nhà tuyển dụng vào bảng employer.
            $this->createNewEmployer($request, $userWithPhone);
            // Đẩy thông tin lên getfly
            //            $this->addNewCampaignGetfly($request);
            Auth::guard()->login($userWithPhone);
            $email = $userWithPhone->email;
            DB::commit();
            // gui email thong bao
            MailConfigController::send_email_employer_confirm($userWithPhone);
        } catch (\Exception $e) {
            Error::setErrorMessage("Không thể Đăng ký tài khoản. Vui lòng thử lại ");
            DB::rollBack();
            return redirect(route('employer_register'))->with('mesage_modal', 'Đăng kí nhà tuyển dụng thất bại ! Vui lòng thử lại');
        } finally {
            $html = '';
            if (Auth::check()) {
                $html = '<div class="noti_success_employer">';
                $html .= '<h5 class="mgb10 text-center fw6 f18">Chúc mừng bạn đã tạo thành công tài khoản nhà tuyển dụng, Mời bạn:</h5>';
                $html .= '<div class="btn_a_noti row">';
                $html .= '<div class="item_div col-md-6 text-center">';
                $html .= '<a class="text-center" href="' . route('job-user.create') . '">
                        Đăng tin tuyển dụng kế toán
                        </br>
                        Miễn phí
                        </a>';
                $html .= '</div>';
                $html .= '<div class="item_div col-md-6 text-center">';
                $html .= '<a class="text-center" href="' . route('list_price') . '">
                        Xem bảng giá
                        </br>
                        Gói lọc hồ sơ đăng tin VIP
                        </a>';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<p class="f14"><i>Lưu ý : Mời bạn cập nhật thêm thông tin, hình ảnh về công ty của bạn để ứng viên hiểu rõ hơn công ty của bạn</i></p>';
                $html .= '<a href="' . route('show_file_job_facebook') . '" class="btn_update_modal_site">Cập nhật</a>';
                $html .= '</div>';
            }
            return redirect(route('list_job_face'))->with('mesage_modal', $html);
        }
    }

    // check điều kiện submit form
    private function validateEmployer($request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'name' => 'required',
            'address' => 'required',
            'employer_name' => 'required',
            'phone' => 'required',
            'user_id' => 'nullable|integer|exists:employees,user_id',
            'tax_code' => ['nullable','regex:/^(\d{10}|\d{13})$/'],
            // 'g-recaptcha-response' => 'required'
        ], [
            //            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'name.required' => 'Tên công ty không được bỏ trống',
            'address.required' => 'Địa chỉ công ty không được bỏ trống',
            'employer_name.required' => 'Tên người phụ trách không được bỏ trống',
            'phone.required' => 'Số điện thoại không được bỏ trống',
            'user_id.integer' => 'Mã giới thiệu không hợp lệ.',
            'user_id.exists' => 'Mã giới thiệu không đúng hoặc không tồn tại.',
            'tax_code.regex'=> 'Mã số thuế phải gồm 10 hoặc 13 chữ số.',
            'g-recaptcha-response.required' => 'Vui lòng tích chọn tôi không phải người máy hoặc  Im not a robot'
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
            'status_email_account' => 0
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
        $employerModel = new Employer();
        // thêm mới nhà tuyển dụng
        $employerID = $employerModel->insertGetId([
            'enterprise_name' => $request->input('name'),
            'address' => $request->input('address'),
            'tax_code' => $request->input('tax_code'),
            'user_id' => $userWithPhone->id,
            'district' => $request->input('district'),
            'province' => $request->input('province'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'created_at' => new \DateTime()
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
        //ung vien gioi thieu ntd
        if (!empty($request->input('user_id'))) {
            $employee_model = new Employee();
            $employee_count = $employee_model->where('user_id', $request->input('user_id'))->count();
            $employee_ft = $employee_model->where('user_id', $request->input('user_id'))->first();
            if (!empty($employee_count)) {
                $employee_intro_employer = new Employee_intro_employer();
                $insert_intro = $employee_intro_employer->insertGetId([
                    'user_id' => $request->input('user_id'),
                    'employer_id' => $employerID,
                    'created_at' => new \DateTime()
                ]);
                $employee_coins_model = new Employee_coins();
                $employee_coints = $employee_coins_model->select('*')
                    ->where('employee_id', $employee_ft->employee_id)
                    ->count();
                //nếu không tồn tại ứng viên thì thêm mới
                if (empty($employee_coints)) {
                    $insert = $employee_coins_model->insert([
                        'total_sale' => 0,
                        'employee_id' => $employee_ft->employee_id,
                        'created_at' => new \DateTime()
                    ]);
                }
                //thêm vào bảng lich sử nạp
                $insert_coint_money = Coin_history_money_employer::insert([
                    'coint_money' => 0,
                    'coint' => 10,
                    'coin_content' => 'Điểm khuyến mãi do nập mã ứng viên',
                    'user_id' => 1,
                    'employer_id' => $employerID,
                    'created_at' => new \DateTime()
                ]);
                $update_employer = Employer::where('employer_id', $employerID)->update([
                    'employer_coin' => 10,
                    'total_employer_coin' => 10
                ]);
            }
        }
        //cap nhat profile ntd
        $update_profile = \App\Entity\Employer::get_user_id_Profile($userWithPhone->id);
    }

    //gửi email thông báo và kích hoạt tài khoản


    public function employeeManagement($slug)
    {
        $user = Auth::user();
        $employer = Employer::where('slug', $slug)->first();
        if (!empty($employer)) {
            $employees = Invite::join('employer', 'employer.employer_id', '=', 'invite.employer_id')
                ->join('jobs', 'jobs.job_id', '=', 'invite.job_id')
                ->join('employees', 'employees.employee_id', '=', 'invite.employee_id')
                ->where('invite.updated_at', null)
                ->where('employer.employer_id', $employer->employer_id)
                ->select(
                    'employees.employee_name as employee_name',
                    'jobs.title as title',
                    'employees.employee_id as employee_id',
                    'jobs.job_id as job_id',
                    'invite.created_at as created_at',
                    'invite.status as status'
                )
                ->paginate(10);
        }
        return view('site.infomation.employer.employee_management', compact('employees', 'employer', 'user'));
    }


    private function addNewCampaignGetfly($request)
    {
        try {
            $account = (object)[
                "account_name" => $request->input('name'),
                "phone_office" => $request->input('phone'),
                "email" => $request->input('email'),
                "gender" => 0,
                "billing_address_street" => $request->input('address'),
                //"birthday" => $request->input('birthday_day').'/'.$request->input('birthday_Month').'/'.$request->input('birthday_Year'),
                "account_type" => 1,
                "industry" => "2,3"
            ];

            $opportunity = (object)[
                'token_api' => SettingGetfly::getCampaignEmployer(),
                'user_id' => "",
                'recipient' => 0,
                'opportunity_status' => SettingGetfly::getCampainStatusEmployer(),

            ];

            $contacts = [
                "first_name" => $request->input('employer_name'),
                "email" => $request->input('email'),
                "phone_mobile" => $request->input('phone')
            ];

            $referer = (object)[
                "utm_source" => "https://tiva.vn/trang/danh-cho-nha-tuyen-dung",
                "utm_campaign" => 'Nhà tuyển dụng tiva',
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

    public function indexCheckout()
    {
        return view('site.infomation.employer.checkout');
    }

    public function recharge(Request $request) {}

    public function detailEmployer($slug)
    {
        $user = Auth()->user();
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
            ->where('slug', $slug)
            ->first();

        if (empty($employer)) {
            return redirect(route('home'));
        }
        return view('site.employer.detail_employer', compact('employer', 'user'));
    }

    public function detail_agency($slug)
    {
        $employer = new Employer();
        $employer = $employer->select(
            'employer.enterprise_name',
            'employer.employer_id',
            'employer.phone',
            'employer.slug',
            'employer.website',
            'employer.image',
            'employer.introduction',
            'employer.tax_code',
            'employer.address',
            'employer.type_of_business_id',
            'employer.status_agency',
            'employer.service_agency',
            'employer.view',
            'employer.province',
            'employer.district',
            'province.province_name',
            'district.district_name',
            'enterprise_name'
        )
            ->join('province', 'province.province_id', 'employer.province')
            ->join('district', 'district.district_id', 'employer.district')
            ->where('slug', $slug)
            ->where('status_agency', 1)
            ->first();
        if (empty($employer)) {
            return redirect(route('home'));
        }
        $view = intval($employer->view + 1);
        $update = $employer->where('slug', $slug)->update([
            'view' => $view
        ]);

        //        return view('site.employer.detail_employer', compact('employer', 'user'));
        return view('site.employer_site.detail_agency', compact('employer'));
    }

    private function checkRoleUser()
    {
        $role = Auth::user()->role;
        if ($role == 2) {
            return true;
        } else {
            return false;
        }
    }

    //Nhà tuyển dụng
    public function portEmployer()
    {
        //
        //        $list_prices = Service_price::get();
        //
        $employee = new Employee();
        //        $total_employee = $employee->where('status_employee', 1)->count();
        $total_employee = $employee->count();

        $employer = new Employer();
        //        $total_employer = $employer->where('status_employer', 1)->count();
        $total_employer = $employer->count();
        $information_service = new InformationService();
        $information_service = $information_service->select('*')->orderBy('service_id', 'asc')->get();

        //        view()->share('sidebar_employer', 'employer');
        //        view()->share('menuTopsite', 'employer');
        return view('site.employer_site.port_employer', compact('total_employee', 'total_employer', 'information_service'));
    }

    public function table_price_employer($slug)
    {
        $prices = Service_price::get();
        $list_price = Service_price::where('service_price_slug', $slug)->first();

        $type = $list_price->service_price_type;
        $employee = new Employee();
        $total_employee = $employee->count();
        $employer = new Employer();
        $total_employer = $employer->count();
        $information_service = new InformationService();
        $information_service = $information_service->select('*')->orderBy('service_id', 'asc')->get();
        if ($type == 0) {

            return view('site.employer.table_price.list_price', compact('total_employee', 'total_employer', 'information_service', 'prices', 'type', 'list_price', 'slug'));
        }
        if ($type == 1) {
            return view('site.employer.table_price.list_price', compact('total_employee', 'total_employer', 'information_service', 'prices', 'list_price', 'type', 'slug'));
        }
        if ($type == 2) {
            $hunters_pos = Hunter_pos::get();
            $hunters_time = Hunter_time::orderBy('hunter_time_id', 'ASC')->get();
            return view('site.employer.table_price.list_price', compact('total_employee', 'total_employer', 'information_service', 'prices', 'list_price', 'hunters_pos', 'hunters_time', 'type', 'slug'));
        }
    }

    //cổng thực tập
    public function intership(Request $request)
    {
        $user = Auth::check();

        $employer = new Employer();

        $employers = $employer->select('employer_id', 'email', 'phone', 'view', 'status_allowance', 'image', 'province', 'district', 'enterprise_name', 'status_intership', 'slug', 'banner_intership', 'type_of_business_id', 'business', 'website');
        //            ->where('status_employer', 1);

        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $employers = $employers->where('type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $employers = $employers->where('business', $business);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $employers = $employers->where('province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $employers = $employers->where('district', $district);
        }
        if (!empty($request->input('word'))) {
            $word = $request->input('word');
            $employers = $employers->where('enterprise_name', 'like', '%' . $word . '%');
        }
        $employers = $employers->where('status_intership', 1);
        $employers = $employers->orderBy('employer_id', 'desc');
        $employers = $employers->paginate(18);
        $employers->appends(request()->query());

        return view('site.employer_site.intership', compact('user', 'employers'));
    }

    public function recruitment(Request $request)
    {
        $post_model = new Post();
        $list_post_new = $post_model->select('posts.post_id', 'posts.title', 'posts.slug', 'posts.content', 'posts.image', 'posts.updated_at', 'posts.sale_money', 'posts.updated_at', 'posts.meta_description')
            ->where('sale_money', 1)
            ->orderBy('post_id', 'desc')
            ->paginate(10);

        $post_sale = new Post_sale_statistical();

        $list_post = $post_sale->select(DB::raw('SUM(total_view_sale) as total_view'), 'post_sale_statistical.post_id')->groupBy('post_sale_statistical.post_id')->orderBy('total_view', 'desc')->limit(18)->get();
        View::share('menuTopsite', 'employer');
        return view('site.employer.recruitment', compact('employee', 'employee_coints', 'list_post_new', 'list_post'));
    }

    public function submit_intership(Request $request)
    {
        $user = auth()->user();
        $career = 'tuyen-thuc-tap-ke-toan';
        if (!empty($request->input('province')) or !empty($request->input('district'))) {
            $career = 'tuyen-thuc-tap-ke-toan-tai';
            if (!empty($request->input('province'))) {
                $career .= '-' . $request->input('province');
            }
            if (!empty($request->input('district'))) {
                $career .= '-' . $request->input('district');
            }
        } else {
            $career = 'tuyen-thuc-tap-ke-toan';
            if (!empty($request->input('type_of_business_id'))) {
                $career .= '-cho-' . $request->input('type_of_business_id');
            }
            if (!empty($request->input('business'))) {
                $career .= '-va-kinh-doanh-' . $request->input('business');
            }
        }

        $provice = Province::select('*')
            ->where('province_slug', $request->input('province'))
            ->first();
        $district = District::select('*')
            ->where('district_slug', $request->input('district'))
            ->first();
        $type_of_business = TypeOfBusiness::select('*')
            ->where('type_of_business_slug', $request->input('type_of_business_id'))
            ->first();
        $business = Business::select('*')
            ->where('business_type_slug', $request->input('business'))
            ->first();

        $career .= '?';
        if (!empty($request->input('type_of_business_id'))) {
            $career .= '&t=' . $type_of_business['type_of_business_id'];
        }
        if (!empty($request->input('business'))) {
            $career .= '&b=' . $business['business_type_id'];
        }
        if (!empty($request->input('province'))) {
            $career .= '&p=' . $provice['province_id'];
        }
        if (!empty($request->input('district'))) {
            $career .= '&q=' . $district['district_id'];
        }
        if (!empty($request->input('word'))) {
            $career .= '&w=' . $request->input('word');
        }
        return redirect(route('search_intership', ['slug' => $career]));
    }

    public function search_intership(Request $request, $slug)
    {
        $user = Auth::check();
        $employer = new Employer();
        $employers = $employer->select('employer_id', 'email', 'phone', 'view', 'status_allowance', 'image', 'province', 'district', 'enterprise_name', 'status_intership', 'slug', 'banner_intership', 'type_of_business_id', 'business', 'website');
        //            ->where('status_employer', 1);
        if (!empty($request->input('t'))) {
            $type_of_business_id = $request->input('t');
            $employers = $employers->where('type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('b'))) {
            $business = $request->input('b');
            $employers = $employers->where('business', $business);
        }
        if (!empty($request->input('p'))) {
            $province = $request->input('p');
            $employers = $employers->where('province', $province);
        }
        if (!empty($request->input('q'))) {
            $district = $request->input('q');
            $employers = $employers->where('district', $district);
        }
        if (!empty($request->input('w'))) {
            $word = $request->input('w');
            $employers = $employers->where('enterprise_name', 'like', '%' . $word . '%');
        }
        $employers = $employers->where('status_intership', 1);
        $employers = $employers->paginate(20);
        $employers->appends(request()->query());
        return view('site.employer.search_intership', compact('user', 'employers'));
    }

    public function detail_intership(Request $request, $slug)
    {

        $user = Auth::check();
        $employer = new Employer();
        $employer = $employer->select('*')
            ->where('slug', $slug)
            ->first();

        //        print_r($employer);die();
        if (empty($employer)) {
            return redirect(route('home'));
        }

        $view = intval($employer->view + 1);
        $update = $employer->where('slug', $slug)->update([
            'view' => $view
        ]);

        return view('site.employer_site.detail_intership', compact('user', 'employer'));
    }

    public function apply_intership(Request $request, $slug)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (Auth::check()) {
            $role = Auth::user()->role;
        }
        if (!Auth::check()) {
            return view('site.employee.create', compact('slug'));
            //neu chua dang nhap thi tao moi ung vien luon
        }
        if (Auth::check()) {
            $role = Auth::user()->role;
            $this->id_user = Auth::user()->id;
            $ckeditor = new CkedittorController();
            $session_image = $ckeditor->checkImage();
        }
        //            ung vien
        if (Auth::check() && $role == 1) {
            $user = Auth::user();
            return view('site.employer_site.update_user_submit_intership', compact('slug', 'user'));
        } else {
            return redirect()->back()->with('erorr_submit', 'Vui lòng đăng nhập tài khoản ứng viên để gửi hồ sơ thực tập');
        }
    }

    public function updateEmployeeSubmitIntership(Request $request)
    {
        $user = Auth::user();
        $email = Auth::user()->email;
        $id = Auth::user()->id;
        try {
            $employee_model = new Employee();
            $employer_model = new Employer();
            $employer = $employer_model->select('*')->where('slug', $request->input('slug'))->first();
            $employee = $employee_model->select('*')->where('user_id', $id)->first();

            $intership = new EmployerIntership();
            $check_inter_ship = $intership->select('*')
                ->where('employer_id', $employer->employer_id)
                ->where('employee_id', $employee->employee_id)
                ->first();
            //            print_r($check_inter_ship);die();
            if (empty($check_inter_ship)) {
                //tien hanh them moi
                $insert_intership = $intership->insert([[
                    'employer_id' => $employer->employer_id,
                    'status_intership' => 0,
                    'employee_id' => $employee->employee_id,
                    'internship_time' => $request->input('internship_time'),
                    'des_time' => $request->input('des_time'),
                    'created_at' => new \DateTime(),
                ]]);
            } else {
                $check_inter_ship = $intership->where('employer_id', $employer->employer_id)
                    ->where('employee_id', $employee->employee_id)
                    ->update([
                        'employer_id' => $employer->employer_id,
                        'status_intership' => 0,
                        'employee_id' => $employee->employee_id,
                        'internship_time' => $request->input('internship_time'),
                        'des_time' => $request->input('des_time'),
                        'updated_at' => new \DateTime(),
                    ]);
                return redirect()->back()->with('suscess', 'Bạn đã đăng kí thực tập tại công ty này rồi');
            }
            //gui cho ung vien
            MailConfigController::send_submit_intership(1, $employer, $employee, $employee->email);
            //gui cho nhà tuyển dụng
            MailConfigController::send_submit_intership(2, $employer, $employee, $employer->email);

            //gửi thông báo info den ứng viên
            $noti_model = new NotificationWindow();
            $link_noti = route('list_intership');
            $noti_insert = $noti_model->insert([
                'title_noti' => 'Sanketoan.vn thông báo',
                'user_id' => $employer['user_id'],
                'employer_id' => $employer['employer_id'],
                'des_noti' => 'Có ứng viên nộp hồ sơ xin thực tập với công ty bạn',
                'link_noti' => $link_noti,
                'created_at' => new \DateTime()
            ]);
            return redirect()->back()->with('suscess', 'Bạn đã đăng kí thực tập công ty thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('erorr', 'Bạn đã đăng kí thực tập công ty thất bại');
        }
    }

    public function list_employer(Request $request)
    {
        $list_employer = Employer::select('employer.employer_id', 'employer.email', 'employer.phone', 'employer.view', 'employer.status_allowance', 'employer.image', 'employer.province', 'employer.district', 'employer.enterprise_name', 'employer.status_intership', 'employer.slug', 'employer.banner_intership', 'employer.type_of_business_id', 'employer.business', 'employer.website', 'users.id', 'users.status_email_account')
            ->join('users', 'users.id', '=', 'employer.user_id');
        //            ->where('status_employer', 1);

        if (!empty($request->input('type_of_business_id'))) {
            $type_of_business_id = $request->input('type_of_business_id');
            $list_employer = $list_employer->where('employer.type_of_business_id', $type_of_business_id);
        }
        if (!empty($request->input('business'))) {
            $business = $request->input('business');
            $list_employer = $list_employer->where('employer.business', $business);
        }
        if (!empty($request->input('province'))) {
            $province = $request->input('province');
            $list_employer = $list_employer->where('employer.province', $province);
        }
        if (!empty($request->input('district'))) {
            $district = $request->input('district');
            $list_employer = $list_employer->where('employer.district', $district);
        }
        if (!empty($request->input('word'))) {
            $word = $request->input('word');
            $list_employer = $list_employer->where('employer.enterprise_name', 'like', '%' . $word . '%');
        }
        $list_employer = $list_employer->where('users.status_email_account', '>=', 1);
        $list_employer = $list_employer->orderBy('employer.employer_id', 'desc');
        $list_employer = $list_employer->paginate(10);
        $list_employer->appends(request()->query());
        return view('site.employer.list_employer', compact('list_employer'));
    }


    public function star_employer(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 1) {
            $qty_stars = $request->input('qty_stars');
            $content_star = $request->input('content_star');
            $employer_id = $request->input('employer_id');
            $id = Auth::user()->id;

            $star_employer = new StarEmployer();


            $star_employer = $star_employer->insertGetId([
                'id_user' => $id,
                'id_employer' => $employer_id,
                'qty_stars' => $qty_stars,
                'content_star' => $content_star,
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
            $starAll = \App\Entity\StarEmployer::checkStarEmployer($employer_id);
            $countStar = \App\Entity\StarEmployer::countEmployer($employer_id);

            $aumAll = 0;
            foreach ($starAll as $star) {
                $aumAll += $star['qty_stars'];
            }
            if ($countStar > 0) {
                $avgStar = $aumAll / $countStar;
            } else {
                $avgStar = 0;
            }
            $employer = new Employer();
            $employer = $employer->where('employer_id', $employer_id)->update([
                'total_star' => $avgStar
            ]);
            return redirect()->back()->with('success_apply_intership', 'Đánh giá công ty thành công!');
        } else {
            return redirect()->back()->with('success_apply_intership', 'Vui lòng đăng nhập tài khoản ứng viên để đánh giá công ty này !');
        }
    }

    public function detail_new_intership($cate_slug, $slug_post)
    {

        $post = $this->getPostDetail($slug_post);
        $category = $this->getCategory($post);
        if (empty($post->template) or $post->template == 'default') {
            return view('site.employer.detail_new_intership', compact('post', 'category', 'cate_slug'));
        } else {
            return view('site.template.' . $post->template, compact('post', 'category', 'cate_slug'));
        }
    }

    private function getPostDetail($slug_post)
    {
        try {
            $post = Post::where('slug', $slug_post)
                ->where('post_type', 'post')
                ->first();

            $inputs = Input::where('post_id', $post->post_id)->get();
            foreach ($inputs as $input) {
                $post[$input->type_input_slug] = $input->content;
            }
            return $post;
        } catch (\Exception $e) {
            Log::error('http->site->PostController->getPostDetail: lỗi lấy dữ liệu post');

            return null;
        }
    }

    private function getCategory($post)
    {
        try {
            $category = Category::join('category_post', 'categories.category_id', '=', 'category_post.category_id')
                ->select('categories.*')
                ->where('category_post.post_id', $post->post_id)
                ->first();

            if (empty($category)) {
                $category = Category::first();
            }

            return $category;
        } catch (\Exception $e) {
            Log::error('http->site->PostController->getPostDetail: lỗi lấy dữ liệu post');

            return redirect('/');
        }
    }

    //danh sach ho so thuc tap da nop
    public function list_profile_intership(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return redirect(route('list_intership'));
        }
        if (!empty($request->input('email')) && !empty($request->input('employer_id'))) {
            $email = $request->input('email');
            $employer_id = $request->input('employer_id');

            $employer = new Employer();
            $employer = $employer->select('employer_id', 'status_intership', 'status_allowance', 'des_intership', 'content_intership', 'user_id', 'updated_at', 'banner_intership', 'email')
                ->where('email', $email)
                ->where('employer_id', $employer_id)
                ->first();

            $intership = new EmployerIntership();
            $intership = $intership->select('employer_intership.*', 'employees.employee_id', 'employees.employee_name', 'employees.province', 'employees.district')
                ->join('employees', 'employees.employee_id', '=', 'employer_intership.employee_id');
            $intership = $intership->where('employer_intership.employer_id', $employer->employer_id);


            if (!empty($request->input('id_status_submit'))) {
                $id_status_submit = $request->input('id_status_submit');
                $intership = $intership->whereIn('employer_intership.id_status', $id_status_submit);
            }
            $intership = $intership->orderBy('employer_intership.intership_id', 'asc');
            $intership = $intership->paginate(10);
            $intership->appends(request()->query());

            return view('site.employer.list_profile_intership', compact('employer', 'intership'));
        }
    }

    //    danh sach ho so ung tuyen
    public function list_profile_job(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 2) {
            return redirect(route('list_Job_Candidate_Employee'));
        }
        if (!empty($request->input('email')) && !empty($request->input('employer_id'))) {
            $email = $request->input('email');
            $employer_id = $request->input('employer_id');
            $employer_model = new Employer();
            $employer = $employer_model->select('employer_id', 'status_intership', 'status_allowance', 'des_intership', 'content_intership', 'user_id', 'updated_at', 'banner_intership', 'email')
                ->where('email', $email)
                ->where('employer_id', $employer_id)
                //                ->where('status_employer', 1)
                ->first();
            $job_model = new Job();

            //danh sach cong viec

            $list = $job_model::select(
                'jobs.job_id',
                'jobs.job_code',
                'jobs.title',
                'jobs.slug',
                'employer_id'
            )->where('employer_id', $employer->employer_id)
                ->get();

            $list_jobs = $job_model::select(
                'jobs.job_id',
                'jobs.job_code',
                'jobs.id_exam',
                'jobs.title',
                'jobs.slug',
                'jobs.deadline_submit_profile',
                'jobs.salary_id',
                'jobs.date_submit',
                'employee_submit_job_facebook.*',
                'employees.employee_id',
                'employees.employee_name',
                'employees.district',
                'employees.province'
            )
                ->leftJoin('employee_submit_job_facebook', 'employee_submit_job_facebook.id_job_fb', '=', 'jobs.job_id')
                ->join('employees', 'employees.employee_id', 'employee_submit_job_facebook.employee_id')
                ->where('jobs.employer_id', $employer->employer_id);
            if (!empty($request->input('id_status_submit'))) {
                $id_status_submit = $request->input('id_status_submit');
                $list_jobs = $list_jobs->whereIn('employee_submit_job_facebook.id_status_submit_job', $id_status_submit);
            }
            $list_jobs = $list_jobs->orderBy('jobs.job_id', 'desc');
            $list_jobs = $list_jobs->orderBy('employee_submit_job_facebook.submit_job_fb_id', 'desc');

            $list_jobs = $list_jobs->paginate(10);
            $list_jobs->appends(request()->query());

            $job_id = array();
            foreach ($list_jobs as $job) {
                $job_id[] = $job->id_job_fb;
            }

            //        echo '<pre>';
            //        print_r($list_jobs);die();
            return view('site.employer.list_profile_job', compact('list', 'list_jobs', 'job_id', 'employer'));
        }
    }

    public function update_profile_employer()
    {
        $employer_model = new Employer();
        $list_employer = $employer_model->select('*')->get();
        foreach ($list_employer as $employer) {
            $update = Employer::get_user_id_Profile($employer->user_id);
        }
        echo 'xong';
    }

    public function detail_table_price(Request $request)
    {
        $table_price_id = $request->table_price_id;
        $comments = Service_comment::where('service_table_price_id', $table_price_id)->get();
        $table_prices = Service_table_price::where('service_table_price_id', $table_price_id)->select('benifit', 'endow')->first();


        return response([
            'comments' => $comments,
            'table_prices' => $table_prices
        ])->header('Content-Type', 'text/plain');
    }

    public function detail_table_price1(Request $request)
    {
        $service_price_id = $request->service_price_id;
        $table_price_id = Service_table_price::where('service_price_id', $service_price_id)->orderBy('service_table_price_id', 'asc')->value('service_table_price_id');
        $comments = Service_comment::where('service_table_price_id', $table_price_id)->get();
        $table_prices = Service_table_price::where('service_price_id', $service_price_id)->orderBy('service_table_price_id', 'asc')->first();

        return response([
            'comments' => $comments,
            'table_prices' => $table_prices
        ])->header('Content-Type', 'text/plain');
    }

    public function detail_table_price2(Request $request)
    {
        $service_price_slug = $request->table_price_slug;
        $service_price_id = Service_price::where('service_price_slug', $service_price_slug)->value('service_price_id');
        $table_price_id = Service_table_price::where('service_price_id', $service_price_id)->orderBy('service_table_price_id', 'asc')->value('service_table_price_id');
        $comments = Service_comment::select(
            'service_comment_content',
            'service_comment_image'
        )
            ->where('service_table_price_id', $table_price_id)->get();
        $table_prices = Service_table_price::where('service_price_id', $service_price_id)->orderBy('service_table_price_id', 'asc')->first();

        return response([
            'comments' => $comments,
            'table_prices' => $table_prices
        ])->header('Content-Type', 'text/plain');
    }


    public function show_info_employee(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employees = new Employee();
        $employee = $employees->select('career_category_id', 'user_id', 'employee_id')->where('employee_id', $employee_id)->first();
        //lấy xu theo danh mục công việc
        //        $caree = \App\Entity\Career::check_view_coint($employee_id);
        $coin_caree = \App\Entity\Employee_career_categories::get_coin_view_profile($employee_id);
        //        echo $employee_id;die;
        $employer = $this->check_user_role();
        if (empty($employer)) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin của ứng viên này.');
        }
        //check trường hopnj ntd hết xu
        $infomation_coin = \App\Entity\Coin_type_information_employer::get_coin_info();
        $coin_free = !empty($infomation_coin['so-diem-mien-phi-theo-ngay']) ? $infomation_coin['so-diem-mien-phi-theo-ngay'] : 0;
        $history_coin = \App\Entity\Coin_history_employer::sum_coin($employer->employer_id);
        $coin_surplus = $coin_free - $history_coin;
        $coin_surplus = !empty($coin_surplus) ? $coin_surplus : 0;
        if (empty($employer->total_employer_coin) && $coin_surplus < $coin_caree) {
            return redirect()->back()->with('error', 'Số điểm miễn phí của bạn không đủ để xem thông tin liên hệ của ứng viên này');
        }
        if (!empty($employer->total_employer_coin) && $employer->employer_coin < $coin_caree) {
            return redirect()->back()->with('error', 'Số điểm còn lại không đủ để xem thông tin liên hệ của ứng viên này.');
        }
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
        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        if (!empty($check_show_employee)) {
            if (!empty($link_cv_upload->employee_cv_status)) {
                $link_cv_upload_contact = asset('employee_link_cv');
            } else {
                $link_cv_upload_contact = route('exportpdf_cv_user_id', ['user_id' => $employee->user_id]);
            }
        }
        DB::commit();
        return redirect()->back()->with('success', 'Xem thông tin liên hệ thành công.');
    }

    public function send_job_employer(Request $request)
    {
        //end test
        $jobs_id = $request->input('job_ids');
        if (empty($jobs_id)) {
            return redirect()->back()->with('error', 'Vui lòng chọn tin tuyển dụng để mời ứng viên ứng tuyển');
        }
        $employee_id = $request->input('employee_id');
        $employees = new Employee();
        $employee = $employees->select('*')->where('employee_id', $employee_id)->first();
        $total_coin = 0;
        foreach ($jobs_id as $job_id) {
            $job = Job::select('career_category_id')->where('job_id', $job_id)->first();
            $caree = \App\Entity\Career::getIdCareer($job->career_category_id);
            $total_coin += $caree->view_apply;
        }
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
            $sendmail = MailConfigController::send_apply_job($jobs_id, $employee->email);
            //email không gửi dc đồng loại nên đóng loại
            //$sendmail = MailConfigController::send_email_invitation_employee($job, $employee_id);
        }
        DB::commit();
        return redirect()->back()->with('success', 'Mời ứng viên ứng tuyển thành công');
    }

    public function vote_employee(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employer = $this->check_user_role();
        if (empty($employer)) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin của ứng viên này.');
        }
        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        if (empty($check_show_employee)) {
            return redirect()->back()->with('error', 'Bạn phải xem thông tin liên hệ của ứng viên mới được đành giá ứng viên.');
        }


        $rating_content = $request->comment;
        $rating_start = $request->vote_star;
        $employer_rate = Employer_rating_employee::where('employer_id', $employer->employer_id)
            ->where('employee_id', $employee_id)->first();
        if (empty($employer_rate)) {
            Employer_rating_employee::insert([
                'employer_id' => $employer->employer_id,
                'employee_id' => $employee_id,
                'rating_start' => $rating_start,
                'rating_content' => $rating_content,
                'status_rating_employee' => 0,
                'created_at' => new \Datetime()
            ]);
        } else {
            $employer_rate->update([
                'rating_start' => $rating_start,
                'rating_content' => $rating_content,
                'status_rating_employee' => 0,
                'updated_at' => new \Datetime()

            ]);
        }
        // tinh diem danh gia trung binh cua ntd cho uv
        $avg = Employer_rating_employee::where('employee_id', $employee_id)->avg('rating_start');
        $avg = round($avg);
        // update profile cua employee

        Employee_profile::where('employee_id', $employee_id)->update([
            'profile_avg' => $avg,
            'updated_at' => new \Datetime()
        ]);
        $employee_profile = Employee_profile::where('employee_id', $employee_id)->first();
        $profile = $employee_profile->profile_info + $employee_profile->profile_cv + $employee_profile->profile_staff + $employee_profile->profile_course + $employee_profile->profile_avg;

        Employee::where('employee_id', $employee_id)->update([
            'profile' => $profile,
            'updated_at' => new \Datetime()
        ]);
        return redirect()->back()->with('success', 'Đánh giá ứng viên thành công.');
    }

    public function response_employee(Request $request)
    {
        $employee_id = $request->input('employee_id');
        $employer = $this->check_user_role();
        if (empty($employer)) {
            return redirect()->back()->with('error', 'Vui lòng đăng nhập tài khoản nhà tuyển dụng để xem thông tin của ứng viên này.');
        }
        $check_show_employee = \App\Entity\Coin_show_employee::check_employer_contact_employee($employer->employer_id, $employee_id);
        if (empty($check_show_employee)) {
            return redirect()->back()->with('error', 'Bạn phải xem thông tin liên hệ của ứng viên mới được phản hồi về CV ứng viên .');
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
        $user_id = Employee::where('employee_id', $employee_id)->value('user_id');
        //thông báo cho ứng viên
        $desc_title = 'Nhà tuyển dụng đã đánh giá CV của bạn thiếu thông tin';
        $noti_id = Notification_employer::insertGetId([
            'title_noti' => 'Sanketoan.vn thông báo', //tiêu đề thông báo
            'user_id' => $user_id, //	0 là thông báo chung
            'des_noti' => $desc_title, //Nội dung thông báo
            'link_noti' => '', //Link thông báo trên window
            'type_noti' => 'employees', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc
            'noti_status' => 0, //trạng thái thông báo 0 là chưa xem 1 đã xem
            'status_noti' => 0, //trạng thái thông báo 1 là đã xem 2 là đã xóa => tạm thời bỏ
            'view_noti' => 0, //Đã hiển thị thông báo ở cửa sơ window
            'job_id' => 0,
            'created_at' => new \DateTime()
        ]);
        //push noti cho app
        $title = 'Sàn kế toán thông báo';
        $type = 'employees';
        $note = 'Nhà tuyển dụng đã đánh giá CV của bạn thiếu thông tin';
        $value = $noti_id;
        $to = $user_id;
        $push_noti_app = new NotificationMobileController();
        $send_push = $push_noti_app->pushNotification($title, $desc_title, $to, $type, $note, $value);
        return redirect()->back()->with('success', 'Phản hồi chất lượng CV thành công.');
    }

    public function check_user_role()
    {
        if (Auth::check() && Auth::user()->role == 2) {
            $user_id = Auth::user()->id;
            $employer = Employer::select(
                'employer_id',
                'enterprise_name',
                'phone',
                'email',
                'employer_coin',
                'total_employer_coin',
                'total_money_coin',
                'user_id'
            )->where('user_id', $user_id)->first();
            return $employer;
        }
        return false;
    }
}
