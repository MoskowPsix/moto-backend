<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function paymentForm()
    {
        $merchant_login = 'demo';
        $password_1 = 'F8KDRr8GupU68RCP0ROW';
        $invid = 617;
        $description = 'Тестовая оплата';
        $default_sum = 100;
        $signature_value = md5("$merchant_login:$default_sum:$invid:$password_1");
        $is_test = 1;

        return view('payment.payform', [
            'merchant_login' => $merchant_login,
            'default_sum' => $default_sum,
            'invid' => $invid,
            'description' => urlencode($description),
            'signature_value' => $signature_value,
            'is_test' => $is_test
        ]);
    }
    public function paymentCallBack(Request $request)
    {
        $out_sum = $request->input('DefaultSum');
        $inv_id = $request->input('InvId');
        $signature = $request->input('SignatureValue');

        $password_2 = "kcdUsu2IT8s4S7W8VvjM";

        $expected_signature = strtoupper(md5("$out_sum:$inv_id:$password_2"));

        if ($signature === $expected_signature) {
            return response("OK$inv_id");
        } else {
            return response("Invalid signature", 400);
        }
    }
}
