<ul>
    @guest
    <li><a href="{{route('register')}}">Register</a></li>
    <li><a href="{{route('login')}}">Login</a></li>
    @else
    <li>
        <a href="{{ route('logout') }}"
            onclick="event.preventDefault();
                     document.getElementById('logout-form').submit();">
            Logout
        </a>
    </li>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
    </form>
    @endguest
    <li><a href="{{route('cart.index')}}">Cart
        <span class="cart-count"><span>{{Cart::instance('default')->count()}}</span></span>
    </a></li>
</ul>
