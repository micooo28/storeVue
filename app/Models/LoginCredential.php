<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\CustomerInfo;

class LoginCredential extends Model
{

    protected $table ='login_credential';
    protected $primaryKey = 'login_id';

    protected $fillable = [
        'email',
        'password',
    ];
    public function customerInfo(){
    
        return $this->hasOne(
            CustomerInfo::class,
            'login_id', #foreign
            'login_id' #primary
        );
    }
    public $timestamps = false;
}
