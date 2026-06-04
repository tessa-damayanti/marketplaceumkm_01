<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\CoreApi;
use Midtrans\Transaction;

class CheckoutController extends Controller
{
    private function boot()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized  = config('midtrans.is_sanitized');
        Config::$is3ds        = config('midtrans.is_3ds');
        Config::$curlOptions  = [
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER     => [],
        ];
    }

    public function charge(Request $request)
    {
        $this->boot();

        $request->validate([
            'buyer_name'     => 'required|string',
            'buyer_phone'    => 'required|string',
            'buyer_address'  => 'required|string',
            'grand_total'    => 'required|numeric|min:1',
        ]);

        $orderId = 'TRX-' . time() . '-' . rand(100, 999);
        $amount  = (int) $request->grand_total;

        $txDetail  = ['order_id' => $orderId, 'gross_amount' => $amount];
        $custDetail = ['first_name' => $request->buyer_name, 'phone' => $request->buyer_phone];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken([
                'transaction_details' => $txDetail,
                'customer_details'    => $custDetail,
            ]);

            return response()->json([
                'snap_token' => $snapToken,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function checkStatus(Request $request)
    {
        $this->boot();
        $request->validate(['order_id' => 'required|string']);

        try {
            $s = (array) Transaction::status($request->order_id);
            return response()->json([
                'transaction_status' => $s['transaction_status'] ?? null,
                'fraud_status'       => $s['fraud_status'] ?? null,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
