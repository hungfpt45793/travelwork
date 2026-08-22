<?php

namespace App\Http\Controllers\Site;

use App\Course\Course;
use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\EmployerEmployee;
use App\Entity\EmployerTransfer;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Province;
use App\Entity\Statistical_employees;
use App\Entity\Teacher;
use App\Entity\Teacher_experience;
use App\Entity\Teacher_specialize;
use App\Entity\TeacherLearnEmployees;
use App\Entity\TeacherStarLearn;
use Illuminate\Http\Request;
use App\Entity\District;
use App\Entity\TypeOfBusiness;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class TeacherViewController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuTopsite', 'teacher');
    }

//    check quyền nhà tuyển dụng

    public function showTeacher(Request $request)
    {
        $teacher = new Teacher();
        $list_teacher = $teacher->select('province','district','business_type_id','teacher_name','teacher_id','teacher_images','slug');
        $list_teacher = $list_teacher->orderBy('teacher.teacher_id', 'desc')->paginate(16);
        $list_teacher->appends(request()->query());
        return view('site.teacher.list_teacher', compact('list_teacher'));
    }

    public static function showCategoryTeacher(Request $request, $slug)
    {
        $teacher = new Teacher();
        $list_teacher = $teacher->select('teacher.province','teacher.district','teacher.business_type_id','teacher.teacher_name','teacher.teacher_id','teacher.teacher_images','teacher.slug')
            ->join('teacher_job_group', 'teacher_job_group.teacher_id', '=', 'teacher.teacher_id')
            ->join('job_group', 'job_group.job_group_id', '=', 'teacher_job_group.job_group_id')->where('job_group.slug', $slug);
        $list_teacher = $list_teacher->orderBy('teacher.teacher_id', 'desc')->paginate(16);
        $list_teacher->appends(request()->query());
        return view('site.teacher.category_teacher', compact('list_teacher'));
    }

    public function submitTeacher(Request $request)
    {
        $user = auth()->user();
        $career = 'tim-giao-vien';
        if(!empty($request->input('province')) or !empty($request->input('district')))
        {
            if (!empty($request->input('province'))) {
                $career .= '-tai-' . $request->input('province');
            }
            if (!empty($request->input('district'))) {
                $career .= '-'. $request->input('district');
            }
        }
        else
        {
            if (!empty($request->input('type_of_business_id'))) {
                $career .= '-cho-' . $request->input('type_of_business_id');
            }
        }

        $provice = Province::select('*')
            ->where('province_slug',$request->input('province'))
            ->first();
        $district = District::select('*')
            ->where('district_slug',$request->input('district'))
            ->first();
        $type_of_business = TypeOfBusiness::select('*')
            ->where('type_of_business_slug',$request->input('type_of_business_id'))
            ->first();
        echo $type_of_business['type_of_business_id'];


        $career .= '?';
        if (!empty($request->input('type_of_business_id'))) {
            $career .= '&t='.$type_of_business['type_of_business_id'];
        }
        if (!empty($request->input('province'))) {
            $career .= '&p='.$provice['province_id'];
        }
        if (!empty($request->input('district'))) {
            $career .= '&q=' . $district['district_id'];
        }
        if (!empty($request->input('word'))) {
            $career .= '&w=' . $request->input('word');
        }
        return redirect(route('searchTeacher', ['slug' => $career]));
    }
    public function searchTeacher( Request $request ,$slug)
    {
        $teacher = new Teacher();
        $list_teacher = $teacher->select('province','district','business_type_id','teacher_name','teacher_id','teacher_images','slug');

        if (!empty($request->input('t'))) {
            $business_type_id = $request->input('t');
            $list_teacher = $list_teacher->where('business_type_id', $business_type_id);

        }
        if (!empty($request->input('p'))) {
            $province = $request->input('p');
            $list_teacher = $list_teacher->where('teacher.province', $province);
        }
        if (!empty($request->input('q'))) {
            $district = $request->input('q');
            $list_teacher = $list_teacher->where('teacher.district', $district);
        }
        if (!empty($request->input('w'))) {
            $teacher_name = $request->input('w');
            $list_teacher = $list_teacher->where('teacher.teacher_name', 'like', '%' . $teacher_name . '%');
        }
        $list_teacher = $list_teacher->orderBy('teacher.teacher_id', 'desc')->paginate(16);
        $list_teacher->appends(request()->query());
        return view('site.teacher.search_teacher', compact('list_teacher'));
    }
    public function detailTeacher($slug)
    {
        $teacher = new Teacher();
        $teacher = $teacher->select('teacher.teacher_phone','teacher.user_id','teacher.teacher_email','teacher.province','teacher.district','teacher.business_type_id','teacher.teacher_name','teacher.teacher_id','teacher.slug','information_verifier','address')->where('slug', $slug)->first();
        if(empty($teacher))
        {
            return redirect(route('home'));
        }
        $course = new Course;
        $course = $course->select('course.*', 'teacher.teacher_name', 'teacher.teacher_images','teacher.course_id')->join('teacher', 'teacher.course_id', '=', 'course.course_id')->orderBy('course.course_id', 'desc')->where('teacher.slug',$slug)->first();

//        kinh nghiem giáo viên
        $teacher_experience = new Teacher_experience();
        $teacher_experience = $teacher_experience->select('*')->orderBy('experience_id', 'asc')->where('teacher_id', $teacher->teacher_id)->get();
//        trình độ giáo viên
        $teacher_specialize = new Teacher_specialize();
        $teacher_specialize = $teacher_specialize->select('*')->orderBy('specialize_id', 'asc')->where('teacher_id', $teacher->teacher_id)->get();
//        khóa học của giáo viên



        $list_teacher = $teacher->select('province','district','business_type_id','teacher_name','teacher_id','teacher_images','slug')->where('business_type_id', $teacher->business_type_id)->where('slug', '!=', $slug)->limit(16)->get();

        return view('site.teacher.detail_teacher', compact('course', 'teacher', 'teacher_experience', 'teacher_specialize', 'course', 'list_teacher'));
    }

    public function detail_new($cate_slug, $slug_post)
    {
        if (!empty($this->domainUser)) {
            if (strtotime($this->domainUser->end_at) < time() && ($this->emailUser != 'vn3ctran@gmail.com')) {
                return redirect(route('admin_dateline'));
            }
        }

        $post = $this->getPostDetail($slug_post);
        $category = $this->getCategory($post);


        if (empty($post->template) or $post->template == 'default') {
            return view('site.teacher.detail_new', compact('post', 'category', 'cate_slug'));
        } else {
            return view('site.template.' . $post->template, compact('post', 'category', 'cate_slug'));
        }
    }

    private function getPostDetail($slug_post)
    {
        try {
            $post = Post::where('slug', $slug_post)
                ->where('post_type', 'post')
                ->first();

            $inputs = Input::where('post_id', $post->post_id)->get();
            foreach ($inputs as $input) {
                $post[$input->type_input_slug] = $input->content;
            }

            return $post;
        } catch (\Exception $e) {
            Log::error('http->site->PostController->getPostDetail: lỗi lấy dữ liệu post');

            return null;
        }
    }

    private function getCategory($post)
    {
        try {
            $category = Category::join('category_post', 'categories.category_id', '=', 'category_post.category_id')
                ->select('categories.*')
                ->where('category_post.post_id', $post->post_id)
                ->first();

            if (empty($category)) {
                $category = Category::first();
            }

            return $category;
        } catch (\Exception $e) {
            Log::error('http->site->PostController->getPostDetail: lỗi lấy dữ liệu post');

            return redirect('/');
        }
    }
    public function joblearn(Request $request, $teacher_id)
    {

//        quyen ung vien
        if (Auth::check() && Auth::user()->role == 1) {
        $user_id = Auth::user()->id;

            $employee = new Employee();
            $employee = $employee->select('employee_id',
                'employee_name',
                'phone',
                'province',
                'email',
                'district',
                'user_id'
             )->where('user_id',$user_id)->first();

            $teacher_learn = new TeacherLearnEmployees();

            $teacher_learns = $teacher_learn->select('*')->where('teacher_id',$teacher_id)->where('employee_id',$employee->employee_id)->first();

            if (empty($teacher_learns)) {
                $insert_id = $teacher_learn->insertGetId([
                    'teacher_id' => $teacher_id,
                    'employee_id' => $employee->employee_id,
                    'status_learn' => 0,
                    'created_at' => new \DateTime(),
                    'updated_at' => new \DateTime()
                ]);
                $teachers = new Teacher();
                $teacher = $teachers->select('teacher_id',
                    'teacher_code',
                    'teacher_name',
                    'slug',
                    'teacher_phone',
                    'teacher_email',
                    'teacher_images',
                    'teacher_info',
                    'province'
                    )->where('teacher_id',$teacher_id)->first();
                $update = $teachers->where('teacher_id',$teacher_id)->update([
                    'status' => 1
                ]);
                //gui cho ứng viên
                MailConfigController::send_learn_teacher(1,$teacher,$employee,$employee->email);
                //gui cho giao vien
                MailConfigController::send_learn_teacher(3,$teacher,$employee,$teacher->teacher_email);

                return redirect()->back()->with('success_learn','Đăng kí khóa học thành công');
            } else {
                return redirect()->back()->with('error_learn','Bạn đã đăng kí khóa học này rồi');
            }
        }else
        {
            return redirect()->back()->with('error_learn','Vui lòng đăng nhập tài khoản ứng viên để đăng kí khóa học');
        }
    }
