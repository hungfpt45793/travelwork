<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Entity\InteractiveTeacher;
use App\Entity\Teacher;
use App\Entity\Teacher_delete_request;
use App\Course\Course;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
use App\Entity\User;
use App\Entity\Staff;
class InteractiveTeacherController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'danhmuc');
            return $next($request);
        });
    }
    public function index($id)
    {
        $teacher = Teacher::where('teacher_id',$id)->select('teacher.teacher_phone','teacher.teacher_email','teacher.province','teacher.district','teacher.business_type_id','teacher.teacher_name','teacher.teacher_id','teacher.slug','teacher.teacher_status_id','information_verifier','address')
            ->first();
        $interactives = InteractiveTeacher::select('interactive_history_teacher.*', 'u.name as user_name')
        ->leftjoin('users as u', 'u.id', 'interactive_history_teacher.user_id')
        ->where('interactive_history_teacher.teacher_id', $id)
        ->orderBy('interactive_history_teacher.id', 'DESC')->paginate(3);
        $course = new Course;
        $course = $course->select('course.*', 'teacher.teacher_name', 'teacher.teacher_images','teacher.course_id')->join('teacher', 'teacher.course_id', '=', 'course.course_id')->orderBy('course.course_id', 'desc')->where('teacher.teacher_id',$id)->first();

//        kinh nghiem giáo viên
        $teacher_experience = new Teacher_experience();
        $teacher_experience = $teacher_experience->select('*')->orderBy('experience_id', 'asc')->where('teacher_id', $teacher->teacher_id)->get();
//        trình độ giáo viên
        $teacher_specialize = new Teacher_specialize();
        $teacher_specialize = $teacher_specialize->select('*')->orderBy('specialize_id', 'asc')->where('teacher_id', $teacher->teacher_id)->get();
        // dd($interactives);
        $check = 0;
        $check_d = Teacher_delete_request::where('teacher_id',$id)->first();
        if($check_d != null){
            $check = 1;
        }
        return view('staff_admin.teacher.interactive', compact('interactives','course', 'teacher', 'teacher_experience', 'teacher_specialize','check'));
    }
    public function listInteractiveStaff(Request $request){
        
        $teachers_id = \App\Entity\InteractiveTeacher::where('user_id', $request->staff_id)->groupBy('teacher_id')->pluck('teacher_id','id');
        $teachers = Teacher::select(
            'teacher.created_at',
            'teacher.updated_at',
            'teacher.teacher_id',
            'teacher.teacher_name',
            'teacher.teacher_email',
            'teacher.teacher_phone',
            'teacher.teacher_images',
            'province.province_name',
            'district.district_name',
            'teacher.career_category_id',
            'teacher.status_accounting',
            'teacher.province'
        )->leftJoin('province', 'province.province_id', 'teacher.province')
            ->leftJoin('district', 'district.district_id', 'teacher.district')->whereIn('teacher_id',$teachers_id);
            if(!empty($request->date_search_start) ){
                $date_start=date_create($request->date_search_start);
                $date_search_start = date_format($date_start,"Y/m/d");
                // dd($date_search_start);
                $teachers = $teachers->whereDate('teacher.updated_at', '>=', $request->date_search_start);
            }
            if(!empty($request->date_search_end)){
                $date_end=date_create($request->date_search_end);
                $date_search_end = date_format($date_end,"Y/m/d");
                $teachers = $teachers->whereDate('teacher.updated_at', '<=', $request->date_search_end);
            }
            if(!empty($request->teacher_status_id)){
                $teachers = $teachers->where('teacher_status_id',$request->teacher_status_id);
            }
            if (!empty($request->province)) {
                // return 4;
                $teachers->where('teacher.province', $request->province);
            }
            if (isset($request->status_accounting)) {
                $teachers->where('teacher.status_accounting', $request->status_accounting);
            }
            if (!empty($request->teacher_name)) {
                $teachers->where('teacher.teacher_name', 'like', '%' . $request->teacher_name . '%');
            }
            if (!empty($request->career_category_id)) {
                $teachers->where('teacher.career_category_id', $request->career_category_id);
            }
            if (!empty($request->district)) {
                $teachers->where('teacher.district', $request->district);
            }
            if (!empty($request->email)) {
                $teachers->where('teacher.teacher_email', 'like', '%' . $request->email . '%');
            }
            if (!empty($request->is_delete)) {
                // return 3;
                $id = [];
                $ls = Teacher_delete_request::get();
                foreach ($ls as $l) {
                    $id[] = $l->teacher_id;
                }
                if ($request->is_delete == 1) {
                    // return 1;
                    $teachers->whereNotIn('teacher.teacher_id', $id);
                }
                if ($request->is_delete == 2) {
                    // return 2;
                    $teachers->whereIn('teacher.teacher_id', $id);
                }
            }
            $total = $teachers->count();
            $num = 30;
            if(!empty($request->num)){
                $num = $request->num;
            }
            $teachers = $teachers->orderBy('teacher.teacher_id', 'desc')
                ->paginate($num);
            $staff_name = User::where('id',$request->staff_id)->value('name');
        return view('staff_admin.teacher.list', compact('teachers', 'total','staff_name'));
    }
    public function listInteractive(){
        $list_staff = User::where('role', 5)->get();
        return view('staff_admin.teacher.list_staff',compact('list_staff'));
    }
    
    public function store(Request $request, $id)
    {
        // $this->validate($request, [
        //     'content' => 'required',
        // ],
        // [
        //     'content.required' => 'Nội dung không được bỏ trống'
        // ]);
        try
        {
            $interactive = new InteractiveTeacher();
            $create = InteractiveTeacher::insert([
                // 'id'          => $check != null? $check->id + 1:1,
                'teacher_id' => $id,
                'interactive_day'   => $request->input('interactive_day'),
                'teacher_status_id'  => $request->input('teacher_status_id'),
                'user_id'     => Auth::id(),
                'content'     => $request->input('content'),
                'created_at'  => date('Y-m-d H:i:s')
            ]);
            $teacher = Teacher::where('teacher_id',$id)->update([
                'teacher_status_id'  => $request->input('teacher_status_id')
            ]);
            // $interactive->content = $request->content;
            // if (isset($request->interactive_day))
            // {
            //     $interactive->interactive_day = $request->interactive_day;
            // }
            // $interactive->interactive_day = date('Y-m-d');
            // $interactive->teacher_id = $id;
            // // if (Auth::check())
            // // {
            // //     $user_id = Auth::id();
            //     $interactive->user_id = Auth::user()->id;
            // // }
            // $interactive->save();
            $request->session()->flash('success', 'Tạo tương tác thành công!');
            return redirect()->back();
        }catch(\Exception $e){
            $request->session()->flash('error', 'Tạo tương tác không thành công!');
            return redirect()->back();
        }
    }
    public function interactive_update(Request $request)
    {
//        try
//        {
            $id = $request->input('id');
            $interactive = new InteractiveTeacher();
            $interac = $interactive->select('*')->where('id',$id)->first();
            $create = InteractiveTeacher::where('id',$id)->update([
                // 'id'          => $check != null? $check->id + 1:1,
                'interactive_day'   => $request->input('interactive_day'),
                'teacher_status_id'  => $request->input('teacher_status_id'),
                'content'     => $request->input('content'),
                'updated_at'  => date('Y-m-d H:i:s'),
            ]);
            $teacher = Teacher::where('teacher_id',$interac->teacher_id)->update([
                'teacher_status_id'  => $request->input('teacher_status_id')
            ]);
            // $interactive->content = $request->content;
            // if (isset($request->interactive_day))
            // {
            //     $interactive->interactive_day = $request->interactive_day;
            // }
            // $interactive->interactive_day = date('Y-m-d');
            // $interactive->teacher_id = $id;
            // // if (Auth::check())
            // // {
            // //     $user_id = Auth::id();
            //     $interactive->user_id = Auth::user()->id;
            // // }
            // $interactive->save();
            $request->session()->flash('success', 'Cập nhật tương tác thành công!');
            return redirect()->back();
//        }catch(\Exception $e){
//            $request->session()->flash('error', 'Cập nhật tương tác không thành công!');
//            return redirect()->back();
//        }
    }
    public function show($id)
    {
        //
    }

   
    public function edit($id)
    {
        $interactive = InteractiveTeacher::findOrFail($id);
        return view('staff_admin.teacher.edit_interactive', compact('interactive'));
    }

//
//    public function update(Request $request, $id)
//    {
//        $interactive = InteractiveTeacher::findOrFail($id);
//        if(Auth::check() && Auth::id() == $interactive->user_id){
//            $data = [];
//            $data['content'] = $request->input('content');
//            if(isset($request->interactive_day)){
//                $data['interactive_day'] = $request->interactive_day;
//            }
//            $data['interactive_day'] = date('Y-m-d');
//            $interactive->update($data);
//            $request->session()->flash('success', 'Sửa tương tác thành công');
//
//            return redirect()->route('interactive_index', $interactive->teacher_id);
//        }
//        else {
//            $request->session()->flash('error', 'Sửa tương tác không thành công');
//            return redirect()->route('interactive_index', $interactive->teacher_id);
//        }
//    }

    public function destroy($id)
    {
        //
    }
}
