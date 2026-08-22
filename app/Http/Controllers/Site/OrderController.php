<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/4/2017
 * Time: 4:40 PM
 */

namespace App\Http\Controllers\Site;


use App\Entity\MailConfig;
use App\Entity\Notification;
use App\Entity\Order;
use App\Entity\OrderBank;
use App\Entity\OrderCodeSale;
use App\Entity\OrderItem;
use App\Entity\OrderShip;
use App\Entity\Post;
use App\Entity\Product;
use App\Entity\SettingGetfly;
use App\Entity\SettingOrder;
use App\Entity\User;
use App\Ultility\CallApi;
use App\Ultility\Ultility;
use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use kcfinder\session;
use Validator;
use App\Entity\NoteOrders;

class OrderController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }

    /*===== thanh toán =====*/
   public function order(Request $request, Product $product) {
       try {
           if (Auth::check()) {
               $user = Auth::user();
               $userId = $user->id;
               $point = $user->point;
           } else {
               $point = null;
           }

           $orderShips = OrderShip::get();
           $orderItems = Order::getOrderItems();
           $orderBanks = OrderBank::get();
           //point
           $price = $product->price;
           $price_deal = $product->price_deal;
           $settingOrder = SettingOrder::first();
           $point_price = 0;
           $point_deal = 0;
           if (!empty($settingOrder)) {
               $point_price = $price/$settingOrder->currency_give_point;
               $point_deal = $price_deal/$settingOrder->currency_give_point;
           }


           return view('site.order.index', compact(
               'orderItems',
               'point',
               'orderShips',
               'orderBanks',
               'point_price',
               'point_deal'
           ));
       } catch (\Exception $e) {
           return redirect(URL::to('/'));
       }

   }

   /* ===== add to cart ======*/
   public function addToCart(Request $request) {
       if (empty($request->input('quantity'))
           || empty($request->input('product_id'))
       ) {
           return response('Error', 404)
               ->header('Content-Type', 'text/plain');
       }

       $quantities = $request->input('quantity');
       $productIds = $request->input('product_id');
       $properties = $request->input('properties');

       $this->insertOrder($request, $productIds,$quantities, $properties);
       $orderItems = $this->productAddToCart($request, $productIds);

       return response([
           'status' => 200,
           'orderItems' => $orderItems,
           'quantities' =>  $quantities,
           'properties' => !empty($properties) ? $properties : '',
       ])->header('Content-Type', 'text/plain');
       
   }


    private function productAddToCart($request, $productIds) {
        $orderItemDetail = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->whereIn('products.product_id', $productIds)
            ->get();
        
        return $orderItemDetail;

    }
    private function insertOrder($request, $productIds, $quantities, $properties, $isSend = false) {
        // update order new;
        $orderNew = array();
        $statusUpdate = array();
        foreach($productIds as $id => $productId) {
            $orderNew[$productId]['quantity'] = $quantities[$id];
            $orderNew[$productId]['properties'] = $properties[$id];
            $statusUpdate[$productId] = false;
        }

        if($request->session()->has('orderItems')) {
            $orderItemOlds = $request->session()->pull('orderItems');
            foreach ($orderItemOlds as $orderItemOld) {
                if (isset($orderNew[$orderItemOld['product_id']]) && !$isSend) {
                    $orderItem = [
                        'quantity' => ($orderNew[$orderItemOld['product_id']]['quantity'] + $orderItemOld['quantity']),
                        'product_id' => $orderItemOld['product_id'],
                        'properties' => $orderNew[$orderItemOld['product_id']]['properties']
                    ];
                    $request->session()->push('orderItems', $orderItem);
                    $statusUpdate[$orderItemOld['product_id']] = true;
                    continue;
                }

                $request->session()->push('orderItems', $orderItemOld);
            }
        }


        foreach ($orderNew as $productId => $orderItem) {
            if(!$statusUpdate[$productId]) {
                $orderItem = [
                    'quantity' => $orderItem['quantity'],
                    'product_id' => $productId,
                    'properties' =>  $orderItem['properties']
                ];
                $request->session()->push('orderItems', $orderItem);
            }
        }
    }
   public function deleteItemCart(Request $request) {
       $productId = $request->input('product_id');

       if($request->session()->has('orderItems')) {
           $orderItemOlds = $request->session()->pull('orderItems');

           foreach ($orderItemOlds as $orderItemOld) {
               if ($productId != $orderItemOld['product_id']) {
                   $request->session()->push('orderItems', $orderItemOld);
               }
           }
       }

       return redirect('/gio-hang');

   }

   private function computePrice() {
       $orderItems = Order::getOrderItems();

       $totalPrice = 0;
       foreach ($orderItems as $orderItem) {
           if (!empty($orderItem->price_deal)) {
               $totalPrice += $orderItem->price_deal*$orderItem->quantity;
           } elseif (!empty($orderItem->discount)) {
               $totalPrice += $orderItem->discount*$orderItem->quantity;
           } else {
               $totalPrice += $orderItem->price*$orderItem->quantity;
           }

       }

       return $totalPrice;
   }
   private function getCodeSalePrice(Request $request, $totalPrice) {
       $oldCodeSale = $request->input('code_sale');

       $codeSale = OrderCodeSale::where('code', $oldCodeSale)
           ->where('many_use', '>', 0)
           ->where('start', '<=', new \DateTime())
           ->where('end', '>=', new \DateTime())
           ->first();

       if (empty($codeSale)) {
           return 0;
       }

       if ($codeSale->method_sale == 0) {
           return $codeSale->sale;
       }

       return ($totalPrice*$codeSale->sale)/100;
   }
   private function getPointGive(Request $request) {
       $oldIsUserPoint = $request->input('is_use_point');
       if ($oldIsUserPoint != 1) {
           return 0;
       }
       if (!Auth::check()) {
           return 0;
       }
       $point = Auth::user()->point;
       $settingOrder = SettingOrder::first();

       return $point*$settingOrder->point_to_currency;
   }
   private function getCostShip(Request $request) {
       $oldMethodShip = $request->input('method_ship');
       $orderShip = OrderShip::where('order_ship_id', $oldMethodShip)->first();

       if (empty($orderShip)) {
           return 0;
       }

       return $orderShip->cost;
   }

   public function send(Request $request){
        try {
//           DB::beginTransaction();
            // tính tổng tiền phải trả
            //
       $orderBanks = OrderBank::get();
       $orderShips = OrderShip::get();
           $totalPrice = $this->computePrice();
           // lấy ra mã giảm giá
           $codeSalePrice = $this->getCodeSalePrice($request, $totalPrice);
           // lấy ra tiền tương ứng với điểm thưởng
           $pointGive = $this->getPointGive($request);
           // lấy ra chi phí ship
           $costShip = $request->input('customer_ship');
           // hình thức thanh toán
           $methodPayment = $request->input('method_payment', '');
           // information customer
           $customer = [
               'ship_name' => $request->input('ship_name'),
               'ship_email' => $request->input('ship_email'),
               'ship_phone' => $request->input('ship_phone'),
               'ship_address' => $request->input('ship_address'),
           ];
           // thêm mới thông tin đơn hàng.
           if(Auth::check()) {
               $userId = Auth::user()->id;
           } else {
               $userModel = new User();
               $userWithPhone = $userModel->where('phone', $request->input('ship_phone'))
                   ->orWhere('email',  $request->input('ship_address'))->first();

               if (empty($userWithPhone)) {
                   $user = $userModel->create([
                       'name' => $request->input('ship_name'),
                       'email' => empty($request->input('ship_email')) ? $request->input('ship_phone') : $request->input('ship_email') ,
                       'phone' => $request->input('ship_phone'),
                       'address' => $request->input('ship_address'),
                       'password' => bcrypt($request->input('ship_phone')),
                       'role' => 1,
                   ]);

                   $userId = $user->id;
               } else {
                   $userId = $userWithPhone->id;
               }
           }
           $order = new Order();
           $orderId = $order->insertGetId([
               'status' => '1', // trang thai đặt hàng thành công
               'shipping_name' => $request->input('ship_name'),
               'shipping_email' => $request->input('ship_email'),
               'shipping_phone' => $request->input('ship_phone'),
               'shipping_address' => $request->input('ship_address'),
               'total_price' => ($totalPrice + $costShip - $codeSalePrice - $pointGive),
               'method_payment' =>  $methodPayment,
               'customer_ship' => $costShip,
               'cost_point' => $pointGive,
               'cost_sale' => $codeSalePrice,
               'ip_customer' => Ultility::get_client_ip(),
               'created_at' =>   new \DateTime(),
               'updated_at' =>   new \DateTime(),
               'user_id' => $userId
           ]);
           $orderDb = new Notification();
           $orderDb->insert([
               'title' => 'Đơn hàng',
               'content' => 'Bạn vừa có đơn hàng mới',
               'status' => '0',
               'url' => route('orderAdmin'),
               'created_at' => new \DateTime(),
               'updated_at' => new \DateTime()
           ]);
           // insert order item
            $quantities = $request->input('quantity');
            $productIds = $request->input('product_id');
            $properties = $request->input('properties');
            $this->insertOrder($request, $productIds,$quantities, $properties, true);
            $orderItems = Order::getOrderItems();

           foreach($orderItems as $orderItem) {
               if (time() <= strtotime($orderItem->deal_end)) {
                   $cost = $orderItem->price_deal;
               } elseif (!empty($orderItem->discount)) {
                   $cost = $orderItem->discount;
               } else {
                   $cost = $orderItem->price;
               }
               OrderItem::insert([
                   'product_id' => $orderItem->product_id,
                   'quantity' => $orderItem->quantity,
                   'order_id' => $orderId,
                   'properties' => $orderItem->properties,
                   'currency' => 'vnd',
                   'cost' => $cost,
               ]);
           }
           if (SettingGetfly::checkSettingGetfly()) {
               $this->postOrderToGetfly($request, $orderItems, $codeSalePrice, $costShip, $totalPrice);
           }

           // minus point user
           $this->minusPointUser( $request);
           // minus many use code_sale
           $this->minusManyCodeSale($request);
           // send mail to admin
            $this->sendMailAdmin();

           // giải phóng session
           $request->session()->pull('orderItems');

           return view('site.order.send', compact(
               'orderId',
               'orderItems',
               'codeSalePrice',
               'pointGive',
               'costShip',
               'totalPrice',
               'customer',
               'orderBanks',
               'methodPayment',
               'orderShips'
           ));
//           DB::commit();

        } catch (\Exception $e) {
            DB::rollback();
             Log::error('http->site->OrderController->send: loi gui don hang');

             return redirect('/');
        }

   }
    private function minusPointUser(Request $request) {
        $oldIsUserPoint = $request->input('is_use_point');
        if ($oldIsUserPoint == 1) {
            $user = Auth::user();
            User::where('id', $user->id)->update([
                'point' => 0
            ]);
        }
    }
    private function minusManyCodeSale(Request $request) {
        $oldCodeSale = $request->session()->get('code_sale');

        $codeSale = OrderCodeSale::where('code', $oldCodeSale)
            ->where('many_use', '>', 0)
            ->where('start', '<=', new \DateTime())
            ->where('end', '>=', new \DateTime())
            ->first();

        if (!empty($codeSale)) {
            $codeSale->update([
                'many_use' => $codeSale->many_use-1
            ]);
        }

    }
    protected function sendMailAdmin() {
       try {
           $subject =  'Đơn hàng mới từ website';
           $content =  'Vừa có đơn hàng mới từ website';

           MailConfig::sendMail('', $subject, $content);
       } catch (\Exception $e) {

       }
    }



    private function postOrderToGetfly($request, $orderItems, $codeSalePrice, $costShip, $totalPrice) {
       try {
           $now = new \DateTime();

           $orderInfor = [
               'account_name' => $request->input('ship_name'),
               'account_address' => $request->input('ship_address'),
               'account_email' => $request->input('ship_email'),
               'account_phone' => $request->input('ship_phone'),
               'order_date' => date_format($now,"d/m/Y"),
               'discount' => 0,
               'discount_amount' => $codeSalePrice,
               'vat' => 0,
               'vat_amount' => 0,
               'transport_amount' => $costShip,
               'installation' => 0,
               'installation_amount' => 0,
               'amount' => $totalPrice,
           ];

           $products = array();
           foreach ($orderItems as $orderItem) {
               $productCode = Product::where('post_id', $orderItem->post_id)->first();
               $products[] = (object) [
                   'product_code' => $productCode->code,
                   'product_name' => $orderItem->title,
                   'quantity' => $orderItem->quantity,
                   'price' =>  $orderItem->price,
                   'product_sale_off' => '',
                   'cash_discount' => ($orderItem->price - $orderItem->discount)
               ];
           }

           $data = (object) [
               'order_info' => $orderInfor,
               'products' => $products,
               'terms' => ['Đơn hàng được gửi tại website của nhasachvidan.vn']
           ];

           $callApi = new CallApi();
           $callApi->postOrder($data);
       } catch (\Exception $e) {
            Log::error('http->site->OrderController->postOrderToGetfly: Lỗi đẩy đơn hàng lên getfly');
       }


    }
    public function note(Request $request){
        $idOrder = NoteOrders::insertGetId([
            'order_id'=> $request->input('id'),
            'note'=> $request->input('content'),
            'created_at' => new \DateTime(),
            'updated_at' => new \DateTime()
        ]);

        $string = '<p>- ' . $request->input('content') .'.</p>
                    <input type="hidden" name="idOrder" value="' . $idOrder .'">';
        echo $string;
    }

    public function deleteJobInvited($id){
      
       try{
                DB::beginTransaction();
                DB::table('orders')->where('order_id', $id)->delete();
                DB::commit();
        }
        catch (\Exception $exception){
            Error::setErrorMessage('Không thể xóa dữ liệu. Đã có lỗi xảy ra');
            DB::rollBack();
        }
        finally{
             return redirect()->back()->with('finishDelete','Đã xóa thành công');
        }
    }
}

