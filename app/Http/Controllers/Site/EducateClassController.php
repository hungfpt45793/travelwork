<?php

namespace App\Http\Controllers\Site;

use App\Entity\Educate_categories;
use App\Entity\Educate_class;
use App\Entity\Educate_employees_class;
use App\Entity\Employee;
use App\Entity\Employer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class EducateClassController extends SiteController
{
    public function detail_edu_class(Request $request, $slug)
    {

        $edu_class = new Educate_class();
        $edu_class = $edu_class->select('*')
            ->where('edu_class_slug', $slug)
            ->first();
        if (empty($edu_class)) {
            return redirect(route('home'));
        }

        $edu_categories = new Educate_categories();
        $edu_categories = $edu_categories->select('edu_cate_id', 'edu_cate_slug', 'edu_cate_title', 'edu_cate_content')
            ->where('edu_cate_id', $edu_class->edu_cate_id)
            ->first();


        $list_relative_class = Educate_class::select('*')
            ->where('edu_cate_id', $edu_class->edu_cate_id)
            ->where('edu_class_id', '!=', $edu_class->edu_class_id)
            ->limit(10)
            ->orderBy('edu_class_id', 'desc')
            ->get();

        return view('site.educate.detail_edu_class', compact('edu_categories', 'edu_class', 'list_relative_class'));

    }

    public function register_educate(Request $request)
    {
        $url = redirect()->back()->getTargetUrl();
        //check kiểm tra tài khoản ứng viên
        if (!Auth::check()) {
            return redirect($url)->with('noti_educate', 'Vui lòng đăng nhập tài khoản ứng viên để đăng kí khóa học');
        }
        if (Auth::check() && Auth::user()->role != 1) {
            return redirect($url)->with('noti_educate', 'Vui lòng đăng nhập tài khoản ứng viên để đăng kí khóa học');
        }
        $employee_profile = Employee::select('user_id', 'employee_id', 'profile')
            ->where('user_id', Auth::user()->id)
            ->first();
        $edu_class_id = $request->input('edu_class_id');
        $edu_class = Educate_class::select('edu_class_id', 'edu_total_employee')->where('edu_class_id', $edu_class_id)->first();

        $total_employee_class = Educate_employees_class::select('*')
            ->where('edu_class_id', $edu_class_id)
            ->count();
//        check sô học viên với tối đa của khóa học
        if ($total_employee_class > $edu_class->edu_total_employee) {
            return redirect($url)->with('noti_educate', 'Khóa học đã nhận đủ ứng viên');
        }

        if ($employee_profile->profile < 100) {
            return redirect($url)->with('noti_educate_profile', 'Bạn phải hoàn thiện hồ sơ 100% mới đăng kí khóa học được !');
        }
        //Mỗi tháng chỉ dc đăng kí 1 khóa học và không đăng kí lai khóa học
        $check_employee_class_month = Educate_employees_class::select('*')
            ->whereMonth('created_at', '=', date('m'))
            ->where('employee_id', $employee_profile->employee_id)
            ->first();
        if (!empty($check_employee_class_month)) {
            return redirect($url)->with('noti_educate', 'Tháng này bạn đã đăng kí khóa học rồi , Mỗi tháng bạn chỉ được đăng kí 1 khóa học thôi');
        }
        //kiem tra ung vien đã đăng kí chưa
        $employee_class = Educate_employees_class::select('*')
            ->where('edu_class_id', $edu_class_id)
            ->where('employee_id', $employee_profile->employee_id)
            ->first();
        if (!empty($employee_class)) {
            return redirect($url)->with('noti_educate', 'Bạn đã đăng kí khóa học này rồi');
        }
        $insert = Educate_employees_class::insert([
            'edu_class_id' => $edu_class_id,
            'employee_id' => $employee_profile->employee_id,
            'created_at' => new \DateTime()
        ]);
        return redirect($url)->with('noti_educate', 'Bạn đã đăng kí khóa học thành công');
    }

    public function list_educate_employee($slug_class)
    {
        $edu_class = new Educate_class();
        $edu_class = $edu_class->select('edu_class_id', 'edu_class_slug', 'edu_cate_id', 'edu_class_name')
            ->where('edu_class_slug', $slug_class)
            ->first();
        if (empty($edu_class)){
            return redirect(route('home'));
        }

        $edu_categories = new Educate_categories();
        $edu_categories = $edu_categories->select('edu_cate_id', 'edu_cate_slug', 'edu_cate_title', 'edu_cate_content')
            ->where('edu_cate_id', $edu_class->edu_cate_id)
            ->first();


        $list_class_employee = Employee::select('employees.employee_id',
            'employees.employee_name',
            'employees.employee_image',
            'employees.updated_at as date_update',
            'employees.created_at as date_create',
            'employees.status',
            'employees.profile',
            'employees.career_category_id',
            'career_categories.career_category_name',
            'salary.description',
            'province.province_name',
            'district.district_name',
            'educate_employees_class.edu_class_id',
            'educate_employees_class.employee_id',
            'educate_employees_class.created_at'
        )
            ->leftJoin('career_categories', 'career_categories.career_category_id', '=', 'employees.career_category_id')
            ->leftJoin('salary', 'salary.salary_id', '=', 'employees.salary_id')
            ->leftJoin('province', 'province.province_id', '=', 'employees.province')
            ->leftJoin('district', 'district.district_id', '=', 'employees.district')
            ->leftJoin('educate_employees_class', 'educate_employees_class.employee_id', '=', 'employees.employee_id')
            ->where('educate_employees_class.edu_class_id', $edu_class->edu_class_id)
            ->paginate(15);

//        echo $edu_class->edu_cate_id;
//        echo '<pre>';
//        print_r($edu_categories);die;
        return view('site.educate.list_educate_employee', compact('edu_categories', 'edu_class', 'list_class_employee'));
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
