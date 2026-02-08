<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Payments\Thawani;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class PaymentsController extends Controller
{
    public function create()
    {
        $client = new Thawani(
            config('services.thawani.secret'),
            config('services.thawani.publishable_key'),
            'test'
        );


        $data = [
            'client_reference_id' => 'Test Payment 1',
            'mode' => 'payment',
            'products' => [
                [
                    'name' => 'Test Product',
                    'unit_amount' => 100 * 100,
                    'quantity' => 2
                ]
            ],
            'success_url' => route('paymentCallback.success'),
            'cancel_url' => route('paymentCallback.cancel')
        ];

        try {
            $session_id = $client->createCheckoutSession($data);
            # saving the data into database
            $payment = Payment::forceCreate([
                'user_id' => auth()->user()->id,
                'gateway' => 'thawani',
                'reference_id' => $session_id,
                'amount' => 100 * 100,
                'status' => 'pending'
            ]);
            Session::put('payment_id', $payment->id);
            Session::put('session_id', $session_id);

            return redirect()->away($client->getPayUrl($session_id));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
