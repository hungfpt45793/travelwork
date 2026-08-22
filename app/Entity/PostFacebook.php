<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 4/25/2018
 * Time: 9:39 AM
 */

namespace App\Entity;

use App\Support\Rating\Ratingable as Rating;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class PostFacebook extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    use Rating;

    protected $table = 'post_facebook';

    protected $primaryKey = 'post_facebook_id';

    protected $fillable = [
        'post_facebook_id',
        'post_id',
        'content',
        'images',
        'link',
        'name_album',
        'post_me',
        'fanpages',
        'post_me_id_album',
        'face_ids',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public static function getDetail($postId) {
        $postFacebook = static::where('post_id', $postId)->first();

        return $postFacebook;
    }
}