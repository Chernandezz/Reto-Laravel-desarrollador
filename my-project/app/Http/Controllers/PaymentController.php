<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayU\Core\Config;
use PayU\Core\PayUConfig;
use PayU\Core\Transaction;
use PayU\Payments\Api\PaymentApi;
use PayU\Payments\Model\Payment;

class PaymentController extends Controller
{
    public function pay(Request $request)
    {
        // Configurar las credenciales de PayU
        Config::setEnvironment(env('PAYU_TEST') ? 'sandbox' : 'production');
        PayUConfig::setAccountId(env('PAYU_ACCOUNT_ID'));
        PayUConfig::setMerchantId(env('PAYU_MERCHANT_ID'));
        PayUConfig::setApiKey(env('PAYU_API_KEY'));
        PayUConfig::setApiLogin(env('PAYU_API_LOGIN'));

        // Crear la transacción con los datos del pago
        $transaction = new Transaction();
        $transaction->setOrder($request->get('order_id'), $request->get('description'), $request->get('amount'));
        $transaction->setBuyer($request->get('buyer_name'), $request->get('buyer_email'), $request->get('buyer_phone'));
        $transaction->setShippingAddress($request->get('shipping_address'));

        // Realizar el pago
        $payment = new Payment();
        $payment->setTransaction($transaction);
        $api = new PaymentApi();
        $response = $api->doPayment($payment);

        // Retornar la respuesta de PayU
        return response()->json($response);
    }
}
