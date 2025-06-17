<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;

class StripeController extends Controller
{
    public function payment(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $charge = Charge::create([
                'amount' => $request->amount,
                'currency' => 'usd',
                'source' => $request->input('stripeToken'),
                'description' => 'Payment from ExpiryProducts',
            ]);

            $user = Auth::user();

            if ($user && $user->cart) {
                foreach ($user->cart as $cart) {
                    $cart->items()->delete();
                }
            }

            return redirect()->back()->with('success', 'Payment successful! Your cart has been cleared.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function paymentCash(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->cart) {
            foreach ($user->cart as $cart) {
                $cart->items()->delete();
            }
        }

        return redirect()->back()->with('success', 'Paiement en espèces confirmé. Votre panier a été vidé.');
    }
}


