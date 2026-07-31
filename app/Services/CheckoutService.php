<?php

namespace App\Services;

use App\Models\Order;
use Stripe\StripeClient;

class CheckoutService
{
    protected StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    public function createPaymentIntent(Order $order): array
    {
        $paymentIntent = $this->stripe->paymentIntents->create([
            'amount' => (int) ($order->total * 100),
            'currency' => 'usd',
            'metadata' => [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
            ],
            'automatic_payment_methods' => ['enabled' => true],
        ]);

        return [
            'client_secret' => $paymentIntent->client_secret,
            'payment_intent_id' => $paymentIntent->id,
        ];
    }
}
