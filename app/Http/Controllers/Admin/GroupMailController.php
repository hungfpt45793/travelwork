<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/13/2017
 * Time: 9:25 AM
 */

namespace App\Http\Controllers\Admin;


use App\Entity\GroupMail;
use App\Entity\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class GroupMailController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });
    }

    public function store(Request $request){
        try {
            $groupMail = new GroupMail();
            $groupMail->insert([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
            ]);
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi tạo mới nhóm email');
            Log::error('http->admin->GroupMailController->store: Lỗi tạo mới nhóm email');
        } finally {
            return redirect(route('subcribe-email.index'));
        }
    }

    public function destroy(GroupMail $groupMail){
        try {
            $groupMail->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xóa nhóm email');
            Log::error('http->admin->GroupMailController->destroy: Lỗi xóa nhóm email');
        } finally {
            return redirect(route('subcribe-email.index'));
        }


    }
}
