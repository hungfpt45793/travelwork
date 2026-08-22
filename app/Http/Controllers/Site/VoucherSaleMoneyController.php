<?php

namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\Employee_coins;
use App\Entity\Forum_notification;
use App\Entity\Information_money;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Post_sale_money;
use App\Entity\Post_sale_statistical;
use App\Entity\TypeInformation_money;
use App\Entity\Voucher;
use App\Entity\Voucher_sale_money;
use App\Entity\Voucher_sale_statistical;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 9:50 AM
 */
class VoucherSaleMoneyController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }


    public function create_employee_share_voucher(Request $request)
    {
        try {
            DB::beginTransaction();
            $employee_id = $request->input('employee_id');
            $voucher_id = $request->input('voucher_id');

            //kiểm tra bài viết có dc chia se hay k
            //nếu bài viết không bật chức năng chia sẻ kiếm tiền
            $post = new Voucher();
            $post = $post->select('id_voucher', 'sale_money')
                ->where('id_voucher', $voucher_id)
                ->where('sale_money', 1)
                ->first();
            if (empty($post)) {
                return response([
                    'status' => 404,
                    'message' => 'Không tìm thấy bài viết này'
                ], 404)->header('Content-Type', 'text/plain');
            }
            //tạo employee_it trong bảng thống kê ứng viên
            $employee_coins_model = new Employee_coins();
            $employee_coints = $employee_coins_model->select('*')
                ->where('employee_id', $employee_id)
                ->first();
            //nếu không tồn tại ứng viên thì thêm mới
            if (empty($employee_coints)) {
                $insert = $employee_coins_model->insert([
                    'total_sale_voucher' => 1,
                    'employee_id' => $employee_id,
                    'created_at' => new \DateTime()
                ]);
            } else {
                $total_sale_voucher = $employee_coints->total_sale_voucher + 1;
                $update = $employee_coins_model->where('employee_id', $employee_id)->update([
                    'total_sale_voucher' => $total_sale_voucher,
                    'updated_at' => new \DateTime(),
                ]);
            }
//            thống kê chia sẻ bài viết theo ứng viên
            $post_sale_static = new Voucher_sale_statistical();
            $check_post_sale_static = $post_sale_static->select('*')
                ->where('employee_id', $employee_id)
                ->where('voucher_id', $voucher_id)
                ->first();
//            nếu tồn tại thì cộng số lần chia sẻ ứng viên
            if (empty($check_post_sale_static)) {
                $insert = $post_sale_static->insert([
                    'employee_id' => $employee_id,
                    'voucher_id' => $voucher_id,
                    'total_share' => 1,
                    'created_at' => new \DateTime()
                ]);

                // nếu chưa tồn tại thì thêm mới ứng viên
            } else {
                $total_share = $check_post_sale_static->total_share + 1;
                $update = $post_sale_static->where('employee_id', $employee_id)
                    ->where('voucher_id', $voucher_id)
                    ->update([
                        'total_share' => $total_share,
                        'updated_at' => new \DateTime(),
                    ]);
            }
            DB::commit();
            return response([
                'status' => 200,
                'employee_id' => $employee_id
            ])->header('Content-Type', 'text/plain');
        } catch (\Exception $e) {
            DB::rollBack();
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
    }



    //them luot view kiem tien cho ung vien

    public function add_ajax_sale_money_voucher(Request $request)
    {
        $ip_sale = !empty($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 0;
        if (!empty($request->input('voucher_id')) && !empty($request->input('employee_id')) && !empty($ip_sale)) {
            DB::beginTransaction();
            //check xem tài khoản ứng viên này co bị chăn kiếm tiền hay không
            $check_employee_coints = Employee_coins::where('employee_id', $request->input('employee_id'))->where('coints_status', 1)
                ->count();

            if ($check_employee_coints > 0) {
                return response([
                    'status' => 404,
                    'message' => 'Ứng viên này bị tắt chức năng kiếm tiền'
                ], 404)->header('Content-Type', 'text/plain');
            }
            $voucher_id = $request->input('voucher_id');
            $employee_id = $request->input('employee_id');
            $day_date = new \DateTime();

            //nếu bài viết không bật chức năng chia sẻ kiếm tiền
            $post = new Voucher();
            $post = $post->select('id_voucher', 'sale_money')
                ->where('id_voucher', $voucher_id)
                ->where('sale_money', 1)
                ->first();
            if (empty($post)) {
                return response([
                    'status' => 404,
                    'message' => 'Không tìm thấy tài liệu này'
                ], 404)->header('Content-Type', 'text/plain');
            }
            //check ứng viên có tồn tại không
            $employee = new Employee();
            $employee = $employee->select('employee_id')->where('employee_id', $employee_id)->first();
            if (empty($employee)) {
                return response([
                    'status' => 404,
                    'message' => 'Ứng viên này không tồn tài'
                ], 404)->header('Content-Type', 'text/plain');
            }

            $post_sale_model = new Voucher_sale_money();
            $check_sale = $post_sale_model->select('*')
                ->where('ip_sale', $ip_sale)
                ->whereDate('date_sale', '=', date_format($day_date, "Y/m/d"))
//                ->where('voucher_id', '=', $voucher_id)
                ->where('employee_id', '=', $employee_id)
                ->first();
//            echo '<pre>';
//            print_r($check_sale);die;
//                print_r($check_sale);die();
            if (!empty($check_sale)) {
                return response([
                    'status' => 404,
                    'message' => 'Bài viết này đã xem trong ngày'
                ], 404)->header('Content-Type', 'text/plain');
            } else {
                //tao lượt xem
                $this->create_post_sale_voucher($employee_id, $voucher_id, $ip_sale, $day_date);
            }
            DB::commit();
        } else {
            DB::rollBack();
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
    }

    public function create_post_sale_voucher($employee_id, $voucher_id, $ip_sale, $day_date)
    {
//        thêm mới lần chia sẻ
        $post_sale_model = new Voucher_sale_money();
        $post_sale_id = $post_sale_model->insertGetId([
            'employee_id' => $employee_id,
            'voucher_id' => $voucher_id,
            'ip_sale' => $ip_sale,
            'date_sale' => date_format($day_date, "Y/m/d"),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime(),
        ]);

        //check thong ke lượt xem
        $post_sale_static = new Voucher_sale_statistical();
        $check_post_sale_static = $post_sale_static->select('*')
            ->where('employee_id', $employee_id)
            ->where('voucher_id', $voucher_id)
            ->first();

        //cau hinh phan tinh tiền
//        $informationShow_money = \App\Ultility\Infomation::information_money();
//        //Số tiền nhận dc khi có người xem bài viết
//        $money_view = !empty($informationShow_money['so-tien-luot-xem-tai-lieu']) ? $informationShow_money['so-tien-luot-xem-tai-lieu'] : 100;
//        //Số tiền tối đa nhận được khi chia sẻ bài viết
//        $max_view_post = !empty($informationShow_money['so-tien-toi-da-trong-1-tai-lieu']) ? $informationShow_money['so-tien-toi-da-trong-1-tai-lieu'] : 100000;

        if (!empty($check_post_sale_static)) {
            $total_view_sale = $check_post_sale_static->total_view_sale + 1;
            $total_coin = $check_post_sale_static->total_coin;
            if($total_view_sale % 10 == 0)
            {
                $total_coin = $check_post_sale_static->total_coin + 1;
                //cộng xu cho ứng viên
                $user_id = Employee::where('employee_id', $employee_id)->value('user_id');
                $user_coin = User::where('id',$user_id)->value('user_coin');
                User::where('id',$user_id)->update([
                    'user_coin' => $user_coin + 1
                ]);
                //tạo thông báo cho sub diendan
                $noti_title = 'Bạn được cộng thêm 1 xu từ chia sẻ tài liệu trên sanketoan.vn';
                $forum_noti = Forum_notification::insert([
                    'noti_title' => $noti_title,
                    'for_post_id'=>0, //mã bài viết
                    'for_comment_id'=>0,
                    'user_id' =>$user_id, //user id nhận thông báo
                    'user_id_comment'=>0, //user người bình luận
                    'noti_type'=>'user_pro', //kiểu thông báo comment=>là thông báo bình luận về bài viết , post_coin=>là thông báo về bài viết mất 1 xu ,comment_coin=>là thông báo về bình luận tặng xu,  user_pro=>tặng xu khi đăng ký tài khoản pro,
                    'noti_status' => 0, //trạng thái thông báo 0 là chưa xem 1 đã xem
                    'created_at' => new \DateTime()
                ]);
            }
            $update = $post_sale_static->where('employee_id', $employee_id)
                ->where('voucher_id', $voucher_id)
                ->update([
                    'total_view_sale' => $total_view_sale,
                    'total_coin' => $total_coin,
                    'updated_at' => new \DateTime(),
                ]);
        }

        return response([
            'status' => 200,
            'post_sale_id' => $post_sale_id
        ])->header('Content-Type', 'text/plain');
    }



    //xóa các giá trị cũ lưu xem bài để check lượt xem
    public function delete_post_sale_money_voucher()
    {
        try{
            $day_date = new \DateTime();
            $post_sale_model = new Voucher_sale_money();
            $check_sale = $post_sale_model->whereDate('date_sale', '!=', date_format($day_date, "Y/m/d"))
                ->delete();
        }
        catch (\Exception $ex)
        {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }
//                print_r($check_sale);die();
    }


}

