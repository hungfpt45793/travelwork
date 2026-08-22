<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:21 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Voucher;
use App\Entity\VoucherCategories;
use App\Entity\VoucherChildCategories;
use App\Entity\VoucherComment;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class VoucherCommentController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
        view()->share('menuVoucher', 'voucher');
    }

    public function addComment(Request $request)
    {
        if (!Auth::user()) {
            return redirect()->back()->with('error_login', 'Vui lòng đăng nhập để bình luận');
        }
        $content_comment = $request->input('content_comment');
        $id_voucher = $request->input('id_voucher');

        $voucher = new Voucher();
        $voucher = $voucher->select('*')->where('id_voucher',$id_voucher)->first();
//       echo $content_comment .'=======' .$id_voucher;die();
        $id_user = Auth::user()->id;
        $comment = new VoucherComment();
        $id_vouchet_cm = $comment->insertGetId([
            'content_voucher_cm' => $content_comment,
            'user_id' => $id_user,
            'id_voucher' => $id_voucher,
            'parent_id_voucher_cm' => 0,
            'day_comment' => new \DateTime(),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);
        if ($id_vouchet_cm > 0) {
            return redirect(route('getVoucher',['slug_voucher'=>$voucher->slug_voucher]) . '#CommentVoucher');
        } else {
            return redirect(route('addComment'))->back();
        }
//        Route::get('/{slug_voucher}', 'VoucherCategoriesController@getVoucher')->name('getVoucher');

    }


}
