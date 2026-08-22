<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Ultility\CallApi;
use App\Ultility\Icon;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;

class CategoryProductController extends AdminController
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
        $category = new Category();
        $categories =$category->getCategory('product');

        return view('admin.product_cate.list', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = new Category();
        $categories =$category->getCategory('product');
        $templates = Template::getTemplate();
        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
                            ->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('cate_product', $token)) {
                $typeInputs[] = $typeInput;
            }
        }

        return view('admin.product_cate.add', compact('categories', 'templates', 'typeInputs'));
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
        $this->createCategory($request, $slug);

        return redirect('admin/category-products');
    }

    private function createCategory ($request, $slug) {
        try {
            $category = new Category();
            $cateId = $category->insertGetId([
                'title' => $request->input('title'),
                'slug' => $slug,
                'parent' => $request->input('parent'),
                'post_type' => 'product',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'image' =>  $request->input('image'),
            ]);

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                ->get();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('cate_product', $token)) {
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
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới danh mục: dữ liệu không hợp lệ.');
            Log::error('http->admin->CategoryProductController->createCategory: Lỗi tạo mới danh mục sản phẩm');
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = $this->getDetailCategory($id);

        $categoryObj = new Category();
        $categories =$categoryObj->getCategory( 'product');
        $templates = Template::getTemplate();

        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputDatabase = TypeInput::orderBy('type_input_id')
            ->get();
        $typeInputs = array();
        foreach($typeInputDatabase as $typeInput) {
            $token = explode(',', $typeInput->post_used);
            if (in_array('cate_product', $token)) {
                $typeInputs[] = $typeInput;
                $category[$typeInput->slug] = Input::getPostMetaCate($typeInput->slug, $category->category_id);
            }
        }

        return view('admin.product_cate.edit', compact('categories', 'templates', 'category', 'typeInputs'));
    }

    private function getDetailCategory($id) {
        try {
            $category = Category::where('category_id', $id)
                ->first();

            return $category;
        } catch (\Exception $e) {
            Error::setErrorMessage('Danh mục lấy ra không tồn tại.');
            Log::error('http->admin->CateogryProductController->getDetailCategory: Category không tồn tại');

            return redirect('admin/category-products');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $category = $this->getDetailCategory($id);

        // if slug null slug create as title
        $slug = $this->createSlug($request);

        // insert to database
        $this->updateCategory($category, $request, $slug);

        return redirect('admin/category-products');
    }

    private function updateCategory($category, $request, $slug) {
        try {
            $category->update([
                'title' => $request->input('title'),
                'slug' => $slug,
                'parent' => $request->input('parent'),
                'post_type' => 'product',
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
                if (in_array('cate_product', $token)) {
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
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật danh mục: Dữ liệu nhập vào không hợp lệ.');
            Log::error('http->Admin->CategoryProductController->updateCategory: Không thể cập nhật category');
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            Category::where('category_id', $id)
                ->delete();

            return redirect('admin/category-products');
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa danh mục: Dữ liệu xóa không hợp lệ.');
            Log::error('http->Admin->CategoryProductController->destroy: Không thể xóa được danh mục sản phẩm');

            return redirect('admin/category-products');
        }


    }

    public function getCateProductGetfly() {
        $callApi = new CallApi();
        $categories = $callApi->getCategory();

        if ($categories == false) {
            return response([
                'httpCode' => 500,
            ])->header('Content-Type', 'text/plain');
        }

        // sắp xếp lại category theo level
        $categories = $this->sortWithLevel($categories);

        // Hiển thị ra danh mục cha và con
        $categorySort = $this->showParentAndChild($categories);

        return response([
            'httpCode' => 200,
            'categories' => $categorySort
        ])->header('Content-Type', 'text/plain');

    }

    private function sortWithLevel ($categories) {
        $categoriesOld = $categories;
        try {
            foreach ($categories as $id => $category) {
                foreach ($categories as $idAfter => $cateAfter) {
                    if ($idAfter > $id && $cateAfter['level'] < $category['level']) {
                        $tg = $categories[$id];
                        $categories[$id] = $categories[$idAfter];
                        $categories[$idAfter] = $tg;
                    }
                }
            }

            return $categories;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy danh mục getfly: Có vấn đề xảy ra với dữ liệu getfly.');
            Log::error('http -> CategoryProductController -> sortWithLevel: Lỗi không sắp xếp theo level');

            return $categoriesOld;
        }
    }

    private function showParentAndChild($categories) {
        $categoriesOld = $categories;
        try {
            $cateogoriesChildren = array();
            $categorySort = array();
            foreach ($categories as $id => $cate) {
                if (in_array($cate['category_id'], $cateogoriesChildren) == false) {
                    $cate['cate_name_show'] = $cate['category_name'];
                    $categorySort[] = $cate;
                    $this->getChildrenGetfly($categorySort, $cateogoriesChildren, $categories, $cate['category_id'], '-----');

                }
            }

            return $categorySort;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy danh mục getfly: Có vấn đề xảy ra với dữ liệu getfly.');
            Log::error('http -> CategoryProductController -> showParentAndChild: Lỗi không thể hiển thị dạng danh mục cha và con');

            return $categoriesOld;
        }

    }

    private function getChildrenGetfly (&$categorySort, &$cateogoriesChildren, $categories, $parent, $subTitle) {
        try {
            foreach ($categories as $id => $cate) {
                if ($cate['parent_id'] == $parent) {
                    $cate['cate_name_show'] = $subTitle.$cate['category_name'];
                    $categorySort[] = $cate;
                    $cateogoriesChildren[] = $cate['category_id'];
                    $this->getChildrenGetfly($categorySort, $cateogoriesChildren, $categories, $cate['category_id'], $subTitle.'-----');
                }
            }

            return ;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy danh mục getfly: Có vấn đề xảy ra với dữ liệu getfly.');
            Log::error('http -> CategoryProductController -> getChildrenGetfly: Lỗi không thể lấy ra danh mục con');
            return ;
        }

    }
}
