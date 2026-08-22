<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class LanguageLiteracy extends Model
{
    protected $table = 'language_literacy';
    protected $primaryKey = 'lang_id';
    protected $fillable = [
        'lang_id',
        'lang_name',
        'lang_give',
        'lang_salary',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

}
