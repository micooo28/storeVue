<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerAddress;
use App\Models\LoginCredential;
class CustomerInfo extends Model
{
    protected $table = 'customer_personalinfo';
    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_fname',
        'customer_lname',
        'contact_no',
        'address_id',
        'login_id',
    ];
    
    public function loginCredentials(){
        return $this->belongsTo(
            LoginCredential::class,
            'login_id', #this is the foreign key
            'login_id', #this is the primary key
        );
    }

    public function address(){
        return $this->belongsTo(
            CustomerAddress:: class,
            'address_id', #this is the foreign key
            'address_id', #this is the primary key
        );
    }
    public $timestamps = false;
}
