<?php

namespace App\Http\Controllers\Admin\Course;

use App\Course\Category_course;
use App\Course\Course_chapter_contents;
use App\Course\Course_chapters;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Courses;
use App\Entity\Teacher;
use App\Entity\User;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UploadFileController;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;

class CourseContentVoucherController extends AdminController
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

    public function store_content_voucher(Request $request)
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

    public function update_content_voucher(Request $request)
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

    public function delete_content_voucher(Request $request,$course_content_voucher_id)
    {
        $course_voucher = new Course_content_voucher();
        $course_content_voucher_update = $course_voucher->where('course_content_voucher_id',$course_content_voucher_id)->delete();
        return redirect()->back()->with('success', 'Xóa tài liệu thành công');
    }

    public function store_content_voucher_answer(Request $request)
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

    public function update_content_voucher_answer(Request $request)
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

    public function delete_content_voucher_answer(Request $request,$course_content_voucher_answer_id)
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

    public function list_chapters(Request $request,$course_chapter_id)
    {
        $course_chapter = new Course_chapters();
        $course_chapter = $course_chapter->select('course_id','course_chapter_id')->where('course_chapter_id',$course_chapter_id)->first();
        $course_chapter_content = new Course_chapter_contents();
        $list_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id',$course_chapter_id)->get();
        $total_chapter_content = $course_chapter_content->select('*')->where('course_chapter_id',$course_chapter_id)->count();

        return view('admin.course.course_chapter.list', compact('course_chapter','list_chapter_content','total_chapter_content'));
//        return redirect()->back()->with('success', 'Cập nhật chương thành công');
    }


}
