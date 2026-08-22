<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class LocalBranch extends Model
{
    protected $table = 'local_branch';
    protected $primaryKey = 'local_branch_id';
    protected $fillable = [
        'local_branch_id',
        'title',
        'slug',
        'phone',
        'address',
        'province_id',
        'local_id',
        'link',
        'created_at',
        'updated_at',
    ];
    public static function getLocal_id($local_id)
    {
        $local_branch = new LocalBranch();
        $local_branch = $local_branch->select('*')
            ->where('local_id',$local_id)
            ->orderBy('local_branch_id','asc')
            ->get();
        return $local_branch;
    }
}
