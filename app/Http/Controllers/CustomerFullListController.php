<?php

namespace App\Http\Controllers;

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
    ->join('employment as e', 'c.employer', '=', 'e.employer')
    ->leftJoin('item as i', 'c.customer_id', '=', 'i.user_id')
    ->leftJoin('payments as p', 'c.customer_id', '=', 'i.user_id')
    ->select(
        'c.customer_id',
        'c.customer_fname',
        'c.customer_lname',
        'e.employer_name',
        'e.employer',
        DB::raw('COALESCE(SUM(i.total), 0) as total_amount')
    )
    ->where('e.employer', $employer)
    ->groupBy(
        'c.customer_id',
        'c.customer_fname',
        'c.customer_lname',
        'e.employer_name',
        'e.employer'
    )
    ->get();
    $customerIds = $customers->pluck('customer_id');

$items = DB::table('item')
    ->whereIn('user_id', $customerIds)
    ->select(
        'item_id',
        'user_id',
        'item_name',
        'quantity',
        'amount',
        'total',
        'date_created',
    )
    ->get()
    ->groupBy('user_id');

$totalPayments = DB::table('payments')
    ->whereIn('user_id', $customerIds)
    ->select(
        'user_id',
        DB::raw('SUM(payment_amount) as total_payment')
    )
    ->groupBy(
        'user_id')
    ->get()
    ->keyBy('user_id');

$payment = DB::table('payments')
    ->whereIn('user_id', $customerIds)
    ->select(
        'user_id',
        'payment_amount',
        'pay_method',
        'date',
    )
    ->get()
    ->groupBy('user_id');


    $customers = $customers->map(function ($customer) use ($items, $totalPayments, $payment) {

    $customer->items = $items
    ->get($customer->customer_id, collect())
    ->values();

    $customer->payment = $payment
    ->get($customer->customer_id, collect())
    ->values();

    $customer->total_payment = $totalPayments
    ->get($customer->customer_id)->total_payment ?? 0;

    return $customer;
});
    return Inertia::render('customer/CustomerFullList', [
        'customers' => $customers,
    ]);
    } 
}
