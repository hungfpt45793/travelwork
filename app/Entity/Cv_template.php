<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Cv_template extends Model
{

    protected $casts = ['deleted_at' => 'datetime'];
    public $timestamps = false;

    protected $table = 'cv_template';
    protected $primaryKey = 'cv_template_id';
    protected $fillable = [
        'cv_template_id',
        'cv_career_category_id',
        'user_id',
        'cv_template_title',
        'cv_template_slug',
        'cv_template_image',
        'cv_template_content',
        'cv_title',
        'cv_name',
        'cv_title_job',
        'cv_image',
        'cv_email',
        'cv_phone',
        'cv_birthday',
        'cv_address',
        'cv_facebook',
        'cv_title_career_goals',
        'cv_career_goals',
        'cv_title_prize',
        'cv_prize',
        'cv_title_card',
        'cv_card',
        'cv_title_interests',
        'cv_interests',
        'cv_title_reference_person',
        'cv_reference_person',
        'title_cv_skills',
        'title_cv_specialize',
        'title_cv_experience',
        'title_cv_work',
        'title_cv_project',
        'title_cv_info',
        'cv_order',
        'show_hidden_cv_order',
        'cv_order_join',
        'show_hidden_cv_order_join',
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    public static function get_template()
    {
        $cv_template = Cv_template::select('*')->first();
        return $cv_template;
    }

}
