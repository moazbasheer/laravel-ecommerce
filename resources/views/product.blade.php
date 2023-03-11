@extends('layout')
@section('extra-css')

@endsection
@section('title', 'Product')

@section('content')

    <div class="breadcrumbs">
        <div class="container">
            <a href="/">Home</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <a href="{{route('shop.index')}}">Shop</a>
            <i class="fa fa-chevron-right breadcrumb-separator"></i>
            <span>{{$product->name}}</span>
        </div>
    </div>

    <div class="product-section container">
        <div>
            <div class="product-section-image">
                <img src="{{asset('storage/' . $product->image)}}" alt="product" class="active" id="currentImage">
            </div>
            <div class="product-section-images">
                <div class="product-section-thumbnail selected">
                    <img src="{{asset('storage/' . $product->image)}}" alt="product">
                </div>

                @if ($product->images)
                    @foreach (json_decode($product->images, true) as $image)
                    <div class="product-section-thumbnail">
                        <img src="{{asset('storage/' . $image)}}" alt="product">
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="product-section-information">
            <h1 class="product-section-title">{{$product->name}}</h1>
            <div class="product-section-subtitle">{{$product->details}}</div>
            <div class="product-section-price">{{$product->presentPrice()}}</div>
            <p>
                {{$product->description}}
            </p>
            <p>&nbsp;</p>
            <form method="post" action="{{route('cart.store')}}">
                @csrf
                <input type="hidden" name="id" value="{{$product->id}}">
                <input type="hidden" name="name" value="{{$product->name}}">
                <input type="hidden" name="price" value="{{$product->price}}">
                <button class="button button-plain">Add to Cart</button>
            </form>
        </div>
    </div>
    @include('partials.might-like-products')
@endsection

@section('extra-js')
    <script>
        (function() {
            const currentImage = document.querySelector("#currentImage");
            const images = document.querySelectorAll(".product-section-thumbnail");
            images.forEach((element) => {
                element.addEventListener('click', function() {
                    currentImage.src = this.querySelector('img').src;
                    images.forEach((element) => {
                        element.classList.remove("selected");
                    });
                    this.classList.add('selected');
                });
            });
        })();
    </script>
@endsection
