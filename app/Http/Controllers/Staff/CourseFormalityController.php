<?php

namespace App\Http\Controllers\Staff;
use App\Course\Course_formality;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Staff\SiteStaffController;

class CourseFormalityController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'khoahoc');
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
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $list_course_formality = Course_formality::select('*')->orderBy('course_formality_id','desc');
        $list_course_formality = $list_course_formality->paginate($num);
        $list_course_formality->appends(request()->query());
        return view('staff_admin.course_formality.list', compact('list_course_formality'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }



    public function store(Request $request)
    {
        $insert = Course_formality::insert([
            'course_formality_title' => $request->input('course_formality_title'),
            'course_formality_des' => $request->input('course_formality_des'),
            'created_at' => new \DateTime(),
        ]);
        return redirect(route('courseFormality.index'))->with('success', 'Thêm hình thức học thành công');
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
    public function edit($course_id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $course_formality_id)
    {
        $update = Course_formality::where('course_formality_id',$course_formality_id)->update([
            'course_formality_title' => $request->input('course_formality_title'),
            'course_formality_des' => $request->input('course_formality_des'),
            'updated_at' => new \DateTime(),
        ]);
        return redirect(route('courseFormality.index'))->with('success', 'Cập nhật hình thức học thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function courseFormalityDestroy($course_formality_id)
    {
        $update = Course_formality::where('course_formality_id',$course_formality_id)->delete();
        return redirect(route('courseFormality.index'))->with('success', 'Xóa hình thức học thành công');
    }
}
