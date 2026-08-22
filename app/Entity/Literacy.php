<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Literacy extends Model
{
    protected $table = 'literacies';
    protected $primaryKey = 'literacy_id';
    protected $fillable = [
        'literacy_id',
        'literacy_name',
        'literacy_salary',
        'description',
        'created_at',
        'updated_at'
    ];

    public static function showAllLiteracies()
    {
        return static::get();
    }

    public static function getAll()
    {
        $literacy = new Literacy();
        $literacy = $literacy->select('*')->orderBy('literacy_id', 'asc')->get();
        return $literacy;
    }

    public static function getIdLi($literacy_id)
    {
        $literacy = new Literacy();
        $literacy = $literacy->select('*')->where('literacy_id', $literacy_id)->first();
        return $literacy;
    }

    public function getId($literacy_id)
    {
        $literacy = new Literacy();
        $literacy = $literacy->select('*')->where('literacy_id', $literacy_id)->first();
        return $literacy;
    }

    public static function get_literacy_name($literacy_id)
    {
        $literacy = new Literacy();
        $literacy = $literacy->select('*')
            ->where('literacy_id', $literacy_id)
            ->first();
        return $literacy;
    }

}
