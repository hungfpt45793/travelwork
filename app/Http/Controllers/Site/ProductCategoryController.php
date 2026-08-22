<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 10:24 AM
 */

namespace App\Http\Controllers\Site;


use App\Entity\Category;
use App\Entity\Input;
use App\Entity\Post;
use App\Entity\Product;
use App\Ultility\Ultility;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class ProductCategoryController extends SiteController
{
    public function __construct(){
        parent::__construct();
    }

    public function index($cate_slug, Request $request) {
        if (!empty($this->domainUser)) {
            if ( strtotime($this->domainUser->end_at) < time() && ($this->emailUser != 'vn3ctran@gmail.com')) {
                return redirect(route('admin_dateline'));
            }
        }
        // lấy ra bộ lọc
        $filters = $request->input('filter');

        $category = $this->getCategoryDetail($cate_slug);

        $productinfors = $this->getProducts($category, $request, $filters);
        $products = $productinfors['products'];
        $countProduct = $productinfors['countProduct'];

        $productSeen =Product::saveProductSeen($request);
        
        if ($category->template == 'default' || empty($category->template)) {
            return view('site.default.category_product', compact('category', 'products', 'productSeen', 'countProduct'));
        } else {
            return view('site.template.'.$category->template, compact('category', 'products', 'productSeen', 'countProduct'));
        }
    }

    private function getCategoryDetail($cate_slug) {
        try {
            $categoryModel = new Category();

            $category = $categoryModel->where('slug', $cate_slug)
                ->first();

            $inputs = Input::where('cate_id', $category->category_id)->get();
            foreach ($inputs as $input) {
                $category[$input->type_input_slug] = $input->content;
            }

            return $category;
        } catch (\Exception $e) {
            Log::error('http->site->ProductCategoryController->getCategoryDetail: Lỗi lấy dữ liệu danh mục sản phẩm');

            return redirect('/');
        }
    }

    private function getProducts($category, $request, $filters) {
         try {
            $postModel = new Post();
            $products = $postModel->join('category_post', 'category_post.post_id', '=', 'posts.post_id')
                ->join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'posts.*',
                    'products.product_id',
                    'products.price',
                    'products.discount',
                    'products.price_deal',
                    'products.discount_start',
                    'products.discount_end',
                    'products.filter',
                    'products.code'
                )
                ->where('visiable', 0)
                ->where('category_post.deleted_at','=' , null)
                ->where('category_post.category_id', $category->category_id);

			
			// xử lý phần bộ lọc
            $productFilters  = array();
            $productIdArray = null;
            if (!empty($filters)) {
                foreach ($filters as $id =>  $filter) {
                    $productFilters = Product::select('product_id')
                        ->where('filter', 'like', '%,'.$filter.'%')
                        ->orWhere('filter', 'like', $filter.'%');
						
					if (!empty($productIdArray)) {
                        $productFilters = $productFilters->whereIn('product_id', $productIdArray);
                    }
					
					$productFilters = $productFilters->get();
				
					foreach ($productFilters as $productFilter) {
						$productIdArray[] =  $productFilter->product_id;
					}
                }

                // lay nhung id product thuoc phan bo loc
                $products = $products->whereIn('product_id', $productIdArray);

			}

            if ($request->has('sort')) {
                switch ($request->input('sort')) {
                    case 'priceIncrease': $products = $products->orderBy('products.price', 'asc'); break;
                    case 'priceReduction': $products = $products->orderBy('products.price', 'desc'); break;
                    case 'sortName': $products = $products->orderBy('posts.title', 'asc'); break;
                }
            }

            // tim kiem product
            if (!empty($request->input('word'))) {
                $word = Ultility::createSlug($request->input('word'));
				$arrayWords = explode('-', $word);
				$productSearchs = array();
				foreach ($arrayWords as $id => $word) {
					if ($id == 0) {
						$productSearchs =  $postModel->where('posts.slug', 'like', '%'.$word.'%')
						->orWhere('posts.slug', 'like', $word.'%');
					} else {
						$productSearchs =  $productSearchs->orWhere('posts.slug', 'like', '%'.$word.'%')
						->orWhere('posts.slug', 'like', $word.'%');
					}	
				}
				$productSearchs = $productSearchs->select('post_id')->get();
				$productIdSearch = array();
				foreach ($productSearchs as $productSearch) {
					$productIdSearch[] = $productSearch->post_id;
				}
				
				$products = $products->whereIn('posts.post_id', $productIdSearch);
				
            }
			
            $products = $products->paginate(12);

			// append filter and word after paginage
			if (!empty($filters)) {
				foreach ($filters as $filter) {
					$products->appends(['filter[]' => $filter]);
				}
				
			}
			if (!empty($request->input('word'))) { 
				$products->appends(['word' => $request->input('word')]);
			}
			
            foreach ($products as $id => $product)
            {
                $inputs = Input::where('post_id', $product->post_id)->get();
                foreach ($inputs as $input) {
                    $products[$id][$input->type_input_slug] = $input->content;
                }
            }


            $countProduct = $products->count();

            return [
                'products' => $products,
                'countProduct' => $countProduct
            ];
         } catch (\Exception $e) {
             Log::error('http->site->ProductCategoryController->getProducts: Lỗi lấy dữ liệu sản phẩm');

             return [
                 'products' => array(),
                 'countProduct' => 0
             ];
         }
    }

    public function search(Request $request) {
        $category = $request->input('category');
        $word = $request->input('word');


        $products = $this->getProductsSearch($word);

        $productSeen =Product::saveProductSeen($request);

        return view('site.default.search', compact('category', 'products', 'productSeen'));
    }

    private function getProductsSearch($word) {
        try {
            $postModel = new Post();

            $products = $postModel->join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'posts.*',
                    'products.product_id',
                    'products.price',
                    'products.discount',
                    'products.price_deal',
                    'products.discount_start',
                    'products.discount_end'
                )
                ->where('posts.post_type', 'product')
                ->where('posts.slug', 'like', '%'.Ultility::createSlug($word).'%')
                ->distinct()
                ->paginate(16);

            return $products;
        } catch (\Exception $e) {
            Log::error('http->site->ProductCategoryController->getProductSearch: Lỗi lấy dữ liệu sản phẩm');

            return array();
        }
    }
    public function searchAjax(Request $request) {
        $word = $request->input('word');
        
        if ( empty($word) ) {
            return response('Error', 404)
                ->header('Content-Type', 'text/plain');
        }

        $products = $this->getDetailProductAjax($word);

        return response([
            'status' => 200,
            'products' => $products
        ])->header('Content-Type', 'text/plain');
    }

    private function getDetailProductAjax($word) {
        try {
            $postModel = new Post();

            $products = $postModel->join('products', 'products.post_id', '=', 'posts.post_id')
                ->select(
                    'posts.*',
                    'products.product_id',
                    'products.price',
                    'products.discount',
                    'products.price_deal',
                    'products.discount_start',
                    'products.discount_end'
                )
                ->where('posts.slug', 'like', '%'.Ultility::createSlug($word).'%')
                ->offset(0)
                ->limit(5)->get();

            return $products;
        } catch (\Exception $e) {
            Log::error('http->site->ProductCategoryController->getDetailProductAjax: Lỗi khi lấy dữ liệu search enjin');

            return array();
        }
    }
}
