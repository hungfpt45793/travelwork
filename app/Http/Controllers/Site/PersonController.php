<?php

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/28/2017
 * Time: 9:31 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Input;
use App\Entity\InformationGeneral;
use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Post;
use App\Entity\User;
use App\Mail\Mail as AccountChangedMail;
use Illuminate\Support\Facades\Mail as MailFacade;
use Illuminate\Support\Facades\Log;
use App\Mail\Resetpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PersonController extends SiteController
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/');
        }
        $user = Auth::user();
        return view('site.default.user', compact('user'));
    }

    public function store(Request $request)
    {

        $fileName = null;
        $image = $request->file('image');
        if (!empty($image)) {
            $image->move('upload', $image->getClientOriginalName());
            $fileName =  'upload/' . $image->getClientOriginalName();
        }

        $user = Auth::user();
        User::where('id', $user->id)->update([
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'age' => $request->input('age'),
            'email' => $request->input('email'),
            'image' => empty($fileName) ? $request->input('avatar') : $fileName
        ]);
        $this->sendMail(
            $request->input('name'),
            $request->input('phone'),
            $request->input('address'),
            $request->input('age'),
            $request->input('email')
        );

        return redirect('/thong-tin-ca-nhan');
    }
    protected function sendMail($name, $phone, $address, $age, $email)
    {
        try {
            $subject = 'Thông báo thay đổi thông tin tài khoản';

            $content = '
                 <h2>Thông báo thay đổi thông tin tài khoản</h2>
                 <p>Thông tin tài khoản của bạn vừa được cập nhật.</p>

                 <p><strong>Họ và tên:</strong> ' . e($name) . '</p>
                 <p><strong>Số điện thoại:</strong> ' . e($phone) . '</p>
                 <p><strong>Tuổi:</strong> ' . e($age) . '</p>
                 <p><strong>Địa chỉ:</strong> ' . e($address) . '</p>
                 <p><strong>Email:</strong> ' . e($email) . '</p>
             ';

            $mail = new \App\Mail\Mail($content);

            \Mail::to($email)->send(
                $mail->subject($subject)
            );

            return true;
        } catch (\Exception $e) {
            \Log::error(
                'Lỗi gửi mail thay đổi thông tin tài khoản: '
                    . $e->getMessage()
            );

            return false;
        }
    }
    public function resetPassword()
    {
        return view('site.default.reset_password');
    }

    public function storeResetPassword(Request $request)
    {

        $user = Auth::user();
        if (!Hash::check($request->input('password_old'), $user->password)) {
            $faidOldPassword = "Mật khẩu cũ của bạn điền không đúng";

            return redirect()->back()
                ->with('faidOldPassword', $faidOldPassword)
                ->withInput();
        }

        $validation = Validator::make($request->all(), [
            'password' => 'required|string|confirmed',
        ]);

        // if validation fail return error
        if ($validation->fails()) {
            return redirect()->back()
                ->withErrors($validation)
                ->withInput();
        }

        User::where('id', $user->id)->update([
            'password' => bcrypt($request->input('password'))
        ]);

        return redirect()->back()
            ->with('success', 'Bạn đã thay đổi mật khẩu thành công')
            ->withInput();
    }

    public function orderPerson(Request $request)
    {
        $phone = $request->input('phone');

        $orders = Order::orderBy('order_id', 'desc')
            ->where('status', '>', 0);

        if (!empty($phone)) {
            $orders = $orders->where('shipping_phone', $phone);
        }

        if (Auth::check() && empty($phone)) {
            $user = Auth::user();
            $orders = $orders->where('user_id', $user->id);
        }

        $orders = $orders->paginate(3);
        $orders->appends(['phone' => $phone]);

        foreach ($orders as $id => $order) {
            $orders[$id]->orderItems = OrderItem::join('products', 'products.product_id', '=', 'order_items.product_id')
                ->join('posts', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'posts.*',
                    'products.price',
                    'products.discount',
                    'products.deal_end',
                    'products.price_deal',
                    'order_items.*'
                )
                ->where('order_id', $order->order_id)
                ->orderBy('order_id', 'desc')
                ->get();
        }

        return view('site.order.order_person', compact('user', 'orders'));
    }

    public function forgetPassword(Request $request)
{
    \Log::info('FORGET PASSWORD: bắt đầu', [
        'email' => $request->input('email')
    ]);

    $validation = Validator::make(
        $request->all(),
        [
            'email' => 'required|email'
        ],
        [
            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.email' => 'Địa chỉ email không hợp lệ.'
        ]
    );

    if ($validation->fails()) {
        \Log::warning('FORGET PASSWORD: validation lỗi');

        return redirect()->back()
            ->withErrors($validation)
            ->withInput();
    }

    $email = trim($request->input('email'));

    $user = User::where('email', $email)->first();

    if (empty($user)) {
        \Log::warning('FORGET PASSWORD: không tìm thấy user', [
            'email' => $email
        ]);

        return redirect()->back()
            ->with('error', 'Không tìm thấy tài khoản với địa chỉ email này.')
            ->withInput();
    }

    \Log::info('FORGET PASSWORD: tìm thấy user', [
        'user_id' => $user->id
    ]);

    $newPassword = \Illuminate\Support\Str::random(12);

    try {
        \DB::beginTransaction();

        $user->password = Hash::make($newPassword);
        $user->save();

        \Log::info('FORGET PASSWORD: chuẩn bị gửi mail');

        $mailSent = $this->sendMailForget(
            $email,
            $user,
            $newPassword
        );

        \Log::info('FORGET PASSWORD: kết quả gửi mail', [
            'mail_sent' => $mailSent
        ]);

        if (!$mailSent) {
            \DB::rollBack();

            return redirect()->back()
                ->with(
                    'error',
                    'Không thể gửi email khôi phục mật khẩu. Vui lòng thử lại.'
                )
                ->withInput();
        }

        \DB::commit();

        \Log::info('FORGET PASSWORD: hoàn tất');

        return redirect()->back()
            ->with(
                'success',
                'Mật khẩu mới đã được gửi tới email của bạn.'
            );

    } catch (\Exception $e) {
        \DB::rollBack();

        \Log::error('FORGET PASSWORD ERROR: ' . $e->getMessage());

        return redirect()->back()
            ->with(
                'error',
                'Không thể khôi phục mật khẩu. Vui lòng thử lại.'
            )
            ->withInput();
    }
}
    private function sendMailForget($email, $user, $newPassword)
    {
        try {

            $subject = 'Khôi phục mật khẩu';

            $userName = !empty($user->name)
                ? e($user->name)
                : 'bạn';

            $content = '
            <h2>Khôi phục mật khẩu</h2>

            <p>Xin chào <strong>' . $userName . '</strong>,</p>

            <p>
                Chúng tôi đã nhận được yêu cầu khôi phục mật khẩu
                cho tài khoản của bạn.
            </p>

            <p>Mật khẩu mới của bạn là:</p>

            <p style="
                font-size: 20px;
                font-weight: bold;
                padding: 12px;
                background: #f5f5f5;
                display: inline-block;
            ">
                ' . e($newPassword) . '
            </p>

            <p>
                Bạn nên đăng nhập và thay đổi mật khẩu ngay sau khi
                truy cập lại tài khoản.
            </p>

            <p>
                Nếu bạn không thực hiện yêu cầu này,
                vui lòng liên hệ với chúng tôi.
            </p>
        ';


            /*
         * Mailable đã được chúng ta test thành công
         */
            $mail = new \App\Mail\Mail($content);


            /*
         * Gửi tới chính email yêu cầu khôi phục
         */
            \Mail::to($email)->send(
                $mail->subject($subject)
            );


            return true;
        } catch (\Exception $e) {

            \Log::error(
                'Lỗi gửi mail quên mật khẩu tới '
                    . $email
                    . ': '
                    . $e->getMessage()
            );

            return false;
        }
    }
}
