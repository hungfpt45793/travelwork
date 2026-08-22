<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Notification_employer extends Model
{
    protected $table = 'notification_employer';
    protected $primaryKey = 'noti_id';
    protected $fillable = [
        'noti_id',
        'title_noti', //tiêu đề thông báo
        'user_id', //	0 là thông báo chung
        'des_noti', //Nội dung thông báo
        'link_noti', //Link thông báo trên window
        'type_noti', //kiểu thông báo  /notification_employer  //employer thông báo của nhà tuyển dụng //employees thong bao ung vien thông báo dựa theo table job //jobs là thông báo về công việc //detail_employee ra chi tiết ứng viên
        'noti_status',//trạng thái thông báo 0 là chưa xem 1 đã xem
        'status_noti', //trạng thái thông báo 1 là đã xem 2 là đã xóa => tạm thời bỏ
        'view_noti', //Đã hiển thị thông báo ở cửa sơ window
        'employee_id',
        'type_job', //view là thông báo tin tuyển dụng đạt 50view , còn submit_date là tin tuyển dụng sắp hết hạn
        'job_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
