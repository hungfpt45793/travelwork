<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $table = 'experience';
    protected $primaryKey = 'experience_id';
    protected $fillable = [
        'experience_id',
        'experience_name',
        'experience_des',
        'experience_month',
        'updated_at'
    ];
    public static function getAllEx()
    {
        $exper = new Experience();
        $exper = $exper->select('*')->orderBy('experience_id', 'asc')->get();
        return $exper;
    }
    public static function getIdEx($id_exper)
    {
        $exper = new Experience();
        $exper = $exper->select('*')->orderBy('experience_id','asc')->where('experience_id',$id_exper)->first();
        return $exper;
    }
}
