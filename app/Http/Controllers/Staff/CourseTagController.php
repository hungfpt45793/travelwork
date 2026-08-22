<?php

namespace App\Http\Controllers\Staff;
use App\Course\Category_course;
use App\Course\Courses;
use App\Course\Course_employee;
use App\Course\Course_chapters;
use App\Course\Course_chapter_contents;
use App\Course\Course_content_voucher;
use App\Course\Course_content_voucher_answer;
use App\Course\Course_tag;
use App\Course\Course_join_formality;
use Illuminate\Http\Request;
use App\Http\Controllers\Staff\SiteStaffController;

class CourseTagController extends SiteStaffController
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
        $list_tag = Course_tag::select('*')->orderBy('tag_id','desc');
        $list_tag = $list_tag->paginate($num);
        $list_tag->appends(request()->query());
        return view('staff_admin.course_tag.list', compact('list_tag'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('staff_admin.course_tag.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */



    public function store(Request $request)
    {
        $tag_id = Course_tag::insertGetId([
            'tag_title' => $request->input('tag_title'),
            'created_at' => new \DateTime(),
        ]);
        $tag_slug = $request->input('tag_slug');
        $postWithSlug = Course_tag::where('tag_slug', $tag_slug)->first();
        if (empty($postWithSlug)) {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug
                ]);
        } else {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug . '-' . $tag_id
                ]);
        }
        return redirect(route('courseTag.index'))->with('success', 'Thêm mới từ khóa thành công');
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
    public function edit($tag_id)
    {
        $course_tag = Course_tag::where('tag_id', '=', $tag_id)->first();
        return view('staff_admin.course_tag.edit', compact('course_tag'));
    }


    public function update(Request $request, $tag_id)
    {

        $update = Course_tag::where('tag_id', $tag_id)->update([
            'tag_title' => $request->input('tag_title'),
            'updated_at' => new \DateTime(),
        ]);

        $tag_slug = $request->input('tag_slug');
        $postWithSlug = Course_tag::where('tag_slug', $tag_slug)->where('tag_id','!=' , $tag_id)->first();
        if (empty($postWithSlug)) {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug
                ]);
        } else {
            Course_tag::where('tag_id', '=', $tag_id)
                ->update([
                    'tag_slug' => $tag_slug . '-' . $tag_id
                ]);
        }
        return redirect(route('courseTag.index'))->with('success', 'Cập nhật từ khóa thành công');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function courseTagDestroy($tag_id)
    {
        try {
            Course_tag::where('tag_id', '=', $tag_id)->delete();
            return redirect(route('courseTag.index'))->with('success', 'Xóa từ khóa thành công');
        } catch (\Exception $exception) {
            return redirect(route('courseTag.index'))->with('error', 'Xóa từ khóa thất bại');
        }
    }
}
