<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order_request extends Model
{
    use SoftDeletes;

    protected $softDelete = true;

    protected $casts = ['deleted_at' => 'datetime'];

    protected $table = 'order_request';
    protected $primaryKey = 'order_request_id';
    protected $fillable = [
        'order_request_id',
        'order_request_code', 
        'order_request_price', 
        'order_request_discount', 
        'advance_status_pay', 
        'image_pay', 
        'guarantee_time', 
        'user_id', 
        'employer_id', 
        'hunter_regis_id', 
        'hunter_pos', 
        'hunter_time', 
        'job_description', 
        'job_requirements', 
        'welfare', 
        'file_upload_contract', 
        'start_time', 
        'created_at', 
        'updated_at', 
        'deleted_at', 
        'all_status_pay'
    ];
    public function upload_file_contract( $employer_id,$request,$input_name)
    {
        $link_contract = '';
        $path_forder_images = public_path('/library_employer/'.$employer_id);

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
            $allowtypes = array('doc', 'docx','pdf');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }

            $name_file =  'hop-dong-don-hang-' . $employer_id .'.'.$file->getClientOriginalExtension();

            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_contract = '/public/library_employer/'.$employer_id.'/'.$name_file;
            return $link_contract;
        }
        return 0;
    }

    public function upload_image( $employer_id,$request,$input_name)
    {
        $link_contract = '';
        $path_forder_images = public_path('/library_employer/'.$employer_id);

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
            $allowtypes = array('JPG', 'JPEG','PNG', 'jpg', 'jpeg', 'png');
            if (!in_array($imageFileType, $allowtypes) || $file->getSize() >= $maxsize) {
                return 0;
            }

            $name_file =  $file->getClientOriginalName() .'.'.$file->getClientOriginalExtension();

            if (file_exists(public_path($path_forder_images . '/' . $name_file))) {
                unlink(public_path($path_forder_images . '/' . $name_file));
            }
            $file->move($path_forder_images, $name_file);
            $link_contract = '/public/library_employer/'.$employer_id.'/'.$name_file;
            return $link_contract;
        }
        return 0;
    }

}
