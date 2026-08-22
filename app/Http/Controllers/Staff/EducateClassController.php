<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Educate_class;
use App\Entity\Educate_employees_class;
use App\Entity\Educate_teacher;
use App\Entity\Employee;
use App\Entity\User;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class EducateClassController extends SiteStaffController
{
    protected $role;

    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'khoahoc');
            return $next($request);
        });
    }

    public function list_educate_employee_class_staff($edu_class_id)
    {
        $educate_class = new Educate_class();
        $educate_class = $educate_class->select('*')->where('edu_class_id', $edu_class_id)->first();

        $list_employee_class = Educate_employees_class::select('educate_employees_class.edu_class_id',
            'educate_employees_class.employee_id',
            'employees.employee_id',
            'employees.employee_name',
            'employees.email',
            'employees.phone'
        )
            ->leftJoin('employees', 'employees.employee_id', '=', 'educate_employees_class.employee_id')
            ->where('educate_employees_class.edu_class_id', $edu_class_id);
            $list_employee_class = $list_employee_class->paginate(20);
            $list_employee_class->appends(request()->query());
        return view('staff_admin.educate_class.list_employee_class', compact('list_employee_class', 'educate_class'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $educate_class = new Educate_class();
        $educate_class = $educate_class->select('*')->orderBy('edu_class_id', 'desc');
        $educate_class = $educate_class->paginate(20);
        $educate_class->appends(request()->query());
        return view('staff_admin.educate_class.list', compact('educate_class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('staff_admin.educate_class.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $edu_class_slug = $request->input('edu_class_slug');
            $edu_class = new Educate_class();
            $edu_class_id = $edu_class->insertGetId([
                'edu_class_name' => $request->input('edu_class_name'),
                'educate_class_image' => $request->input('educate_class_image'),
                'edu_class_des' => $request->input('edu_class_des'),
                'edu_class_content' => $request->input('edu_class_content'),
                'edu_class_link_zalo' => $request->input('edu_class_link_zalo'),
                'edu_class_video' => $request->input('edu_class_video'),
                'edu_date_end' => $request->input('edu_date_end'),
                'edu_total_employee' => $request->input('edu_total_employee'),
                'edu_teacher_id' => $request->input('edu_teacher_id'),
                'edu_cate_id' => $request->input('edu_cate_id'),
                'teacher_name' => $request->input('teacher_name'),
                'teacher_link' => $request->input('teacher_link'),
                'edu_class_regulations' => $request->input('edu_class_regulations'),
                'user_id' => Auth::user()->id,
                'created_at' => new \DateTime()
            ]);

            $postWithSlug = $edu_class->where('edu_class_slug', $edu_class_slug)->first();
            if (empty($postWithSlug)) {
                $edu_class->where('edu_class_id', '=', $edu_class_id)
                    ->update([
                        'edu_class_slug' => $edu_class_slug
                    ]);
            } else {
                $edu_class->where('edu_class_id', '=', $edu_class_id)
                    ->update([
                        'edu_class_slug' => $edu_class_slug . '-' . $edu_class_id
                    ]);
            }
            return redirect(route('educateClass.index'))->with('success', 'Thêm thành công');
        } catch (\Exception $e) {
            return redirect(route('educateClass.index'))->with('error', 'Thêm thất bại');
        }

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
    public function edit($id)
    {
        $educate_class = new Educate_class();
        $educate_class = $educate_class->where('edu_class_id', $id)->first();
        return view('staff_admin.educate_class.edit', compact('educate_class'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $edu_class_slug = $request->input('edu_class_slug');
            $edu_class = new Educate_class();
            $edu_class_id = $edu_class->where('edu_class_id', $id)->update([
                'edu_class_name' => $request->input('edu_class_name'),
                'educate_class_image' => $request->input('educate_class_image'),
                'edu_class_des' => $request->input('edu_class_des'),
                'edu_class_content' => $request->input('edu_class_content'),
                'edu_class_link_zalo' => $request->input('edu_class_link_zalo'),
                'edu_class_video' => $request->input('edu_class_video'),
                'edu_date_end' => $request->input('edu_date_end'),
                'edu_total_employee' => $request->input('edu_total_employee'),
                'edu_teacher_id' => $request->input('edu_teacher_id'),
                'edu_cate_id' => $request->input('edu_cate_id'),
                'teacher_name' => $request->input('teacher_name'),
                'teacher_link' => $request->input('teacher_link'),
                'edu_class_regulations' => $request->input('edu_class_regulations'),
                'user_id' => Auth::user()->id,
                'created_at' => new \DateTime(),
            ]);

            $postWithSlug = $edu_class->where('edu_class_slug', $edu_class_slug)->where('edu_class_id', '!=', $id)->first();
            if (empty($postWithSlug)) {
                $edu_class->where('edu_class_id', '=', $id)
                    ->update([
                        'edu_class_slug' => $edu_class_slug
                    ]);
            } else {
                $edu_class->where('edu_class_id', '=', $id)
                    ->update([
                        'edu_class_slug' => $edu_class_slug . '-' . $id
                    ]);
            }
            return redirect(route('educateClass.index'))->with('success', 'Cập nhật thành công');
        } catch (\Exception $e) {
            return redirect(route('educateClass.index'))->with('error', 'Cập nhật thất bại');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function educateClassDestroy($edu_class_id)
    {
        $edu_class = new Educate_class();
        $edu_teacher = $edu_class->where('edu_class_id', $edu_class_id)->delete();
        return redirect(route('educateClass.index'))->with('success', 'Xóa thành công');
    }
}
