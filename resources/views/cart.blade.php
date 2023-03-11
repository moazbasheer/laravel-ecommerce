@extends('layout')

@section('title', 'Shopping Cart')

@section('extra-css')
@endsection

@section('content')
    <div class="breadcrumbs">
        <div class="breadcrumbs-container container">
            <div>
                <a href="/">Home</a>
                <i class="fa fa-chevron-right breadcrumb-separator"></i>
                <span>Shopping Cart</span>
            </div>
        </div>
    </div>
    <div class="cart-section container">
        <div>
            <div style="color: green;">
                @if(session()->has('success_message'))
                    {{session()->get('success_message')}}
                @endif
            </div>
            @if (Cart::instance('default')->count() > 0)

            <h2>{{ Cart::count() }} item(s) in Shopping Cart</h2>

            <div class="cart-table">
                @foreach (Cart::content() as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{asset('storage/' . $item->model->image)}}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a></div>
                            <div class="cart-table-description">{{ $item->model->details }}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="cart-options">Remove</button>
                            </form>

                            <form action="{{route('cart.switchToSaveForLater', $item->rowId)}}" method="POST">
                                {{ csrf_field() }}

                                <button type="submit" class="cart-options">Save for Later</button>
                            </form>
                        </div>
                        <div>
                            <select class="quantity" data-id="{{ $item->rowId }}" data-productQuantity="{{ $item->model->quantity }}">
                                @for ($i = 1; $i < 5 + 1 ; $i++)
                                    <option {{ $item->qty == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>{{$item->model->presentPrice()}}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach
                <div class="cart-totals">
                <div class="cart-totals-left">
                    Shipping is free because we’re awesome like that. Also because that’s additional stuff I don’t feel like figuring out :).
                </div>

                <div class="cart-totals-right">
                    <div>
                        Subtotal <br>
                        @if (session()->has('coupon'))
                            Code ({{ session()->get('coupon')['name'] }})
                            <form action="{{ route('coupon.destroy') }}" method="POST" style="display:block">
                                {{ csrf_field() }}
                                {{ method_field('delete') }}
                                <button type="submit" style="font-size:14px;">Remove</button>
                            </form>
                            <hr>
                            New Subtotal <br>
                        @endif
                        Tax<br>
                        <span class="cart-totals-total">Total</span>
                    </div>
                    <div class="cart-totals-subtotal">
                        {{ Cart::subtotal()}} <br>
                        {{ Cart::tax() }} <br>
                        <span class="cart-totals-total">{{ Cart::total() }}</span>
                    </div>
                </div>
            </div> <!-- end cart-totals -->
            <div class="cart-buttons">
                <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                <a href="{{ route('checkout.index') }}" class="button-primary">Proceed to Checkout</a>
            </div>
                @else
                    <h3>No items in Cart!</h3>
                    <div class="spacer"></div>
                    <a href="{{ route('shop.index') }}" class="button">Continue Shopping</a>
                    <div class="spacer"></div>
                @endif
            @if (Cart::instance('saveForLater')->count() > 0)

            <h2>{{ Cart::instance('saveForLater')->count() }} item(s) Saved For Later</h2>

            <div class="saved-for-later cart-table">
                @foreach (Cart::instance('saveForLater')->content() as $item)
                <div class="cart-table-row">
                    <div class="cart-table-row-left">
                        <a href="{{ route('shop.show', $item->model->slug) }}"><img src="{{ asset('img/products/'.$item->model->slug.'.png') }}" alt="item" class="cart-table-img"></a>
                        <div class="cart-item-details">
                            <div class="cart-table-item"><a href="{{ route('shop.show', $item->model->slug) }}">{{ $item->model->name }}</a></div>
                            <div class="cart-table-description">{{ $item->model->details }}</div>
                        </div>
                    </div>
                    <div class="cart-table-row-right">
                        <div class="cart-table-actions">
                            <form action="{{ route('saveForLater.destroy', $item->rowId) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}

                                <button type="submit" class="cart-options">Remove</button>
                            </form>

                            <form action="{{ route('saveForLater.moveToCart', $item->rowId) }}" method="POST">
                                {{ csrf_field() }}

                                <button type="submit" class="cart-options">Move to Cart</button>
                            </form>
                        </div>

                        <div>{{ $item->model->presentPrice() }}</div>
                    </div>
                </div> <!-- end cart-table-row -->
                @endforeach

            </div> <!-- end saved-for-later -->

            @else

            <h3>You have no items Saved for Later.</h3>

            @endif
            </div> <!-- end cart-table -->

        </div>
    </div>
    @include('partials.might-like-products')
@endsection
@section('extra-js')
<script src="{{asset('js/app.js')}}"></script>
<script>
    (function() {
        const classname = document.querySelectorAll('.quantity');
        Array.from(classname).forEach(function(element) {
            element.addEventListener('change', function() {
                const id = element.getAttribute("data-id");
                axios.patch(`/cart/${id}`, {
                    quantity: this.value
                }).then(function(response) {
                    console.log(response);
                    window.location.href = "{{route('cart.index')}}";
                }).catch(function(error) {
                    console.log(error.error);
                    window.location.href = "{{route('cart.index')}}";
                })
            })
        })
    })();
</script>
@endsection
