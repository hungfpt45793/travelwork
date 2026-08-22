<?php

namespace App\Http\Controllers\Site;

use App\Course\Detailresult_question_course;
use App\Entity\Combo_advise;
use App\Entity\Employee;
use App\Entity\Employee_profile;
use App\Entity\Forum_post;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
use App\Entity\User;
use App\Entity\User_advise;
use App\Entity\User_advise_submit;
use App\Entity\User_support;
use App\Entity\User_support_connect_advise;
use App\Entity\User_support_question;
use Cassandra\Date;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserSupportAdvieController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'menuwebsite');
    }

    public function user_support_advise(Request $request)
    {
        $list_advise = User_advise::select('user_advise.*', 'users.name', 'users.image', 'users.role', 'users.id')
            ->join('users', 'users.id', 'user_advise.user_id')
            ->where('user_advise.ad_status', 1)
            ->orderBy('user_advise.ad_id', 'desc')
            ->get();


        $list_support = User_support::select('user_support.*', 'users.name', 'users.image', 'users.role', 'users.id', 'user_support_question.support_id', 'user_support_question.ques_status', 'user_support_question.ques_id', 'user_support_question.ad_id')
            ->join('users', 'users.id', 'user_support.user_id')
            ->join('user_support_question', 'user_support_question.sup_id', 'user_support.sup_id')
            ->where('user_support_question.status_show', 0)
            ->orderBy('user_support.sup_id', 'desc')
            ->distinct()
            ->get();
//        echo '<pre>';
//        print_r($list_support);die;
        return view('site.user_advise_support.user_support_advise', compact('list_advise', 'list_support'));
    }

    public function res_user_advise(Request $request)
    {
        return view('site.user_advise_support.res_user_advise');
    }

    public function res_user_support(Request $request)
    {
        return view('site.user_advise_support.res_user_support');
    }

    public function get_connect_user_support(Request $request, $user_id)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('mesage_modal_advise', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $user_advise = User::where('id', $user_id)->first();
        $check = User_support_connect_advise::check_res_advise($user_advise->ad_id, Auth::user()->id);
        if (!empty($check)) {
            return redirect(route('user_support_advise'))->with('mesage_modal', 'Bạn đa liên hệ với gia su này rồi');
        }
        return view('site.user_advise_support.get_connect_user_support', compact('user_advise'));
    }

    //chi tiet giao vien ket noi
    public function detail_user_teacher($slug)
    {

        $teacher = new Teacher();
        $teacher = $teacher->select('teacher.teacher_images', 'teacher.teacher_phone', 'teacher.user_id', 'teacher.teacher_email', 'teacher.province', 'teacher.district', 'teacher.business_type_id', 'teacher.teacher_name', 'teacher.teacher_id', 'teacher.slug', 'information_verifier', 'address')->where('teacher.slug', $slug)->first();
        if (empty($teacher)) {
            return redirect(route('home'));
        }


        $user_advise = User_advise::select('user_advise.*', 'users.name', 'users.image', 'users.role', 'users.id')
            ->join('users', 'users.id', 'user_advise.user_id')
            ->where('user_advise.ad_status', 1)
            ->where('users.id', $teacher->user_id)
            ->first();


//        kinh nghiem giáo viên
        $teacher_experience = new Teacher_experience();
        $teacher_experience = $teacher_experience->select('*')->orderBy('experience_id', 'asc')->where('teacher_id', $teacher->teacher_id)->get();
//        trình độ giáo viên
        $teacher_specialize = new Teacher_specialize();
        $teacher_specialize = $teacher_specialize->select('*')->orderBy('specialize_id', 'asc')->where('teacher_id', $teacher->teacher_id)->get();

        return view('site.user_advise_support.detail_user_teacher', compact('teacher', 'user_advise', 'teacher_experience', 'teacher_specialize'));
    }

    //chi tiet ke toán
    public function detail_user_employee($employee_slug)
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
//        if ($view == 50) {
//            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
//        }
//        if ($view == 100) {
//            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
//        }
//        if ($view == 150) {
//            $mail = MailConfigController::send_view_50_employee($employee->email, $view);
//        }
//        //điểm của ứng viên
        $employee_profile = Employee_profile::where('employee_id', $employee->employee_id)->first();
        $user_advise = User_advise::where('user_id',$employee->user_id)->first();
        $comco_ad = Combo_advise::where('combo_ad_id',$user_advise->combo_ad_id)->first();
