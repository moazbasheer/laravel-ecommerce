<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

class SaveForLaterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
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
        Cart::instance('saveForLater')->remove($id);
        return back()->with('success_message', 'Item is removed from save for later list!');
    }

    public function moveToCart($id) {
        $item = Cart::instance('saveForLater')->get($id);

        $duplicates = Cart::instance('default')->search(function($e) use($item) {
            return $e->id == $item->id;
        });

        if($duplicates->isNotEmpty()) {
            return back()->with('success_message', 'Item is already in cart list!');
        }

        Cart::instance('saveForLater')->remove($id);
        Cart::instance('default')->add($item->id, $item->name, 1, $item->price)
        ->associate('App\Models\Product');
        return redirect()->route('cart.index')->with('success_message', 'Item was saved to save for later!');
    }
}
