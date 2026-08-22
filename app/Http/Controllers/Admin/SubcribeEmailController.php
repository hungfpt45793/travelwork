<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/7/2017
 * Time: 2:47 PM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\GroupMail;
use App\Entity\MailConfig;
use App\Entity\Post;
use App\Entity\SubcribeEmail;
use App\Entity\User;
use App\Mail\Mail;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class SubcribeEmailController extends AdminController
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

            view()->share('menuTop', 'customers');

            return $next($request);
        });

    }

    public function index() {
        try {
            $groupMails = GroupMail::orderBy('group_mail_id', 'desc')->get();

            return view('admin.subcribe_email.index', compact('groupMails'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị đăng ký email kh: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubcribeEmailController->index: Lỗi xảy ra trong quá trình hiển thị đăng ký email khách hàng');

            return redirect('admin/home');
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $groupMails = GroupMail::orderBy('group_mail_id', 'desc')->get();

            return view('admin.subcribe_email.add', compact('groupMails'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới đăng ký email kh: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubcribeEmailController->create: Lỗi xảy ra trong quá trình tạo mới đăng ký email khách hàng');

            return redirect('admin/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $subcribeEmail = new SubcribeEmail();
            $subcribeEmail->insert([
                'email' => $request->input('email'),
                'slug_gruop' => $request->input('slug_gruop'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới đăng ký email kh: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubcribeEmailController->store: Lỗi xảy ra trong quá trình tạo mới đăng ký email khách hàng');
        } finally {
            return redirect(route('subcribe-email.index'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\SubcribeEmail  $subcribeEmail
     * @return \Illuminate\Http\Response
     */
    public function show(SubcribeEmail $subcribeEmail)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\SubcribeEmail  $subcribeEmail
     * @return \Illuminate\Http\Response
     */
    public function edit(SubcribeEmail $subcribeEmail)
    {
        try {
            $groupMails = GroupMail::orderBy('group_mail_id', 'desc')->get();

            return view('admin.subcribe_email.edit', compact('groupMails', 'subcribeEmail'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa đăng ký email kh: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubcribeEmailController->edit: Lỗi xảy ra trong quá trình chỉnh sửa đăng ký email khách hàng');

            return redirect('admin/home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\SubcribeEmail  $subcribeEmail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubcribeEmail $subcribeEmail)
    {
        try {
            $subcribeEmail->update([
                'email' => $request->input('email'),
                'slug_gruop' => $request->input('slug_gruop'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa đăng ký email kh: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubcribeEmailController->update: Lỗi xảy ra trong quá trình chỉnh sửa đăng ký email khách hàng');
        } finally {
            return redirect(route('subcribe-email.index'));
        }
    }

    public function anyDatatables(Request $request) {
        $subcribeEmail = new SubcribeEmail();
        $subcribeEmails = $subcribeEmail->orderBy('subcribe_email_id', 'desc');

        return Datatables::of($subcribeEmails)
            ->addColumn('action', function($subcribeEmail) {
                $string =  '<a href="'.route('subcribe-email.edit', ['subcribe_email_id' => $subcribeEmail->subcribe_email_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('subcribe-email.destroy', ['subcribe_email_id' => $subcribeEmail->subcribe_email_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })->make(true);
    }
    
    public function destroy(SubcribeEmail $subcribeEmail) {
        try {
            $subcribeEmails = new SubcribeEmail();
            $subcribeEmails->where('subcribe_email_id', $subcribeEmail->subcribe_email_id)->delete();
//            return redirect(route('subcribe-email.index'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa đăng ký email kh: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubcribeEmailController->update: Lỗi xảy ra trong quá trình xóa đăng ký email khách hàng');
        } finally {
            return redirect(route('subcribe-email.index'));
        }

    }

    public function send(Request $request) {
        try {
            $group = $request->input('group');
            $subject = $request->input('subject');
            $message = $request->input('content');

            // get email to
            $emails = SubcribeEmail::where('group_id', $group)->get();
            $emailSend = array();
            foreach($emails as $email) {
                $emailSend[] =  $email->email;
            }

            MailConfig::sendMail($emailSend, $subject, $message);


        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi gửi email kh: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubcribeEmailController->send: Lỗi xảy ra trong quá trình gửi email khách hàng');
        } finally {
            return redirect(route('subcribe-email.index'));
        }

    }
}
