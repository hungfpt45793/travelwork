<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category_tag;
use App\Entity\Post;
use App\Entity\SubPost;
use App\Entity\TypeSubPost;
use App\Entity\User;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use App\Ultility\Ultility;
use App\Entity\Template;
use App\Entity\Input;
use App\Entity\TypeInput;
use Yajra\DataTables\DataTables;

class SubPostController extends AdminController
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
     * @param  string  $typePost
     * @return \Illuminate\Http\Response
     */
    public function index($typePost)
    {

        return View('admin.sub_post.list', compact('typePost'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  string  $typePost
     * @return \Illuminate\Http\Response
     */
    public function create($typePost)
    {
        try {
            $templates = Template::orderBy('template_id')->get();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array($typePost, $token)) {
                    $typeInputs[] = $typeInput;
                }
            }

            $typeSubPost = TypeSubPost::where('slug', $typePost)->first();
            return view('admin.sub_post.add', compact('templates', 'typeInputs', 'typePost', 'typeSubPost'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubPostController->create: Lỗi xảy ra trong quá trình tạo mới bài viết');

            return redirect('admin/home');
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  string  $typePost
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $typePost)
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
            
            // insert to database
            $post = new Post();
            $postId = $post->insertGetId([
                'title' => $request->input('title'),
                'post_type' => $typePost,
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'image' =>  $request->input('image'),
                'content' =>  $request->input('content')
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
                        'slug' => $slug.'-'.$postId,
                    ]);
            }

            $subPost = new SubPost();
            $subPost->insert([
                'post_id' => $postId,
                'type_sub_post_slug' => $typePost,
            ]);

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array($typePost, $token)) {
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
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubPostController->store: Lỗi xảy ra trong quá trình tạo mới dạng bài viết');
        } finally {
            return redirect(route('sub-posts.index', ['typePost' => $typePost]));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $typePost
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function show($subPost, $typePost)
    {
        return redirect(route('sub-posts.index', ['typePost' => $typePost]));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string  $typePost
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function edit($typePost, SubPost $subPost )
    {
        try {
            $post = Post::where('post_id', $subPost->post_id)->first();

            $templates = Template::orderBy('template_id')->get();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();

            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array($typePost, $token)) {
                    $typeInputs[] = $typeInput;
                    $post[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
                }
            }

            $typeSubPost = TypeSubPost::where('slug', $typePost)->first();

            return view('admin.sub_post.edit', compact('templates', 'typeInputs', 'post', 'typePost', 'typeSubPost', 'subPost'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubPostController->edit: Lỗi xảy ra trong quá trình chỉnh sửa dạng bài viết');

            return redirect('admin/home');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $typePost
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $typePost, SubPost $subPost )
    {
        try {
            DB::beginTransaction();
            $userId = 0;
            $post = Post::where('post_id', $subPost->post_id)->first();

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            // update to database
            // lấy ra danh mục cha
            $post->update([
                'title' => $request->input('title'),
                'post_type' => $typePost,
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'image' =>  $request->input('image'),
                'content' =>  $request->input('content'),
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
            $input->updateInput($typeInputDatabase, $request, $post->post_id, $typePost);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubPostController->update: Lỗi xảy ra trong quá trình chỉnh sửa dạng bài viết');
        } finally {
            return redirect(route('sub-posts.index', ['typePost' => $typePost]));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $typePost
     * @param  \App\Entity\SubPost  $subPost
     * @return \Illuminate\Http\Response
     */
    public function destroy($typePost, SubPost $subPost )
    {
        try {
            DB::beginTransaction();
            
            Input::where('post_id', $subPost->post_id)->delete();
            Post::where('post_id', $subPost->post_id)->delete();
            SubPost::where('sub_post_id', $subPost->sub_post_id)
                ->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi xóa dạng bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->SubPostController->destroy: Lỗi xảy ra trong quá trình xóa dạng bài viết');
        } finally {
            return redirect(route('sub-posts.index', ['typePost' => $typePost]));
        }
    }
    public function anyDatatables(Request $request, $typePost) {
        $posts = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
            ->select(
                'sub_post.sub_post_id',
                'posts.*'
            )
            ->where('post_type', $typePost)->orderBy('posts.post_id', 'desc');

        return Datatables::of($posts)
            ->addColumn('action', function($post) {
                $string =  '<a href="'.route('sub-posts.edit', ['typePost' => $post->post_type, 'sub_post_id' => $post->sub_post_id ]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('sub-posts.destroy', ['typePost' => $post->post_type, 'sub_post_id' => $post->sub_post_id ]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                return $string;
            })
            ->make(true);
    }
}