//
//        return view('site.employee_site.detail_employee', compact('employee', 'employee_profile'));


        return view('site.user_advise_support.detail_user_employee', compact('employee', 'employee_profile','comco_ad'));
    }


    public function res_advise(Request $request)
    {

        $validation = $this->validateEmployee($request);
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->with('registerEmployee', 'Đăng ký ứng viên lỗi !')
                ->withInput();
        }

        $url = redirect()->back()->getTargetUrl();
        if (!Auth::check()) {
            return redirect()->back()->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        if (Auth::user()->role == 1 || Auth::user()->role == 3) {

            $user = Auth::user();
//            if ($user->user_advise_support == 1) {
//                return redirect()->back()->with('mesage_modal', 'Bạn đã đăng ký chuyên gia tư vấn rồi, Vui lòng chờ Admin duyệt tài khoản của bạn');
//            }
//            if ($user->user_advise_support == 2) {
//                return redirect()->back()->with('mesage_modal', 'Bạn đã đăng ký kế toán cần hỗ trợ rồi nên không thể đăng ký thành chuyên gia tư vấn được');
//            }
            //check vao bang user
            if ($user->user_advise_support == 0) {
                $update = User::where('id', $user->id)->update([
                    'user_advise_support' => 1
                ]);
            }
            //chek trường họp user đăng 10 bài tư vấn skt.
            $ad_status = 0;
            $total_post = Forum_post::where('for_user_id', $user->id)->count();
            if ($total_post >= 10) {
                $ad_status = 1;
            }
            //dang ký thành chuyên gia
            $check = User_advise::where('user_id', $user->id)->first();
            if (!empty($check)) {
                return redirect($url)->with('mesage_modal', 'Bạn đã đăng ký thành công chuyên gia tư vấn rồi , Vui lòng chờ Admin duyệt tài khoản của bạn');
            }
            $insert = User_advise::insert([
                'user_id' => $user->id,
                'user_ad_status' => 0, //0 là không có ai duyệt
                'ad_status' => $ad_status, //	0 là chưa duyêt, 1 là đã duyệt
                'combo_ad_id' => $request->input('combo_ad_id'), //0laf chưa chọn gói tu vấn
                'created_at' => new \DateTime()
            ]);
            return redirect($url)->with('mesage_modal', 'Bạn đã đăng ký thành công chuyên gia tư vấn , Vui lòng chờ Admin duyệt tài khoản của bạn');

        } else {
            return redirect()->back()->with('mesage_modal', 'Vui lòng đăng nhập tài khoản giáo viên với tài khoản ứng viên để sử dụng chức năng này');
        }


    }

    public function res_support(Request $request)
    {
//        $validation = $this->validatesuppott($request);
//        if ($validation->fails()) {
//            return redirect()->back()
//                ->withErrors($validation)
//                ->with('registerEmployee', 'Đăng ký ứng viên lỗi !')
//                ->withInput();
//        }

        $url = redirect()->back()->getTargetUrl();
        if (!Auth::check()) {
            return redirect()->back()->with('mesage_modal_advise', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        if (Auth::user()->role == 1 || Auth::user()->role == 2) {
            $user = Auth::user();
            if ($user->user_advise_support == 0) {
                $update = User::where('id', $user->id)->update([
                    'user_advise_support' => 1
                ]);
            }
            //chek trường họp user đăng 10 bài tư vấn skt.

//            //dang ký thành chuyên gia
//            $check = User_support::where('user_id', $user->id)->first();
//            if (!empty($check)) {
//                return redirect($url)->with('mesage_modal', 'Bạn đã gửi yêu cầu hỗ trợ rồi');
//            }
            $check_user_support = User_support::where('user_id', $user->id)->first();
            if (empty($check_user_support)) {
                $sup_id = User_support::insertGetId([
                    'user_id' => $user->id,
                    'created_at' => new \DateTime()
                ]);
            } else {
                $sup_id = $check_user_support->sup_id;
            }
            $sup_id_question = User_support_question::insertGetId([
                'support_id' => $request->input('support_id'),
                'sup_id' => $sup_id, //id người ra câu hỏi
                'ad_id' => 0, //id chuyên gia nhận tuwe vấn
                'ques_status' => 0,  //0 đã nhận 1 là từ chối 2 là đã hoàn thành
                'created_at' => new \DateTime()
            ]);
            return redirect(route('user_support_advise'))->with('mesage_modal', 'Bạn đã gửi yêu cầu hỗ trợ thành công');

        } else {
            return redirect()->back()->with('mesage_modal', 'Chức năng này chỉ dành cho nhà tuyển và ứng viên');
        }


    }

    private function validateEmployee($request)
    {
        $validation = Validator::make($request->all(), [
            'combo_ad_id' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'combo_ad_id.required' => 'Vui lòng chọn 1 trong các gói gia sư',
        ]);
        return $validation;
    }

    private function validatesuppott($request)
    {
        $validation = Validator::make($request->all(), [
            'ques_title' => 'required',
            'ques_content' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'ques_title.required' => 'Tiêu đề hỗ trợ không được để trống',
            'ques_content.required' => 'Nội dung hỗ trợ không được để trống',
        ]);
        return $validation;
    }

    //Kế toán chọn gia sư
    public function user_advise_submit(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('mesage_modal_advise', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $advise = User_advise::where('user_id', $request->user_id)->first();
        $check = User_support_connect_advise::where('ad_id', $advise->ad_id)
//            ->where('sup_id', $user_spport->sup_id)
            ->where('user_id', Auth::user()->id)
            ->first();
        if (!empty($check)) {
            return redirect()->back()->with('mesage_modal', 'Gia sư này bạn đã liên hệ rồi chờ phản hồi');
        }
        $insert = User_support_connect_advise::insert([
            'ad_id' => $advise->ad_id, //id của chuyên gia
            'user_id' => Auth::user()->id, //id của người hỗ trợ
            'status_connect' => 0,  //0 chưa xác nhận ,1 là đã nhận , 2 là từ chối , 3 là hoàn thành
            'support_id' => $request->input('support_id'),
            'created_at' => new \DateTime(),

        ]);
        //gửi email thông báo cho giáo viên
        MailConfigController::send_user_advise_submit(Auth::user()->email);
        return redirect(route('user_support_advise'))->with('mesage_modal', 'Bạn đã gửi yêu cầu cho gia sư thành công');
    }

    //Gia sư tu vân cho kế toan
    public function support_user_advise(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->back()->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $user_spport = User_support::where('sup_id', $request->sup_id)->first();
        $user_advise = User_advise::where('user_id', Auth::user()->id)->where('ad_status', 1)->first();
        if (empty($user_advise)) {
            return redirect()->back()->with('mesage_modal', 'Chức năng này chỉ dành cho gia sư');
        }
        $check = User_support_question::where('ques_id', $request->ques_id)
            ->first();
        if (!empty($check->ad_id)) {
            return redirect()->back()->with('mesage_modal', 'Kế toán này đang có gia sư liên hệ rồi');
        }
//        if ($check->ques_status == 3) {
//            return redirect()->back()->with('mesage_modal', 'Kế toán này đã có gia sư hỗ trợ rồi');
//        }
        $insert = User_support_question::where('ques_id', $request->ques_id)
            ->update([
                'ad_id' => $user_advise->ad_id,
                'updated_at' => new \DateTime()
            ]);

        //gửi email thông báo cho kế toán là có gia sư muốn tư vấn
        //gửi email thông báo cho giáo viên
        MailConfigController::send_support_user_advise(Auth::user()->email);
        return redirect()->back()->with('mesage_modal', 'Bạn đã gửi yêu cầu cho gia sư thành công');
    }

    public function list_advise_user(Request $request)
    {

        //gia su
        if (!Auth::check()) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $user_advise = User_advise::where('user_id', Auth::user()->id)->first();
        if (empty($user_advise)) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $list_ad = User_support_connect_advise::select('user_support_connect_advise.*', 'list_support.support_id', 'list_support.title_support', 'users.name', 'users.id', 'users.email', 'users.phone')
            ->join('list_support', 'list_support.support_id', 'user_support_connect_advise.support_id')
            ->join('users', 'users.id', 'user_support_connect_advise.user_id')
            ->where('user_support_connect_advise.ad_id', $user_advise->ad_id)
            ->get();
//        return view('site.user_advise_support.list_advise_user');
        return view('site.user_advise_support.list_advise_user', compact('list_ad'));
    }

    public function list_update_advise_status(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $user_advise = User_advise::where('user_id', Auth::user()->id)->first();
        if (empty($user_advise)) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }

        $connect_id = $request->input('connect_id');

        $update = User_support_connect_advise::where('connect_id', $connect_id)->update([
            'status_connect' => $request->input('status_connect')
        ]);
        //gửi email thông báo
        $trang_thai = 'chưa nhận';
        if ($request->input('status_connect') == 1) {
            $trang_thai = 'đã nhận';
        }
        if ($request->input('status_connect') == 2) {
            $trang_thai = 'từ chối';
        }
        if ($request->input('status_connect') == 3) {
            $trang_thai = 'hoàn thành';
        }
        MailConfigController::send_list_update_advise_status(Auth::user()->email,$trang_thai);
        return redirect()->back()->with('mesage_modal', 'Cập nhật trạng thái thành công');

    }

    public function list_support_user(Request $request)
    {
//        return view('site.user_advise_support.list_test');
//        ke toan

        if (!Auth::check()) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $user_support = User_support::where('user_id', Auth::user()->id)->first();
        if (empty($user_support)) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }


        $list_sup = User_support_question::select('user_support_question.*', 'list_support.title_support')
            ->join('list_support', 'list_support.support_id', '=', 'user_support_question.support_id')
//            ->join('user_support', 'user_support.sup_id', '=', 'user_support_question.sup_id')
            ->where('user_support_question.sup_id', $user_support->sup_id)
            ->orderBy('user_support_question.ques_id', 'desc')
            ->get();
//
//                echo '<pre>';
//        print_r($list_sup);die;
        return view('site.user_advise_support.list_support_user', compact('list_sup'));
    }

    public function list_update_support_status($ques_id, Request $request)
    {
        if (!Auth::check()) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
        $user_support = User_support::where('user_id', Auth::user()->id)->first();
        if (empty($user_support)) {
            return redirect('/')->with('mesage_modal', 'Vui lòng đăng nhập để sử dụng chức năng này');
        }
//        $connect_id = $request->input('connect_id');
        $update = User_support_question::where('ques_id', $ques_id)->update([
            'ques_status' => $request->input('ques_status')
        ]);
        //gửi email thông báo
        //gửi email thông báo

//        'ques_status',  //0 cần được tư vấn ,1 là đã được tư vấn, 2 là từ chối , 3 là hoàn thành

        $trang_thai = 'cần được tư vấn';
        if ($request->input('ques_status') == 1) {
            $trang_thai = 'đã được tư vấn';
        }
        if ($request->input('ques_status') == 2) {
            $trang_thai = 'từ chối';
        }
        if ($request->input('ques_status') == 3) {
            $trang_thai = 'hoàn thành';
        }
        MailConfigController::send_list_update_support_status(Auth::user()->email,$trang_thai);

        return redirect()->back()->with('mesage_modal', 'Cập nhật trạng thái thành công');
    }
}
