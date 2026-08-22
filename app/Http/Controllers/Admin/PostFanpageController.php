<?php
/**
 * Created by PhpStorm.
 * User: nam tran
 * Date: 4/25/2018
 * Time: 9:52 AM
 */

namespace App\Http\Controllers\Admin;

use App\Entity\PostFacebook;
use App\Entity\User;
use App\Facebook\Fanpage;
use App\Facebook\People;
use App\Ultility\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PostFanpageController extends AdminController
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

    public function uploadFanpage(Request $request) {
          try {
            $postFacebokModel = new PostFacebook();
            $postFacebok = $postFacebokModel->where('post_id', $request->input('post_id'))->first();
            // nếu chưa tồn tại thì insert
            if (empty($postFacebok)) {
                if (!empty($request->input('fanpages'))) {
                    $faceIds = $this->uploadToFanpage($request);
                }

                if ($request->input('post_me') == 1) {
                    $postIdOld = $this->uploadToMe($request);
                }
                $postFacebokModel->insert([
                    'post_id' => $request->input('post_id'),
                    'content' => $request->input('content'),
                    'images' => $request->input('images'),
                    'link' => $request->input('link'),
                    'name_album' => $request->input('name_album'),
                    'fanpages' => !empty($request->input('fanpages')) ? implode(',', $request->input('fanpages')) : '',
                    'post_me' => $request->has('post_me') ? $request->input('post_me') : 0,
                    'face_ids' => isset($faceIds) ? $faceIds : '',
                    'post_me_id_album' => isset($postIdOld) ? $postIdOld : '',
                    'created_at' => new \DateTime()
                ]);

                return redirect($request->input('current_url'));
            }
			if (!empty($request->input('fanpages'))) {
				$faceIds = $this->uploadToFanpage($request, $postFacebokModel->face_ids);
			}
			
            if ($request->input('post_me') == 1) {
                $postIdOld = $this->uploadToMe($request, $postFacebok->post_me_id_album);
            }

            // nếu tồn tại thì cập nhật lại thông tin
            $postFacebok->update([
                'content' => $request->input('content'),
                'images' => $request->input('images'),
                'link' => $request->input('link'),
                'name_album' => $request->input('name_album'),
                'fanpages' => !empty($request->input('fanpages')) ? implode(',', $request->input('fanpages')) : '',
                'post_me' => $request->has('post_me') ? $request->input('post_me') : 0,
                'face_ids' => isset($faceIds) ? $faceIds : '',
                'post_me_id_album' => isset($postIdOld) ? $postIdOld : '',
                'updated_at' => new \DateTime()
            ]);

            return redirect($request->input('current_url'));
          } catch (\Exception $e) {
              Error::setErrorMessage('Lỗi xảy ra khi tạo mới bài viết: dữ liệu không hợp lệ.');
              Log::error('http->admin->PostController->create: Lỗi xảy ra trong quá trình tạo mới bài viết');

              return redirect('admin/home');
          }
    }

    private function uploadToMe($request, $postIdOld = '') {
        $people = new People();
        // up to me wall

        $nameAlbum = $request->input('name_album');
        $linkFacebook = $request->input('link');

        $postIdOld =  $people->upToMe(
            $postIdOld,
            mb_convert_encoding($request->input('content'), 'UTF-8'),
            $request->input('images'),
            $linkFacebook,
            $nameAlbum
        );
        return $postIdOld;
    }
    private function uploadToFanpage($request, $facebookSave = '') {
        $fanpagePosts = $request->input('fanpages');
        $fanpage = new Fanpage();

        $informationFanpage = $fanpage->getInforFanpage($fanpagePosts, $facebookSave);
		
		$fanpageSaveArray = explode(';', $informationFanpage);
		
        $fanpageSave = $fanpage->postFanpage(
            $fanpageSaveArray,
            mb_convert_encoding($request->input('content'), 'UTF-8'),
            $request->input('images'),
            $request->input('link'),
            $request->input('name_album')
        );

        return $fanpageSave;

    }

}