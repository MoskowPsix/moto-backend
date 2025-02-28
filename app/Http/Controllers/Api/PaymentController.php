<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function showPaymentButton(Request $request)
    {
        $merchant_login = "mototrack";
        $password_1 = "F8KDRr8GupU68RCP0ROW";
        $invid = 678678;
        $description = "Тестовая оплата";
        $out_sum = "100";
        $IsTest = 1;
        $signature_value = md5("$merchant_login:$out_sum:$invid:$password_1");

        return view('payment.form', compact(
            'merchant_login',
            'out_sum',
            'invid',
            'description',
            'signature_value',
            'IsTest',
        ));
    }

    public function handleResult(Request $request)
    {
        // Данные из запроса
        $out_sum = $request->input('OutSum');
        $inv_id = $request->input('InvId');
        $signature_value = $request->input('SignatureValue');

        $password_2 = "F8KDRr8GupU68RCP0ROW";

        $expected_signature = strtoupper(md5("$out_sum:$inv_id:$password_2"));

        if (strtoupper($signature_value) === $expected_signature) {
            return response('OK', 200);
        } else {
            // Подпись неверна, возвращаем ошибку
            return response('Invalid signature', 400);
        }
    }

}
