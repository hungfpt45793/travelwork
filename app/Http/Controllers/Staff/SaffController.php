<?php

namespace App\Http\Controllers\Staff;


use App\Entity\Staff;
use App\Entity\User;
use App\Http\Controllers\Staff\SiteStaffController;
use App\Ultility\Error;
use Illuminate\Http\Request;

use App\Entity\Employee;
use App\Entity\Statistical_employees;
use App\Entity\Employee_experience;
use App\Entity\Employee_specialize;
use App\Entity\Interactive_history_employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Entity\Employer;
use App\Entity\Staff_follow;
use Validator;

class SaffController extends SiteStaffController
{
    public function edit_staff_info()
    {
        $user_id = Auth::user()->id;
//        echo $user_id;die();
        $user = Auth::user();
        $staff = Staff::select('*')->where('user_id',$user_id)->first();
        return view('staff_admin.staff.edit_staff_info', compact('user','staff'));
    }
//    public function staff_change_password(Request $request)
//    {
//        $user_id = Auth::user()->id;
//        $staff = Staff::select('*')->where('user_id',$user_id)->first();
//        return view('staff_admin.staff.edit_staff_info.blade', compact('user'));
//    }
    public function staff_change_password(Request $request)
    {
        $user = Auth::user();
        return view('staff_admin.staff.staff_change_password', compact('user'));
    }

    public function post_change_password(Request $request) {

        $user = Auth::user();
        if ( !Hash::check($request->input('password_old'), $user->password)) {
            $faidOldPassword = "Mật khẩu cũ của bạn điền không đúng";
            return redirect()->back()
                ->with('faidOldPassword', $faidOldPassword)
                ->withInput();
        }

        $validation = Validator::make($request->all(), [
            'password' => 'required|string|confirmed',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }
        User::where('id', $user->id)->update([
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->back()
            ->with('success', 'Bạn đã thay đổi mật khẩu thành công')
            ->withInput();

    }
    public  function update_staff_info(Request $request)
    {
//        try {
            DB::beginTransaction();
         $user_id = Auth::user()->id;
            $staff = new Staff();
            $staff = $staff->select('*')->where('user_id',$user_id)->first();
            $userModel = new User();
            $user = $userModel->where('id', $staff->user_id)->first();

            $isChangePassword = $request->input('is_change_password');
            if ($isChangePassword == 1) {
                $user->update([
                    'password' => bcrypt($request->input('password')),
                ]);
            }
            $user->update([
                'name' => $request->input('staff_name'),
                'phone' => $request->has('staff_phone') ? $request->input('staff_phone') : '',
                'status_email_account' => 1,
            ]);
            $update = Staff::where('user_id',$user_id)->update([
                'staff_name' => $request->input('staff_name'),
                'staff_phone' => $request->has('staff_phone') ? $request->input('staff_phone') : '',
                'staff_image' => $request->input('staff_image'),
                'updated_at' => new \DateTime(),
            ]);
            DB::commit();
            return redirect(route('edit_staff_info'))->with('success', 'Cập nhật thông tin thành công');
//        } catch (\Exception $exception) {
//            Error::setErrorMessage("Không thể thêm mới dữ liệu. Đã có lỗi xảy ra trong quá trình nhập dữ liệu");
//            DB::rollBack();
//            return redirect(route('edit_staff_info'))->with('error', 'Cập nhật thông tin thất bại');
//        }
    } 
    public function follow_user($id)
    {
        $staff_user_id = Auth::id();
        $staff_id = Staff::where('user_id', $staff_user_id)->value('staff_id');
        $staff_follow = Staff_follow::where('staff_follow.user_id', $id)->where('staff_id', $staff_id)->first();
        $type_user = User::where('id', $id)->value('role');
        if(isset($staff_follow)){
            $status = $staff_follow->status_follow;
            
            if($status == 1){
                $staff_follow->update([
                    'status_follow' => 2,
                ]);
            }
            else{
                $staff_follow->update([
                    'status_follow' => 1,
                ]);
            }
           
            
        }
        else {
            $staff_follow = Staff_follow::create([
                'staff_id' => $staff_id,
                'user_id' => $id,
                'type_user' => $type_user,
                'status_follow' => 1,
            ]);
        }
        return redirect()->back()->with('msg','Theo dõi thành công!');
    }

}


