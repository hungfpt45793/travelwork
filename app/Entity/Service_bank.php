<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Service_bank extends Model
{
    protected $table = 'service_bank';
    protected $primaryKey = 'service_bank_id';
    protected $fillable = [
        'service_bank_id',
        'service_bank_name',
        'service_bank_number',
        'service_bank_image',
        'service_bank_own',
        'service_bank_branch',
        'service_bank_content',
        'feature',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
}
