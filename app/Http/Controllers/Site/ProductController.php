<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:23 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Product;
use App\Entity\SettingOrder;
use App\Entity\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProductController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }

    public function index($slug_post, Request $request) {
        try {
            $product = $this->getProduct($slug_post);
            $averageRating = $product->avgRating;
            $sumRating = $product->countPositive;

            $categories = $this->getCategories($product);

            // product seen
            $productSeen = Product::saveProductSeen($request, $product);
            //point
            $inforPoint = $this->getPoint($product);
            $point_price = $inforPoint['pointPrice'];
            $point_deal = $inforPoint['point_detal'];

            if ($product->template == 'default' || empty($product->template)) {
                return view('site.default.product', compact('product', 'categories', 'productSeen', 'averageRating', 'sumRating', 'point_price','point_deal'));
            } else {
                return view('site.template.'.$product->template, compact('product', 'categories', 'productSeen', 'averageRating', 'sumRating', 'point_price','point_deal'));
            }
        } catch (\Exception $e) {
            Log::error('http->site->ProductController->index: loi lay san pham');
            return redirect('/');
        }
    }

    private function getProduct ($slug_post) {
        try {
            $product = Post::join('products', 'products.post_id','=', 'posts.post_id')
                ->select(
                    'products.price',
                    'products.image_list',
                    'products.discount',
                    'products.price_deal',
                    'products.deal_end',
                    'products.code',
                    'products.product_id',
                    'products.properties',
                    'products.buy_together',
                    'products.buy_after',
                    'products.discount_start',
                    'products.discount_end',
                    'posts.*'
                )
                ->where('post_type', 'product')
                ->where('visiable', 0)
                ->where('posts.slug', $slug_post)->first();

            $inputs = Input::where('post_id', $product->post_id)->get();
            foreach ($inputs as $input) {
                $product[$input->type_input_slug] = $input->content;
            }

            return $product;
        } catch (\Exception $e) {
            Log::error('http->site->ProductController->getProduct: lỗi lấy dữ liệu sản phẩm');

            return redirect('/');
        }
    }

    private function getCategories ($product) {
        try {
            $categories = Category::join('category_post', 'categories.category_id', '=', 'category_post.category_id')
                ->select('categories.*')
                ->where('category_post.post_id', $product->post_id)->get();

            return $categories;
        } catch(\Exception $e) {
            Log::error('http->site->ProductController->getCategories: lỗi lấy dữ liệu danh mục');
            return null;
        }
    }

    private function getPoint($product) {
        try {
            $price = $product->price;
            $price_deal = $product->price_deal;

            $settingOrder = SettingOrder::first();
            if (!empty($settingOrder)) {
                $point_price = $price/$settingOrder->currency_give_point;
                $point_deal = $price_deal/$settingOrder->currency_give_point;
            } else {
                $point_price = 0;
                $point_deal = 0;
            }

            return [
                'pointPrice' => $point_price,
                'point_detal' => $point_deal
            ];

        } catch (\Exception $e) {
            Log::error('http->site->ProductController ->getPoint');

            return [
                'pointPrice' => 0,
                'point_detal' => 0
            ];
        }
    }
    public function Rating(Request $request){
        $postId = $request->input('postid');
        $rating = $request->input('rating');

        $post = Post::where('post_id', $postId)->first();
        $post->id = $post->post_id;
        $user = User::first();
        $rating = $post->rating([
            'rating' => $rating
        ], $user);
        $averageRating = $post->avgRating;
        $return_arr = array("averageRating"=>$averageRating);

        return response()->json($return_arr);
    }

    public function demoProduct($slug_post, Request $request) {
        try {

            $product = $this->getProduct($slug_post);
            $averageRating = $product->avgRating;
            $sumRating = $product->countPositive;

            $categories = $this->getCategories($product);

            // product seen
            $productSeen = Product::saveProductSeen($request, $product);
            //point
            $inforPoint = $this->getPoint($product);
            $point_price = $inforPoint['pointPrice'];
            $point_deal = $inforPoint['point_detal'];

            return view('site.template.show-product', compact('product', 'categories', 'productSeen', 'averageRating', 'sumRating', 'point_price','point_deal'));
        } catch (\Exception $e) {
            Log::error('http->site->ProductController->index: loi lay san pham');
            return redirect('/');
        }
    }
}
