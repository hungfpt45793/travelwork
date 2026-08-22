<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Service_name_benifit extends Model
{
    protected $table = 'service_name_benifit';
    protected $primaryKey = 'service_name_benifit_id';
    protected $fillable = [
        'service_name_benifit_id',
        'service_name_benifit_title',
        'created_at',
        'updated_at',
    ];
}
