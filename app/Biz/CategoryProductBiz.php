<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 11/30/2017
 * Time: 2:47 PM
 */

namespace App\Biz;


use App\Entity\Category;
use App\Entity\ModelParent;
use App\Ultility\Ultility;

class CategoryProductBiz
{
    public function saveCateGetfy ($cateGetflyId, $cateGetFlyName) {
        $category = Category::where('cate_getfly', $cateGetflyId)
           ->first();
        $slug = Ultility::createSlug($cateGetFlyName);
        if (empty($category) ) {
            $category = new Category();
            $cateId = $category->insertGetId([
                'title' => $cateGetFlyName,
                'slug' => trim($slug, '-'),
                'parent' => 0,
                'post_type' => 'product',
                'cate_getfly' => $cateGetflyId,
            ]);
        } else {
            $category->update([
                'title' => $cateGetFlyName,
                'slug' => trim($slug, '-'),
                'parent' => 0,
                'post_type' => 'product',
                'cate_getfly' => $cateGetflyId,
            ]);
            $cateId =  $category->category_id;
        }

        return $cateId;
    }

    public function updateParentCateGetFly($cateGetflies) {
        //reupdate category to know parent and children
        foreach ($cateGetflies as $cateGetfly) {
            $token = explode(',', $cateGetfly);
            $cateGetflyId = $token[0];
            $cateParentId = $token[2];
            if ($cateParentId != 0) {
                $category = new Category();
                $categoryParent = $category->where('cate_getfly', '=', $cateParentId )
                    ->first();
                $categoryChild = $category->where('cate_getfly',$cateGetflyId )
                    ->first();
                if (!empty($categoryParent)) {
                    $categoryChild->update([
                        'parent' => $categoryParent->category_id
                    ]);
                }
            }

        }
    }
}
