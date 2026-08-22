<?php

namespace App\Http\Controllers\Site;

use App\Entity\Category;
use App\Entity\Input;
use App\Entity\List_teacher_agency;
use App\Entity\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 10/19/2017
 * Time: 9:50 AM
 */
class List_teacher_agencyController extends SiteController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_api_teacher()
    {
        $arrContextOptions = array(
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false,
            ),
        );
        $host_api = 'https://ketoandichvu.com.vn/';
        $api_list_teacher_mb = file_get_contents($host_api . '/api/danh-sach-ke-toan/1', false, stream_context_create($arrContextOptions));
        $api_list_teacher_mt = file_get_contents($host_api . '/api/danh-sach-ke-toan/2', false, stream_context_create($arrContextOptions));
        $api_list_teacher_mn = file_get_contents($host_api . '/api/danh-sach-ke-toan/3', false, stream_context_create($arrContextOptions));

        $api_delete_teacher = file_get_contents($host_api . '/api/danh-sach-ke-toan-da-xoa', false, stream_context_create($arrContextOptions));

        $list_teacher_mb = json_decode($api_list_teacher_mb); // decode the JSON feed
        $list_teacher_mt = json_decode($api_list_teacher_mt); // decode the JSON feed
        $list_teacher_mn = json_decode($api_list_teacher_mn); // decode the JSON feed
        $list_teacher_delete = json_decode($api_delete_teacher); // decode the JSON feed

        if ($list_teacher_mb->status == 200) {
            foreach ($list_teacher_mb->teacher as $item) {
                $teacher_agen = new List_teacher_agency();
                $check_email = $teacher_agen->where('teacher_email', $item->teacher_email)->count();
                if ($check_email > 0) {
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'teacher_id' => $item->teacher_id,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'updated_at' => new \DateTime(),
                        'deleted_at' => NULL,
                    ]);
                } else {
                    //delete truoc rồi xóa sau
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'deleted_at' => new \DateTime(),
                    ]);
                    $inert = $teacher_agen->insertGetId([
                        'teacher_id' => $item->teacher_id,
                        'teacher_email' => $item->teacher_email,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'created_at' => new \DateTime(),
                        'deleted_at' => NULL,
                    ]);
                }
            }
            foreach ($list_teacher_mb->teacher_ex as $item_ex) {
                foreach ($item_ex as $id => $ex) {
                    $check_ex = $teacher_agen->where('teacher_email', $id)->count();
                    if ($check_ex > 0) {
                        $update = $teacher_agen->where('teacher_email', $id)->update([
                            'teacher_min' => $ex,
                            'updated_at' => new \DateTime(),
                        ]);
                    }
                }
            }
        }
        if ($list_teacher_mt->status == 200) {
            foreach ($list_teacher_mt->teacher as $item) {
                $teacher_agen = new List_teacher_agency();
                $check_email = $teacher_agen->where('teacher_email', $item->teacher_email)->count();
                if ($check_email > 0) {
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'teacher_id' => $item->teacher_id,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'updated_at' => new \DateTime(),
                        'deleted_at' => NULL,
                    ]);
                } else {
                    //delete truoc rồi xóa sau
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'deleted_at' => new \DateTime(),
                    ]);
                    $inert = $teacher_agen->insertGetId([
                        'teacher_id' => $item->teacher_id,
                        'teacher_email' => $item->teacher_email,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'created_at' => new \DateTime(),
                        'deleted_at' => NULL,
                    ]);
                }
            }
            foreach ($list_teacher_mt->teacher_ex as $item_ex) {
                foreach ($item_ex as $id => $ex) {
                    $check_ex = $teacher_agen->where('teacher_email', $id)->count();
                    if ($check_ex > 0) {
                        $update = $teacher_agen->where('teacher_email', $id)->update([
                            'teacher_min' => $ex,
                            'updated_at' => new \DateTime(),
                        ]);
                    }
                }
            }
        }
        if ($list_teacher_mn->status == 200) {
            foreach ($list_teacher_mn->teacher as $item) {
                $teacher_agen = new List_teacher_agency();
                $check_email = $teacher_agen->where('teacher_email', $item->teacher_email)->count();
                if ($check_email > 0) {
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'teacher_id' => $item->teacher_id,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'updated_at' => new \DateTime(),
                        'deleted_at' => NULL,
                    ]);
                } else {
                    //delete truoc rồi xóa sau
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'deleted_at' => new \DateTime(),
                    ]);
                    $inert = $teacher_agen->insertGetId([
                        'teacher_id' => $item->teacher_id,
                        'teacher_email' => $item->teacher_email,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'created_at' => new \DateTime(),
                        'deleted_at' => NULL,
                    ]);
                }
            }
            foreach ($list_teacher_mn->teacher_ex as $item_ex) {
                foreach ($item_ex as $id => $ex) {
                    $check_ex = $teacher_agen->where('teacher_email', $id)->count();
                    if ($check_ex > 0) {
                        $update = $teacher_agen->where('teacher_email', $id)->update([
                            'teacher_min' => $ex,
                            'updated_at' => new \DateTime(),
                        ]);
                    }
                }
            }
        }
        if ($list_teacher_delete->status == 200) {
            foreach ($list_teacher_delete->teacher as $item) {
                $teacher_agen = new List_teacher_agency();
                $check_email = $teacher_agen->where('teacher_email', $item->teacher_email)->count();
                if ($check_email > 0) {
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'teacher_id' => $item->teacher_id,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'updated_at' => new \DateTime(),
                        'deleted_at' => new \DateTime(),
                    ]);
                } else {
                    //delete truoc rồi xóa sau
                    $update_agen = $teacher_agen->where('teacher_email', $item->teacher_email)->update([
                        'deleted_at' => new \DateTime(),
                    ]);
                    $inert = $teacher_agen->insertGetId([
                        'teacher_id' => $item->teacher_id,
                        'teacher_email' => $item->teacher_email,
                        'teacher_name' => $item->teacher_name,
                        'teacher_slug' => $item->slug,
                        'local_area' => $item->local_area,
                        'province' => $item->province,
                        'district' => $item->district,
                        'created_at' => new \DateTime(),
                        'deleted_at' => NULL,
                    ]);
                }
            }
            foreach ($list_teacher_mb->teacher_ex as $item_ex) {
                foreach ($item_ex as $id => $ex) {
                    $check_ex = $teacher_agen->where('teacher_email', $id)->count();
                    if ($check_ex > 0) {
                        $update = $teacher_agen->where('teacher_email', $id)->update([
                            'teacher_min' => $ex,
                            'updated_at' => new \DateTime(),
                        ]);
                    }
                }
            }
        }
        return redirect('/');

    }

    public function index($cate_slug, $slug_post)
    {
        if (!empty($this->domainUser)) {
            if (strtotime($this->domainUser->end_at) < time() && ($this->emailUser != 'vn3ctran@gmail.com')) {
                return redirect(route('admin_dateline'));
            }
        }
        $post = $this->getPostDetail($slug_post);
        $category = $this->getCategory($post);
//        echo $slug_post;die();
//print_r($post);die();
//        echo '<pre>';
//        print_r($post);die();

        if (empty($category->template) or $category->template == 'ho-tro') {
            return view('site.default.single_support', compact('post', 'category', 'cate_slug'));
        } elseif (empty($post->template) or $post->template == 'default') {
            return view('site.default.single', compact('post', 'category', 'cate_slug'));
        } else {
            return view('site.template.' . $post->template, compact('post', 'category', 'cate_slug'));
        }
    }

    public static function create_agen($teacher_email,$teacher_name,$teacher_slug,$local_area,$province,$district,$teacher_ex,$teacher_min)
    {
        $teacher_agen = new List_teacher_agency();
        $insert = $teacher_agen->insert([
            'teacher_email' => $teacher_email,
            'teacher_name' => $teacher_name,
            'teacher_slug' => $teacher_slug,
            'local_area' => $local_area,
            'province' => $province,
            'district' => $district,
            'teacher_ex' => $teacher_ex,
            'teacher_min' => $teacher_min,
            'created_at' => new \DateTime(),
        ]);

    }

}
