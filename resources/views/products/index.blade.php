@extends('layouts.master')

@section('title', 'All Products | Test Project March 2022')

@section('content')
    <div class="card mt-3">
        <div class="card-header">
            <h3 class="d-inline-block">All Products</h3>
            <a href="{{ route('product.create') }}" class="btn btn-success float-end">Create New Product</a>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show p-2 w-50 text-center" role="alert" id="success">
                            <strong>{{ $message }}</strong>
                            <button type="button" class="btn-close p-2" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <div id="successMessage" class="alert alert-success alert-dismissible fade show p-2 text-center" role="alert" style="display: none; max-width:400px">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product Title</th>
                                    <th>Product Description</th>
                                    <th class="text-center">Product Image</th>
                                    <th>Price Info</th>
                                    <th class="text-center">Active Status</th>
                                    <th class="text-center">Category</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php $i = 1; @endphp

                                @foreach ($products as $product)
                                    <tr>
                                        <td class="align-middle text-center">{{ $i++ }}</td>
                                        <td class="align-middle">{{ $product->title }}</td>
                                        <td class="align-middle">
                                            @if ($product->description)
                                                {{ $product->description }}
                                            @else
                                                <small> No Description </small>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($product->image)
                                            <img src="{{ asset('product-images/'.$product->image) }}" alt="{{ $product->title }}" height="40" width="45">
                                            @else
                                            <small> No Image </small>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            <strong>{{ $product->prices }}</strong><br>
                                            <small> Active From: {{ date('d F Y', strtotime($product->active_dates)) }} </small>
                                           {{-- @foreach ($product->prices as $row) --}}

                                                     {{-- <strong> @if ($row->priceType) {{ $row->priceType->name }} @else No Price Type @endif:
                                                        @if ($row->price) {{ $row->price }} @else No Price @endif</strong><br>
                                                        @if ($row->active_date) <small> Active From: {{ date('d F Y', strtotime($row->active_date)) }} </small> @endif
                                                    <hr class="g-0"> --}}
                                           {{-- @endforeach --}}
                                        </td>

                                        <td class="align-middle text-center">
                                            <input data-id="{{$product->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $product->is_active ? 'checked' : '' }}>
                                        </td>
                                        <td class="align-middle text-center">
                                            @if ($product->cat_name)
                                            {{ $product->cat_name }}
                                            @else
                                            <small>No Category</small>
                                            @endif
                                        </td>
                                        <td class="align-middle text-center">
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-primary me-1" href="{{ route('product.edit', $product->id) }}">Edit</a>

                                                <form action="{{ route('product.destroy', $product->id) }}" method="POST">
                                                    @csrf

                                                    <button type="submit" onclick="return confirm('Are you sure want to delete this product ?')" class="btn btn-danger btn-block">Delete</button>
                                                </form>

                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- Close Card body-->
    </div> <!-- Close Card-->
@endsection

@push('scripts')
<script>
    $(function() {
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var product_id = $(this).data('id');
            console.log(status);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('product.updateStatus') }}',
                data: {'status': status, 'product_id': product_id},
                success: function(data){
                    $("#successMessage").html(data.success).show().delay(3000).fadeOut(400);;
                }
            });
        })
    })

    // Hide Flash Message After 5 Second
    $(document).ready(function(){
        $("#success").delay(5000).slideUp(300);
    });
</script>
@endpush
