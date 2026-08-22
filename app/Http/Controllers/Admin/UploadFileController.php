<?php

namespace App\Http\Controllers\Admin;

use App\Entity\Category;
use App\Entity\CategoryChildVoucher;
use App\Entity\CategoryVoucher;
use App\Entity\User;
use App\Entity\Voucher;
use App\Ultility\Ultility;
use Faker\Provider\File;
use Illuminate\Http\Request;
use Validator;
use Yajra\DataTables\DataTables;

class UploadFileController extends AdminController
{
    protected $role;

    public function __construct()
    {
        parent::__construct();
        $this->middleware(function ($request, $next) {
            $this->role = Auth::user()->role;

            if (User::isMember($this->role)) {
                return redirect('admin/home');
            }

            view()->share('menuTop', 'voucher');

            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload_file(Request $request,$input_name,$id,$user_id)
    {
        $link_image = '';
        $path_forder_images = public_path('/upload_file_course/'.$user_id);
        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $imageFileType = trim($file->getMimeType());
//            echo $imageFileType;die;
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
            $allowtypes = array('doc', 'docx', 'xlsx', 'xls','pdf');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }
            $name_file = $user_id . '_' . $id . '_' . $file->getClientOriginalName();
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/upload_file_course/'.$user_id.'/'.$name_file ;
            return $link_image;
        }
        return 0;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Entity\Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id_voucher)
    {
        try {
            $sale_money = 0;
            if(!empty($request->input('sale_money')))
            {
                $sale_money = $request->input('sale_money');
            }
            $voucher = new Voucher();
            $voucher_slug = $request->input('slug_voucher');
            if (empty($voucher_slug)) {
                $voucher_slug = Ultility::createSlug($request->input('name_voucher'));
            }
            $update = $voucher->where('id_voucher', $id_voucher)->update([
                'name_voucher' => $request->input('name_voucher'),
                'des_voucher' => $request->input('des_voucher'),
                'image_voucher' => $request->input('image_voucher'),
                'content_voucher' => $request->input('content_voucher'),
                'id_cate_child' => $request->input('id_cate_child'),
                'link_dowload_file' => $request->input('link_dowload_file'),
                'sale_money' =>  $sale_money,
                'meta_title' => $request->input('meta_title'),
                'meta_description' => $request->input('meta_description'),
                'meta_keyword' => $request->input('meta_keyword'),
            ]);
            $postWithSlug = $voucher->where('slug_voucher', $voucher_slug)
                ->where('id_voucher', '!=', $id_voucher)
                ->first();
            if (empty($postWithSlug)) {
                $voucher->where('id_voucher', $id_voucher)
                    ->update([
                        'slug_voucher' => $voucher_slug
                    ]);
            } else {
                $voucher->where('id_voucher', $id_voucher)
                    ->update([
                        'slug_voucher' => $voucher_slug . '-' . $id_voucher
                    ]);
            }
            if (!empty($request->input('checkUploadFile'))) {
                if ($request->hasFile('link_dowload_voucher')) {
                    $list = $voucher->select('*')->where('id_voucher', $id_voucher)->first();
                    if (file_exists($list->link_dowload_voucher))
                    {
                        unlink(public_path('upload/' . $list->link_dowload_voucher));
                    }
                    $file = $request->link_dowload_voucher;
                    $maxsize = 10500000;  //khoang 10Mb
                    if ($file->getSize() >= $maxsize) {
                        return redirect(route('voucher.update', ['id_voucher' => $id_voucher]))->with('error', 'File quá lớn không thể upload');
                    }
                    $name_file = Ultility::createSlug($file->getClientOriginalName()) . $id_voucher . '.' . $file->getClientOriginalExtension();


                    $type = $file->getClientOriginalExtension();
                    $file->move('upload', $name_file);
                    $voucher->where('id_voucher', '=', $id_voucher)
                        ->update([
                            'type_voucher' => $type,
                            'link_dowload_voucher' => $name_file,
                        ]);

                }
            }
            return redirect('admin/voucher')->with('success', 'Sửa tài liệu thành công');
        } catch (\Exception $e) {
            return redirect('admin/voucher')->with('error', 'Sửa  tài liệu thất bại');
        }

    }



}
