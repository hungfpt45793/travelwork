<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class CategoryController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

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
            $category = new Category();
            $categories = $category->getCategory();
        } catch (\Exception $e) {
            $categories = null;
            Error::setErrorMessage('Hiển thị danh mục xảy ra lỗi.');
            Log::error('http->Admin->CategoryController->index: Hiển thị danh mục xảy ra lỗi');
        } finally {
            return view('admin.post_cate.list', compact('categories'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $categories = $category->getCategory();
        $templates = Template::getTemplate();
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('cate_post', $token)) {
                $typeInputs[] = $typeInput;
            }
        }

        return view('admin.post_cate.add', compact('categories', 'templates', 'typeInputs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // if slug null slug create as title
        $slug = $this->createSlug($request);
        // insert to database
        $this->insertCategory($request, $slug);

        return redirect('admin/categories');
    }

    private function insertCategory($request, $slug) {
        try {
            $category = new Category();
            $cateId = $category->insertGetId([
                'title' => $request->input('title'),
                'slug' => $slug,
                'parent' => $request->input('parent'),
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'image' =>  $request->input('image'),
            ]);

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
               ->get();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('cate_post', $token)) {
                    $contentInput =  $request->input($typeInput->slug);
                    if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'image_list'), true) && strpos($typeInput->type_input, 'listMultil') >= 0) {
                        $contentInput = ( !empty($contentInput) && count($contentInput) >= 1) ? implode(',', $contentInput) : $contentInput;
                    }
                    $input = new Input();
                    $input->insert([
                        'type_input_slug' => $typeInput->slug,
                        'content' => $contentInput,
                        'cate_id' => $cateId,
                    ]);
                }
            }

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới danh mục: dữ liệu nhập vào không hợp lệ.');

            Log::error('http->admin->CategoryController->insertCategory: Lỗi insert danh mục category');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = $category->getCategory();
        $templates = Template::getTemplate();
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('cate_post', $token)) {
                $typeInputs[] = $typeInput;
                $category[$typeInput->slug] = Input::getPostMetaCate($typeInput->slug, $category->category_id);
            }
        }
        return view('admin.post_cate.edit', compact('categories', 'templates', 'category', 'typeInputs'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        // if slug null slug create as title
        $slug = $this->createSlug($request);

        // update to database
        $this->updateCategory($category, $request, $slug);

        return redirect('admin/categories');
    }

    private function updateCategory ($category, $request, $slug) {
        try {
            $category->update([
                'title' => $request->input('title'),
                'parent' => $request->input('parent'),
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'image' =>  $request->input('image'),
            ]);

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                                ->get();
            Input::where([
                'cate_id' =>  $category->category_id
            ])
                ->delete();

            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('cate_post', $token)) {
                    $contentInput =  $request->input($typeInput->slug);
                    if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor', 'image_list'), true) && strpos($typeInput->type_input, 'listMultil') >= 0) {
                        $contentInput = ( !empty($contentInput) && count($contentInput) >= 1) ? implode(',', $contentInput) : $contentInput;
                    }
                    Input::insert([
                        'type_input_slug' => $typeInput->slug,
                        'content' => $contentInput,
                        'cate_id' => $category->category_id,
                    ]);
                }
            }
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật danh mục: dữ liệu nhập vào không hợp lệ.');

            Log::error('http->admin->CategoryController->updateCategory: Lỗi xảy ra trong quá trình update category');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        try {
            $categoryModel = new Category();
            $categoryModel->where('category_id', $category->category_id)
                ->delete();

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa danh mục: dữ liệu xóa không hợp lệ.');
            Log::error('http->admin->categoryController->destroy: Lỗi xảy tra trong quá trình xóa danh mục');
        } finally {
            return redirect('admin/categories');
        }
    }
}
