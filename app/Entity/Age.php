<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Age extends Model
{
    protected $table = 'age';
    protected $primaryKey = 'id_age';
    protected $fillable = [
        'id_age',
        'name_age',
        'id_job',
        'updated_at',
    ];
    public static function getAllAge()
    {
        $age = new Age();
        $age = $age->select('*')->orderBy('id_age', 'asc')->get();
        return $age;
    }
    public static function getIdAge($id_age)
    {
        $age = new Age();
        $age = $age->select('*')->orderBy('id_age', 'asc')->where('id_age',$id_age)->first();
        return $age;
    }
}
