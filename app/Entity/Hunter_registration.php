<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Hunter_registration extends Model
{
    protected $table = 'hunter_registration';
    protected $primaryKey = 'hunter_regis_id';
    protected $fillable = [
        'hunter_regis_id',
        'hunter_regis_pos',
        'hunter_regis_time',
        'hunter_regis_price',
        'hunter_regis_name',
        'hunter_regis_email',
        'hunter_regis_phone',
        'hunter_regis_province',
        'hunter_regis_district',
        'hunter_regis_address',
        'hunter_regis_note',
        'hunter_regis_status',
        'hunter_regis_code',
        'hunter_tax_code',
        'user_id',
        'employer_id',
        'updated_at',
        'deleted_at',
        'created_at',
    ];
}
