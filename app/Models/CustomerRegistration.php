<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerRegistration extends Model
{
    public function customerInfo(){
        return @$this->hasOne(CustomerInfo::class, 'customer_id', 'customer_id');
    }
}
