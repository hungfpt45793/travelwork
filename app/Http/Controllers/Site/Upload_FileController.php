<?php

namespace App\Http\Controllers\Site;

use App\Entity\User;
use App\Http\Controllers\Controller;
use App\Ultility\Ultility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Course\Course;
use App\Entity\Category;
use App\Entity\Employee;
use App\Entity\EmployerEmployee;
use App\Entity\EmployerTransfer;
use Illuminate\Filesystem\Filesystem;


class Upload_FileController extends Controller
{
    public function upload_image($id, $request, $input_name)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employee/' . $id . '/images/');
        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $imageFileType = trim($file->getClientOriginalExtension());
//            echo $imageFileType;die;
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
            $allowtypes = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }
            $user_model = new User();
            $user_name = $user_model->where('id', $id)->value('name');
            $name_file = str_slug($user_name).$id. '.' . $file->getClientOriginalExtension();
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/library_employee/' . $id . '/images/' . $name_file;
            return $link_image;
        }
        return 0;
    }

    public function upload_file_cv($id, $request, $input_name)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employee_cv/' . $id);

        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $imageFileType = trim($file->getClientOriginalExtension());
//            $imageFileType = trim($file->getMimeType());

            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
            $allowtypes = array('doc', 'docx', 'pdf');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }
            $user_model = new User();
            $user_name = $user_model->where('id', $id)->value('name');
            $name_file = str_slug($user_name) .$id. '.' . $file->getClientOriginalExtension();
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/library_employee_cv/' . $id . '/' . $name_file;
            return $link_image;
        }
        return 0;
    }

    public function move_file_cv($link)
    {
        if (file_exists(public_path($link))) {
            unlink(public_path($link));
        }
        return true;
    }
    //dung api de scrop giam dung luong image
    public function scrop_image_base64($request)
    {
        $path_forder_images = public_path('/library_employee/' . Auth::user()->id . '/images/');
        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }

        $files_uploadted = glob($path_forder_images . '/*'); // get all file names
        foreach ($files_uploadted as $file_uploadted) { // iterate files
            if (is_file($file_uploadted)) {
                unlink($file_uploadted); // delete file
            }
        }
        $random_string = Ultility::create_random_string(2,5);
        $link_image = Ultility::base64_to_jpeg($request->input('image_scrop'), $path_forder_images.str_slug(Auth::user()->name).$random_string.'_base64.png');
        $link_image_new = '/public/library_employee/' . Auth::user()->id . '/images/' . str_slug(Auth::user()->name).$random_string.'_base64.png';
        return $link_image_new;
