<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerInfo;
class CustomerAddress extends Model
{
   protected $table = 'customer_address';
   protected $primaryKey = 'address_id';

   protected $fillable = [
    'street',
    'barangay',
    'city',
    'province',
   ];

   public function customerInfo(){
    
    return $this->hasOne(
        CustomerInfo::class,
        'address_id', #foreign
        'address_id' #primary
    );
    
   }
   public $timestamps = false;
}
