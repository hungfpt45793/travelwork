<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/1/2017
 * Time: 2:17 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Comment;
use App\Entity\Notification;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Post;
use App\Entity\Product;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;

class CommentController extends SiteController
{
     public function index(Request $request){
         // chech xem co ton tai message comment không
         if (empty($request->input('message'))) {
             return response('Message is not null', 404)
                 ->header('Content-Type', 'text/plain');
         }

         // lay du lieu tu request
         $parent = $request->input('parent');
         $jobId = $request->input('job_id');
         $message = $request->input('message');
         $userId = $request->input('user_id');
         $commentId = $request->input('comment_id');
         $commentName = $request->input('name');
         $commentPhone = $request->input('phone');
         $commentEmail = $request->input('email');


         // luu comment
         $commentModel = new Comment();
         $comment = $commentModel->where('comment_id', $commentId)->first();
         if (!empty($comment)) {
             $comment->update([
                 'job_id' => $jobId,
                 'parent' => $parent,
                 'content' => $message,
                 'user_id' => $userId,
                 'created_at' => date("y/m/d"),
             ]);

             return response([
                 'status' => 200,
                 'comment_id' => $commentId,
             ])->header('Content-Type', 'text/plain');
         }

         $commentId = $commentModel->insertGetId([
             'job_id' => $jobId,
             'parent' => $parent,
             'content' => $message,
             'customer_name' => $commentName,
             'customer_email' => $commentEmail,
             'customer_phone' => $commentPhone,
             'user_id' => $userId,
             'created_at' => date("y/m/d"),
         ]);

         // luu thong bao trong admin
//        $notification = new Notification();
//        $notification->insert([
//           'title'=>'Bình luận',
//           'content'=>Auth::check() ? Auth::user()->name . ' Đã bình luận về bài viết': 'Một người lạ đã bình luận về bài viết' ,
//            'status' => '0',
//            'url' => route('virtural_comment'),
//            'theme_code' => $this->themeCode,
//            'user_email' => $this->emailUser,
//            'created_at' => new \DateTime(),
//            'updated_at' => new \DateTime()
//        ]);


        // tra ve ket qua
         return response([
             'status' => 200,
             'comment_id' => $commentId,
         ])->header('Content-Type', 'text/plain');
     }
    public function delete(Request $request){
         // lay du lieu tu brower truyen len
        $commentId = $request->input('comment_id');

        // xóa bỏ comment
        Comment::where('comment_id', $commentId)->delete();
        Comment::where('parent', $commentId)->delete();

        return response([
            'status' => 200,
            'comment_id' => $commentId,
        ])->header('Content-Type', 'text/plain');
        // quay trả về trang cũ
    }

    public function edit(Request $request) {
        $commentId = $request->input('comment_id');
        $message = $request->input('message');

        Comment::where('comment_id', $commentId)->update([
            'content' => $message,
            'theme_code' => $this->themeCode,
            'user_email' => $this->emailUser,
        ]);

        return response([
            'status' => 200,
        ])->header('Content-Type', 'text/plain');
    }

    public function virtural(){
        $random =rand(10,100);
        // nếu radom là số lẻ thì lấy order
        if ($random %2 == 1) {
            $product = Product::join('posts', 'products.post_id', '=', 'posts.post_id')
                    ->select(
                        'products.product_id',
                        'posts.*',
                        'products.price',
                        'products.discount',
                        'products.price_deal'
                    )
                ->orderBy(DB::raw('RAND()'))
                ->first();
            $url = route('product', [ 'post_slug' => $product->slug]);
            $img = '<a href="'.$url.'"><img src="'. asset($product->image) .'" width="50"/></a>';
            $price = 0;
            if (!empty($product->price_deal)) {
                $price = $product->price_deal;
            }
            elseif (!empty($product->discount)) {
                $price = $product->discount;
            } else {
                $price = $product->price;
            }
            $content = '<a href="'.$url.'">'.$product->title.'</a><br> Một ai đó vừa mua sản phẩm này chỉ với giá: <div class="priceDiscount">'.number_format($price  , 0, ',', '.').' VNĐ</div>';
        }
        // nếu random là số chắn thì lấy ra comment
        if ($random %2 == 0) {
            $comment = Comment::join('posts', 'posts.post_id', 'comments.post_id')
                ->where('post_type', 'product')
                ->select(
                    'posts.*',
                    'comments.user_id',
                    'comments.content as contentComment'
                )
                ->orderBy(DB::raw('RAND()'))->first();
            if ($comment->user_id == 0) {
                $username = 'Ẩn danh';
            } else {
                $user = User::where('id', $comment->user_id)
                    ->first();
                $username = $user->name;
            }

            $url = route('product', [ 'post_slug' => $comment->slug]);
            $img = '<a href="'.$url.'"><img src="'. asset($comment->image) .'" width="50"/></a>';

            $content = '<a href="'.$url.'">'.$comment->title.'</a><br> '.$username.' vừa bình luận: "'.$comment->contentComment.'"' ;
        }

        return response([
            'status' => 200,
            'content' => $content,
            'image' => $img
        ])->header('Content-Type', 'text/plain');
    }
}
