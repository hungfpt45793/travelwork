<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Contact;
use App\Ultility\Error;
use Illuminate\Http\Request;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class ContactController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (!   User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'websites');
            return $next($request);
        });

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contact = new Contact();
        try {
            $contacts = $contact->orderBy('contact_id', 'desc')
                ->paginate(15);

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị liên hệ: dữ liệu lỗi.');

            Log::error('http->admin->ContactController->index: Lỗi lấy dữ liệu contacts');

            $contacts = null;
        } finally {
            return view('admin.contact.list', compact('contacts'));
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('admin.contact.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if slug null slug create as title
        $this->insertContact($request);

        return redirect(route('contact.index'));
    }

    private function insertContact($request) {
        try {
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
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới liên hệ: Dữ liệu nhập vào không hợp lệ');
            Log::error(' http->admin->ContactController->insertContact: Lỗi thêm mới liên hệ');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function edit(Contact  $contact)
    {
        return View('admin.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact  $contact)
    {
        $this->updateContact($contact, $request);

        return redirect(route('contact.index'));
    }

    private function updateContact($contact, $request) {
        try {
            $contact->update([
                'status_view' => 1,
                'updated_at' => new \DateTime()
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy khi cập nhật liên hệ: Dữ liệu nhập vào không hợp lệ');
            Log::error('http->admin->ContactController->updateContact: Lỗi khi cập nhật liên hệ');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Contact  $contact
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact  $contact)
    {
        $contact->delete();

        return redirect(route('contact.index'));
    }
}
