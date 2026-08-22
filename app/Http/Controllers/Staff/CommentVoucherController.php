<?php

namespace App\Http\Controllers\Staff;

use App\Entity\Category;
use App\Entity\CategoryChildVoucher;
use App\Entity\CategoryPost;
use App\Entity\CategoryVoucher;
use App\Entity\Comment;
use App\Entity\Input;
use App\Entity\MailConfig;
use App\Entity\Post;
use App\Entity\PostFacebook;
use App\Entity\Template;
use App\Entity\TypeInput;
use App\Entity\User;
use App\Entity\Voucher;
use App\Entity\VoucherCategories;
use App\Entity\VoucherChildCategories;
use App\Entity\VoucherComment;
use App\Facebook\Fanpage;
use App\Ultility\Error;
use App\Ultility\Ultility;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Validator;
use Yajra\DataTables\DataTables;

class CommentVoucherController extends SiteStaffController
{
    public function __construct(){
        parent::__construct();
        $this->middleware(function ($request, $next) {
            view()->share('menuTop', 'tailieu');
            return $next($request);
        });
    }
    public function index(Request $request)
    {
        $voucher_comment = new VoucherComment();
        $voucher_comments = $voucher_comment->select('*')
            ->where('parent_id_voucher_cm',0)
            ->orderBy('id_voucher_cm','desc');
        $num = 20;
        if(!empty($request->num)){
            $num = $request->num;
        }
        $total = $voucher_comments->count();
        $voucher_comments = $voucher_comments->paginate($num);

        // $voucher_comments->appends(request()->query());
        return View('staff_admin.comment_voucher.index', compact( 'voucher_comments','total'));
    }

    public function create()
    {
        return View('staff_admin.comment_voucher.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id_voucher_cm)
    {
        $voucher_comment = new VoucherComment();
        $question_comment = $voucher_comment->select('*')
            ->leftJoin('users','users.id','=','voucher_comment.user_id')
            ->where('voucher_comment.id_voucher_cm',$id_voucher_cm)
            ->where('voucher_comment.parent_id_voucher_cm',0)
            ->first();
        $reply_comment = $voucher_comment->select('*')
            ->join('users','users.id','=','voucher_comment.user_id')
            ->where('voucher_comment.parent_id_voucher_cm',$id_voucher_cm)
            ->first();
        $voucher = new Voucher();
        $voucher = $voucher->select('*')
            ->where('id_voucher',$question_comment->id_voucher)
            ->first();
        return View('staff_admin.comment_voucher.edit', compact('voucher', 'question_comment','reply_comment','voucher'));
    }

    public function update(Request $request, $id_voucher_cm)
    {
        $id_user = Auth::user()->id;
        $voucher_comment = new VoucherComment();

        $comment = $voucher_comment->select('*')
            ->join('users','users.id','=','voucher_comment.user_id')
            ->where('voucher_comment.id_voucher_cm',$id_voucher_cm)
            ->first();

        $question_comment = $voucher_comment->select('*')
            ->where('id_voucher_cm',$id_voucher_cm)->update([
               'content_voucher_cm' => $request->input('content_voucher_cm')
            ]);
        $reply_comment = $voucher_comment->select('*')
            ->where('parent_id_voucher_cm',$id_voucher_cm)->first();
//            ->update([
//                'content_voucher_cm' => $request->input('content_voucher_reply')
//            ]);
        if(!empty($reply_comment))
        {
            $update = $voucher_comment->select('*')
                ->where('parent_id_voucher_cm',$id_voucher_cm)
            ->update([
                'content_voucher_cm' => $request->input('content_voucher_reply'),
                'day_comment' => new \DateTime(),
            ]);
        }
        else
        {
            $insert = $voucher_comment->insert([
                'content_voucher_cm' => $request->input('content_voucher_reply'),
                'user_id' => $id_user,
                'parent_id_voucher_cm' => $id_voucher_cm,
                'id_voucher' => $comment->id_voucher,
                'day_comment' => new \DateTime(),
                'created_at' => new \DateTime(),
                'updated_at' => new \DateTime(),
            ]);
        }
        $voucher = new Voucher();
        $voucher = $voucher->select('*')->where('id_voucher',$comment->id_voucher)->first();
        $email = $comment->email;
        $subject = 'Câu hỏi của bạn đã được trả lời';
        $content = 'Vui lòng nhấn vào link để xem câu hỏi';

        $linkichhoat = route('getVoucher',['slug_voucher'=>$voucher->slug_voucher]).'#'.$comment->id_voucher_cm;
//        $linkichhoat = route('active_user',['code'=> $codeacte]);
        $content .= '<a href="'.$linkichhoat.'">'.' Xem trả lời tại đây !'.'</a>';
        MailConfig::sendMail($email, $subject, $content);
        return redirect('staff/staff_comment_voucher');
    }

    public function destroy($id_voucher)
    {
        try {
            $voucher_comment = new VoucherComment();
            $delete = $voucher_comment->where('id_voucher_cm',$id_voucher)->delete();
            $delete_parent = $voucher_comment->where('parent_id_voucher_cm',$id_voucher)->delete();
            return redirect('staff/staff_comment_voucher')->with('success', 'Xóa tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('staff/staff_comment_voucher')->with('error', 'Xóa tài liệu thất bại');
        }
    }
    public function deleteAll(Request $request)
    {
        $ids = $request->ids;   
        $arrids = explode(",",$ids);
        foreach ($arrids as $arrid) {
            VoucherComment::where('id_voucher_cm', $arrid)->delete();
        }
       
        return response()->json(['success'=>"Products Deleted successfully."]);
    }
}
