<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Remuneration extends Model
{
    protected $table = 'remunerations';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'remuneration_title',
        'employer_id',
        'deleted_at',
        'updated_at'
    ];

    public static function showFirstEndow($employer){
        return Remuneration::where('employer_id', $employer)
            ->first();
    }

    public static function showEndow($employer){
        $count = Remuneration::where('employer_id', $employer)->count();
        $endows = Remuneration::where('employer_id', $employer)
            ->offset(1)
            ->limit($count)
            ->get();

        return $endows;
    }

    public static function showAllEndow($employer_id){
        return static::where('employer_id', $employer_id);
    }
}
