<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SaleGroup extends Model
{
    protected $table = 'list_sales_packages';
    protected $primaryKey = 'list_sales_packages_id';
    protected $fillable = [
        'list_sales_packages_id',
        'list_sales_packages_name',
        'description',
        'quantity',
        'total_costs',
        'paid',
        'created_at',
        'updated_at'
    ];
}
