<?php

namespace App\Entity;

use Illuminate\Database\Eloquent\Model;

class Send_user_email_marketting extends Model
{
    protected $table = 'send_user_email_marketting';
    protected $primaryKey = 'send_id';
    protected $fillable = [
        'send_id',
        'email',
        'send_date',
        'created_at',
        'updated_at',
    ];

    public static function delete_email()
    {
        $day_date = new \DateTime();
        $post_sale_model = new Send_user_email_marketting();
        $check_sale = $post_sale_model->whereDate('send_date', '!=', date_format($day_date, "Y/m/d"))
            ->delete();
    }

    public static function insert_email($email)
    {
        $day_date = new \DateTime();
        $post_sale_model = new Send_user_email_marketting();
        $check_sale = $post_sale_model->insertGetId([
            'email' => $email,
            'send_date' => date_format($day_date, "Y/m/d"),
            'created_at' => new \DateTime()
        ]);
    }
}
