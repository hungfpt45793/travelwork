<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Template_email extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'template_email';

    protected $primaryKey = 'id_tem';

    protected $fillable = [
        'id_tem',
        'name_tem', //Tên của template email
        'slug_tem',
        'subject_tem', //Tiêu đề của email khi gửi
        'content_tem', //	Nội dung của email có truyền biên {var}
        'id_cate_tem', //Danh mục email
        'status_tem', //Trạng thái của template xem có hiển thị không: 0 là không hiện ; 1 là hiện
        'status_people', //	1:gửi cho ứng viên; 2 gửi cho nhà tuyển dung , 3 gửi cho ứng viên
        'created_at',
        'updated_at'
    ];
    public static function getTotal($id_cate_tem)
    {
        $template_email_model = new Template_email();
        $total = $template_email_model->select('*')->where('id_cate_tem',$id_cate_tem)->count();
        if(empty($total))
        {
            $total = 0;
        }
        return $total;
    }

}
