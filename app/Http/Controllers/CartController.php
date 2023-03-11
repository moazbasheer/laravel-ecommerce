<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Validator;
class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mightAlsoLike = Product::inRandomOrder()->limit(4)->get();
        return view('cart', compact('mightAlsoLike'));
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
        $duplicates = Cart::instance('default')->search(function($e) use($req) {
            return $e->id == $req->id;
        });

        if($duplicates->isNotEmpty()) {
            return redirect()->route('cart.index')->with('success_message', 'Item is already in cart list!');
        }
        Cart::add([
            'id' => $req->id,
            'name' => $req->name,
            'price' => $req->price,
            'qty' => 1,
        ])
        ->associate('App\Models\Product');

        return redirect()->route('cart.index')->with('success_message', 'Item was added to your cart!');
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
    public function update(Request $req, $id)
    {
        $validator = Validator::make($req->all(), [
            'quantity' => 'required|numeric|between:1,5'
        ]);

        if($validator->fails()) {
            session()->flash('errors', collect(['Quantity must be between 1 and 5.']));
            return response([
                'success' => false
            ], 400);
        }
        Cart::update($id, $req->quantity);
        session()->flash('success_message', 'Quantity was updated successfully');
        return [
            'success' => true
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Cart::remove($id);
        session()->flash('success_message', 'Item was removed from your cart!');
        return back();
    }

    public function switchToSaveForLater($id) {
        $item = Cart::instance('default')->get($id);

        $duplicates = Cart::instance('saveForLater')->search(function($e) use($item) {
            return $e->id == $item->id;
        });

        if($duplicates->isNotEmpty()) {
            return back()->with('success_message', 'Item is already in save for later list!');
        }

        Cart::instance('default')->remove($id);
        Cart::instance('saveForLater')->add($item->id, $item->name, 1, $item->price)
        ->associate('App\Models\Product');
        return redirect()->route('cart.index')->with('success_message', 'Item was saved to save for later!');
    }
}
