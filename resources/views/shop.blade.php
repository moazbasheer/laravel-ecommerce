@extends('layout')

@section('title', 'Products')

@section('extra-css')
    <link rel="stylesheet" href="{{ asset('css/algolia.css') }}">
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>Shop</span>
        </div>
    </div>
    <div class="products-section container">
        <div class="sidebar">
            <h3>By Category</h3>
            <ul>
                @foreach ($categories as $category)
                    <li><a href="{{route('shop.index', ['category' => $category->slug])}}">{{$category->name}}</a></li>
                @endforeach

            </ul>
        </div> <!-- end sidebar -->
        <div>
            <div class="products-header">
                <h1 class="stylish-heading">{{$categoryName}}</h1>
                <div>
                <div><span>Price: </span><a href="{{route('shop.index', ['category' => request()->category, 'sort' => 'low_high'])}}">Low to high</a> |
                        <a href="{{route('shop.index', ['category' => request()->category, 'sort' => 'high_low'])}}">High to low</a></div>

                </div>
            </div>

            <div class="products text-center">
                @forelse($products as $product)
                    <div class="product">
                        <a href="{{ route('shop.show', $product->slug) }}"><img src="{{asset('storage/' . $product->image)}}" alt="product" style="width: 200px; height: 200px;"></a>
                        <a href="{{ route('shop.show', $product->slug) }}"><div class="product-name">{{ $product->name }}</div></a>
                        <div class="product-price">{{ $product->presentPrice() }}</div>
                    </div>
                @empty
                    <div style="text-align: left">No items found</div>
                @endforelse
            </div> <!-- end products -->
        </div>
        <div class="spacer"></div>
        {{$products->appends(request()->input())->links()}}
    </div>

@endsection
