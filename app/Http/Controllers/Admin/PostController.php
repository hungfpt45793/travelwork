<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category_tag;
use App\Entity\Category;
use App\Entity\CategoryPost;
use App\Entity\Input;
use App\Entity\Notification_post;
use App\Entity\Post;
use App\Entity\Post_question;
use App\Entity\PostFacebook;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Facebook\Fanpage;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Ultility\CallApi;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Validator;
use Yajra\DataTables\DataTables;

class PostController extends AdminController
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
    public function index(Request $request)
    {
        $posts = $this->applyPostFilters(
            Post::where('post_type', 'post'),
            $request
        );

        $total_post = $posts->count();

        return View('admin.post.list', compact('total_post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // try {
            $category = new Category();
            $categories =$category->getCategory();
            $templates = Template::getTemplate();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('post', $token)) {
                    $typeInputs[] = $typeInput;
                }
            }

            $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'products.product_id',
                    'posts.*'
                )
                ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')->get();
        
//            $callApi = new CallApi();
//            $campaigns = $callApi->getCampaigns();
            $input_tags = Category_tag::all_tags_post();
            $categoryPost = [];
            // dd($input_tags);
            return view('admin.post.add', compact('categories', 'templates', 'typeInputs', 'productList', 'input_tags', 'categoryPost'));
        // } catch (\Exception $e) {
        //     Error::setErrorMessage('Lỗi xảy ra khi tạo mới bài viết: dữ liệu không hợp lệ.');
        //     Log::error('http->admin->PostController->create: Lỗi xảy ra trong quá trình tạo mới bài viết');

        //     return redirect('admin/home');
        // }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // try {
            DB::beginTransaction();
            // lấy user id
            $userId = Auth::user()->id;

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }

            // insert to database
            if (!empty($request->input('parents'))) {
                $categoriParents = Category::whereIn('category_id', $request->input('parents'))->get();
                $categories = array();
                foreach ($categoriParents as $cate) {
                    $categories[] =  $cate->title;
                }
            }
            $sale_money = 0;
            if(!empty($request->input('sale_money')))
            {
                $sale_money = $request->input('sale_money');
            }

            $noti_post = 0;
            if(!empty($request->input('noti_post')))
            {
                $noti_post = $request->input('noti_post');
            }
            $campain = $request->input('campain_getfly');
            $campains = explode('-', $campain);
            $campainCandidate = 0;
            $campainStatus = 0;
            if (count($campains) == 2 ) {
                $campainCandidate = $campains[0];
                $campainId = $campains[1];
                $callApi = new CallApi();
                $campaignStatusList = $callApi->getCampaignStatus($campainId);
                $campainStatus = isset($campaignStatusList['decode'][0]['opportunity_status_id']) ? $campaignStatusList['decode'][0]['opportunity_status_id'] : 0;
            }

            // thêm tag
            $tags = "";
            foreach ($request->input('tags') as $tag)
            {
                $tags .= $tag.',';
            }
            $tags = rtrim($tags, ",");
            // END thêm tag

            $post = new Post();
            $postId = $post->insertGetId([
                'title' => $request->input('title'),
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'tags' => $tags,
                'image' =>  $request->input('image'),
                'content' =>  $request->input('content'),
                'campain_getfly' =>  $campainCandidate,
                'campain_status' =>  $campainStatus,
                'form_status' =>  $request->input('form_status'),
                'visiable' => 0,
                'category_string' => !empty($categories) ? implode(',', $categories) : '',
                'meta_title' => $request->input('meta_title'),
                'sale_money' => $sale_money,
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
                'noti_post' => $noti_post,
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

            // insert danh mục cha
            $categoryPost = new CategoryPost();
            if (!empty($request->input('parents'))) {
                foreach($request->input('parents') as $parent) {
                    $categoryPost->insert([
                        'category_id' => $parent,
                        'post_id' => $postId,
                    ]);
                }
            }

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('post', $token)) {
                    $contentInput =  $request->input($typeInput->slug);
                    if(!in_array($typeInput->type_input, array('one_line', 'multi_line', 'image', 'editor'), true) && strpos($typeInput->type_input, 'listMultil') >= 0) {
                        $contentInput = ( !empty($contentInput) && count($contentInput) >= 1) ? implode(',', $contentInput) : $contentInput;
                    }
                    $input = new Input();
                    $input->insert([
                        'type_input_slug' => $typeInput->slug,
                        'content' => $contentInput,
                        'post_id' => $postId,
                    ]);
                }
            }
            if($noti_post == 1)
            {
                $post_noti  = Post::select('post_id',
                    'title',
                    'slug')->where('post_id',$postId)->first();
                $api_push_noti = new NotificationMobileController();
                $title = 'Sàn kế toán thông báo';
                $body = $post_noti->title;
                $type = 'post';
                $note = 'Bài viết trên  sanketoan $value slug bài viết';
                $value = $post_noti->slug;
                $to = '';
                $noti = new NotificationMobileController();
                $send = $noti->pushNotification( $title, $body, $to,$type,$note,$value);
//                ( $title = '', $body = '', $to = '',$type='',$note='',$value='')

                $insert_noti_post = Notification_post::insertGetId([
                    'noti_title' => $request->input('title'),
                    'post_id' => $postId,
                    'slug' => $post_noti->slug,
                    'created_at' => new \DateTime(),
                ]);
//                ECHO $insert_noti_post;DIE();
            }
            DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Error::setErrorMessage('Lỗi xảy ra khi tạo mới bài viết: dữ liệu không hợp lệ.');
        //     Log::error('http->admin->PostController->store: Lỗi xảy ra trong quá trình tạo mới bài viết');
        // } 
        // finally {
            return redirect('admin/posts');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        try {
            $postExist = Post::where('post_id', $post->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/posts');
            }

            $category = new Category();
            $categories =$category->getCategory();
            $templates = Template::orderBy('template_id')->get();
            // lọc bỏ những trường mà ko sử dụng trong post
            $typeInputDatabase = TypeInput::orderBy('type_input_id')
                ->get();
            $typeInputs = array();
            foreach($typeInputDatabase as $typeInput) {
                $token = explode(',', $typeInput->post_used);
                if (in_array('post', $token)) {
                    $typeInputs[] = $typeInput;
                    $post[$typeInput->slug] = Input::getPostMeta($typeInput->slug, $post->post_id);
                }
            }
            $categoryPosts = CategoryPost::where('post_id', $post->post_id)
                ->get();
            $categoryPost = array();
            foreach($categoryPosts as $cate ) {
                $categoryPost[] = $cate->category_id;
            }

            $productList = Post::join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'products.product_id',
                    'posts.*'
                )
                ->where('post_type', 'product')
                ->orderBy('posts.post_id', 'desc')
                ->get();

            // Tích hợp GetFly hiện đang tắt, nhưng view vẫn cần biến này.
            $campaigns = [];
            $input_tags = Category_tag::all_tags_post();
            return view('admin.post.edit', compact(
                'categories',
                'templates',
                'typeInputs',
                'post',
                'categoryPost',
                'productList',
                'campaigns',
                'input_tags'
            ));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->PostController->edit: Lỗi xảy ra trong quá trình chỉnh sửa bài viết');

            return redirect('admin/home');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // try {
            DB::beginTransaction();
            $postExist = Post::where('post_id', $post->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/posts');
            }

            // if slug null slug create as title
            $slug = $request->input('slug');
            if (empty($slug)) {
                $slug = Ultility::createSlug($request->input('title'));
            }
            // update to database
            if (!empty($request->input('parents'))) {
                $categoriParents = Category::whereIn('category_id', $request->input('parents'))->get();
                $categories = array();
                foreach ($categoriParents as $cate) {
                    $categories[] =  $cate->title;
                }
            }
            $sale_money = 0;
            if(!empty($request->input('sale_money')))
            {
                $sale_money = $request->input('sale_money');
            }
            $noti_post = 0;
            if(!empty($request->input('noti_post')))
            {
                $noti_post = $request->input('noti_post');
            }
            $campain = $request->input('campain_getfly');
            $campains = explode('-', $campain);
            $campainCandidate = 0;
            $campainStatus = 0;
            if (count($campains) == 2 ) {
                $campainCandidate = $campains[0];
                $campainId = $campains[1];
                $callApi = new CallApi();
                $campaignStatusList = $callApi->getCampaignStatus($campainId);
                $campainStatus = isset($campaignStatusList['decode'][0]['opportunity_status_id']) ? $campaignStatusList['decode'][0]['opportunity_status_id'] : 0;
            }

            $tags = "";
            foreach ($request->input('tags') as $tag)
            {
                $tags .= $tag.',';
            }
            $tags = rtrim($tags, ",");

            $post->update([
                'title' => $request->input('title'),
                'post_type' => 'post',
                'template' =>  $request->input('template'),
                'description' => $request->input('description'),
                'tags' => $tags,
                'image' =>  $request->input('image'),
                'content' =>  $request->input('content'),
                'form_status' =>  $request->input('form_status'),
                'sale_money' =>  $sale_money,
                'visiable' => 0,
                'campain_getfly' =>  $campainCandidate,
                'campain_status' =>  $campainStatus,
                'category_string' => !empty($categories) ? implode(',', $categories) : '',
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
                'product_list' => !empty($request->input('product_list')) ? implode(',', $request->input('product_list')) : '',
                'noti_post' => $noti_post,
            ]);
            // insert danh mục cha
            $categoryPost = new CategoryPost();
            $categoryPost->where('post_id', $post->post_id)
                ->delete();
            if (!empty($request->input('parents'))) {
                foreach($request->input('parents') as $parent) {
                    $categoryPost->insert([
                        'category_id' => $parent,
                        'post_id' => $post->post_id,
                    ]);
                }
            }

            // insert input
            $typeInputDatabase = TypeInput::orderBy('type_input_id')->get();
            $input = new Input();
            $input->updateInput($typeInputDatabase, $request, $post->post_id);
            DB::commit();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa bài viết: dữ liệu không hợp lệ.');
        //     Log::error('http->admin->PostController->update: Lỗi xảy ra trong quá trình chỉnh sửa bài viết');
        // } finally {
            return redirect('admin/posts');
        // }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        try {
            DB::beginTransaction();
            $postExist = Post::where('post_id', $post->post_id)->exists();
            if (!$postExist) {
                return redirect('admin/posts');
            }

            $posts = new Post();
            $posts->where('post_id', $post->post_id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi xóa bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->PostController->destroy: Lỗi xảy ra trong quá trình xóa bài viết', [
                'post_id' => $post->post_id,
                'exception' => $e,
            ]);
        } finally {
            return redirect('admin/posts');
        }
    }
    public function add_question(Request $request ,$post_id)
    {
        $post_question_model = new Post_question();
        $list_post_question = $post_question_model->select('*')->where('post_id',$post_id)->orderBy('post_ques_id','asc')->get();
        $post = Post::select('*')->where('post_id',$post_id)->first();
        return view('admin.post.add_question',compact('post','list_post_question'));
    }
    public function store_question(Request $request)
    {

        $post_question_model = new Post_question();
        $insert = $post_question_model->insert([
           'post_id'=> $request->input('post_id'),
           'post_ques'=> $request->input('question'),
           'post_answer'=> $request->input('answer'),
            'created_at'=> new \DateTime()
        ]);
        $post = Post::where('post_id',$request->input('post_id'))->update([
            'post_question' => 1
        ]);
        return redirect(route('add_question',['post_id'=> $request->input('post_id')]));
    }
    public function update_question(Request $request)
    {

        $post_question_model = new Post_question();
        $update = $post_question_model->where('post_ques_id',$request->input('post_ques_id'))->update([
           'post_ques'=> $request->input('question'),
           'post_answer'=> $request->input('answer'),
            'updated_at'=> new \DateTime()
        ]);
        return redirect(route('add_question',['post_id'=> $request->input('post_id')]));
    }
    public function delete_question(Request $request,$post_ques_id)
    {
        $post_question_model = new Post_question();
        $post_question = $post_question_model->select('*')->where('post_ques_id',$post_ques_id)->first();
        $update = $post_question_model->where('post_ques_id',$post_ques_id)->delete();

        $count = Post_question::where('post_id',$post_question->post_id)->count();
        if(empty($count))
        {
            $post = Post::where('post_id',$post_question->post_id)->update([
                'post_question' => 0
            ]);
        }
        return redirect(route('add_question',['post_id'=> $post_question->post_id]));
    }
    public function edit_question(Request $request ,$post_ques_id)
    {

        $post_question_model = new Post_question();
        $post_question = $post_question_model->select('*')->where('post_ques_id',$post_ques_id)->first();
        $list_post_question = $post_question_model->select('*')->where('post_id',$post_question->post_id)->orderBy('post_ques_id','asc')->get();
        $post = Post::select('*')->where('post_id',$post_question->post_id)->first();
        return view('admin.post.edit_question',compact('post','list_post_question','post_question'));
    }
    public function visiable(Request $request) {
        $visiable = $request->input('visiable');
        $postId = $request->input('post_id');
        
        Post::where('post_id', $postId)->update([
            'visiable' => $visiable
        ]);

        return response([
            'status' => 200
        ])->header('Content-Type', 'text/plain');
    }
    
    public function anyDatatables(Request $request) {
        $posts = $this->applyPostFilters(
            Post::where('post_type', 'post')->select('posts.*'),
            $request
        );

        return Datatables::of($posts)
           ->addColumn('action', function($post) {
               $string = '<input type="checkbox" class="flat-red" onclick="return visiablePost(this); " value="'.$post->post_id.'"'.( ($post->visiable == 0 || $post->visiable == null ) ? 'checked' : '' ).'/> Hiện ';
               $string .=  '<a href="'.route('posts.edit', ['post' => $post->post_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
               $string .= '<a  href="'.route('posts.destroy', ['post' => $post->post_id]).'" class="btn btn-danger btnDelete"
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
               return $string;
           })
            ->orderColumn('post_id', 'post_id desc')
           ->make(true);
    }

    private function applyPostFilters($posts, Request $request)
    {
        if ($request->filled('post_question')) {
            $posts->where('post_question', $request->input('post_question'));
        }

        if ($request->filled('title')) {
            $posts->where('title', 'like', '%' . trim($request->input('title')) . '%');
        }

        if ($request->filled('sale_money')) {
            $posts->where('sale_money', $request->input('sale_money'));
        }

        return $posts;
    }
}
