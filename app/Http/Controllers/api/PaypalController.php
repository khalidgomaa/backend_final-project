<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Srmklive\PayPal\Services\ExpressCheckout;

class PaypalController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function payment(Request $request)
    {
        // $user = Auth::guard('sanctum')->user();
        // $order = Order::all();
        // dd($order);
        $data = [];
        $data['items'] = [
            [
                'name' => 'Product 1',
                'price' => 9.99,
                'desc'  => 'Description for product 1',
                'qty' => 1
            ],
            [
                'name' => 'Product 2',
                'price' => 4.99,
                'desc'  => 'Description for product 2',
                'qty' => 2
            ]
        ];

        $data['invoice_id'] = 1;
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = url('http://127.0.0.1:8000/api/payment/success');
        $data['cancel_url'] = url('http://127.0.0.1:8000/api/cancel');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;

        //give a discount of 10% of the order amount
        $data['shipping_discount'] = round((10 / 100) * $total, 2);

        $provider = new ExpressCheckout;
       

        // Use the following line when creating recurring payment profiles (subscriptions)
        $response = $provider->setExpressCheckout($data, true);

        // This will redirect user to PayPal
        return redirect($response['paypal_link']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function cancel()
    {
        response()->json('you are cancelled this payment');
    }

    /**
     * Display the specified resource.
     */
    public function success(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);
        // dd($response);
        if(in_array(strtoupper($response['ACK']),['SUCCESS','SUCCESSWITHWARNING'])){
            // response()->json('your payment was successfully ');
            dd('success ya 2lb a5oooook');
        }else{
            dd('faild ya 2lb a5oooook');

            // response()->json('please try later ');
        }

    }
}