//        if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
//            unlink(public_path($path_forder_images . '/' . $name_file));
//        }
//        $file->move($path_forder_images, $name_file);
//        $link_image = '/public/library_employee/'.$id.'/images' . '/'.$name_file;
//
//
//
//
//
//        return $link_image;
//        $link_url = '/public/library_employee/' . Auth::user()->id . '/images/'.str_slug(Auth::user()->name).'_base64.png';
//        return $link_url;
    }
    public function upload_tinify_image($id, $file,$slug_name,$url_image)
    {
//        try{
            $link_image = '';
            $path_forder_images = public_path('/library_employee/' . $id . '/images/');
            if (!is_dir($path_forder_images)) {
                mkdir($path_forder_images, 0777, true);
            }
            //Lấy phần mở rộng của file (jpg, png, ...)

            // Cỡ lớn nhất được upload (bytes)
            $filename = $_FILES['images']['name'];
            $location = $path_forder_images . $filename;
            $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
            $imageFileType = strtolower($imageFileType);
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
            $allowtypes = array('jpg', 'png','jpeg', 'gif','jfif','');
            if (!in_array($imageFileType, $allowtypes) || $_FILES['images']['size'] >= $maxsize) {
                return 0;
            }
//            if(!empty($url_image))
//            {
//                if (file_exists(public_path(str_replace("/public/","",$url_image)))) {
//                    unlink(public_path(str_replace("/public/","",$url_image)));
//                }
//            }
            \Tinify\setKey(env('API_TINIFY'));
            $source = \Tinify\fromFile($file);
            $resized = $source->resize(array(
                "method" => "fit",
                "width" => 250,
                "height" => 250
            ));
            $resized->toFile($path_forder_images . $slug_name);
            $link_image = '/public/library_employee/' . $id . '/images/' . $slug_name;
            return $link_image;
//        }catch (\Exception $e)
//        {
//            return 0;
//        }
    }

    public function test_api_upload_image($id, $request, $input_name)
    {

        $link_image = '';
        $path_forder_images = public_path('/library_employee/' . $id . '/images/');
        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile($input_name)) {
            $file = $request->file($input_name);
            $imageFileType = trim($file->getClientOriginalExtension());
//            echo $imageFileType;die;
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
            $allowtypes = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }
            $user_model = new User();
            $user_name = $user_model->where('id', $id)->value('name');
            $name_file = str_slug($user_name).$id. '.' . $file->getClientOriginalExtension();
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {

                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/library_employee/' . $id . '/images/' . $name_file;

            \Tinify\setKey(env("API_TINIFY"));
            $source = \Tinify\fromFile(asset($link_image));
            $source->toFile(asset($link_image));

            return $source;
        }
        return 0;


    }
    public function check_ajax_upload_image($id, $file)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employee/' . $id . '/images/');

        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        /* Getting file name */
        $filename = $file['name'];
        /* Location */
        $location = $path_forder_images . $filename;
        $imageFileType = pathinfo($location,PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        // Cỡ lớn nhất được upload (bytes)
        $maxsize = 10500000;  //khoang 10Mb
        ////Những loại file được phép upload
        $allowtypes = array('jpg', 'png','jpeg', 'gif','jfif','');
        if (!in_array($imageFileType, $allowtypes) || $file['size'] >= $maxsize) {
            return 0;
        }
        return 1;
    }

    public function ajax_upload_image($id, $file)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employee/' . $id . '/images/');

        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        /* Getting file name */
        $filename = $file['name'];
        /* Location */
        $location = $path_forder_images . $filename;
        $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        // Cỡ lớn nhất được upload (bytes)
        $maxsize = 10500000;  //khoang 10Mb
        ////Những loại file được phép upload
        $allowtypes = array('jpg', 'png', 'jpeg', 'gif');
        if ($file['size'] >= $maxsize) {
            return 0;
        }
        $user_model = new User();
        $user_name = $user_model->where('id', $id)->value('name');
        $name_file = str_slug($user_name) . '.' . $imageFileType;

        if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
            unlink(public_path($path_forder_images . '/' . $name_file));
        }
        move_uploaded_file($_FILES['file']['tmp_name'], $path_forder_images . '/' . $name_file);
        $link_image = '/library_employee/' . $id . '/images/' . $name_file;
        return $link_image;

    }
    //ung vien upload cv -> to pdf hoac html
    public function ajax_upload_file_cv($id, $file)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employee_cv/' . $id);

        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        /* Getting file name */
        $filename = $file['name'];
        $real_name = explode('.', $file['name'])[0];
        /* Location */
        $location = $path_forder_images . '/' . $filename;
        $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        // Cỡ lớn nhất được upload (bytes)
        $maxsize = 10500000;  //khoang 10Mb
        ////Những loại file được phép upload
         $allowtypes = array('pdf');
//        $allowtypes = array('pdf');
        if (!in_array($imageFileType, $allowtypes) || $file['size'] >= $maxsize) {
            return 0;
        }
        $user_model = new User();
        $user_name = $user_model->where('id', $id)->value('name');
        $string_random = Ultility::create_random_string(10,15);
        $name_file = $string_random.$id.str_slug($user_name) . '.' . $imageFileType;
        // if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
        //     unlink(public_path($path_forder_images . '/' . $name_file));
        // }
        // array_map('unlink', glob($path_forder_images . '/*'));
        $files_uploadted = glob($path_forder_images . '/*'); // get all file names
        foreach ($files_uploadted as $file_uploadted) { // iterate files
            if (is_file($file_uploadted)) {
                unlink($file_uploadted); // delete file
            }
        }
        // return $files_uploadted;
        move_uploaded_file($_FILES['file']['tmp_name'], $path_forder_images . '/' . $name_file);
        $link_image = '/public/library_employee_cv/' . $id . '/' . $name_file;
        return [$link_image, $imageFileType];

    }
    //ung vien upload cv -> to pdf hoac html danh cho api
    public function api_ajax_upload_file_cv($id, $file)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employee_cv/' . $id);

        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        /* Getting file name */
        $filename = $file['name'];
        $real_name = explode('.', $file['name'])[0];
        /* Location */
        $location = $path_forder_images . '/' . $filename;
        $imageFileType = pathinfo($location, PATHINFO_EXTENSION);
        $imageFileType = strtolower($imageFileType);
        // Cỡ lớn nhất được upload (bytes)
        $maxsize = 10500000;  //khoang 10Mb
        ////Những loại file được phép upload
         $allowtypes = array('pdf');
