<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\CustomerInfo;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function store(Request $request)
   {
    $data = $request->validate([
        'items' => 'required|array|min:1',
        'items.*.date_created' => 'required|date',
        'items.*.item_name' => 'required|string|max:255',
        'items.*.quantity' => 'required|numeric|min:1',
        'items.*.amount' => 'required|numeric|min:0',
        'items.*.initial_amount' => 'required|numeric|min:0',
        'items.*.user_id' => 'required|integer|exists:customer_personalinfo,customer_id', 
    ]);

    DB::transaction(function () use ($data) {
        foreach ($data['items'] as $item) {
            Order::create([
                'date_created' => $item['date_created'],
                'item_name' => $item['item_name'],
                'quantity' => $item['quantity'],
                'amount' => $item['amount'],
                'total' => $item['quantity'] * $item['amount'],
                'initial_amount' => $item['quantity'] * $item['amount'],
                'user_id' => $item['user_id'],
           ]);
        }
    });

    return redirect()->back()->with('success', 'Orders successfully saved!');
}
public function index()
{
    $employee = CustomerInfo::select(
        'customer_id',
        'customer_fname',
        'customer_lname',
    )->get();



    return Inertia::render('customer/Customersorder', [
        'employee' => $employee
    ]);
}
}