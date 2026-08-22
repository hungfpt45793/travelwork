<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Service_benifit extends Model
{
    protected $table = 'service_benifit';
    protected $primaryKey = 'service_benifit_id';
    protected $fillable = [
        'service_benifit_id',
        'service_benifit_name',
        'created_at',
        'updated_at'
    ];
}
