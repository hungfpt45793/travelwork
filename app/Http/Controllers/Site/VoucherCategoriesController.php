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
class VoucherCategoriesController extends SiteController
{
    public function __construct(){
        parent::__construct();
        view()->share('menuTopsite', 'voucher');

    }
    public function index( Request $request) {

        $posts = $this->getPosts($request);
        return view('site.default.category', compact('posts'));

    }
    public function getAllCategoryVoucher($slug_cate_voucher)
    {
        $cate_voucher = new VoucherCategories();
        $cate_voucher = $cate_voucher->select( 'id_cate_voucher',
            'name_cate_voucher',
            'slug_cate_voucher')
            ->where('slug_cate_voucher',$slug_cate_voucher)
            ->first();
        $cate_child_voucher = new VoucherChildCategories();
        $cate_child_voucher = $cate_child_voucher->select('id_cate_child',
            'name_cate_child',
            'slug_cate_child',
            'id_cate_voucher')
            ->where('id_cate_voucher','=',$cate_voucher->id_cate_voucher)
            ->get();
        return view('site.voucher_site.kho-tai-lieu',compact('cate_voucher','cate_child_voucher'));
    }
    public function getChildVoucher($slug_cate_child)
    {
        $cate_child_voucher = new VoucherChildCategories();
        $cate_child_voucher = $cate_child_voucher->select( 'id_cate_child',
            'name_cate_child',
            'slug_cate_child',
            'id_cate_voucher')
            ->where('slug_cate_child',$slug_cate_child)->first();
        if(empty($cate_child_voucher))
        {
            return redirect(route('home'));
        }
        $cate_voucher = new VoucherCategories();
        $cate_voucher = $cate_voucher->select('id_cate_voucher',
            'name_cate_voucher',
            'slug_cate_voucher'
            )
            ->where('id_cate_voucher',$cate_child_voucher->id_cate_voucher)
            ->first();
        $vouchers = new Voucher();
        $vouchers = $vouchers->select('id_voucher',
            'name_voucher',
            'slug_voucher',
            'image_voucher',
            'type_voucher',
            'view_voucher',
            'link_dowload_voucher',
            'link_dowload_file',
            'dowload_voucher',
            'id_cate_child',
            'created_at')
            ->where('id_cate_child',$cate_child_voucher->id_cate_child)
            ->orderBy('id_cate_child','desc')
            ->paginate(12);
        return view('site.voucher_site.danh-muc-chung-tu',compact('cate_voucher','cate_child_voucher','cate_voucher','vouchers'));
    }
    public function searchVoucher(Request $request)
    {
        $name_voucher = $request->input('name_voucher');
        $vouchers = new Voucher();
        $vouchers = $vouchers->select('id_voucher',
            'name_voucher',
            'slug_voucher',
            'image_voucher',
            'type_voucher',
            'view_voucher',
            'link_dowload_voucher',
            'link_dowload_file',
            'dowload_voucher',
            'id_cate_child',
            'created_at')
            ->where('name_voucher',  'like', '%' . $name_voucher . '%')
            ->orderBy('id_voucher','desc')
            ->paginate(12);
        $vouchers->appends(request()->query());
        return view('site.voucher_site.tim-kiem-tai-lieu',compact('vouchers'));
    }
//  chi tiet tai lieu
    public function getVoucher($slug_voucher)
    {
        $voucher = new Voucher();
        $vouchers = $voucher->select('*')
            ->where('slug_voucher',$slug_voucher)
            ->first();
        if(empty($vouchers))
        {
            return redirect(route('home'));
        }
        $view_voucher = $vouchers->view_voucher + 1;
        $update =  $voucher->where('slug_voucher',$slug_voucher)->update([
            'view_voucher'=>$view_voucher,
        ]);
        $voucher__dowload_max = $voucher->select('*')
            ->orderBy('dowload_voucher','desc')
            ->limit(5)->get();
        $voucher_news =  $voucher->select('id_voucher',
            'name_voucher',
            'slug_voucher',
            'image_voucher',
            'type_voucher',
            'view_voucher',
            'link_dowload_voucher',
            'link_dowload_file',
            'dowload_voucher',
            'id_cate_child',
            'created_at')
            ->orderBy('id_voucher','desc')
            ->limit(5)->get();
        $voucher_comments = new VoucherComment();
        $voucher_comment = $voucher_comments->select('voucher_comment.*','users.name','users.image')
            ->join('users','users.id','=','voucher_comment.user_id')
            ->where('voucher_comment.id_voucher',$vouchers->id_voucher)
            ->where('voucher_comment.parent_id_voucher_cm',0)
            ->orderBy('voucher_comment.id_voucher_cm','desc');
        $total_comment = $voucher_comment->count();
        $voucher_comment = $voucher_comment->get();
        $cate_child_voucher = '';
        $cate_voucher = '';
        $tag_child_voucher ='';
        if(!empty($vouchers->id_cate_child))
        {
            $cate_child_voucher = new VoucherChildCategories();
            $cate_child_voucher = $cate_child_voucher->select('id_cate_child',
                'name_cate_child',
                'slug_cate_child',
                'id_cate_voucher')
                ->where('id_cate_child',$vouchers->id_cate_child)->first();
            if(!empty($cate_child_voucher->id_cate_voucher))
            {
                $cate_voucher = new VoucherCategories();
                $cate_voucher = $cate_voucher->select('id_cate_voucher',
                    'name_cate_voucher',
                    'slug_cate_voucher')
                    ->where('id_cate_voucher',$cate_child_voucher->id_cate_voucher)
                    ->first();
                $tag_child_voucher =  $cate_child_voucher->select('*')
                    ->where('id_cate_voucher',$cate_child_voucher->id_cate_voucher)
                    ->get();

            }
        }
    //  print_r($tag_child_voucher);die();
        return view('site.voucher_site.tai-lieu',compact('vouchers','voucher__dowload_max','voucher_news','cate_child_voucher','cate_voucher','voucher_comment','total_comment','tag_child_voucher'));
    }
    public function dowload_total(Request $request ,$id)
    {
        $voucher = new Voucher();
        $vouchers = $voucher->select('*')
            ->where('id_voucher',$id)
            ->first();
        $dowload_voucher = $vouchers->dowload_voucher + 1;
        $update =  $voucher->where('id_voucher',$id)->update([
            'dowload_voucher'=>$dowload_voucher,
        ]);
//        return response([
//            'status' => 200,
//            'update' => $update
//        ])->header('Content-Type', 'text/plain');
    }
}