<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class InformationService extends Model
{
    protected $table = 'information_service';
    protected $primaryKey = 'service_id';
    protected $fillable = [
        'service_id',
        'name_age',
        'title',
        'slug',
        'images',
        'description',
        'content',
        'created_at',
        'updated_at',
    ];
}
