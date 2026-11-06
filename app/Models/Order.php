<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
        protected $table = 'item';

        protected $fillable = [
        'date_created',
        'item_name',
        'quantity',
        'amount',
        'total',
        'initial_amount',
        'user_id'
    ];
    public function customerId(){
        return $this->belongsTo(
            CustomerInfo::class,
            'user_id', #foreign key
            'customer_id' #primary key
        );
    }

    public $timestamps = false;
}
