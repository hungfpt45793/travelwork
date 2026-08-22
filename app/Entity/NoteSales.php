<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class NoteSales extends Model
{
    protected $table = 'note_sales';
    protected $primaryKey = 'note_sale_id';
    protected $fillable = [
        'note_sale_id',
        'sale_package_id',
        'note',
        'created_at',
        'updated_at'
    ];
}
