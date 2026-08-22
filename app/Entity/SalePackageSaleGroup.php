<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class SalePackageSaleGroup extends Model
{
    protected $table = 'sale_package_spgroup';
    protected $primaryKey = 'sale_package_spgroup_id';
    protected $fillable = [
        'sale_package_spgroup_id',
        'sale_package_id',
        'list_sales_packages_id',
        'total_costs',
        'paid',
        'created_at',
        'updated_at'
    ];
}
