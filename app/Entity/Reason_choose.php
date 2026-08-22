<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Reason_choose extends Model
{
    protected $table = 'reason_chooses';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'reason_choose_title',
        'employer_id',
        'deleted_at',
        'updated_at'
    ];

    public static function showReason($employer){
        $count = Reason_choose::where('employer_id', $employer)->count();
        $reasons = Reason_choose::where('employer_id', $employer)
            ->offset(1)
            ->limit($count)
            ->get();
        return $reasons;
    }

    public static function showFirstReason($employer){
        return Reason_choose::where('employer_id', $employer)
            ->first();
    }

    public static function showAllReason($employer_id){
        return static::where('employer_id', $employer_id);
    }
}
