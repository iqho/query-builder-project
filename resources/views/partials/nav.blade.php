    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            <li class="nav-item">
                <a class="nav-link @if(Request::is('/')) active @endif" aria-current="page" href="{{ url('/') }}">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('categories/create')) active @endif" aria-current="page" href="{{ route('categories.create') }}">Create New Categeory</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Request::is('categories')) active @endif" aria-current="page" href="{{ route('categories.index') }}">All Categories</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('product/create')) active @endif" aria-current="page" href="{{ route('product.create') }}">Create New Product</a>
            </li>
            <li class="nav-item">
                <a class="nav-link @if(Request::is('products')) active @endif" aria-current="page" href="{{ route('products.index') }}">All Products</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('price-type/create')) active @endif" aria-current="page" href="{{ route('price-type.create') }}">Create New Price Type</a>
            </li>

            <li class="nav-item">
                <a class="nav-link @if(Request::is('all-price-types')) active @endif" aria-current="page" href="{{ route('all.price-type') }}">All Price Types</a>
            </li>

        </ul>
    </div>

