<ul>
    @foreach($items as $menu_item)
        @if($menu_item->title == "Cart")
            <li><a href="{{$menu_item->link()}}">{{$menu_item->title}}
                @if(Cart::instance('default')->count() > 0)
                    <span class="cart-count"><span>{{Cart::instance('default')->count()}}</span></span>
                @endif
            </a></li>
        @else
            <li><a href="{{$menu_item->link()}}">{{$menu_item->title}}</a></li>
        @endif
    @endforeach
</ul>
