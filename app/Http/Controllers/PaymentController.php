<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\PaymentModel;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request){
        $data = $request->validate([
            "customer_id"=> "required|numeric",
            "employer"=> "required|numeric",
            "date_paid"=> "required|date",
            "amount"=> "required|numeric|min:1",
            "method_pay"=> "required|string|max:255",
        ]);

        DB::transaction(function () use ($data) {

        $remainingPayment = (float) $data['amount'];

        // Get customer's unpaid items, oldest first
        $items = DB::table('item')
            ->where('user_id', $data['customer_id'])
            ->where('total', '>', 0)
            ->orderBy('date_created')
            ->orderBy('item_id')
            ->lockForUpdate()
            ->get();

        $totalBalance = $items->sum('total');

        if ($remainingPayment > $totalBalance) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'payment_amount' => 'Payment exceeds the outstanding balance.',
            ]);
        }

        // Deduct payment from individual items
        foreach ($items as $item) {

            if ($remainingPayment <= 0) {
                break;
            }

            $itemBalance = (float) $item->total;

            $deduction = min($remainingPayment, $itemBalance);

            $newBalance = round($itemBalance - $deduction, 2);

            DB::table('item')
                ->where('item_id', $item->item_id)
                ->update([
                    'total' => $newBalance,
                ]);

            $remainingPayment = round(
                $remainingPayment - $deduction,
                2
            );
        }

        // Save payment history
        DB::table('payments')->insert([
            'user_id' => $data['customer_id'],
            'date' => $data['date_paid'],
            'payment_amount' => $data['amount'],
            'pay_method' => $data['method_pay'],
        ]);
    });

    return redirect()->route('fullList', [
    'employer' => $data['employer'],
])->with('success', 'Payment successfully recorded!');

    }
}
