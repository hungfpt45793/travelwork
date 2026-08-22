<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Comment;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use Yajra\DataTables\DataTables;

class PageController extends AdminController
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
        return View('admin.page.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $templates = Template::getTemplate();

        // lọc bỏ những trường mà ko sử dụng trong post
        $typeInputs = $this->getTypeInputs();

        return view('admin.page.add', compact('templates', 'typeInputs', 'productList'));
    }

    private function getTypeInputs() {
        try {
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                ->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('page', $token)) {
                    $typeInputs[] = $typeInput;
                }
            }

            return $typeInputs;
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi lấy trường dữ liệu: trường dữ liệu không hợp lệ.');
            Log::error('http->admin->categoryController->getTypeInputs: Lỗi xảy ra khi lấy trường dữ liệu');

            return null;
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
            $userId = Auth::user()->id;

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            $post = new Post();
            $postId = $post->insertGetId([
                'title' => $request->input('title'),
                'post_type' => 'page',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'tags' => $request->input('tags'),
                'image' =>  $request->input('image'),
                'content' =>  $request->input('content'),
                'visiable' => 0,
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
                'product_list' => !empty($request->input('product_list')) ? implode(',', $request->input('product_list')) : '',
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

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
               ->get();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('page', $token)) {
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
            Error::setErrorMessage('Lỗi xảy ra khi thêm mới trang: dữ liệu không hợp lệ.');
            Log::error('http->admin->PageController->store: Lỗi xảy ra trong quá trình thêm mới trang');
        } finally {
            return redirect('admin/pages');
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
        try {
            $post = Post::where('post_id', $id)->first();

            $postExist = Post::where('post_id', $post->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/pages');
            }

            $templates = Template::orderBy('template_id')->get();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                ->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('page', $token)) {
                    $typeInputs[] = $typeInput;
                    $post[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
                }
            }

            return view('admin.page.edit', compact('templates', 'typeInputs', 'post'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa trang: dữ liệu không hợp lệ.');
            Log::error('http->admin->PageController->edit: Lỗi xảy ra trong quá trình chỉnh sửa trang');

            return redirect('admin/home');
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
        try {
            DB::beginTransaction();
            $post = Post::where('post_id', $id)->first();

            $postExist = Post::where('post_id', $post->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/pages');
            }

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            $post->update([
                'title' => $request->input('title'),
                'post_type' => 'page',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'tags' => $request->input('tags'),
                'image' =>  $request->input('image'),
                'content' =>  $request->input('content'),
                'visiable' => 0,
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
                'product_list' => !empty($request->input('product_list')) ? implode(',', $request->input('product_list')) : '',
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
                        'slug' => $slug.'-'.$post->post_id
                    ]);
            }

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            $input = new Input();
            $input->updateInput($typeInputDatabase, $request, $post->post_id, 'page');
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa trang: dữ liệu không hợp lệ.');
            Log::error('http->admin->PageController->update: Lỗi xảy ra trong quá trình chỉnh sửa trang');
        } finally {
            return redirect('admin/pages');
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
            DB::beginTransaction();
            $post = Post::where('post_id', $id)->first();

            $postExist = Post::where('post_id', $post->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/pages');
            }

            $posts = new Post();
            $posts->where('post_id', $post->post_id)
               ->delete();

            Comment::where('post_id', $post->post_id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi xóa trang: dữ liệu không hợp lệ.');
            Log::error('http->admin->PageController->destroy: Lỗi xảy ra trong quá trình xóa trang');
        } finally {
            return redirect('admin/pages');
        }
    }

    public function anyDatatables(Request $request) {

        $posts = Post::where('post_type', 'page')->select('posts.*');

        return Datatables::of($posts)
            ->addColumn('action', function($post) {
                $string =  '<a href="'.route('pages.edit', ['post_id' => $post->post_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('pages.destroy', ['post_id' => $post->post_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->orderColumn('post_id', 'post_id desc')
            ->make(true);
    }
}
