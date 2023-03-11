<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class ShopController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->category) {
            $products = Product::with('categories')->whereHas('categories', function($query) {
                return $query->where('slug', request()->category);
            });
            $category = Category::where('slug', request()->category)->first();
            $categoryName = optional($category)->name;
        } else {
            $products = Product::inRandomOrder()->limit(8);
            $categoryName = 'Featured';
        }
        if(request()->sort == "low_high") {
            $products = $products->orderBy('price')->paginate(4);
        } else if(request()->sort == "high_low") {
            $products = $products->orderBy('price', 'DESC')->paginate(4);
        } else  {
            $products = $products->paginate(4);
        }
        $categories = Category::get();
        return view('shop', compact('products', 'categories', 'categoryName'));
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
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $mightAlsoLike = Product::where('slug', '!=', $slug)->inRandomOrder()->limit(4)->get();
        return view('product', compact('product', 'mightAlsoLike'));
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
}