//    sidebar ứng viên
    public function listlearn(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 1) {
            $user_id = Auth::user()->id;
            $user= Auth::user();
            $employees = new Employee();
            $employee =  $employees->select('user_id','employee_id')->where('user_id',$user_id)->first();

            $teachers = new Teacher();
            $list_teacher = $teachers->select('teacher.slug','teacher.teacher_name','teacher.teacher_id','teacher_learn_employees.employee_id','teacher_learn_employees.created_at','teacher_learn_employees.status_teacher','teacher_learn_employees.status_learn','teacher_learn_employees.id_teacher_learn')->join('teacher_learn_employees','teacher_learn_employees.teacher_id','=','teacher.teacher_id')->where('teacher_learn_employees.employee_id',$employee->employee_id)->get();
            return view('site.teacher.list_learn_employee',compact('list_teacher','user'));
        }
        return redirect('/');
    }
    public function addstarlearn(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 1) {
            $teacher_star_learns = new TeacherStarLearn();
            $teacher_star_learns->insert([
               'status_star' => $request->input('status_star'),
               'content_star' => $request->input('content_star'),
               'id_teacher_learn' => $request->input('id_teacher_learn'),
                'date_month' => date("Y/m/d H:i:s"),
            ]);
            return redirect()->back();
        }
        return redirect('/');
    }
    public function updatestarlearn(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 1) {
            $id_teacher_star_learn = $request->input('id_teacher_star_learn');
            $teacher_star_learns = new TeacherStarLearn();
            $teacher_star_learns->where('id_teacher_star_learn',$id_teacher_star_learn)->update([
                'status_star' => $request->input('status_star'),
                'content_star' => $request->input('content_star')
            ]);
            return redirect()->back();
        }
        return redirect('/');
    }
    public function starlearn(Request $request,$id_teacher_learn)
    {
        if (Auth::check() && Auth::user()->role == 1) {
            $user= Auth::user();
            $teacher_star_learns = new TeacherStarLearn();

            $list_star_learn = $teacher_star_learns->select('*')->where('id_teacher_learn',$id_teacher_learn)->orderBy('id_teacher_star_learn','desc')->get();

            $month_star_learn = $teacher_star_learns->select('*')
                ->where('id_teacher_learn',$id_teacher_learn)
                ->whereYear('date_month', '=', date("Y"))
                ->whereMonth('date_month', '=', date("m"))
                ->first();
            return view('site.teacher.list_star_employee',compact('list_star_learn','user','id_teacher_learn','month_star_learn'));
        }
        return redirect('/');
    }
    //sidebar giao viên
    public function teacher_learn_employee(Request $request)
    {

        if (Auth::check() && Auth::user()->role == 3) {
            $user= Auth::user();

            $teachers= new Teacher();
            $teacher = $teachers->select('*')->where('user_id',$user->id)->first();
            $teacher_learns = new  TeacherLearnEmployees();
            $teacher_learn = $teacher_learns->select('*')->where('teacher_id',$teacher->teacher_id)->get();
                return view('site.teacher.list_teacher_learn_employee',compact('teacher_learn','user'));
        }
        return redirect('/');
    }
    public function update_teacher_learn(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 1) {
            $user= Auth::user();
            $id = Auth::user()->id;

            $employees = new Employee();
            $employee = $employees->select('*')->where('user_id',$user->id)->first();


            $id_teacher_learn = $request->input('id_teacher_learn');
            $teacher_learns = new  TeacherLearnEmployees();

            $update_teacher_learn = $teacher_learns->where('id_teacher_learn',$id_teacher_learn)->update([
                'status_learn' => $request->input('status_learn')
            ]);

            if($request->input('status_learn') == 1)
            {
                $this->statis_employee($id);
            }
            //nếu giáo viên
            $teacher_learn = $teacher_learns->where('id_teacher_learn',$id_teacher_learn)->first();

            $teachersa = new Teacher();
            $teachers = $teachersa->select('*')->where('teacher_id',$teacher_learn->teacher_id)->first();


            if($teacher_learn->status_learn == 1)
            {
                $update = $teachersa->where('teacher_id',$teachers->teacher_id)->update([
                    'status' => 1
                ]);
            }
                //

            return redirect()->back();
        }
        return redirect('/');
    }
    //thong ke
    public function statis_employee($id)
    {
        $employee = new Employee();
        $employees = $employee->select('employee_id','user_id')->where('user_id', $id)->first();

        $statiscals = new Statistical_employees();
        $statis = $statiscals->select('*')->where('employees_id', $employees->employee_id)->first();

        $total_teacher = $statis->total_teacher + 1;
        $statiscal = $statiscals->where('employees_id', $employees->employee_id)->update([
            'total_teacher' => $total_teacher
        ]);
    }
}
