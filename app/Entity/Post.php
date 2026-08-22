<?php

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Post extends Model 
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    use Rating;
    
    protected $table = 'posts';

    protected $primaryKey = 'post_id';

    protected $fillable = [
        'post_id',
        'title',
        'slug',
        'description',
        'tags',
        'content',
        'template',
        'image',
        'post_type',
        'parents',
        'is_hide',
        'visiable',
        'campain_getfly',
        'campain_status',
        'form_status', // 1. nhà tuyển dụng, 2. ứng viên
        'meta_title',
        'meta_description',
        'meta_keyword',
        'category_string',
        'product_list',
        'deleted_at',
        'created_at',
        'updated_at',
        'sale_money',
        'post_question',
        'noti_post',
        'user_create_post',
        'user_update_post',
    ];

    public function categoryPost () {
        return $this->belongsTo('App\Entity\CategoryPost', 'category_id');
    }
    
    public static function newPost($countPost = 8) {
        try {
            $postModel = new Post();

            $posts = $postModel->where('posts.post_type', 'post')
//                ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
//                ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
//                ->where('categories.slug', $slug)
                ->select(
                    'posts.*'
                )
                ->where('visiable', 0)
//				 ->where('category_post.deleted_at','=' , null)
                ->orderBy('posts.post_id', 'desc')
                ->offset(0)
                ->limit($countPost)->get();

            foreach ($posts as $id => $post) {
                $inputs = Input::where('post_id', $post->post_id)
                    ->get();
                foreach ($inputs as $input) {
                    $posts[$id][$input->type_input_slug] = $input->content;
                }
            }

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->newPost: Lỗi lấy bài viết mới nhất.');

            return array();
        }

    }

    public static function categoryShow($categorySlug, $countPost = 5) {
        try {
            $postModel = new Post();
            $categoryModel = new Category();
            $category = $categoryModel->where('slug', $categorySlug)
                ->where('post_type', 'post')
                ->first();

            $posts = $postModel->join('category_post', 'category_post.post_id', '=', 'posts.post_id')
                ->select(
                    'posts.title',
                    'posts.slug',
                    'posts.image',
                    'posts.description'
                )
                ->where('category_post.category_id', $category->category_id)
                ->where('visiable', 0)
                ->offset(0)
                ->limit($countPost)
                ->orderBy('posts.post_id', 'desc')
				->distinct()
                ->where('category_post.deleted_at', null)
				->get();

            foreach ($posts as $id => $post) {
                $inputs = Input::where('post_id', $post->post_id)
                    ->get();
                foreach ($inputs as $input) {
                    $posts[$id][$input->type_input_slug] = $input->content;
                }
            }
            
            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->categoryShow: Lỗi bài viết theo danh mục.');

            return array();
        }

    }
    public static function categoryShowAsc($categorySlug, $countPost = 5) {
        try {
            $postModel = new Post();
            $categoryModel = new Category();
            $category = $categoryModel->where('slug', $categorySlug)
                ->where('post_type', 'post')
                ->first();

            $posts = $postModel->join('category_post', 'category_post.post_id', '=', 'posts.post_id')
                ->select('posts.title','posts.slug','posts.content','posts.post_id')
                ->where('category_post.category_id', $category->category_id)
                ->where('visiable', 0)
                ->offset(0)
                ->limit($countPost)
                ->orderBy('posts.post_id', 'asc')
                ->distinct()
                ->where('category_post.deleted_at', null)
                ->get();

            foreach ($posts as $id => $post) {
                $inputs = Input::select(
                    'type_input_slug',
                    'content'
                )
                ->where('post_id', $post->post_id)
                ->get();
                foreach ($inputs as $input) {
                    $posts[$id][$input->type_input_slug] = $input->content;
                }
            }

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->categoryShow: Lỗi bài viết theo danh mục.');

            return array();
        }

    }
    public static function get_post_id($post_id)
    {
        $postModel = new Post();
        $post = $postModel->select('post_id',
            'title',
            'slug',
            'description',
            'tags',
            'content',
            'template',
            'image',
            'post_type',
            'form_status', // 1. nhà tuyển dụng, 2. ứng viên
            'meta_title',
            'meta_description',
            'deleted_at',
            'created_at',
            'updated_at',
            'sale_money')
            ->where('post_id',$post_id)->first();
        return $post;
    }



    public static function subPostShow($subPostSlug, $countPost = 5) {
        try {
            $postModel = new Post();

            $posts = $postModel->join('sub_post', 'sub_post.post_id', '=', 'posts.post_id')
                ->select('posts.*')
                ->where('type_sub_post_slug', $subPostSlug)
                ->where('visiable', 0)
                ->offset(0)
                ->limit($countPost)
                ->get();

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->SubPostShow: Lỗi bài viết theo danh mục.');

            return array();
        }

    }

    public static function relativeProduct($slug, $countProduct = 4) {
        try {
            $postModel = new Post();

            $categoriesDB = $postModel->where('posts.post_type', 'post')
                ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
                ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
                ->where('posts.slug', $slug)
                ->where('visiable', 0)
                ->select(
                    'categories.category_id'
                )
                ->get();

            $categories = array();
            foreach($categoriesDB as $category) {
                $categories[] =  $category->category_id;
            }

            $posts = $postModel->where('posts.post_type', 'post')
                ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
                ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
                ->whereIn('categories.category_id', $categories)
                ->select(
                    'posts.*'
                )
                ->where('visiable', 0)
                ->where('posts.slug','!=' , $slug)
                ->offset(0)
                ->limit($countProduct)->distinct()->get();

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->relativeProduct: Lỗi lấy bài viết liên quan.');

            return array();
        }

    }
    public static function show_relative_Product($slug, $countProduct = 4) {
        try {
            $postModel = new Post();

            $categoriesDB = $postModel->where('posts.post_type', 'post')
                ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
                ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
                ->where('posts.slug', $slug)
                ->where('visiable', 0)
                ->select(
                    'categories.category_id'
                )
                ->get();

            $categories = array();
            foreach($categoriesDB as $category) {
                $categories[] =  $category->category_id;
            }

            $posts = $postModel->where('posts.post_type', 'post')
                ->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
                ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
                ->whereIn('categories.category_id', $categories)
                ->select(
                    'posts.title',
                    'posts.slug',
                    'posts.description'
                )
                ->where('visiable', 0)
                ->where('posts.slug','!=' , $slug)
                ->orderBy('posts.post_id','desc')
                ->offset(0)
                ->limit($countProduct)->distinct()->get();

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->relativeProduct: Lỗi lấy bài viết liên quan.');

            return array();
        }

    }
    public static function relativeMoney() {
        try {
            $postModel = new Post();

            $posts = $postModel->select('*')->where('posts.post_type', 'post')
                ->where('visiable', 0)
                ->where('posts.sale_money', 1)
                ->distinct()->get();

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->relativeProduct: Lỗi lấy bài viết liên quan.');

            return array();
        }

    }
    public static function show_relative_Money($countProduct) {
        try {
            $postModel = new Post();

            $posts = $postModel->select( 'title',
                'slug',
                'description'
            )->where('posts.post_type', 'post')
                ->where('visiable', 0)
                ->where('posts.sale_money', 1)
                ->limit($countProduct)->distinct()->get();

            return $posts;
        } catch (\Exception $e) {
            Log::error('Entity->Post->relativeProduct: Lỗi lấy bài viết liên quan.');

            return array();
        }

    }

    public static function getBreadcrumb($postId, $categorySlug) {
        try {
            $postModel = new Post();

            $categoriesDB = $postModel->join('category_post', 'posts.post_id', '=', 'category_post.post_id')
                ->join('categories', 'category_post.category_id', '=', 'categories.category_id')
                ->where('posts.post_id', $postId)
                ->where('visiable', 0)
                ->select(
                    'categories.*'
                )
                ->get();

            // lấy ra tập categoryIDs
            $categoryIDs = array();
            foreach ($categoriesDB as $cate) {
                $categoryIDs[] = $cate->category_id;
            }

            $post = $postModel->where('post_id', $postId)
                ->first();

            static::showBreadCrumb($post->post_type, $categoryIDs, $post);

            if ($post->post_type == 'post') {
                echo '<a href="'. route('post', ['cate_slug' => $categorySlug , 'post_slug' => $post->slug]).'" class="active">'.$post->title.'</a>';

                return ;
            }

            echo '<a href="'.route('product', [ 'post_slug' => $post->slug]).'" class="active">'.$post->title.'</a>';

            return ;
        } catch (\Exception $e) {
            Log::error('Entity->Post->relativeProduct: Lỗi lấy breadcrumb.');

            return array();
        }

    }

    private static function showBreadCrumb($postType, $categoryIDs, $post) {
        $categoryModel = new Category();
        $categories = $categoryModel->getCategory($postType);

        echo '<a href="/">Trang chủ</a> <i class="fa fa-angle-double-right" aria-hidden="true"></i>';

        $stringShowCates = array();
        foreach ($categories as $cate) {
            if (in_array($cate->category_id, $categoryIDs) != false) {
                $stringShowCates[] = static::showCateRouteBreadCrumb($postType, $cate->slug, $cate->title);
            }
        }

        if (!empty($stringShowCates)) {
            echo implode(', ', $stringShowCates). ' <i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        }

        $level = 2;
        while ($level < 6) {
            $stringShowCates = array();
            foreach ($categories as $cate) {
                if (isset($cate['sub_children'])) {
                    foreach ($cate['sub_children'] as $cateChildren) {
                        if ($cateChildren['level'] == $level && in_array($cateChildren['category_id'], $categoryIDs) != false) {
                            $stringShowCates[] = static::showCateRouteBreadCrumb($postType, $cateChildren['slug'], $cateChildren['title_show']);
                        }
                    }
                }
            }

            if (!empty($stringShowCates)) {
                echo implode(', ', $stringShowCates). ' <i class="fa fa-angle-double-right" aria-hidden="true"></i> ';
            }

            $level ++;
        }
    }

    private static function showCateRouteBreadCrumb($postType, $categorySlug, $categoryTitle) {
        if ($postType == 'post') {
            return '<a href="'.route('site_category_post', ['cate_slug' => $categorySlug]).'"> '.$categoryTitle.'</a>';
        }

        return '<a href="'.route('site_category_product', ['cate_slug' => $categorySlug]).'"> '.$categoryTitle.'</a>';
    }

    public static function getPostDetail($slug) {
		try {
			
			$postModel = new Post();
			$inputModel = new Input();

			$post = $postModel->where('slug', $slug)
	//            ->where('post_type', 'post')
				->first();

			$inputs = $inputModel->where('post_id', $post->post_id)->get();
			foreach ($inputs as $input) {
				$post[$input->type_input_slug] = $input->content;
			}

			return $post;
		} catch(\Exception $e) {
			return null;
		}
        
    }
}
