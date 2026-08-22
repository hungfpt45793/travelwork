<?php

namespace App\Http\Controllers\Admin\Exam;

use App\Exam\CategoriesExam;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class CategoriesExamController extends \App\Http\Controllers\Admin\AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'exam');

            return $next($request);
        });

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam', '=', 0)->paginate(5);

        } catch (\Exception $e) {
            $categories = null;
//            Error::setErrorMessage('Hiển thị danh mục xảy ra lỗi.');
            Log::error('http->Admin->CategoryController->index: Hiển thị danh mục xảy ra lỗi');
        } finally {
            return view('admin.exam.categories_exam.list', compact('categories_exam'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories_exam = CategoriesExam::select('*')->where('parent_cate_exam', '=', 0)->get();
        return view('admin.exam.categories_exam.add', compact('categories_exam'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->insertCategory($request);
        return redirect('admin/categories-exam')->with('create', 'thanh cong');
    }

    private function insertCategory($request)
    {
        $this->validate($request, [
            'code_cate_exam' => 'required|unique:categories_exam|max:255',
        ]);
        $categories_exam = new CategoriesExam();
        $id_cate_exam = $categories_exam->insertGetId([
            'parent_cate_exam' => $request->input('parent_cate_exam'),
            'code_cate_exam' => $request->input('code_cate_exam'),
            'name_cate_exam' => $request->input('name_cate_exam'),
            'into_cate_exam' => $request->input('into_cate_exam'),
            'content_cate_exam' => $request->input('content_cate_exam'),
            'image_cate_exam' => $request->input('image_cate_exam'),
            'icon' => $request->input('icon'),
            'location' => $request->input('location'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        //tao slug cho danh mục
//        slug_cate_exam
        $slug = $request->input('slug_cate_exam');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('name_cate_exam'));
        }
        $cateSlug = CategoriesExam::where('slug_cate_exam', $slug)
            ->where('id_cate_exam', '!=', $id_cate_exam)
            ->first();
        if (empty($cateSlug)) {
            $categories_exam->where('id_cate_exam', $id_cate_exam)
                ->update([
                    'slug_cate_exam' => $slug
                ]);
        } else {
            $categories_exam->where('id_cate_exam', $id_cate_exam)
                ->update([
                    'slug_cate_exam' => $slug . '-' . $id_cate_exam
                ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(CategoriesExam $categoriesExam)
    {

        try {

            return view('admin.exam.categories_exam.edit', compact('categoriesExam'));

        } catch (\Exception $e) {
            Log::error('Loi');
            return redirect('admin/categories-exam')->with('error_edit_delete', 'Lỗi không cập nhật được sản phẩm');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        try {
//        echo $request->input('parent_cate_exam');exit();
        $categories_exam = new CategoriesExam();
        $categories_exam->where('id_cate_exam', '=', $id)->update([
            'name_cate_exam' => $request->input('name_cate_exam'),
            'into_cate_exam' => $request->input('into_cate_exam'),
            'content_cate_exam' => $request->input('content_cate_exam'),
            'image_cate_exam' => $request->input('image_cate_exam'),
            'icon' => $request->input('icon'),
            'location' => $request->input('location'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);

        //tao slug cho danh mục
        $slug = $request->input('slug_cate_exam');
        if (empty($slug)) {
            $slug = Ultility::createSlug($request->input('name_cate_exam'));
        }


        $cateSlug = CategoriesExam::where('slug_cate_exam', $slug)
            ->where('id_cate_exam', '!=', $id)
            ->first();
        if (empty($cateSlug)) {
            $categories_exam->where('id_cate_exam', $id)
                ->update([
                    'slug_cate_exam' => $slug
                ]);
        } else {
            $categories_exam->where('id_cate_exam', $id)
                ->update([
                    'slug_cate_exam' => $slug . '-' . $id
                ]);
        }

        return redirect('admin/categories-exam')->with('create', 'thanh cong');

//        } catch (\Exception $e) {
//
//            Log::error('http->admin->CategoryController->insertCategory: Lỗi insert danh mục category');
//            return redirect('admin/categories-exam')->with('error_create', 'thất bại');
//        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(CategoriesExam $categoriesExam)
    {
        try {
            $categories_exam = new CategoriesExam();
            $categories_exam->where('id_cate_exam', $categoriesExam->id_cate_exam)
                ->delete();
            return redirect('admin/categories-exam')->with('create', 'thanh cong');
        } catch (\Exception $e) {
            return redirect('admin/categories-exam')->with('error_create', 'thất bại');
            Log::error('http->admin->categoryController->destroy: Lỗi xảy tra trong quá trình xóa danh mục');
        }
    }
}
