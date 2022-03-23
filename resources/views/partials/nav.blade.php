    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link @if(Request::is('/')) active @endif" aria-current="page" href="{{ url('/') }}">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('categories/create')) active @endif" aria-current="page" href="{{ route('categories.create') }}">Add Categeory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Request::is('categories')) active @endif" aria-current="page" href="{{ route('categories.index') }}">All Categories</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('products/create')) active @endif" aria-current="page" href="{{ route('products.create') }}">Add New Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Request::is('products')) active @endif" aria-current="page" href="{{ route('products.index') }}">All Products</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('price-type/create')) active @endif" aria-current="page" href="{{ route('price-type.create') }}">Add Price Type</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('all-price-types')) active @endif" aria-current="page" href="{{ route('all.price-type') }}">All Price Types</a>
            </li>

        </ul>
    </div>

