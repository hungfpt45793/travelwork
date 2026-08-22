<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entity\Order_interactive;

class OrderInteractiveController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'donhang');
            return $next($request);
        });
    }

    public function store(Request $request){
        Order_interactive::create($request->all()); 
        return redirect()->back()->with('msg', 'thêm mới tương tác thành công!');
    }

    public function destroy($id){
        Order_interactive::findOrFail($id)->delete();
        return redirect()->back()->with('msg', 'Xóa tương tác thành công!');
    }
    public function update($id,Request $request){
        Order_interactive::findOrFail($id)->update($request->all());
        return redirect()->back()->with('msg', 'Sửa tương tác thành công!');
    }
}
