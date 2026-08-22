<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Employer_recruitment extends Model
{
    protected $table = 'employer_recruitment';
    protected $primaryKey = 'id';
    protected $fillable = [
    	'id',
        'item_id',
        'employer_id',
        'title',
        'price_min',
        'price_max',
        'type_price',
        'hidden_wage',
        'expected_nature',
        'expected_province',
        'expected_district',
        'rec_time_trial',
        'rec_number',
        'rec_gender',
        'content',
        'content1',
        'content2',
        'content3',
        'type_apply',
        'exp_submit',
		'exp_submit',
		'arr_apply',
		'hidden_company',
		'hidden_contact',
		'company','address',
		'contact_full_name',
		'contact_phone',
		'contact_email',
		'lang_notification',
		'receive_appropriate',
		'auto_reply',
		'mail_header',
		'mail_content',
		'type_mail',
		'hidden_image',
		'link_youtube',
		'file_attach',
		'title_score',
		'location_score',
		'industry_score',
		'skill_score',
		'salary_score',
		'fit_1',
		'fit_2',
		'fit_3',
		'fit_4',
		'fit_5',
		'friendly_link',
		'meta_title',
		'meta_key',
		'meta_desc',
		'is_show',
		'is_focus',
		'is_approved',
		'is_draft',
		'is_refast',
		'is_complete',
		'is_searchable',
		'show_order',
		'date_refresh',
		'num_refresh',
		'date_create',
		'date_update',
		'lang',
		'num_view',
		'admin_id',
		'admin_full_name',
		'vip_id','vip_type',
		'vip_begin',
		'vip_end',
		'tag_list',
		'tag_list_link'
    ];
    //lấy tất cả danh sách Loại hình donah nghiệp 
    public static function getAll() {
  
    return  static::get();
    }
}
