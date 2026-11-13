<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentModel extends Model
{
    protected $table = "payments";
    protected $primaryKey = "pay_id";
    protected $fillable = [
        "payment_amount",
        "payment_method",
        "date",
        "user_id",
    ] ;
}
