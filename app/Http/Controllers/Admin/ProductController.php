<?php

namespace App\Http\Controllers\Admin;

use App\Support\SpreadsheetFile;
use App\Entity\Category;
use App\Entity\CategoryPost;
use App\Entity\Comment;
use App\Entity\Filter;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\Product;
use App\Entity\User;
use App\Ultility\CallApi;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Validator;
use Yajra\DataTables\DataTables;
use App\Biz\CategoryProductBiz;
use App\Biz\ProductBiz;

class ProductController extends AdminController
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
        
        return view('admin.product.list', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $category = new Category();
            $categories =$category->getCategory('product');
            $templates = Template::orderBy('template_id')->get();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('product', $token)) {
                    $typeInputs[] = $typeInput;
                }
            }

            $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'products.product_id',
                    'posts.*'
                )
                ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();
            //lấy ra bộ lọc
            $filter = Filter::get();

            return view('admin.product.add', compact('categories', 'templates', 'typeInputs', 'productList', 'filter'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->PostController->create: Lỗi xảy ra trong quá trình tạo mới sản phẩm');

            return redirect('admin/home');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // lấy user id
            $userId = 1;

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            if (!empty($request->input('parents'))) {
                $categoriParents = Category::whereIn('category_id', $request->input('parents'))->get();
                $categories = array();
                foreach ($categoriParents as $cate) {
                    $categories[] =  $cate->title;
                }
            }
            // insert to database
            $post = new Post();
            $postId = $post->insertGetId([
                'title' => $request->input('title'),
                'post_type' => 'product',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'tags' => $request->input('tags'),
                'image' =>  $request->input('image'),
                'content' =>  $request->input('content'),
                'visiable' => 0,
                'category_string' => !empty($categories) ? implode(',', $categories) : '',
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),

            ]);

            // insert slug
            $postWithSlug = $post->where('slug', $slug)->first();
            if (empty($postWithSlug)) {
                $post->where('post_id', '=', $postId)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $post->where('post_id', '=', $postId)
                    ->update([
                        'slug' => $slug.'-'.$postId
                    ]);
            }

            // insert danh mục cha
            $categoryPost = new CategoryPost();
            if (!empty($request->input('parents'))) {
                foreach ($request->input('parents') as $parent) {
                    $categoryPost->insert([
                        'category_id' => $parent,
                        'post_id' => $postId,
                    ]);
                }
            }

            $isDiscount = $request->input('is_discount');
            $discountStart = null;
            $discountEnd = null;
            if ($isDiscount == 1) {
                $discountStartEnd = $request->input('discount_start_end');
                $discountTime = explode('-', $discountStartEnd);
                $discountStart = $discountTime[0];
                $discountEnd = $discountTime[1];

            }
            $product = new Product();
            $product->insert([
                'post_id' => $postId,
                'code' =>  $request->input('code'),
                'price' =>  !empty($request->input('price')) ? str_replace(".", "", $request->input('price')) : 0,
                'origin_price' =>  !empty($request->input('origin_price')) ? str_replace(".", "", $request->input('origin_price')) : 0,
                'discount' =>  !empty($request->input('discount')) ? str_replace(".", "", $request->input('discount')) : 0,
                'discount_start' => new \Datetime($discountStart),
                'discount_end' => new \Datetime($discountEnd),
                'image_list' =>  $request->input('image_list'),
                'properties' =>  $request->input('properties'),
                'deal_end' =>  new \DateTime($request->input('deal_end')),
                'price_deal' =>  !empty($request->input('price_deal')) ? str_replace(".", "", $request->input('price_deal')) : 0,
                'buy_together' => !empty($request->input('buy_together')) ? implode(',', $request->input('buy_together')) : null,
                'buy_after' => !empty($request->input('buy_after')) ?  implode(',', $request->input('buy_after')) : null,
                'filter' => !empty($request->input('filter')) ?  implode(',', $request->input('filter')) : null
            ]);


            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('product', $token)) {
                    $contentInput =  $request->input($typeInput->slug);
                    $input = new Input();
                    $input->insert([
                        'type_input_slug' => $typeInput->slug,
                        'content' => $contentInput,
                        'post_id' => $postId,
                    ]);
                }
            }

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->ProductController->store: Lỗi xảy ra trong quá trình tạo mới sản phẩm');
        } finally {
            return redirect('admin/products');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return redirect('admin/products');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        try {
            $post = Post::where('post_id', $product->post_id)->first();

            $category = new Category();
            $categories =$category->getCategory('product');
            $templates = Template::orderBy('template_id')->get();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('product', $token)) {
                    $typeInputs[] = $typeInput;
                    $post[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
                }
            }

            $categoryPosts = CategoryPost::where('post_id', $post->post_id)->get();
            $categoryPost = array();

            $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'products.product_id',
                    'posts.*'
                )
                ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();


            foreach($categoryPosts as $cate ) {
                $categoryPost[] = $cate->category_id;
            }

            //lấy ra bộ lọc
            $filter = Filter::get();

            return view('admin.product.edit', compact('categories', 'templates', 'typeInputs', 'post', 'product', 'categoryPost', 'productList', 'filter'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->productController->edit: Lỗi xảy ra trong quá trình chỉnh sửa sản phẩm');

            return redirect('admin/home');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $postExist = Post::where('post_id', $product->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/products');
            }

            $userId = 0;
            $post = Post::where('post_id', $product->post_id)->first();

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            if (!empty($request->input('parents'))) {
                $categoriParents = Category::whereIn('category_id', $request->input('parents'))->get();
                $categories = array();
                foreach ($categoriParents as $cate) {
                    $categories[] = $cate->title;
                }
            }

            // update to database
            $post->update([
                'title' => $request->input('title'),
                'post_type' => 'product',
                'template' => $request->input('template'),
                'description' => $request->input('description'),
                'tags' => $request->input('tags'),
                'image' => $request->input('image'),
                'content' => $request->input('content'),
                'visiable' => 0,
                'category_string' => !empty($categories) ? implode(',', $categories) : '',
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
            ]);

            // insert slug
            $postWithSlug = Post::where('slug', $slug)
                ->where('post_id', '!=', $post->post_id)
                ->first();
            if (empty($postWithSlug)) {
                $post->where('post_id', $post->post_id)
                    ->update([
                        'slug' => $slug
                    ]);
            } else {
                $post->where('post_id', $post->post_id)
                    ->update([
                        'slug' => $slug . '-' . $post->post_id
                    ]);
            }

            // insert danh mục cha
            $categoryPost = new CategoryPost();
            $categoryPost->where('post_id', $post->post_id)->delete();
            if (!empty($request->input('parents'))) {
                foreach ($request->input('parents') as $parent) {
                    $categoryPost->insert([
                        'category_id' => $parent,
                        'post_id' => $post->post_id,
                    ]);
                }
            }


            $isDiscount = $request->input('is_discount');
            $discountStart = null;
            $discountEnd = null;
            if ($isDiscount == 1) {
                $discountStartEnd = $request->input('discount_start_end');
                $discountTime = explode('-', $discountStartEnd);
                $discountStart = $discountTime[0];
                $discountEnd = $discountTime[1];

            }

            $product->update([
                'price' => !empty($request->input('price')) ? str_replace(".", "", $request->input('price')) : 0,
                'origin_price' => !empty($request->input('origin_price')) ? str_replace(".", "", $request->input('origin_price')) : 0,
                'code' => $request->input('code'),
                'discount' => !empty($request->input('discount')) ? str_replace(".", "", $request->input('discount')) :0 ,
                'discount_start' => !empty($discountStart) ? new \DateTime($discountStart) : null,
                'discount_end' => !empty($discountEnd) ? new \DateTime($discountEnd) : null,
                'image_list' => $request->input('image_list'),
                'properties' => $request->input('properties'),
                'deal_end' =>  new \DateTime($request->input('deal_end')),
                'price_deal' =>  !empty($request->input('price_deal')) ? str_replace(".", "", $request->input('price_deal')) : 0,
                'buy_together' => !empty($request->input('buy_together')) ? implode(',', $request->input('buy_together')) : null,
                'buy_after' => !empty($request->input('buy_after')) ? implode(',', $request->input('buy_after')) : null,
                'filter' => !empty($request->input('filter')) ? implode(',', $request->input('filter')) : null

            ]);
            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                ->get();
            $input = new Input();
            $input->updateInput($typeInputDatabase, $request, $post->post_id, 'product');

            DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->productController->update: Lỗi xảy ra trong quá trình chỉnh sửa sản phẩm');
        } finally {
            return redirect('admin/products');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            DB::beginTransaction();
            $postExist = Post::where('post_id', $product->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/products');
            }

            Product::where('product_id', $product->product_id)->delete();
            Post::where('post_id', $product->post_id)->delete();
            Comment::where('post_id', $product->post_id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi xóa sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->productController->destroy: Lỗi xảy ra trong quá trình xóa sản phẩm');
        } finally {
            return redirect('admin/products');
        }
    }

    public function anyDatatables(Request $request) {
        $posts = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'posts.*',
                'products.price',
                'products.code'
            )
            ->where('post_type', 'product');
        
        return Datatables::of($posts)
            ->addColumn('action', function($post) {
                $string = '<input type="checkbox" class="flat-red" onclick="return visiablePost(this);" value="'.$post->post_id.'" '.( ($post->visiable == 0 || $post->visiable == null ) ? 'checked' : '' ).'/> Hiện ';
                
                $string .=  '<a href="'.route('products.edit', ['product_id' => $post->product_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('products.destroy', ['product_id' => $post->product_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('posts.post_id', 'posts.post_id desc')
            ->make(true);
    }
    public function exportToExcel()
    {
        try {
            $posts = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'products.product_id',
                    'discount',
                    'price',
                    'title',
                    'code',
                    'image',
                    'posts.post_id',
                    'description',
                    'content',
                    'tags',
                    'slug',
                    'category_string',
                    'meta_title',
                    'meta_description',
                    'meta_keyword'
                )
                ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();
            $data = array();
            $data[] = array(
                'Id',
                'Đường dẫn',
                'Tiêu đề',
                'Mô tả sản phẩm',
                'Nội dung sản phẩm',
                'Thẻ tag',
                'Thẻ title',
                'Thẻ description',
                'Thẻ keyword',
                'Danh mục',
                'Mã sản phẩm',
                'Giá tiền',
                'Giá khuyến mãi',
                'Xuất xứ',
                'Hãng sản xuất',
                'Hình ảnh'
            );
            foreach ($posts as $product){
                $inputs = Input::where('post_id', $product->post_id)->get();
                foreach ($inputs as $input) {
                    $product[$input->type_input_slug] = $input->content;
                }

                $data[] = array(
                    $product->post_id,
                    $product->slug,
                    $product->title,
                    $product->description,
                    $product->content,
                    $product->tags,
                    $product->meta_title,
                    $product->meta_description,
                    $product->meta_keyword,
                    $product->category_string,
                    $product->code,
                    $product->price,
                    $product->discount,
                    $product['xuat-su'],
                    $product['hang-san-xuat'],
                    asset($product->image)
                );
            }
            $date = new \DateTime();
            $fileName = "San-pham-".$date->format("d/m/y");
            return SpreadsheetFile::download($data, $fileName);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi export sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->productController->exportToExcel: Lỗi xảy ra trong quá trình export sản phẩm');

            return null;
        }
    }
    public function importToExcel()
    {
        try {
            DB::beginTransaction();
            foreach (SpreadsheetFile::rows(request()->file('file')) as $row) {
                    // Loop through all rows
                    if ($row[0] != 'Id') {
                        $postId = $row[0];
                        $slug = $row[1];
                        $title = $row[2];
                        $description = $row[3];
                        $content = $row[4];
                        $tags = $row[5];
                        $meta_title = $row[6];
                        $meta_description = $row[7];
                        $meta_keyword = $row[8];
                        $category_string = $row[9];
                        $code = $row[10];
                        $price = $row[11];
                        $discount = $row[12];
                        $xuatSu = $row[13];
                        $hangSanXuat = $row[14];
                        $img = $row[15];

                        $productExist = Post::join('products','products.post_id','=','posts.post_id')
                            ->select('posts.post_id', 'products.product_id')
                            ->where('posts.post_id', '=',$postId)->first();

                        if (empty($productExist)){
                            // thêm cho bảng post
                            $post = new Post();
                            $postId = $post->insertGetId([
                                'title' => $title,
                                'slug' => Ultility::createSlug($title),
                                'description' => $description,
                                'content' => $content,
                                'tags' => $tags,
                                'category_string' => $category_string,
                                'meta_title' => $meta_title,
                                'meta_description' => $meta_description,
                                'meta_keyword' => $meta_keyword,
                                'created_at' => new \DateTime(),
                                'updated_at' => new \DateTime(),
                            ]);
                            // thêm cho bảng product
                            $product = new Product();
                            $product->insert([
                                'post_id' => $postId,
                                'code' =>  $code,
                                'price' =>  $price,
                                'discount' =>  $discount,
                                'image_list' =>  $img
                            ]);
                            Input::saveInput('xuat-su', $postId, $xuatSu);
                            Input::saveInput('hang-san-xuat', $postId, $hangSanXuat);
                        } else {
                            // cập nhật bảng post
                            $postId = $productExist->post_id;
                            $post = Post::where('post_id', '=', $postId);
                            $post->update([
                                'title' => $title,
                                'slug' => Ultility::createSlug($title),
                                'description' => $description,
                                'content' => $content,
                                'tags' => $tags,
                                'category_string' => $category_string,
                                'meta_title' => $meta_title,
                                'meta_description' => $meta_description,
                                'meta_keyword' => $meta_keyword,
                                'created_at' => new \DateTime(),
                                'updated_at' => new \DateTime(),
                            ]);
                            // cập nhật bảng product
                            $productId = $productExist->product_id;
                            $product = Product::where('product_id', $productId);
                            $product->update([
                                'code' =>  $code,
                                'price' =>  $price,
                                'discount' =>  $discount,
                                'image_list' =>  $img
                            ]);
                            Input::saveInput('xuat-su', $postId, $xuatSu);
                            Input::saveInput('hang-san-xuat', $postId, $hangSanXuat);
                        }
                    }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi import sản phẩm: dữ liệu không hợp lệ.');
            Log::error('http->admin->productController->exportToExcel: Lỗi xảy ra trong quá trình import sản phẩm');
        } finally {
            return redirect('admin/products');
        }
    }

    public function getProductGetfly(Request $request) {
        try {
            DB::beginTransaction();
            $cateGetflies = $request->input('cate_getfly');
            $categoryProductBiz = new CategoryProductBiz();

            foreach ($cateGetflies as $cateGetfly) {
                $token = explode(',', $cateGetfly);
                $cateGetflyId = $token[0];
                $cateGetFlyName = $token[1];
                // Luu category
                $cateId = $categoryProductBiz->saveCateGetfy($cateGetflyId, $cateGetFlyName);
                // call api lấy sẩn phẩm trên getfly
                $callApi = new CallApi();
                $products = $callApi->getProduct([
                    'category_id' => $cateGetflyId
                ]);
                // luu san pham
                $productBiz = new ProductBiz();
                $productBiz->saveProductGetFly($products, $cateId, $cateGetFlyName);
            }
            // cap nhat lai id cho parent
            $categoryProductBiz->updateParentCateGetFly($cateGetflies);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi lấy sản phẩm từ getfly: dữ liệu không hợp lệ.');
            Log::error('http->admin->productController->getProductGetfly: Lỗi xảy ra trong quá trình lấy sản phẩm từ getfly');
        } finally {
            return redirect('admin/products');
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
