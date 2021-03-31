<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Session;

class StripeController extends Controller
{
    public function handleGet()
    {
        return view('home');
    }

    /**
     * handling payment with POST
     */
    public function handlePost(Request $request)
    {


        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      	$data =  Stripe\Charge::create ([
                "amount" => 99 * 100,
                "currency" => "bdt",
                "source" => $request->stripeToken,
                "description" => "Making test payment.",
                "receipt_email" => "rony@gmail.com",
                'metadata' => [
                    'contents' => 'test',
                    'quantity' => 2,
                    'discount' => 100,
                ],

                "shipping"=> [
		            'address'=>[
					    "city" => 'Dhaka',
			            "country" => 'Bangladesh',
			            "line1" => "Chilahati, Nilphamari",
			            "line2" => "",
			            "postal_code" => "1209",
			            "state" => 'Rangpur',
		             ],
		             "name"=> "Arafat",
		             "phone" => "016392799",
		          ],





        ]);

    

        if($data['status'] == 'succeeded') {
                    Session::flash('success', 'Money add successfully in wallet.');
                   return back();
                } else {
                    Session::flash('error','Money not add in wallet!!');
                    return back();
                }

        Session::flash('success', 'Payment has been successfully processed.');

        return back();
    }
}
