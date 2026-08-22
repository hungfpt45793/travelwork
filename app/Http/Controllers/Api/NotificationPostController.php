<?php

namespace App\Http\Controllers\Api;

use App\Entity\Notification_post;
use App\Exam\Exam;
use App\Http\Controllers\Controller;
use Validator;
use JWTAuth;

class NotificationPostController extends Controller
{
    public function list_noti_post()
    {
        $noti_post_model = new Notification_post();
        $list_post = $noti_post_model->select('*')->orderBy('noti_id', 'desc')
            ->paginate(30);
        foreach($list_post as $id=>$post)
        {
            if($post->type == 'exam')
            {
                $id_exam = Exam::where('slug_exam',$post->slug)->value('id_exam');
                $list_post[$id]['id_exam'] = $id_exam;
            }
        }
        if (!empty($list_post)) {
            return response()->json([
                'status' => 200,
                'message_post' => 'Thông báo tin tức mới',
                'list_post' => $list_post,
//                        'user' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message_post' => 'Thông báo tin tức mới',
                'list_post' => $list_post,
            ], 404);
        }
    }

}
