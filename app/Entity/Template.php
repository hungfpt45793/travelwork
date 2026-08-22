<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Template extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'template';

    protected $primaryKey = 'template_id';

    protected $fillable = [
        'template_id',
        'title',
        'slug',
        'is_hide',
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public static function getTemplate() {
        try {
            $templateModel = new Template();

            return $templateModel->orderBy('template_id')
                ->get();
        } catch (\Exception $e) {
            Log::error('Lỗi lấy tất cả template '.$e->getMessage());

            return null;
        }
    }
}
