<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $fillable = [
        'name_role',
        'role',
        'created_at',
        'updated_at',
    ];
    public static function get_role()
    {
        return $role =  Role::get();
    }
    public static function get_name($role)
    {
        return $role =  Role::where('role',$role)->first();
    }
    public static function get_role_id()
    {
        return $list_role =  Role::select('role')->get();
    }
}
