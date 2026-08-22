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
use App\Mail\Mail;
use App\Mail\Resetpassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class PersonController extends SiteController
{
     public function index() {
         if (!Auth::check()) {
             return redirect('/');
         }
         $user = Auth::user();
         return view('site.default.user', compact('user'));
     }

     public function store(Request $request) {

         $fileName = null;
         $image = $request->file('image');
         if (!empty($image)) {
             $image->move('upload',$image->getClientOriginalName());
             $fileName =  'upload/'.$image->getClientOriginalName();
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
//         $this->sendMail(
//             $request->input('name'),
//             $request->input('phone'),
//             $request->input('address'),
//             $request->input('age'),
//             $request->input('email')
//         );
         
         return redirect('/thong-tin-ca-nhan');
     }
     protected function sendMail($name, $phone, $address, $age, $email) {
         $mailConfig = Post::join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
             ->select('posts.*')
             ->where('type_sub_post_slug', 'cau-hinh-email')
             ->where('posts.slug', 'mail-thay-doi-tai-khoan')
             ->first();
          // config content
         $mailConfig->content = str_replace('[your-name]', $name, $mailConfig->content);
         $mailConfig->content = str_replace('[your-phone]', $phone, $mailConfig->content);
         $mailConfig->content = str_replace('[your-age]', $age, $mailConfig->content);
         $mailConfig->content = str_replace('[your-address]', $address, $mailConfig->content);
         $mailConfig->content = str_replace('[your-email]', $email, $mailConfig->content);
         $mailConfig->content = str_replace('[]', $email, $mailConfig->content);
         
         $inputs = Input::where('post_id', $mailConfig->post_id)->get();
         foreach ($inputs as $input) {
             $mailConfig[$input->type_input_slug] = $input->content;
             // config to, from, subject
             $mailConfig[$input->type_input_slug] = str_replace('[your-name]', $name, $mailConfig[$input->type_input_slug]);
             $mailConfig[$input->type_input_slug] = str_replace('[your-phone]', $phone,  $mailConfig[$input->type_input_slug]);
             $mailConfig[$input->type_input_slug] = str_replace('[your-age]', $age, $mailConfig[$input->type_input_slug]);
             $mailConfig[$input->type_input_slug] = str_replace('[your-address]', $address, $mailConfig[$input->type_input_slug]);
             $mailConfig[$input->type_input_slug] = str_replace('[your-email]', $email, $mailConfig[$input->type_input_slug]);
         }

         $to =  $mailConfig['to'];
         $from = $mailConfig['from'];
         $subject = $mailConfig['chu-de-(subject)'];
         $content = $mailConfig->content;
         $mail = new Mail(
            $content
         );

         \Mail::to($to)->send($mail->from($from)->subject($subject));
     }
     public function resetPassword() {
         return view('site.default.reset_password');
     }

     public function storeResetPassword(Request $request) {
       
              $user = Auth::user();
         if ( !Hash::check($request->input('password_old'), $user->password)) {
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

     public function orderPerson(Request $request) {
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
         
         foreach($orders as $id => $order) {
             $orders[$id]->orderItems = OrderItem::join('products','products.product_id','=', 'order_items.product_id')
                 ->join('posts', 'products.post_id','=','posts.post_id')
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

    public function forgetPassword(Request $request) {
        $email = $request->input('email');
        $newPassword = str_random(10);
        $user = User::where('email',$email)->first();
        $isSuccess = 0;
        if (empty($user)) {
            return view('site.Auth.forget_password', compact('isSuccess'));
        }

        $user->update([
            'password' => bcrypt($newPassword)
        ]);

        $this->sendMailForget($email, $user, $newPassword);
        $isSuccess = 1;
        
        return view('site.Auth.forget_password', compact('isSuccess'));
    }

    private function sendMailForget($email, $user, $newPassword) {
		$informationGeneralModel = new InformationGeneral();
		$informationGenerals = $informationGeneralModel
		->where('theme_code', $this->themeCode)
		->where('user_email', $this->emailUser)
		->get();

		//lay theo element de show ra
		$informationElement = array();
		foreach($informationGenerals as $informationGeneral){
			$informationElement[$informationGeneral->slug] = $informationGeneral->content;
		}
		$link_web = URL::to('/');
		print_r($informationElement); exit;
		$phone = informationElement['phone'];
		$address = informationElement['address'];
		$link_fb = informationElement['fb'];
		$link_logo = informationElement['logo'];
        $to =  $email;
        $from = 'vn3ctran@gmail.com';
        $subject ='q m k';
        $content = $mailConfig->content;
//$email, $name, $password,$link_web,$phone,$address,$link_fb,$link_logo
        $mail = new Resetpassword(
            $email,
			$user->name,
			$newPassword,
			$link_web,
			$phone,
			$address,
			$link_fb,
			$link_logo
        );

        \Mail::to($to)->send($mail->from($from)->subject($subject));
    }


}
