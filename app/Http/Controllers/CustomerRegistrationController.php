<?php

namespace App\Http\Controllers; 
use App\Models\LoginCredential;
use App\Models\CustomerAddress; 
use App\Models\CustomerInfo;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class CustomerRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $registrationInfo = $request->validate([

        // This is Personal Info
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'contact_no' => 'required|string|max:20',
            'employer'=> 'required|numeric|max:20',
            'supervisor'=> 'required|string|max:255',


        // Address
            'street' => 'required|string|max:255',
            'barangay' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'province' => 'required|string|max:255',

        //Login Credential
            'email' => 'required|email|max:255',
            'password' => 'required|string|confirmed|min:8',
        ]);

               DB::transaction(function () use ($registrationInfo) {

            // Login credentials
            $login = LoginCredential::create([
                'email' => $registrationInfo['email'],
                // 'password' => Hash::make($registrationInfo['password']),
                'password' => $registrationInfo['password'],
            ]);

            // address
            $address = CustomerAddress::create([
                'province' => $registrationInfo['province'],
                'city' => $registrationInfo['city'],
                'barangay' => $registrationInfo['barangay'],
                'street' => $registrationInfo['street'] ?? null,
            ]);

            // customer information
            CustomerInfo::create([
                'customer_fname' => $registrationInfo['fname'],
                'customer_lname' => $registrationInfo['lname'],
                'contact_no' => $registrationInfo['contact_no'],
                'supervisor'=> $registrationInfo['supervisor'],
                'employer'=> $registrationInfo['employer'],
                'login_id' => $login->login_id,
                'address_id' => $address->address_id,
            ]);
        });

        return response()->json(['message' => 'Customer registered successfully']);
    }
}


