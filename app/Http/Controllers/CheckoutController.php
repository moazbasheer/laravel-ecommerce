<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;
class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user() && request()->is('checkout/guest')) {
            return redirect()->route('checkout.index');
        }
        return view('checkout')->with([
            'discount' => $this->getNumbers()->get('discount'),
            'newSubtotal' => $this->getNumbers()->get('newSubtotal'),
            'newTax' => $this->getNumbers()->get('newTax'),
            'newTotal' => $this->getNumbers()->get('newTotal'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        $result = null;
        Stripe\Stripe::setApiKey(env("STRIPE_SECRET"));
        try {
            $result = Stripe\Token::create([
                "card" => [
                    "name" => $req->name,
                    "number" => $req->card_number,
                    "exp_month" => $req->month_expire,
                    "exp_year" => $req->year_expire,
                    "cvc" => $req->CVC
                ]
            ]);
        } catch(\Exception $e) {
            return redirect()->back()->withErrors("Error! " . $e->getMessage());
        }
        $token = $result['id'];
        // $amount = (float) str_replace(",", "", Cart::instance('default')->total()) * 100;
        try{
            $status = Stripe\Charge::create([
                "amount" => $this->getNumbers()->get('newTotal') * 100,
                "currency" => "usd",
                "card" => $token,
                "description" => "Order"
            ]);
        } catch(\Exception $e) {
            return redirect()->back()->withErrors("Error! " . $e->getMessage());
        }
        Cart::instance('default')->destroy();
        session()->forget('coupon');

        return redirect()->route('cart.index')->with('success_message', 'Payment is done successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    private function getNumbers() {
        $tax = config('cart.tax') / 100;
        $discount = session()->has('coupon')?session()->get('coupon')['discount']:0;
        $newSubtotal = str_replace(",", "", Cart::instance('default')->subtotal()) - $discount;
        $newTax = $newSubtotal * $tax;
        $newTotal = $newSubtotal * (1 + $tax);

        return collect([
            'discount' => $discount,
            'newSubtotal' => $newSubtotal,
            'newTax' => $newTax,
            'newTotal' => $newTotal
        ]);
    }
}
