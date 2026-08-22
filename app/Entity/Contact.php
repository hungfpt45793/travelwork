<?php
/**
 * Created by PhpStorm.
 * User: Nam Handsome
 * Date: 12/5/2017
 * Time: 2:07 PM
 */

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
//    use SoftDeletes;
//
//    protected $softDelete = true;
//
//    protected $dates = ['deleted_at'];

    protected $table = 'contact';

    protected $primaryKey = 'contact_id';

    protected $fillable = [
        'contact_id',
        'name',
        'phone',
        'email',
        'address',
        'message',
        'images',
        'status',
        'user_id',
        'status_view',
        'deleted_at',
        'created_at',
        'updated_at'
    ];
    public static function updateView($contact_id)
    {
        $contact =  new Contact();
        $contact->where('contact_id',$contact_id)->update([
            'status_view' => 1,
            'updated_at' => new \DateTime()
        ]);
        return $contact;
    }
}

