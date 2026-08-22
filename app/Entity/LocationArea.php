<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class LocationArea extends Model
{
    protected $table = 'location_area';
    protected $primaryKey = 'local_id';
    protected $fillable = [
        'local_id',
        'title',
        'slug',
        'created_at',
        'updated_at',
    ];
    public static function getAll()
    {
        $localtion = new LocationArea();
        $localtion = $localtion->select('*')
            ->orderBy('local_id','asc')
            ->get();
        return $localtion;
    }
    public static function getId($local_id)
    {
        $localtion = new LocationArea();
        $localtion = $localtion->select('*')
            ->where('local_id',$local_id)
            ->first();
        return $localtion;
    }
}
