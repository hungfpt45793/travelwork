<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/7/2017
 * Time: 3:06 PM
 */

namespace App\Http\Controllers\Site;


use App\Entity\SubcribeEmail;
use Illuminate\Http\Request;

class SubcribeEmailController extends SiteController
{
    public function index(Request $request) {
        $email = $request->input('email');

        // nếu email truyền vào là rỗng thì trả ra là bắt buộc nhập email
        if (empty($email)) {
            return response([
                'status' => 200,
                'message' => 'Bạn chưa nhập email (sdt), vui lòng nhập email!'
            ])->header('Content-Type', 'text/plain');
        }

        // Nếu đúng thì thêm vào admin
        SubcribeEmail::insert([
            'email' => $email,
            'created_at' => new \DateTime(),
        ]);

        return response([
            'status' => 200,
            'message' => 'Cảm ơn bạn đã đăng ký với chúng tôi!'
        ])->header('Content-Type', 'text/plain');


    }
    public function addEmail(Request $request)
    {
        $subsctibe = new SubcribeEmail();
        $subsctibe = $subsctibe->insertGetId([
            'email' => $request->input('email'),
            'slug_gruop' => $request->input('slug_gruop'),
        ]);
        return redirect()->back()->with('success_email','Đăng kí email thành công');
    }
}
