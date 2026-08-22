<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Comment;
use App\Entity\Post;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;
use App\Ultility\Error;

class CommentController extends AdminController
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

            view()->share('menuTop', 'customers');

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
        $comments = Comment::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('jobs', 'jobs.job_id', '=', 'comments.job_id')
            ->where('parent', '<', 1)
            ->select(
                'jobs.title',
                'users.name',
                'users.image',
                'comments.*'
            )->paginate(10);

        $commentShow = Comment::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('jobs', 'jobs.job_id', '=', 'comments.job_id')
            ->where('parent', '<', 1)
            ->select(
                'jobs.title',
                'jobs.job_id',
                'users.name',
                'users.id as user_id',
                'users.image',
                'comments.*'
            );

        if ($request->has('comment_id')) {
            $commentShow->where('comment_id', $request->input('comment_id'));
        }

        $commentShow = $commentShow->first();

        $commentChildrens = Comment::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('jobs', 'jobs.job_id', '=', 'comments.job_id')
            ->where('parent', $commentShow->comment_id)
            ->select(
                'jobs.title',
                'users.name',
                'users.id as user_id',
                'users.image',
                'comments.*'
            )->get();

        return view('admin.comment.index', compact('comments', 'commentShow', 'commentChildrens'));
    }
    public function anyDatatables(Request $request) {
        $comments = Comment::leftJoin('users', 'users.id', '=', 'comments.user_id')
            ->leftJoin('posts', 'posts.post_id', '=', 'comments.post_id')
            ->select(
                'posts.title',
                'users.name',
                'comments.*'
            );

        return Datatables::of($comments)
            ->addColumn('action', function($comment) {
                $string =  '<a href="'.route('comments.edit', ['comment_id' => $comment->comment_id]).'">
                           <button class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                       </a>';
                $string .= '<a  href="'.route('comments.destroy', ['comment_id' => $comment->comment_id]).'" class="btn btn-danger btnDelete" 
                            data-toggle="modal" data-target="#myModalDelete" onclick="return submitDelete(this);">
                               <i class="fa fa-trash-o" aria-hidden="true"></i>
                            </a>';
                
                return $string;
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $userModel = new User();
            $commentModel = new Comment();
            $postModel = new Post();

            $users = $userModel->get();

            $comments = $commentModel->get();

            $posts = $postModel->get();

            return view('admin.comment.add', compact('users', 'comments', 'posts'));

        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới bình luận: dữ liệu không hợp lệ.');
            Log::error('http->admin->CommentController->create: Lỗi xảy ra trong quá trình tạo mới bình luận');

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
            $commentModel = new Comment();
            $commentModel->insert([
                'parent' => $request->input('parent'),
                'content' => $request->input('content'),
                'user_id' => 1,
                'job_id' => $request->input('job_id'),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime()
            ]);

            return response([
                'status' => 200,
                'content' =>  $request->input('content'),
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi tạo mới bình luận: dữ liệu không hợp lệ.');
            Log::error('http->admin->CommentController->store: Lỗi xảy ra trong quá trình tạo mới bình luận');

            return response([
                'status' => 500,
            ])->header('Content-Type', 'text/plain');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entity\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entity\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        $userModel = new User();
        $commentModel = new Comment();
        $postModel = new Post();

        $users = $userModel->get();

        $comments = $commentModel->get();

        $posts = $postModel->get();

        return view('admin.comment.edit', compact('comment', 'users', 'comments', 'posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entity\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        try {
            $comment->update([
                'parent' => $request->input('parent'),
                'content' => $request->input('content'),
                'user_id' => $request->input('user_id'),
                'post_id' => $request->input('post_id'),
            ]);

            return redirect(route('comments.index'));
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi cập nhật bình luận: dữ liệu cập nhật không hợp lệ.');
            Log::error('http->Admin->CommentController->update: Lỗi xảy ra trong quá trình update');

            return redirect(route('comments.index'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entity\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        try {
            $comment->delete();

            return redirect('admin/comments');
        } catch (\Exception $e) {
            Error::setErrorMessage('Lỗi xảy ra khi xóa bình luận: dữ liệu xóa không hợp lệ.');
            Log::error('http->Admin->CommentController->destroy: Lỗi xảy ra khi xóa comment');

            return redirect('admin/comments');
        }
    }

    public function randomComment() {
        $commentModel = new Comment();
        $postModel = new Post();

        // lấy hết tất cả comment tự tạo
        $comments = $commentModel
            ->where('post_id', 0)
            ->where('parent', 0)
            ->get();
        // get commentIds để random
        $commentRandomIds = array();
        $commentByIds = array();
        foreach ($comments as $comment) {
            $commentRandomIds[] = $comment->comment_id;
            $commentChilds = $commentModel
                ->where('post_id', 0)
                ->where('parent', $comment->comment_id)
                ->get();
            $comment->children = $commentChilds;

            $commentByIds[$comment->comment_id] = $comment;
        }

        $posts = $postModel->select('post_id')
            ->where('post_type', 'product')
            ->get();

        foreach ($posts as $post) {
            // check xem post có comment chưa
            $commentPostIdt = $commentModel
                ->where('post_id', $post->post_id)
                ->first();
            if (!empty($commentPostIdt)) {
                continue;
            }

            $randComments = array_rand($commentRandomIds, 8);
            foreach ($randComments as $randComment) {
                // random ngayf thang
                $start = strtotime("10 September 2016");
                $end = strtotime("22 July 2018");
                $timestamp = mt_rand($start, $end);

                $commentId = $commentRandomIds[$randComment];
                $commentParentID = $commentModel->insertGetId([
                    'content' => $commentByIds[$commentId]->content,
                    'user_id' => $commentByIds[$commentId]->user_id,
                    'created_at' => date("Y-m-d", $timestamp),
                    'updated_at' => date("Y-m-d", $timestamp),
                    'post_id' => $post->post_id,
                    'parent' => 0
                ]);
                // insert childComment
                foreach ($commentByIds[$commentId]->children as $childComment) {
                    $commentModel->insert([
                        'content' => $childComment->content,
                        'user_id' => $childComment->user_id,
                        'created_at' => date("Y-m-d", $timestamp),
                        'updated_at' => date("Y-m-d", $timestamp),
                        'post_id' => $post->post_id,
                        'parent' => $commentParentID
                    ]);
                }
            }
        }

        return redirect(route('comments.index'));
    }

    public function randomCommentFromForm(Request $request) {
        $contentComments = $request->input('content_comment');
        $postModel = new Post();
        $commentModel = new Comment();
        $userModel = new User();

        // lấy hết tất cả comment tự tạo
        $comments = explode(';', $contentComments);

        if (count($comments) < 2) {
            return redirect(route('comments.index'));
        }

        $posts = $postModel->select('post_id')
            ->where('post_type', 'product')
            ->get();

        $users = $userModel->select('id')
            ->where('role', '<', 3)
            ->get();

        $userRandoms = array();
        foreach ($users as $user) {
            $userRandoms[] = $user->id;
        }
        foreach ($posts as $post) {
            // check xem post có comment chưa
            $commentPostIdt = $commentModel
                ->where('post_id', $post->post_id)
                ->first();

            if (!empty($commentPostIdt)) {
                continue;
            }

            $randComments = array_rand($comments, rand(2, count($comments)  ));
            foreach ($randComments as $randComment) {
                $userRandom = array_rand($userRandoms, 1);
                // random ngayf thang
                $start = strtotime("10 September 2016");
                $end = strtotime("22 July 2018");
                $timestamp = mt_rand($start, $end);

                $commentParentID = $commentModel->insertGetId([
                    'content' => $comments[$randComment],
                    'user_id' => $userRandoms[$userRandom],
                    'created_at' => date("Y-m-d", $timestamp),
                    'updated_at' => date("Y-m-d", $timestamp),
                    'post_id' => $post->post_id,
                    'parent' => 0
                ]);
            }
        }

        return redirect(route('comments.index'));

    }
}
