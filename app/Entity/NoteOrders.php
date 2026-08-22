<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class NoteOrders extends Model
{
    protected $table = 'note_orders';
    protected $primaryKey = 'note_order_id';
    protected $fillable = [
        'note_order_id',
        'order_id',
        'note',
        'created_at',
        'updated_at'
    ];

    public static function GetStatusWithId($order_id){
        $noteOderModel = new NoteOrders();
        $note = $noteOderModel->where('order_id',$order_id)
        ->get()
        ;
        return $note;




    }
}
