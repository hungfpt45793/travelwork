<?php

namespace App\Exam;

use Illuminate\Database\Eloquent\Model;

class Type_class extends Model
{
    protected $table = 'type_class';
    protected $primaryKey = 'id_type';
    protected $fillable = [
        'id_type',
        'name_type',
    ];
    public static function getAll()
    {

        $type = Type_class::select('*')->orderBy('id_type', 'asc')->get();
        return $type;
    }
}
