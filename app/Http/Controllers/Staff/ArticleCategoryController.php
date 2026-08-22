<?php

namespace App\Http\Controllers\Staff;

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

class ArticleCategoryController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'article');
            return $next($request);
        });
    }
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
            return view('staff_admin.news_article.category', compact('categories'));
        }
       
    }

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
        return view('staff_admin.news_article.add_category',compact('categories', 'templates', 'typeInputs'));
    }

    public function store(Request $request)
    {
        // if slug null slug create as title
        $slug = $this->createSlug($request);
        // insert to database
        if($this->insertCategory($request, $slug)){
            dd('as');
        };

        return redirect('staff/staff_article_category');
    }
    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        $category = Category::where('category_id',$id)->first();
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
        return view('staff_admin.news_article.edit_category', compact('categories', 'templates', 'category', 'typeInputs'));
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        $category =Category::findOrFail($id)->delete();
        return redirect(route('staff_category_article.index'))->with('success','Xóa thành công');
    }
    protected function createSlug($request) {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
        } catch (\Exception $exception) {
            $slug = rand(10,10000000);

        } finally {
            return $slug;
        }
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
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;   
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            Category::where('category_id', $arrid)->delete();
        }
       
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
