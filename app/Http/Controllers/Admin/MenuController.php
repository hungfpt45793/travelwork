<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\Menu;
use App\Entity\MenuElement;
use App\Entity\Post;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Location;
use Illuminate\Http\Request;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;

class MenuController extends AdminController
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
            $menus = Menu::orderBy('menu_id', 'desc')
                ->get();

            return View('admin.menu.list', compact('menus'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi hiển thị menu: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->index: Lỗi xảy tra trong quá trình lấy dữ liệu menu');
            $menus = null;
        } finally {
            return View('admin.menu.list', compact('menus'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $location = new Location();
        $locationMenus = $location->getLocationMenu();

        return View('admin.menu.add', compact('locationMenus'));
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
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            // insert to database
            $menu = new Menu();
            $menu->insert([
                'title' => $request->input('title'),
                'slug' => $slug,
                'image' => $request->input('image'),
                'location' => $request->input('location'),
            ]);
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới menu: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->store: Lỗi xảy tra trong quá trình thêm mới menu');
        } finally {
            return redirect('admin/menus');
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

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu  $menu)
    {
        $category = new Category();
        /* ==== get all post ==== */
        // get category of post
        $postCategories = $category->getCategory();
        // get all Post
        $posts = $this->getPosts();

        /* ==== get all product === */
        // get category of product
        $productCategories =$category->getCategory('product');
        // get all product
        $products = $this->getProducts();

        /* ==== get all sub post ==== */
        // get all sub post
        $typeSubPosts = $this->getTypeSubPosts();
        $subPosts = $this->getSubPost($typeSubPosts);

        // lấy ra trang
        $pages = $this->getPage();

        $location = new Location();
        $locationMenus = $location->getLocationMenu();
        
        return View('admin.menu.edit', compact(
            'menu',
            'postCategories',
            'posts',
            'productCategories',
            'products',
            'typeSubPosts',
            'subPosts',
            'locationMenus',
            'pages'
            )
        );
    }

    private function getPosts() {
        try {
            $posts = Post::where('post_type', 'post')
                ->orderBy('post_id', 'desc')
                ->get();

            return $posts;
        } catch(\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy bài viết: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->getPosts: Lỗi xảy ra khi lấy bài viết');
        }
    }

    private function getProducts() {
        try {
            $products = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'products.product_id',
                    'title',
                    'slug',
                    'image'
                )
                ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();

            return $products;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy sản phẩm: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->getProducts: Lỗi xảy ra khi lấy sản phẩm');

            return null;
        }
    }

    private function getTypeSubPosts() {
        try {
            $typeSubPosts = TypeSubPost::orderBy('type_sub_post_id', 'desc')
                ->get();

            return $typeSubPosts;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy dạng bài viết: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->getTypeSubPosts: Lỗi xảy ra khi lấy dạng bài viết');

            return null;
        }
    }

    private function getSubPost($typeSubPosts) {
        try {
            $subPosts = array();
            foreach ($typeSubPosts as $typeSubPost) {
                $subPosts[$typeSubPost->slug] = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                    ->select(
                        'sub_post.sub_post_id',
                        'posts.post_id',
                        'title',
                        'slug',
                        'image'
                    )
                    ->where('post_type', $typeSubPost->slug)->orderBy('posts.post_id', 'desc')->get();
            }

            return $subPosts;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy dạng bài viết: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->getSubPost: Lỗi xảy ra khi lấy dạng bài viết');

            return null;
        }
    }

    private function getPage() {
        try {
            $pages = Post::where('post_type', 'page')
                ->get();

            return $pages;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy trangt: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->getPage: Lỗi xảy ra khi lấy trang');

            return null;
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu  $menu)
    {
        try {
            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            // insert to database
            $menu->update([
                'title' => $request->input('title'),
                'slug' => $slug,
                'image' =>  $request->input('image'),
                'location' =>  $request->input('location'),
            ]);

            $menuElement = new MenuElement();
            $menuElement->updateMenuElement(
                $menu->slug,
                $request->input('url'),
                $request->input('title_show'),
                $request->input('menu_level'),
                $request->input('menu_image')
            );

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa menu: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->update: Lỗi xảy tra trong quá trình cập nhật menu');
        } finally {
            return redirect('admin/menus');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu  $menu)
    {
        try {

            $menuElement = new MenuElement();
            $menuElement->where('menu_slug', $menu->slug)
                ->delete();

            $menus = new Menu();
            $menus->where('menu_id', $menu->menu_id)->delete();
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa menu: dữ liệu hợp lệ.');
            Log::error('http->admin->MenuController->destroy: Lỗi xảy tra trong quá trình xóa menu');
        } finally {
            return redirect('admin/menus');
        }

    }
}
