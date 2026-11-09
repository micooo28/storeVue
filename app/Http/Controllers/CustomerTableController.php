<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerInfo;
use App\Models\Order;
use App\Models\EmploymentModel;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CustomerTableController extends Controller
{
    // public function index(){
    //     $employee = CustomerInfo::select (
    //         'customer_id',
    //         'customer_fname',
    //         'customer_lname',
    //         'employer',
    //         'contact_no',
    //     )->get();

    //     return Inertia::render('customer/Customertable' , [
    //     'employee' => $employee
    //     ]);
    // }

    public function index()
{
    $employee = CustomerInfo::select(
        'customer_id',
        'customer_fname',
        'customer_lname',
        'employer',
        'contact_no',
    )->get()->map(function ($emp_total) {

        $emp_total->total = Order::where(
            'user_id',
            $emp_total->customer_id
        )->sum('initial_amount');
        
        $emp_total->total = Order::where(
            'user_id',
            $emp_total->customer_id
        )->sum('total');


        return $emp_total;
    });
        $employment = EmploymentModel::select(
            'employer',
            'employer_name',
        )->get();

    $items = DB::table('employment as e')
        ->leftJoin(
            'customer_personalinfo as c',
            'e.employer',
            '=',
            'c.employer'
        )
        ->leftJoin(
            'item as i',
            'c.customer_id',
            '=',
            'i.user_id'
        )
        ->select(
            'e.employer',
            'e.employer_name',
            DB::raw('COALESCE(SUM(i.total), 0) as total_amount')
        )
        ->groupBy(
            'e.employer',
            'e.employer_name'
        )
        ->get();
        // $sorted_total = CustomerInfo::select(
        //     'employer',
        // )->distinct()->get()
        // ->map(funtion ($employer_sorted_total))->sum('');
        

    return Inertia::render('customer/Customertable', [
        'employee' => $employee,
        'employment'=> $employment,
        'items' => $items
    ]);
}
}
