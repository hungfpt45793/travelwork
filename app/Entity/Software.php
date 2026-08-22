<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    protected $table = 'software';
    protected $primaryKey = 'software_id';
    protected $fillable = [
      'software_id',
      'software_name',
      'software_give',
      'software_salary',
      'created_at',
      'updated_at'
    ];
    public  static  function getAll()
    {
        $software = new Software();
        $software  =$software->select('*')->orderBy('software_id','asc')->get();
        return $software;
    }
    public  static  function getId($software_id)
    {
        $software = new Software();
        $software  =$software->select('*')->where('software_id',$software_id)->first();
        return $software;
    }

}
