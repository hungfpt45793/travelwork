<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Category extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'categories';

    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'image',
        'template',
        'parent',
        'cate_getfly',
        'post_type',
        'is_hide',
        'created_at',
        'updated_at',
        'deleted_at',
        
    ];

    public function getCategory($postType = 'post'){
        try {
            $categories = $this->where([
                'post_type' => $postType,
            ])->where('parent', 0)
                ->orderBy('category_id')->get();

            foreach ($categories as $id => $cate) {
                $categories[$id]['sub_children'] = array();
                $categories[$id]['sub_children'] = $this->getSubCategory($cate->category_id, $categories[$id]['sub_children'], $postType);
            }

        } catch (\Exception $e) {
            $categories = null;

            Log::error('Entity->Category->getCategory: Lấy danh mục ra bị lỗi: '.$e->getMessage());
        } finally {
            return $categories;
        }
    }

    public function getSubCategory($cateId, $categorySource = array(), $postType = 'post', $subChild = '', $level = 2) {
        try {
            $categories = $this->where([
                'parent' => $cateId,
                'post_type' => $postType
            ])->orderBy('category_id')->get();

            if($categories->isEmpty()) {

                return $categorySource;
            }
            $subChild .= '---';
            $level ++;
            foreach ($categories as $cate) {
                $categorySource[] = [
                    'title' => $subChild.$cate->title,
                    'title_show' => $cate->title,
                    'category_id' => $cate->category_id,
                    'parent' => $cate->parent,
                    'image' => $cate->image,
                    'slug' => $cate->slug,
					'updated_at' => $cate->updated_at,
                    'level' => $level
                ];
                $categorySource = $this->getSubCategory($cate->category_id, $categorySource, $postType, $subChild, $level);
            }
        } catch (\Exception $e) {
            $categorySource = null;

            Log::error('Entity->Category->getCategory: Lấy danh mục ra bị lỗi: '.$e->getMessage());
        } finally {
            return $categorySource;
        }
    }

    public static function getChildrenCategory($parent, $postType = 'post') {
        $categories = static::where([
            'parent' => $parent,
            'post_type' => $postType
        ])->orderBy('category_id')->get();

        return $categories;
    }

    // láy ra chi tiết category với slug
    public static function getDetailCategory($slug) {
        $categoryModel = new Category();
        $category = $categoryModel->where('slug', $slug)
            ->first();

        if (empty($category)) {
            return null;
        }
        $inputs = Input::where('cate_id', $category->category_id)->get();
        foreach ($inputs as $input) {
            $category[$input->type_input_slug] = $input->content;
        }
        return $category;
    }
    public static function getDetaicolumDetail($slug) {
        $categoryModel = new Category( );
        $category = $categoryModel->select('title',
            'slug',
            'description',
            'image')->where('slug', $slug)
            ->first();
        return $category;
    }

    // kiểm tra xem với slug thì category tồn tại không
    public static function existCategory($slug) {
        $categoryModel = new Category();

        return $categoryModel->where('slug', $slug)
            ->exists();
    }

}