//        $allowtypes = array('pdf');
        if (!in_array($imageFileType, $allowtypes) || $file['size'] >= $maxsize) {
            return 0;
        }
        $user_model = new User();
        $user_name = $user_model->where('id', $id)->value('name');
        $string_random = Ultility::create_random_string(10,15);
        $name_file = $string_random.$id.str_slug($user_name) . '.' . $imageFileType;
        // if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
        //     unlink(public_path($path_forder_images . '/' . $name_file));
        // }
        // array_map('unlink', glob($path_forder_images . '/*'));
        $files_uploadted = glob($path_forder_images . '/*'); // get all file names
        foreach ($files_uploadted as $file_uploadted) { // iterate files
            if (is_file($file_uploadted)) {
                unlink($file_uploadted); // delete file
            }
        }
        // return $files_uploadted;
        move_uploaded_file($_FILES['file_cv']['tmp_name'], $path_forder_images . '/' . $name_file);
        $link_image = '/public/library_employee_cv/' . $id . '/' . $name_file;
        return [$link_image, $imageFileType];

    }
//    api upload image

    public function api_upload_image_employer($email,$id,$request)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employer/'.$email.'/images/');
        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $imageFileType = trim($file->getClientOriginalExtension());
//            echo $imageFileType;die;
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
//            $allowtypes = array('image/jpg', 'image/png', 'image/jpeg', 'image/gif');
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }
            $user_name = User::where('id',$id)->value('name');
            $name_file = $id . '_' . $user_name;
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/library_employer/'.$email.'/images/mobile' . '/'.$name_file;
            return $link_image;
        }
        return 0;
    }
    //ham nay chinh lai sau
    public function api_upload_list_image_employer($email)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employer/'.$email.'/images/');
        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        $user_name = User::where('email',$email)->value('name');
        //Lấy phần mở rộng của file (jpg, png, ...)
        $file_array = array();
        foreach ($_FILES['images_list']['name']as $id_type=>$file_list_image)
        {
            $file_array[$id_type]['name'] = $_FILES['images_list']['name'][$id_type];
            $file_array[$id_type]['type'] = $_FILES['images_list']['type'][$id_type];
//            $file_array[$id_type]['type'] = trim($_FILES['images_list']['type']->getClientOriginalExtension());
            $file_array[$id_type]['tmp_name'] = $_FILES['images_list']['tmp_name'][$id_type];
            $file_array[$id_type]['error'] = $_FILES['images_list']['error'][$id_type];
            $file_array[$id_type]['size'] = $_FILES['images_list']['size'][$id_type];

            $maxsize = 10500000;  //khoang 10Mb
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif');
//            if (!in_array($_FILES['images_list']['type'][$id_type], $allowtypes) || $_FILES['images_list']['size'][$id_type] >= $maxsize) {
//                return 0;
//            }
            //move_uploaded_file(duong dan luu cline , duong dan luu server)
            move_uploaded_file($_FILES['images_list']['tmp_name'][$id_type], $path_forder_images.$_FILES['images_list']['name'][$id_type]);
            $link_image .= '/public/library_employer/'.$email.'/images/'.$_FILES['images_list']['name'][$id_type].',';
        }
        $link_image = rtrim($link_image, ",");
        return $link_image;

    }
//    api upload image của ung viên
    public function api_upload_image_employee($email,$id,$request)
    {
        $link_image = '';
        $path_forder_images = public_path('/library_employee/'.$id.'/images');
        if (!is_dir($path_forder_images)) {
            mkdir($path_forder_images, 0777, true);
        }
        //Lấy phần mở rộng của file (jpg, png, ...)
        if ($request->hasFile('image')) {
            $file = $request->file('image');
//            $imageFileType = trim($file->getMimeType());
            $imageFileType = trim($file->getClientOriginalExtension());
//            echo $imageFileType;die;
            // Cỡ lớn nhất được upload (bytes)
            $maxsize = 10500000;  //khoang 10Mb
            ////Những loại file được phép upload
            $allowtypes = array('jpg', 'png', 'jpeg', 'gif');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }
            $name_file = $id . '_' . $file->getClientOriginalName();
            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_image = '/public/library_employee/'.$id.'/images' . '/'.$name_file;
            return $link_image;
        }
        return 0;
    }

}
