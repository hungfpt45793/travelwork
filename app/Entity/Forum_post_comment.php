<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Forum_post_comment extends Model
{
    use SoftDeletes;
    protected $softDelete = true;

    protected $dates = ['deleted_at'];

    protected $table = 'forum_post_comment';

    protected $primaryKey = 'for_comment_id';
    protected $fillable = [
        'for_comment_id',
        'for_post_id',
        'user_id',
        'for_comment_title',
        'for_comment_image',
        'for_comment_parent',
        'total_comment_coin', //tông so xu da tang
        'user_id_update', //tông so xu da tang
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function countComment() {
        try {
            $commentModel = new Comment();

            return $commentModel->select('*')->where('forum_post_comment.for_post_id','=','forum_post.for_post_id')->count();

        } catch (\Exception $e) {
            Log::error('Models->ForumComment->getCountComment: Lỗi tính tổng số comment');

            return 0;
        }
    }

    public function replies()
    {
        return $this->hasMany(Forum_post_comment::class, 'for_comment_parent');
    }
    public function user()
    {
        return $this->hasOne('App\Entity\User','id','user_id')->withDefault(['name' => '']);
    }
    public function commentParent()
    {
        return $this->hasOne('App\Entity\Forum_post_comment','for_comment_id','for_comment_parent')->withDefault(['for_comment_title' => '']);
    }
    public function usercomment()
    {
        return $this->hasOne('App\Entity\User','id','user_id');
    }
    public function comments()
    {
        return $this->hasMany('App\Entity\Forum_post_comment','for_comment_id','for_comment_parent');
    }
    public function comment()
    {
        return $this->belongsTo('App\Entity\Forum_post','for_post_id','for_post_id');
    }
    public function postcomment()
    {
        return $this->hasOne('App\Entity\Forum_post','for_post_id','for_post_id')->withDefault(['for_description' => '']);
    }
    public static function get_total($for_post_id)
    {
        $total  = Forum_post_comment::where('for_post_id',$for_post_id)->count();
        return $total;
    }
    public static function admin_get_comment()
    {
        $comment  = Forum_post_comment::select('forum_post_comment.for_comment_title','forum_post_comment.user_id','forum_post_comment.for_comment_image','forum_post_comment.for_comment_id','forum_post_comment.for_comment_parent','forum_post_comment.created_at','users.name','forum_categories.for_title')
            ->join('users','users.id','=','forum_post_comment.user_id')
            ->join('forum_post','forum_post.for_post_id','=','forum_post_comment.for_post_id')
            ->join('forum_categories','forum_categories.for_category_id','=','forum_post.for_category_id')
            ->orderByDesc('for_comment_id')
            ->paginate(20);
        return $comment;
    }
    public static function get_comment_post($for_post_id,$star,$end)
    {
        $comment  = Forum_post_comment::select('forum_post_comment.for_comment_title','forum_post_comment.total_comment_coin','forum_post_comment.user_id','forum_post_comment.for_comment_image','forum_post_comment.for_comment_id','forum_post_comment.created_at','users.name','users.image','users.diendan_image','users.diendan_role')->where('for_post_id',$for_post_id)
            ->join('users','users.id','=','forum_post_comment.user_id')
            ->orderBy('for_comment_id','desc')
            ->offset($star)
            ->limit($end)
            ->get();
        foreach($comment as $id=>$c)
        {
            $comment[$id]['src_for_comment_image'] = !empty($c->for_comment_image) ? explode(',', $c->for_comment_image) : '';
            $comment[$id]['date_facebook'] = \App\Ultility\Ultility::getdateFacebook($c['created_at']);
        }
        return $comment;
    }
    public static function get_for_comment_id($for_comment_id)
    {
        $comment  = Forum_post_comment::select('forum_post_comment.for_comment_title','forum_post_comment.total_comment_coin','forum_post_comment.user_id','forum_post_comment.for_comment_id','forum_post_comment.for_comment_image','forum_post_comment.created_at','users.name','users.image','users.diendan_image','users.diendan_role')->where('for_comment_id',$for_comment_id)
            ->join('users','users.id','=','forum_post_comment.user_id')
            ->orderBy('for_comment_id','desc')
            ->first();
        $comment['src_for_comment_image'] = !empty($comment->for_comment_image) ? explode(',', $comment->for_comment_image) : '';
        return $comment;
    }
    public static function api_get_for_comment_id($for_comment_id)
    {
        $comment  = Forum_post_comment::select('forum_post_comment.for_comment_title','forum_post_comment.total_comment_coin','forum_post_comment.user_id','forum_post_comment.for_comment_id','forum_post_comment.for_comment_image','forum_post_comment.created_at','users.name','users.diendan_image','users.diendan_role')->where('for_comment_id',$for_comment_id)
            ->join('users','users.id','=','forum_post_comment.user_id')
            ->orderBy('for_comment_id','desc')
            ->first();
        $comment['diendan_image'] = !empty($comment['diendan_image']) ? asset($comment['diendan_image']) : '';
        $list_comment_image = array();
        if(!empty($comment->for_comment_image))
        {
            $list_block_img = explode(',', $comment->for_comment_image);
            foreach ($list_block_img as $id_b => $block_img) {
                $list_comment_image[] = !empty($block_img) ? asset($block_img) : '';
            }
        }
        $comment['list_comment_image'] = $list_comment_image;
        return $comment;
    }
    public static function get_comment()
    {
        $comment  = Forum_post_comment::select('forum_post_comment.for_comment_title','forum_post_comment.user_id','forum_post_comment.for_comment_image','forum_post_comment.for_comment_id','forum_post_comment.for_comment_parent','forum_post_comment.created_at','users.name','users.image','users.diendan_image','forum_categories.for_title')
            ->join('users','users.id','=','forum_post_comment.user_id')
            ->join('forum_post','forum_post.for_post_id','=','forum_post_comment.for_post_id')
            ->join('forum_categories','forum_categories.for_category_id','=','forum_post.for_category_id')
            ->orderByDesc('for_comment_id')
            ->paginate(20);
        return $comment;
    }
    public static function get_comment_post_api($for_post_id,$star,$end)
    {
        $comment  = Forum_post_comment::select('forum_post_comment.for_comment_title','forum_post_comment.total_comment_coin','forum_post_comment.user_id','forum_post_comment.for_comment_image','forum_post_comment.for_comment_id','forum_post_comment.created_at','users.name','users.diendan_image','users.diendan_role')->where('for_post_id',$for_post_id)
            ->join('users','users.id','=','forum_post_comment.user_id')
            ->orderBy('for_comment_id','desc')
            ->offset($star)
            ->limit($end)
            ->get();
        foreach($comment as $id=>$c)
        {
            $comment[$id]['date_facebook'] = \App\Ultility\Ultility::getdateFacebook($c['created_at']);
            $comment[$id]['diendan_image'] = !empty($c['diendan_image']) ? asset($c['diendan_image']) : '';
            $list_comment_image = array();
            if(!empty($c->for_comment_image))
            {
                $list_block_img = explode(',', $c->for_comment_image);
                foreach ($list_block_img as $id_b => $block_img) {
                    $list_comment_image[] = !empty($block_img) ? asset($block_img) : '';
                }
            }
            $comment[$id]['list_comment_image'] = $list_comment_image;
        }
        return $comment;
    }
}
