<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 5/2/2018
 * Time: 9:53 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\User;
use App\Facebook\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Facebook\Fanpage;
use App\Facebook\People;

class CommentFacebookController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role =  Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            return $next($request);
        });
    }

    public function pushComment() {
        $faceId = '1848604152121513';
        Comment::pushComment($faceId);
    }
}