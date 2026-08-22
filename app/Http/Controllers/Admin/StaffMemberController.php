<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Staff;
use App\Entity\Staff_member;
use Illuminate\Http\Request;
use App\Entity\User;
use App\Exam\CommentExam;
use App\Exam\Exam;
use App\Exam\Questions;
use App\Exam\StarExam;
use App\Http\Controllers\Site\MailConfigController;
use App\Ultility\Error;
use App\Ultility\Ultility;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class StaffMemberController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'customers');
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $staff = new Staff_member();
        $list_staff = $staff->select('*');
//        if (!empty($request->input('business'))) {
//            $business = $request->input('business');
//            $employers = $employers->where('employer.business', $business);
//        }
        $total = $list_staff->count();
        $list_staff = $list_staff->paginate(20);
        $list_staff->appends(request()->query());
        return view('customers.staff_member.list', compact('list_staff', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('customers.staff_member.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'email' => 'required|unique:users',
            'password' => 'required|min:8',
            'staff_member_name' => 'required',
        ], [
//            'enterprise_id.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bạn chưa nhập mật khẩu.',
            'email.required' => 'Bạn chưa nhập email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.min' => 'Mật khẩu Phải lớn hơn 8 ký tự.',
            'staff_member_name.required' => 'Tên cộng tác viên không được để trống',

        ]);

        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        try {
            DB::beginTransaction();

            $userModel = new User();
            $user_id_create = $userModel->insertGetId([
                'name' => $request->input('staff_member_name'),
                'email' => $request->input('email'),
                'password' => bcrypt($request->input('password')),
                'phone' => $request->has('staff_member_phone') ? $request->input('staff_member_phone') : '',
                'status_email_account' => 1,
                'role' => 6
            ]);
            $insert = Staff_member::insertGetId([
                'staff_member_name' => $request->input('staff_member_name'),
                'staff_member_email' => $request->input('email'),
                'staff_member_phone' => $request->has('staff_member_phone') ? $request->input('staff_member_phone') : '',
                'staff_member_image' => $request->has('staff_member_image') ? $request->input('staff_member_image') : '',
                'user_id' => $user_id_create,
                'created_at' => new \DateTime(),
            ]);
            DB::commit();
            return redirect(route('staff_member.index'))->with('success', 'Thêm mới cộng tác viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('staff_member.index'))->with('error', 'Thêm mới cộng tác viên thất bại');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($staff_member_id)
    {
        $staff = new Staff_member();
        $staff = $staff->select('*')->where('staff_member_id',$staff_member_id)->first();
        return view('customers.staff_member.edit', compact('staff'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $staff_member_id)
    {

        try {
        DB::beginTransaction();
        $staff = new Staff_member();
        $staff = $staff->select('*')->where('staff_member_id',$staff_member_id)->first();
        $userModel = new User();
        $user = $userModel->where('id', $staff->user_id)->first();

        $isChangePassword = $request->input('is_change_password');
        if ($isChangePassword == 1) {
            $user->update([
                'password' => bcrypt($request->input('password')),
            ]);
        }
        $user->update([
            'name' => $request->input('staff_member_name'),
            'phone' => $request->has('staff_member_phone') ? $request->input('staff_member_phone') : '',
            'status_email_account' => 1,
        ]);
        $update = Staff_member::where('staff_member_id',$staff_member_id)->update([
            'staff_member_name' => $request->input('staff_member_name'),
            'staff_member_phone' => $request->has('staff_member_phone') ? $request->input('staff_member_phone') : '',
            'staff_member_image' => $request->input('staff_member_image'),
            'updated_at' => new \DateTime(),
        ]);
        DB::commit();
        return redirect(route('staff_member.index'))->with('success', 'Cập nhật mới nhân viên thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
            DB::rollBack();
            return redirect(route('staff_member.index'))->with('error', 'Cập nhật nhân viên thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($staff_member_id)
    {
        try {

            DB::beginTransaction();
            $staff = new Staff_member();
            $staff = $staff->select('*')->where('staff_member_id',$staff_member_id)->first();
            $user = new User();
            $user = $user->where('id', $staff->user_id)->delete();
            $delete = $staff->select('*')->where('staff_member_id',$staff_member_id)->delete();

            DB::commit();
            return redirect(route('staff_member.index'))->with('success', 'Xóa thành công');
        } catch (\Exception $exception) {
            Error::setErrorMessage("Không thể xóa dữ liệu. Đã có lỗi xảy ra");
            DB::rollBack();
            return redirect(route('staff_member.index'))->with('error', 'Xóa thất bại');
        }
    }

    public function listStaffMemberDelete(Request $request)
    {
        $staff = new Staff_member();
        $list_staff = $staff->onlyTrashed()->select('*');
        $total = $list_staff->count();
        $list_staff = $list_staff->paginate(50);
        $list_staff->appends(request()->query());
        return view('customers.staff_member.list_delete', compact('list_staff', 'total'));
    }

    public function Staff_member_restore(Request $request, $staff_member_id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {

                $staff = new Staff_member();
                $staff = $staff->onlyTrashed()->select('*')->where('staff_member_id',$staff_member_id)->first();

                $user_model = new User();
                $restore = $user_model->withTrashed()->where('id', $staff->user_id)->restore();
                $restore_employee = $staff->withTrashed()->where('user_id', $staff->user_id)->restore();

                //khoi phuc ban ghi
                DB::commit();
                return redirect(route('listStaffMemberDelete'))->with('success', 'Khôi phục thành công');
            }
        } catch (\Exception $exception) {
            DB::rollBack();
            return redirect(route('listStaffMemberDelete'))->with('error', 'Khôi phục thất bại');
        }


    }

    public function Staff_member_forceDelete(Request $request, $staff_member_id)
    {
        try {
            DB::beginTransaction();
            $userLogin = Auth::user();
            if ($userLogin->role == 4) {

                $staff_model = new Staff_member();
                $staff = $staff_model->onlyTrashed()->select('*')->where('staff_member_id',$staff_member_id)->first();

                $user_model = new User();
                $delete_user = $user_model->where('id', $staff->user_id)->delete();

                $forceDelete = $user_model->withTrashed()
                    ->where('id', $staff->user_id)
                    ->forceDelete();

                $force_delete = $staff_model->withTrashed()
                    ->where('user_id', $staff->user_id)
                    ->forceDelete();

            }
            DB::commit();
            return redirect(route('listStaffMemberDelete'))->with('success', 'Xóa vĩnh viễn thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect(route('listStaffMemberDelete'))->with('success', 'Xóa vĩnh viễn thất bại');
        }

    }
}
