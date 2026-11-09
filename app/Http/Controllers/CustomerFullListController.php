<?php

namespace App\Http\Controllers;

use App\Models\EmploymentModel;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Illuminate\Http\Request;

class CustomerFullListController extends Controller
{
    public function index(Request $request){

        $list = $request->validate([
            'employer' => 'required|integer',
        ]) ;

    $employer = $list['employer'];

    $customers = DB::table('customer_personalinfo as c')
        ->join('employment as e','c.employer','=','e.employer')
        ->leftJoin('item as i','c.customer_id','=','i.user_id')
        ->select(
            'c.customer_id',
            'c.customer_fname',
            'c.customer_lname',            
            'e.employer_name',
            DB::raw('COALESCE(SUM(i.total), 0) as total_amount')
        )->where('e.employer', $employer )
        ->groupBy(
            'c.customer_id',
            'c.customer_fname',
            'c.customer_lname',
            'e.employer_name',
            )
        ->get();

    return Inertia::render('customer/CustomerFullList', [
        'customers' => $customers,
    ]);
    } 
}
