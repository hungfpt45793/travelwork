<?php

namespace App\Biz;

use App\Entity\CategoryPost;
use App\Entity\Post;
use App\Entity\Product;
use App\Ultility\Ultility;
use Intervention\Image\ImageManager;
use App\Ultility\CallApi;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/30/2017
 * Time: 2:45 PM
 */
class ProductBiz
{
    public function saveProductGetFly ($products, $cateId, $cateGetFlyName) {
        foreach ($products['records'] as $product) {
            if (!empty($product['product_name'])) {
                // tách thuộc tính của product name
                $propertyProduct = $this->getPropertyProduct($product['product_name']);

                $categoryPost = new CategoryPost();
                $productModel = new Product();
                // phan tich list anh
                $imageList = array();
                $imageMain = '';
                if (!empty($product['images'])) {
                    foreach ($product['images'] as $idx => $productImage) {
                        try {
                            $path = $productImage['origin_src'];
                            $filename = basename($path);
                            $imgLibrary = new ImageManager();
                            $img = $imgLibrary->make($path);

                            if ($img->height() > 800) {
                                $height = $img->height();
                                $width = $img->width();
                                $img->resize((int)($width*800/$height), 800);
                            }
                            $img->save(public_path('library/images/' . $filename));

                            $imageList[] = '/library/images/' . $filename;
                            if ($idx == 0) {
                                $imageMain = '/library/images/' . $filename;
                            }
                        } catch (\Exception $e) {
                            $imageList[] = $productImage['origin_src'];
                            if ($idx == 0) {
                                $imageMain = $productImage['origin_src'];
                            }
                        }

                    }
                }

                //check ton tai san pham
                $post = Post::where('title', $propertyProduct['product_name'])
                    ->first();
                if (!empty($post)) {
                    // update category post
                    $categoryPost->where('post_id', $post->post_id)
                       ->delete();
                    $categoryPost->insert([
                        'category_id' => $cateId,
                        'post_id' => $post->post_id,
                    ]);

                    $post->update([
                        'title' => $propertyProduct['product_name'],
                        'slug' => Ultility::createSlug($propertyProduct['product_name']),
                        'post_type' => 'product',
                        'description' => $product['description'],
                        'image' => $imageMain,
                        'visiable' => 0,
                        'category_string' => $cateGetFlyName,
                        'created_at' => new \Datetime(),
                        'updated_at' => new \Datetime(),
                    ]);

                    $productOld = Product::where('post_id', $post->post_id)->first();
                    $discount = $product['cover_price'] - $product['cover_price']*$product['discount_online'] /100;
                    if (!empty($productOld)) {
                        $productOld->update([
                            'code' =>  $product['product_code'],
                            'price' =>  $product['cover_price'],
                            'discount' =>  ($discount !=  $product['cover_price']) ? $discount : 0,
                            'image_list' => !empty($imageList) ? implode(',',$imageList) : ''
                        ]);
                    } else {
                        $productOld =  new Product();
                        $productOld->insert([
                            'post_id' => $post->post_id,
                            'code' =>  $product['product_code'],
                            'price' =>  $product['cover_price'],
                            'category_string' => $cateGetFlyName,
                            'discount' =>  ($discount !=  $product['cover_price']) ? $discount : 0,
                            'image_list' => !empty($imageList) ? implode(',',$imageList) : ''
                        ]);
                    }

                    // insert to properti product
//                    $this->inssertToProperTyProduct($propertyProduct, $post->post_id, $product['product_code']);
                    continue;
                }

                // insert to database
                $post = new Post();
                $postId = $post->insertGetId([
                    'title' => $propertyProduct['product_name'],
                    'slug' => Ultility::createSlug($propertyProduct['product_name']),
                    'post_type' => 'product',
                    'description' => $product['description'],
                    'image' => $imageMain,
                    'visiable' => 0,
                    'category_string' => $cateGetFlyName,
                    'created_at' => new \Datetime(),

                ]);
                // insert danh mục cha

                $categoryPost->insert([
                    'category_id' => $cateId,
                    'post_id' => $postId,
                ]);


                $productModel->insert([
                    'post_id' => $postId,
                    'code' =>  $product['product_code'],
                    'price' =>  $product['cover_price'],
                    'discount' =>  $product['cover_price'] - $product['cover_price']*$product['discount_online'] /100,
                    'image_list' => !empty($imageList) ? implode(',', $imageList) : ''
                ]);

//                $this->inssertToProperTyProduct($propertyProduct, $post->post_id, $product['product_code']);
            }
        }
    }

    private function getPropertyProduct($productNameGetFly) {
        $propertyProducts = explode(',', $productNameGetFly);
        if (count($propertyProducts) == 3) {
            return array(
                'product_name' => $propertyProducts[0],
                'color' => $propertyProducts[1],
                'size' => $propertyProducts[2]
            );
        }

        if (count($propertyProducts) == 2) {
            return array(
                'product_name' => $propertyProducts[0],
                'color' => $propertyProducts[1],
                'size' => ''
            );
        }

        return array(
            'product_name' => $propertyProducts[0],
            'color' => '',
            'size' => ''
        );
    }

//    private function inssertToProperTyProduct($propertyProduct, $postId, $productCode) {
//        $propertyGetflyProduct = PropertiesGetfyProduct::where('product_id', $postId)
//            ->where('product_code', $productCode)
//            ->first();
//        if (!empty($propertyGetflyProduct)) {
//            $propertyGetflyProduct->update([
//                'color' => trim($propertyProduct['color']),
//                'size' => trim($propertyProduct['size']),
//            ]);
//
//            return 0;
//        }
//
//        $propertyGetflyProduct = new PropertiesGetfyProduct();
//        $propertyGetflyProduct->insert([
//            'color' => trim($propertyProduct['color']),
//            'size' => trim($propertyProduct['size']),
//            'product_code' => $productCode,
//            'product_id' => $postId
//        ]);
//
//        return 0;
//    }
}
