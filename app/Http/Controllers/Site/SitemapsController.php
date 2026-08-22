<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/14/2017
 * Time: 3:35 PM
 */

namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\MenuElement;
use App\Entity\Post;
use Sitemap;

class SitemapsController extends SiteController
{
    public function index()
    {
        $sitemaps = array();
        // trang chủ
        $sitemaps[] = array(
            'url' => asset('/'),
            'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', time() ),
            'priority' => 1.00
        );

        // show sitemap voi tin tuc
        $category = new Category();
        $postCategories = $category->getCategory();
        $posts = Post::where('post_type', 'post')->orderBy('post_id', 'desc')->get();
        foreach ($postCategories as $cate) {
            $sitemaps[] = array(
                'url' => asset('/danh-muc/'.$cate->slug),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($cate->updated_at) ),
                'priority' => 0.8
            );
            foreach ($cate['sub_children'] as $child) {
                $sitemaps[] = array(
                    'url' => asset('/danh-muc/'.$child['slug']),
                    'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($child['updated_at']) ),
                    'priority' => 0.8
                );
            }
        }
        foreach ($posts as $post ) {
            $sitemaps[] = array(
                'url' => asset('/tin-tuc/'.$post->slug),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($post->updated_at) ),
                'priority' => 0.64
            );
			// Sitemap::addTag(asset('/tin-tuc/'.$post->slug), $post->created_at, 'daily', '0.64');
            // Sitemap::addSitemap(asset('/tin-tuc/'.$post->slug), $post->updated_at);
        }

        // show sitemap voi danh muc san pham
        $productCategories =$category->getCategory('product');
        foreach ($productCategories as $cate) {
			// Sitemap::addTag(asset('/cua-hang/'.$cate->slug), $cate->created_at, 'daily', '0.8');
//            Sitemap::addSitemap(asset('/cua-hang/'.$cate->slug), $cate->updated_at);
            $sitemaps[] = array(
                'url' => asset('/cua-hang/'.$cate->slug),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($cate->updated_at) ),
                'priority' => 0.8
            );
            foreach ($cate['sub_children'] as $child) {
                $sitemaps[] = array(
                    'url' => asset('/cua-hang/'.$child['slug']),
                    'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($child['updated_at']) ),
                    'priority' => 0.8
                );
				// Sitemap::addTag(asset('/cua-hang/'.$child['slug']), $child->created_at, 'daily', '0.8');
//                Sitemap::addSitemap(asset('/cua-hang/'.$child['slug']), $child['updated_at']);
            }
        }

        $products = Post::join('products', 'products.post_id', '=', 'posts.post_id')
            ->select(
                'products.product_id',
                'title',
                'slug',
                'image',
				'posts.updated_at'
            )
            ->where('post_type', 'product')->orderBy('posts.post_id', 'desc')
			->get();
        foreach ($products as $product ) {
            $sitemaps[] = array(
                'url' => asset('/'.$product->slug),
                'lastmod' => gmdate('Y-m-d\TH:i:s+00:00', strtotime($product->updated_at) ),
                'priority' => 0.64
            );
        }

        // Return the sitemap to the client.
        return response()->view('sitemap', [
            'sitemaps' => $sitemaps,
        ])->header('Content-Type', 'text/xml');
//        return Sitemap::index();
    }
}
