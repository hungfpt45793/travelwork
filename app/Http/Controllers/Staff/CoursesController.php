<?php

namespace App\Http\Controllers\Staff;
use App\Entity\Teacher;
use App\Course\Course_tag;
use App\Course\Category_course;
use App\Course\Courses;
use App\Course\Course_chapters;
use App\Course\Course_chapter_contents;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Course_tag_id;
use App\Course\Course_join_formality;
use App\Course\Course_order;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;

class CoursesController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'khoahoc');
            return $next($request);
        });
    }
    public function index(Request $request){
        $num = 30;
        // $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $courses = new Courses();
        $list_courses = $courses->select('courses.*', 'teacher.teacher_name', 'category_course.category_course_title', 'users.name')
            ->join('teacher', 'teacher.teacher_id', '=', 'courses.teacher_id')
            ->join('category_course', 'category_course.category_course_id', '=', 'courses.category_course_id')
            ->join('users', 'users.id', '=', 'courses.admin_id')
            ->orderBy('courses.course_id', 'desc');

        $total = $list_courses->count();

        if (!empty($request->input('course_id'))) {
            $list_courses = $list_courses->where('courses.course_id', $request->course_id);
        }

        if (!empty($request->input('num'))) {
            $num = $request->input('num');
            $list_courses = $list_courses->paginate($num);
        } else {
            $list_courses = $list_courses->paginate($num);
        }

        $list_courses->appends(request()->query());
        return view('staff_admin.courses.list', compact('list_courses', 'total'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $list_teacher = Teacher::select('teacher_id', 'teacher_name', 'teacher_email', 'teacher_phone')->get();
        $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $list_tag = Course_tag::select('*')->get();
        return view('staff_admin.courses.add', compact('list_teacher', 'list_category', 'list_tag'));
    }

    public function store(Request $request)
    {
        $courses_model = new Courses();
        $insert_id = $courses_model->insertGetId([
            'category_course_id' => $request->input('category_course_id'),
            'teacher_id' => $request->input('teacher_id'),
            'course_title' => $request->input('course_title'),
            'course_code' => $request->input('course_code'),
            'course_image' => $request->input('course_image'),
            'course_descript' => $request->input('course_descript'),
            'course_content' => $request->input('course_content'),
            'course_benefit' => $request->input('course_benefit'), //Lợi ích khóa học
            'activation_code' => $request->input('activation_code'), // mã kích hoạt khóa học mặc định
            'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
            'course_discount' => !empty($request->input('course_discount')) ? str_replace(".", "", $request->input('course_discount')) : 0,
            'admin_id' => Auth::user()->id, //user duyệt khóa học
            'course_status' => $request->input('course_status'),
            'created_at' => new \DateTime(),
        ]);
        $activation_code = Ultility::create_random_string(0, 6) . $insert_id;
        if (!empty($request->input('activation_code'))) {
            $activation_code = substr($request->activation_code . $insert_id, 0, 6);
        }
        $update_activation_code = $courses_model->where('course_id', $insert_id)->update([
            'activation_code' => $activation_code
        ]);

        $postWithSlug = $courses_model->where('course_slug', $request->course_slug)->first();
        if (empty($postWithSlug)) {
            $courses_model->where('course_id', '=', $insert_id)
                ->update([
                    'course_slug' => $request->course_slug
                ]);
        } else {
            $courses_model->where('course_id', '=', $insert_id)
                ->update([
                    'course_slug' => $request->course_slug . '-' . $insert_id
                ]);
        }
        if (!empty($request->input('tag_id'))) {
            $list_tag = $request->input('tag_id');
            foreach ($list_tag as $tag_id) {
                Course_tag_id::insertGetId([
                    'tag_id' => $tag_id,
                    'course_id' => $insert_id,
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        return redirect(route('coursesStaff.index'))->with('success', 'Thêm khóa học thành công');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($course_id)
    {
        $list_teacher = Teacher::select('teacher_id', 'teacher_name', 'teacher_email', 'teacher_phone')->get();
        $list_category = Category_course::select('category_course_id', 'category_course_title')->get();
        $list_tag = Course_tag::select('*')->get();
        $tags = Course_tag_id::select('*')->where('course_id', $course_id)->get();
        $tag = array();
        foreach ($tags as $t) {
            $tag[] = $t->tag_id;
        }
        $course = new Courses();
        $course = $course->select('courses.*')
            ->where('courses.course_id', $course_id)
            ->first();
        return view('staff_admin.courses.edit', compact('list_teacher', 'list_category', 'course', 'list_tag', 'tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $insert_id)
    {
        //
        $courses_model = new Courses();
        $update = $courses_model->where('course_id', $insert_id)->update([
            'category_course_id' => $request->input('category_course_id'),
            'teacher_id' => $request->input('teacher_id'),
            'course_title' => $request->input('course_title'),
            'course_code' => $request->input('course_code'),
            'course_image' => $request->input('course_image'),
            'course_descript' => $request->input('course_descript'),
            'course_content' => $request->input('course_content'),
            'course_benefit' => $request->input('course_benefit'), //Lợi ích khóa học
            'activation_code' => $request->input('activation_code'), // mã kích hoạt khóa học mặc định
            'course_price' => !empty($request->input('course_price')) ? str_replace(".", "", $request->input('course_price')) : 0,
            'course_discount' => !empty($request->input('course_discount')) ? str_replace(".", "", $request->input('course_discount')) : 0,
            'admin_id' => Auth::user()->id, //user duyệt khóa học
            'course_status' => $request->input('course_status'),
            'updated_at' => new \DateTime(),
        ]);

        if (!empty($request->input('activation_code'))) {
            $activation_code = substr($request->activation_code . $insert_id, 0, 6);
            $update_activation_code = $courses_model->where('course_id', $insert_id)->update([
                'activation_code' => $activation_code
            ]);
        }
        if (!empty($request->input('tag_id'))) {
            Course_tag_id::where('course_id', $insert_id)->delete();
            $list_tag = $request->input('tag_id');
            foreach ($list_tag as $tag_id) {
                Course_tag_id::insertGetId([
                    'tag_id' => $tag_id,
                    'course_id' => $insert_id,
                    'created_at' => new \DateTime(),
                ]);
            }
        }
        return redirect(route('coursesStaff.index'))->with('success', 'Cập nhật khóa học thành công');
    }

    public function coursesStaffDestroy($course_id)
    {
        try {
            $courses_model = new Courses();
            $delete_id = $courses_model->where('course_id', $course_id)->delete();
            return redirect(route('coursesStaff.index'))->with('success', 'Xóa khóa học thành công');
        } catch (\Exception $exception) {
            return redirect(route('coursesStaff.index'))->with('error', 'Xóa khóa học thất bại');
        }
    }

    public function course_chapter_staff(Request $request, $course_id)
    {
        $course = new Courses();
        $course = $course->select('course_id',
            'course_title',
            'course_code')
            ->where('courses.course_id', $course_id)
            ->first();
        $course_chapters = new Course_chapters();
        $list_course_chapter = $course_chapters->select('*')->where('course_id', $course_id)->paginate(20);
        $total = $course_chapters->where('course_id', $course_id)->count();
        return view('staff_admin.courses.course_chapter', compact('course', 'list_course_chapter', 'total'));
    }

    public function store_course_chapter_staff(Request $request)
    {
        $course_chapter = new Course_chapters();
        $insert = $course_chapter->insertGetId([
            'course_id' => $request->input('course_id'),
            'course_chapter_name' => $request->input('course_chapter_name'),
            'course_chapter_status' => $request->input('course_chapter_status'),
            'course_chapter_descript' => $request->input('course_chapter_descript'),
            'course_chapter_content' => $request->input('course_chapter_content'),
            'created_at' => new \DateTime(),
        ]);
        return redirect()->back()->with('success', 'Thêm mới chương thành công');
    }

    public function update_course_chapter_staff(Request $request)
    {
        $course_chapter = new Course_chapters();
        $course_chapter_id = $request->input('course_chapter_id');
        $update = $course_chapter->where('course_chapter_id',$course_chapter_id)
            ->update([
            'course_chapter_name' => $request->input('course_chapter_name'),
            'course_chapter_status' => $request->input('course_chapter_status'),
            'course_chapter_descript' => $request->input('course_chapter_descript'),
            'course_chapter_content' => $request->input('course_chapter_content'),
            'updated_at' => new \DateTime(),
        ]);
        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }

    public function delete_course_chapter_staff(Request $request,$course_chapter_id)
    {
        $course_chapter = new Course_chapters();
        $update = $course_chapter->where('course_chapter_id',$course_chapter_id)
            ->delete();
        return redirect()->back()->with('success', 'Xóa chương thành công');
    }

    public function list_chapters_staff(Request $request,$course_chapter_id)
    {
        $course_chapter = new Course_chapters();
        $course_chapter = $course_chapter->select('course_id','course_chapter_name','course_chapter_id')->where('course_chapter_id',$course_chapter_id)->first();
        $course_chapter_content = new Course_chapter_contents();
        $list_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id',$course_chapter_id)->paginate(20);
        $total = $course_chapter_content->select('*')->where('course_chapter_id',$course_chapter_id)->count();

        $course_title = Courses::where('course_id',$course_chapter->course_id)->value('course_title');

        return view('staff_admin.courses.list_course_chapter', compact('course_chapter','list_chapter_content','total','course_title'));
    }

    public function store_chapter_content_staff(Request $request)
    {
        $course_chapter_content = new Course_chapter_contents();
        $insert = $course_chapter_content->insertGetId([
            'course_id' => $request->input('course_id'),
            'course_chapter_id' => $request->input('course_chapter_id'),
            'course_content_title' => $request->input('course_content_title'),
            'course_content_image' => $request->input('course_content_image'),
            'course_content_descript' => $request->input('course_content_descript'),
            'course_content_content' => $request->input('course_content_content'),
            'course_link_youtuber' => $request->input('course_link_youtuber'),
            'created_at' =>  new \DateTime()
        ]);
        return redirect()->back()->with('success', 'Thêm mới bài học thành công');
    }

    public function update_chapter_content_staff(Request $request)
    {
        $course_chapter = new Course_chapter_contents();
        $course_content_id = $request->input('course_content_id');
        $update = $course_chapter->where('course_content_id',$course_content_id)
            ->update([
                'course_content_title' => $request->input('course_content_title'),
                'course_content_image' => $request->input('course_content_image'),
                'course_content_descript' => $request->input('course_content_descript'),
                'course_content_content' => $request->input('course_content_content'),
                'course_link_youtuber' => $request->input('course_link_youtuber'),
                'updated_at' => new \DateTime()
            ]);
        return redirect()->back()->with('success', 'Cập nhật bài học thành công');
    }

    public function delete_chapter_content_staff(Request $request,$course_chapter_id)
    {
        $course_chapter = new Course_chapter_contents();
        $update = $course_chapter->where('course_content_id',$course_chapter_id)
            ->delete();
        return redirect()->back()->with('success', 'Xóa bài học thành công');
    }

    public function list_content_voucher_staff(Request $request,$course_content_id)
    {

        $course_chapter = new Course_chapter_contents();
        $course_chapter = $course_chapter->where('course_content_id',$course_content_id)
           ->first();
        $course_chapter_name = Course_chapters::where('course_chapter_id',$course_chapter->course_chapter_id)->value('course_chapter_name');

        $course_voucher = new Course_content_voucher();
        $list_voucher = $course_voucher->select('*')->where('course_content_id',$course_content_id)->get();
        $total_voucher = $course_voucher->where('course_content_id',$course_content_id)->count();

        $course_voucher_answer = new Course_content_voucher_answer();
        $list_voucher_answer = $course_voucher_answer->select('*')->where('course_content_id',$course_content_id)->get();
        $total_voucher_answer = $course_voucher_answer->where('course_content_id',$course_content_id)->count();

        $course_title = Courses::where('course_id',$course_chapter->course_id)->value('course_title');
        return view('staff_admin.courses.list_content_voucher', compact('course_chapter','list_voucher','total_voucher','course_title','course_chapter_name','list_voucher_answer','total_voucher_answer'));
    }

    public function store_content_voucher_staff(Request $request)
    {
        DB::beginTransaction();
        $course_voucher = new Course_content_voucher();
        $course_content_voucher_id = $course_voucher->insertGetId([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'course_content_id' => $request->input('course_content_id'),
            'created_at' => new \DateTime()
        ]);
        $content_voucher_link = $this->upload_file( $request,'content_voucher_link',$course_content_voucher_id,Auth::user()->id);
        if(empty($content_voucher_link))
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher  = $course_voucher->where('course_content_voucher_id',$course_content_voucher_id)
            ->update([
            'content_voucher_link' => $content_voucher_link,
            'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Thêm mới tài liệu thành công');
    }

    public function update_content_voucher_staff(Request $request)
    {

        DB::beginTransaction();
        $course_content_voucher_id = $request->input('course_content_voucher_id');
        $course_voucher = new Course_content_voucher();
        $course_content_voucher_update = $course_voucher->where('course_content_voucher_id',$course_content_voucher_id)->update([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'updated_at' => new \DateTime()
        ]);
        $course_content_voucher= $course_voucher->select('content_voucher_link')->where('course_content_voucher_id',$course_content_voucher_id)->first();
        $content_voucher_link = $course_content_voucher->content_voucher_link;
        if(!empty($request->input('check_content_voucher_link')))
        {
            $content_voucher_link = $this->upload_file( $request,'content_voucher_link',$course_content_voucher_id,Auth::user()->id);
        }
        if(empty($content_voucher_link))
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher  = $course_voucher->where('course_content_voucher_id',$course_content_voucher_id)
            ->update([
                    'content_voucher_link' => $content_voucher_link,
                'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Cập nhật tài liệu thành công');

    }

    public function delete_content_voucher_staff(Request $request,$course_content_voucher_id)
    {
        $course_voucher = new Course_content_voucher();
        $course_content_voucher_update = $course_voucher->where('course_content_voucher_id',$course_content_voucher_id)->delete();
        return redirect()->back()->with('success', 'Xóa tài liệu thành công');
    }

    public function store_content_voucher_answer_staff(Request $request)
    {
        DB::beginTransaction();
        $course_voucher = new Course_content_voucher_answer();
        $course_content_voucher_id = $course_voucher->insertGetId([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'course_content_id' => $request->input('course_content_id'),
            'created_at' => new \DateTime()
        ]);
        $content_voucher_answer_link = $this->upload_file( $request,'content_voucher_answer_link',$course_content_voucher_id,Auth::user()->id);
        if(empty($content_voucher_answer_link))
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher  = $course_voucher->where('course_content_voucher_answer_id',$course_content_voucher_id)
            ->update([
            'content_voucher_answer_link' => $content_voucher_answer_link,
            'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Thêm mới tài liệu đáp án thành công');
    }

    public function update_content_voucher_answer_staff(Request $request)
    {

        DB::beginTransaction();
        $course_content_voucher_id = $request->input('course_content_voucher_answer_id');
        $course_voucher = new Course_content_voucher_answer();
        $course_content_voucher_update = $course_voucher->where('course_content_voucher_answer_id',$course_content_voucher_id)->update([
            'content_voucher_title' => $request->input('content_voucher_title'),
            'updated_at' => new \DateTime()
        ]);
        $course_content_voucher= $course_voucher->select('content_voucher_answer_link')->where('course_content_voucher_answer_id',$course_content_voucher_id)->first();
        $content_voucher_answer_link = $course_content_voucher->content_voucher_answer_link;
        if(!empty($request->input('check_content_voucher_answer_link')))
        {
            $content_voucher_answer_link = $this->upload_file( $request,'content_voucher_answer_link',$course_content_voucher_id,Auth::user()->id);
        }
        if(empty($content_voucher_answer_link))
        {
            DB::rollBack();
            return redirect()->back()->with('error', 'File tài liệu không đúng định dạng và dung lượng file nhỏ hơn <10M');
        }
        $upload_content_voucher  = $course_voucher->where('course_content_voucher_answer_id',$course_content_voucher_id)
            ->update([
                'content_voucher_answer_link' => $content_voucher_answer_link,
                'updated_at' => new \DateTime(),
            ]);
        DB::commit();
        return redirect()->back()->with('success', 'Cập nhật tài liệu đáp án thành công');

    }

    public function delete_content_voucher_answer_staff(Request $request,$course_content_voucher_answer_id)
    {
//        echo $course_content_voucher_answer_id;die;
        $course_voucher = new Course_content_voucher_answer();
        $course_content_voucher_delete = $course_voucher->where('course_content_voucher_answer_id',$course_content_voucher_answer_id)->delete();
        return redirect()->back()->with('success', 'Xóa tài liệu đáp án thành công');

    }

    public function upload_file(Request $request,$input_name,$id,$user_id)
    {
        $link_image = '';
        $path_forder_images = public_path('/upload_file_course/'.$user_id);

        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $imageFileType =$file->getClientOriginalExtension();
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
//            $allowtypes = array('doc', 'docx', 'xlsx', 'xls','pdf','pptx');
//            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
//                return 0;
//            }
            if ($file->getSize() >= $maxsize) {
                return 0;
            }
            $name_file = $user_id . '_' . $id . '_' . $file->getClientOriginalName();
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/upload_file_course/'.$user_id.'/'.$name_file ;
            return $link_image;
        }
        return 0;
    }

    public function list_formality_staff($course_id)
    {
        $course = new Courses();
        $course = $course->select('courses.*')
            ->where('courses.course_id', $course_id)
            ->first();

        $list_formality = Course_join_formality::select('course_join_formality.*', 'course_formality.course_formality_title')
            ->join('course_formality', 'course_formality.course_formality_id', '=', 'course_join_formality.course_formality_id')
            ->where('course_join_formality.course_id', $course_id)->paginate(20);

        $formality_id = array();
        foreach ($list_formality as $formality) {
            $formality_id[] = $formality->course_formality_id;
        }

        $total = $list_formality->count();
        return view('staff_admin.courses.list_formality_staff', compact('course', 'list_formality', 'formality_id'));
    }

    public function store_formality_staff(Request $request)
    {
        if(!empty($request->input('course_formality_id')))
        {
            $insert = Course_join_formality::insert([
                'course_id' => $request->input('course_id'),
                'course_formality_id' => $request->input('course_formality_id'),
                'course_formality_price' => !empty($request->input('course_formality_price')) ? str_replace(".", "", $request->input('course_formality_price')) : 0,
                'course_formality_discount' => !empty($request->input('course_formality_discount')) ? str_replace(".", "", $request->input('course_formality_discount')) : 0,
                'course_formality_des' => $request->input('course_formality_des'),
                'created_at' => new \DateTime()
            ]);
            return redirect()->back()->with('success', 'Thêm hình thức học thành công');
        }
        return redirect()->back()->with('error', 'Hình thức học đã được tạo hết');
    }
    public function update_formality_staff(Request $request)
    {
        $course_formality_id = Course_join_formality::where('course_join_formality_id',$request->input('course_join_formality_id'))->value('course_formality_id');
        if(!empty($request->input('course_formality_id')))
        {
            $course_formality_id = $request->input('course_formality_id');
        }
        $update = Course_join_formality::where('course_join_formality_id',$request->input('course_join_formality_id'))->update([
            'course_formality_id' => $course_formality_id,
            'course_formality_price' => !empty($request->input('course_formality_price')) ? str_replace(".", "", $request->input('course_formality_price')) : 0,
            'course_formality_discount' => !empty($request->input('course_formality_discount')) ? str_replace(".", "", $request->input('course_formality_discount')) : 0,
            'course_formality_des' => $request->input('course_formality_des'),
            'updated_at' => new \DateTime()
        ]);
        return redirect()->back()->with('success', 'Cập nhật hình thức học thành công');
    }
    public function delete_formality_staff($course_join_formality_id)
    {
        $delete = Course_join_formality::where('course_join_formality_id',$course_join_formality_id)->delete();
        return redirect()->back()->with('success', 'Xóa hình thức học thành công');
    }
}
