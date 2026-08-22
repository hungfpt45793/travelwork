<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Status_submit_job extends Model
{
    protected $table = 'status_submit_job';
    protected $primaryKey = 'id_status';
    protected $fillable = [
        'id_status',
        'name_status',
        'status_order',
        'created_at',
        'updated_at',
    ];
    public static function  getAll()
    {
        $list_status = Status_submit_job::select('name_status','id_status','status_order')->orderBy('status_order','asc')->get();
        return $list_status;
    } public static function  get_list($count)
    {
        $list_status = Status_submit_job::select('name_status','id_status','status_order')->orderBy('id_status','desc')->limit($count)->get();
        return $list_status;
    }
}
