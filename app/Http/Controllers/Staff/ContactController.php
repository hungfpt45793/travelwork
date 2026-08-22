<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Contact;
use App\Ultility\Error;
use Illuminate\Http\Request;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class ContactController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'advisory');
            return $next($request);
        });
    }
    public function index()
    {
        $contact = new Contact();
            $contacts = $contact->orderBy('contact_id', 'desc');
            $total = $contacts->count();

            $contacts = $contacts->paginate(15);
            return view('staff_admin.advisory.list_contact', compact('contacts','total'));
        
    }

    public function create()
    {
        return view('staff_admin.advisory.add_contact');
    }

   
    public function store(Request $request)
    {
        
        if($this->insertContact($request))
        return redirect(route('staff_advisory_contact.index'))->with('success', 'Thêm liên hệ thành công');
        return redirect(route('staff_advisory_contact.index'))->with('error', 'Thêm liên hệ thất bại');
    }

    
    public function show($id)
    {
        
    }

  
    public function edit($id)
    {
        $contact = Contact::where('contact_id',$id)->first();
        return View('staff_admin.advisory.edit_contact', compact('contact'));
    }


    public function update(Request $request, $id)
    {
        $contact = Contact::findOrFail($id);
        $this->updateContact($contact, $request);
            return redirect(route('staff_advisory_contact.index'))->with('success', 'Thành công');
        
        // else
        // return redirect()->back()->with('error', 'Không thành công');
    }

    private function updateContact($contact, $request) {
        // try {
            $contact->update([
                'status_view' => 1,
                'message' => $request->message,
                'updated_at' => new \DateTime()
            ]);
        // } catch (\Exception $e) {
        //     Error::setErrorMessage('Lỗi xảy khi cập nhật liên hệ: Dữ liệu nhập vào không hợp lệ');
        //     Log::error('http->admin->ContactController->updateContact: Lỗi khi cập nhật liên hệ');
        // }
    }
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect(route('staff_advisory_contact.index'));
    }
    private function insertContact($request) {
        // try {           
            $contact = new Contact();
            $contact->insert([
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'address' => $request->input('address'),
                // 'status' => $request->input('status'),
                'message' => $request->input('message'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);
        // } catch(\Exception $e) {
        //     Error::setErrorMessage('Lỗi xảy ra khi thêm mới liên hệ: Dữ liệu nhập vào không hợp lệ');
        //     Log::error(' http->admin->ContactController->insertContact: Lỗi thêm mới liên hệ');
        // }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;   
        $arrids = explode(",",$ids);
        // ResAdvisory::whereIn('id_res',explode(",",$ids))->delete();
        foreach ($arrids as $arrid) {
            Contact::where('contact_id', $arrid)->delete();
        }
       
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
