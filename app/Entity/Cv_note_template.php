<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class Cv_note_template extends Model
{
    public $timestamps = false;

    protected $table = 'cv_note_template';
    protected $primaryKey = 'cv_note_id';
    protected $fillable = [
        'cv_note_id', 'cv_template_id', 'note_guide','note_cv_personal', 'note_cv_title_career_goals', 'note_cv_title_prize', 'note_cv_title_card', 'note_cv_title_interests', 'note_title_reference_person', 'note_title_cv_skills', 'note_title_cv_specialize', 'note_title_cv_experience', 'note_title_cv_work', 'note_title_cv_project', 'note_cv_info', 'created_at', 'updated_at'
    ];
    public static function get_all($template_id)
    {
        $list = Cv_note_template::select('*')->where('cv_template_id', $template_id)->get();
        return $list;
    }


}
