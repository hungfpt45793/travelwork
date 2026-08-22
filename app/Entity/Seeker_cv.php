<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Seeker_cv extends Model
{
    protected $table = 'seeker_cv';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'item_id',
        'seeker_id',
        'type',
        'file',
        'title',
        'price_min',
        'price_max',
        'type_price',
        'expected_nature',
        'expected_province',
        'expected_district',
        'expected_target',
        'experience',
        'certificate',
        'language',
        'referencer',
        'skill_main',
        'skill_it',
        'skill_other',
        'skill_hobby',
        'tag_list',
        'tag_list_link',
        'friendly_link',
        'meta_title',
        'meta_key',
        'meta_desc',
        'is_show',
        'is_approved',
        'is_draft',
        'is_complete',
        'is_searchable',
        'is_experience',
        'show_order',
        'date_create',
        'date_update',
        'lang',
        'num_view',
        'admin_id',
        'admin_full_name',
        ];
    //lấy tất cả danh sách Loại hình donah nghiệp 
    public static function getAll() {
  
    return  static::get();
    }
}
