<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forum_post extends Model
{

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'forum_post';

    protected $primaryKey = 'for_post_id';
    protected $fillable = [
        'for_post_id',
        'for_title',
        'for_description',
        'for_content',
        'for_tags',
        'for_slug',
        'for_user_id',
        'for_is_hide',
        'for_image',
        'file_upload',
        'for_post_type',
        'for_user_create_post',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public function categories()
    {
        return $this->belongsToMany('App\Entity\ForumMenu','forum_category_post','for_post_id','for_category_id');
    }
    public function detachCate()
    {
        return $this->categories()->detach();
    }
    public function detachCmt()
    {
        return $this->comments()->detach();
    }

    public function comments()
    {
        return $this->hasMany('App\Entity\ForumComment','for_post_id');
    }

    public function getUser()
    {
        $user = ForumPost::select('*')->where('forum_post.for_user_id', '=','users.id');
        return $user;
    }


}
