<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Res_advisory_interactive;

class AdvisoryInteractiveController extends SiteStaffController
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
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        Res_advisory_interactive::create($request->all());
        return redirect()->back()->with('msg', 'Tạo thành công!');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        $res_advisory_interactive = Res_advisory_interactive::findOrFail($id);
        $res_advisory_interactive->update($request->all());
        return redirect()->back()->with('msg', 'bạn sửa thành công');
    }

    public function destroy($id)
    {
        Res_advisory_interactive::findOrFail($id)->delete();
        return redirect()->back()->with('msg', 'bạn xóa thành công');
    }
}
