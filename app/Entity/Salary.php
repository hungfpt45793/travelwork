<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    protected $table = 'salary';
    protected $primaryKey = 'salary_id';
    protected $fillable = [
        'salary_id',
        'salary_from',
        'salary_to',
        'status_salary',
        'description',
        'created_at',
        'updated_at'
    ];
    public static function showAllSalary () {
        return static::get();
    }
	 public static function showAllSalaryStatus () {
        return static::where('status_salary',0)->get();
      
    }
    public static function getIdSalary($id_salary)
    {
        $salary = new Salary();
        $salary = $salary->select('*')->where('salary_id',$id_salary)->first();
        return $salary;
    }

}
