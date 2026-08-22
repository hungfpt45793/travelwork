<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Entity\Category_tag;
use App\Entity\Post;
use App\Entity\CategoryPost;
use App\Entity\Category;
use App\Entity\TypeInput;
use App\Entity\Template;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Ultility\Ultility;
use App\Entity\Input;
use App\Entity\Post_question;
use App\Http\Controllers\Api\NotificationMobileController;
use App\Entity\Notification_post;
use App\Ultility\Error;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Site\CkedittorController;


class PostController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->id_user = Auth::id();
            $ckeditor = new CkedittorController();
            $session_image = $ckeditor->checkImage();
            view()->share('menuTop', 'article');
            return $next($request);
        });
    }
    public function index(Request $request)
    {

        $total_post = 0;
        $posts = Post::where('post_type', 'post');
        // tìm theo id bai viết
        if (!empty($request->post_id)) {
            $posts = $posts->where('posts.post_id', $request->post_id);
        }
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            // dd($date_search_start);
            $posts = $posts->whereDate('updated_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $posts = $posts->whereDate('updated_at', '<=', $request->date_search_end);
        }
        if(!empty($request->post_question)) {
            $posts = $posts->where('post_question', $request->post_question);
        }
        if(!empty($request->title)) {
            $posts = $posts->where('title', $request->title);
        }
        if(!empty($request->input('sale_money')))
        {
            $posts = $posts->where('sale_money', $request->input('sale_money'));
        }
        $posts = $posts->orderBy('posts.post_id','desc');
        $total_post = $posts->count();
        $num = 20;
        if(!empty($request->num)){
            $num = 20;
        }
        $posts = $posts->paginate($request->num);
        $posts->appends(request()->query());
        return view('staff_admin.news_article.list',compact('posts','total_post'));
    }


    public function create()
    {
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
            return view('staff_admin.news_article.create', compact('categories', 'templates', 'typeInputs', 'productList', 'input_tags'));
    }


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

            $tags = "";
            foreach ($request->input('tags') as $tag)
            {
                $tags .= $tag.',';
            }
            $tags = rtrim($tags, ",");

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
        // } finally {
            return redirect('staff/staff_article');
        // }
    }


    public function show($id)
    {
        //
    }


    public function edit($id)
    {
    //    try{
        $post = Post::where('post_id', $id)->first();
            $category = new Category();
            $categories =$category->getCategory();
            $templates = Template::orderBy('template_id')->get();
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

//            $callApi = new CallApi();
//            $campaigns = $callApi->getCampaigns();
            $input_tags = Category_tag::all_tags_post();
            return view('staff_admin.news_article.edit', compact(
                'categories',
                'templates',
                'typeInputs',
                'post',
                'categoryPost',
                'productList',
                'input_tags'
            ));
        // } catch (\Exception $e) {
        //     Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa bài viết: dữ liệu không hợp lệ.');
        //     Log::error('http->admin->PostController->edit: Lỗi xảy ra trong quá trình chỉnh sửa bài viết');

        //     return redirect('admin/home');
        // }
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            // $postExist = Post::where('post_id', $post->post_id)->exists();
            // if (!$postExist) {
            //     return redirect('admin/posts');
            // }

            // if slug null slug create as title
            $post = Post::where('post_id',$id)->first();

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

            // insert slug
            $postWithSlug = Post::where('slug', $slug)
                ->where('post_id', '!=', $post->post_id)
                ->first();

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
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi chỉnh sửa bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->PostController->update: Lỗi xảy ra trong quá trình chỉnh sửa bài viết');
        } finally {
            return redirect('staff/staff_article');
        }

    }

    public function destroy($id)
    {

        try {
            DB::beginTransaction();
            // $postExist = Post::where('post_id', $post->post_id)->exists();
            // if (!$postExist) {
            //     return redirect('admin/posts');
            // }

            $posts = new Post();
            $posts->where('post_id', $id)->delete();

            Comment::where('post_id', $id)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            Error::setErrorMessage('Lỗi xảy ra khi xóa bài viết: dữ liệu không hợp lệ.');
            Log::error('http->admin->PostController->destroy: Lỗi xảy ra trong quá trình xóa bài viết');
        } finally {
            return redirect('staff/staff_article');
        }
    }
    public function add_question(Request $request ,$post_id)
    {
        $post_question_model = new Post_question();
        $list_post_question = $post_question_model->select('*')->where('post_id',$post_id)->orderBy('post_ques_id','asc')->get();
        $post = Post::select('*')->where('post_id',$post_id)->first();
        return view('staff_admin.news_article.add_question',compact('post','list_post_question'));
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
        return redirect()->back();
    }
    public function update_question(Request $request)
    {

        $post_question_model = new Post_question();
        $update = $post_question_model->where('post_ques_id',$request->input('post_ques_id'))->update([
           'post_ques'=> $request->input('question'),
           'post_answer'=> $request->input('answer'),
            'updated_at'=> new \DateTime()
        ]);
        return redirect(route('staff_add_question',['post_id'=> $request->input('post_id')]));
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
        return redirect()->back();
    }
    public function edit_question(Request $request ,$post_ques_id)
    {

        $post_question_model = new Post_question();
        $post_question = $post_question_model->select('*')->where('post_ques_id',$post_ques_id)->first();
        $list_post_question = $post_question_model->select('*')->where('post_id',$post_question->post_id)->orderBy('post_ques_id','asc')->get();
        $post = Post::select('*')->where('post_id',$post_question->post_id)->first();
        return view('staff_admin.news_article.edit_question',compact('post','list_post_question','post_question'));
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            Post::where('post_id', $arrid)->delete();
        }

        return response()->json(['success'=>"Xóa thành công!!!"]);
    }

    public function deleteHardAllPost(Request $request)
    {
        // dd(1);
        $ids = $request->Ids;
        $arrids = explode(",", $ids);
        foreach ($arrids as $arrid) {
            Post::onlyTrashed()->where('post_id', $arrid)->forceDelete();
        }
        return response()->json(['success'=>"Xóa hẳn thành công!!!"]);
    }

    public function staff_article_delete(Request $request)
    {
        $total_post = 0;
        $posts = Post::where('post_type', 'post');
        if(!empty($request->date_search_start) ){
            $date_start=date_create($request->date_search_start);
            $date_search_start = date_format($date_start,"Y/m/d");
            // dd($date_search_start);
            $posts = $posts->whereDate('updated_at', '>=', $request->date_search_start);
        }
        if(!empty($request->date_search_end)){
            $date_end=date_create($request->date_search_end);
            $date_search_end = date_format($date_end,"Y/m/d");
            $posts = $posts->whereDate('updated_at', '<=', $request->date_search_end);
        }
        if(!empty($request->post_question)) {
            $posts = $posts->where('post_question', $request->post_question);
        }
        if(!empty($request->title)) {
            $posts = $posts->where('title', $request->title);
        }
        if(!empty($request->input('sale_money')))
        {
            $posts = $posts->where('sale_money', $request->input('sale_money'));
        }
        $posts = $posts->orderBy('posts.post_id','desc');
        $total_post = $posts->count();
        $num = 20;
        if(!empty($request->num)){
            $num = 20;
        }
        $posts = $posts->onlyTrashed();
        $posts = $posts->paginate($request->num);
        $posts->appends(request()->query());
        return view('staff_admin.news_article.list_delete',compact('posts','total_post'));
    }
    public function delete_hard_post($id)
    {
        Post::onlyTrashed()->where('post_id', $id)->forceDelete();
        return redirect()->back()->with('success', 'Xóa hẳn thành công!');
    }
    public function reset_post($id)
    {
        Post::where('post_id', $id)->restore();
        return redirect()->back()->with('success', 'Reset thành công!');
    }
    public function dashboard(){
        return view('staff_admin.dashboard.dashboardArticle',compact(''));
    }
}
