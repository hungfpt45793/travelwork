<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Contact;
use App\Entity\ResAdvisory;

class AdvisoryController extends SiteStaffController
{ 
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'advisory');
            return $next($request);
        });
    }
    public function employee(){
        $res_ads = new ResAdvisory();
        $res_ads = $res_ads->select('id_res','created_at','name_res','phone_res','address_res','message_res','status_view')
            ->orderBy('id_res', 'desc')
            ->where('status_res',1);
            $total  = $res_ads->count();
            $res_ads =$res_ads->paginate(15);
        
        return view('staff_admin.advisory.employee_advisory', compact('res_ads','total'));
    }
    public function employer(){
        $res_ads = new ResAdvisory();
        $res_ads = $res_ads->select('id_res','created_at','name_res','phone_res','address_res','message_res','status_view')
            ->orderBy('id_res', 'desc')
            ->where('status_res',0);
        $total = $res_ads->count();
        $res_ads = $res_ads->paginate(15);
        return view('staff_admin.advisory.employer_advisory', compact('res_ads','total'));
    }
    public function contact(){
        $contact = new Contact();
        try {
            $contacts = $contact->orderBy('contact_id', 'desc');
            $total = $contacts->count();

            $contacts = $contacts->paginate(15);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị liên hệ: dữ liệu lỗi.');

            Log::error('http->admin->ContactController->index: Lỗi lấy dữ liệu contacts');

            $contacts = null;
        } finally {
            return view('staff_admin.advisory.list_contact', compact('contacts','total'));
        }
       
    }
}
