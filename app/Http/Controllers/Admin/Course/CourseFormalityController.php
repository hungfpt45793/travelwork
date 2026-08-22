<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapters;
use App\Course\Course_formality;
use App\Course\Course_tag;
use App\Course\Course_tag_id;
use App\Course\Courses;
use App\Entity\Teacher;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CourseFormalityController extends AdminController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;
            if (!User::isCreater($this->role)) {
                return redirect('admin/home');
            }
            view()->share('menuTop', 'educate');
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
       $list_course_formality = Course_formality::select('*')->orderBy('course_formality_id','desc')->get();
        return view('admin.course.course_formality.list', compact('list_course_formality'));

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
        return redirect('admin/course_formality')->with('success', 'Thêm hình thức học thành công');
//        } catch (\Exception $exception) {
//            return redirect('admin/category_course')->with('error', 'Thên danh mục thất bại');
//        }

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
        return redirect('admin/course_formality')->with('success', 'Cập nhật hình thức học thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($course_formality_id)
    {
        $update = Course_formality::where('course_formality_id',$course_formality_id)->delete();
        return redirect('admin/course_formality')->with('success', 'Xóa hình thức học thành công');
    }
}
