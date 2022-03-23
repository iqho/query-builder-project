@extends('layouts.master')

@section('title', 'Update Product | Test Project March 2022')

@section('content')
    <div class="card mt-2 w-100 w-lg-75">
        <div class="card-header"><h2>Update Product</h1></div>
        <div class="card-body">

            <div class="row">
                <div class="col-12">

                    @if ($errors->any())
                        <div class="alert alert-danger p-1 m-0">
                            <ul class="g-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div id="successMessage" class="alert alert-success alert-dismissible fade show p-2 text-center" role="alert" style="display: none; max-width:400px"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="title" class="form-label">Product Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Product Title" value="{{ $product->title }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ $product->description }}</textarea>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="image" class="form-label">Product Image</label>
                                <input class="form-control" type="file" id="image" name="image">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-2">
                                <img id="preview-image-before-upload" src="@if($product->image) {{ asset('product-images/'.$product->image) }} @else {{ asset('assets/images/image-not-available.jpg') }} @endif"
                                alt="preview image" style="max-height: 95px; max-width:100px">
                            </div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-8">
                                <label for="category_id" class="form-label">Product Category</label>
                                <select class="form-select mb-3" id="category_id" name="category_id">

                                    @if($product->category)
                                    <option value="{{ $product->category->id }}" selected>{{ $product->category->name }}</option>
                                    @else
                                    <option value="" selected>Please Select Product Category</option>
                                    @endif

                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-4 align-self-center text-center">
                                <input class="form-check-input" type="checkbox" name="is_active" value="1" id="flexCheckChecked" @if($product->is_active == 1) checked @endif style="transform: scale(1.5); margin-right:8px">
                                <label class="form-check-label" for="flexCheckChecked">Product Is Active </label>
                            </div>

                        </div>

                        <div class="row g-0 d-flex align-items-end">
                            <div class="col-md-3 col-12 g-0" style="padding-right:5px!important">
                                <label for="price_type_id" class="form-label">Product Price Type</label>
                            </div>

                            <div class="col-md-3 col-12 g-0" style="padding-right:5px!important">
                                <label for="price" class="form-label">Price</label>
                            </div>

                            <div class="col-md-4 col-12 g-0" style="padding-right:5px!important">
                                <label for="active_date" class="form-label">Price Active From</label>
                            </div>

                            <div class="col-md-2 col-12 d-flex align-items-end g-0">
                                <a href="javascript:void(0)" class="btn btn-success addMore"><span class="glyphicon glyphicon glyphicon-plus"
                                        aria-hidden="true"></span> Add More</a>
                            </div>
                        </div>

                        @forelse ($product->productPrices as $row)

                            <div class="row prices g-0 del_row{{ $row->id }}">

                                <input type="hidden" value="{{ $row->id }}" name="product_price_id[]" />

                                <div class="col-md-3 col-12 g-0" style="margin-top:5px!important; padding-right:5px!important">
                                    <select class="form-select" name="price_type_id[]" id="price_type_id">

                                        @if ($row->priceType)
                                        <option value="{{ $row->priceType->id }}" selected>{{ $row->priceType->name }}</option>
                                        @else
                                        <option value="" selected>Select Price Type</option>
                                        @endif

                                        @foreach ($price_types as $ptype)
                                        <option value="{{ $ptype->id }}">{{ $ptype->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-3 col-12 g-0" style="margin-top:5px!important; padding-right:5px!important">
                                    <input type="number" min="0" class="form-control" name="price[]" id="price" placeholder="Price"
                                            value="{{ $row->price }}">
                                </div>

                                <div class="col-md-4 col-12 g-0" style="margin-top:5px!important; padding-right:5px!important">
                                    <input type="date" class="form-control" name="active_date[]" value="{{ $row->active_date }}"
                                        id="active_date">
                                </div>

                                <div class="col-md-2 col-12 d-flex align-items-end g-0" style="margin-top:5px!important;">
                                    <a href="javascript:void(0)" class="btn btn-danger deleteRecord" data-id="{{ $row->id }}"><span class="glyphicon glyphicon glyphicon-remove"
                                            aria-hidden="true"></span> Remove</a>
                                </div>

                            </div>

                        @empty

                            <div class="row prices g-0"  style="margin-top:5px!important;">

                                <div class="col-sm-12 col-md-3 g-0" style="padding-right:5px!important">
                                    <select class="form-select" name="price_type_new_id[]" id="price_type_id">
                                        <option value="" selected>Select Price Type</option>

                                        @foreach ($price_types as $ptype)
                                        <option value="{{ $ptype->id }}">{{ $ptype->name }}</option>
                                        @endforeach

                                    </select>
                                </div>

                                <div class="col-md-3 col-12 g-0" style="padding-right:5px!important">
                                    <input type="number" min="0" class="form-control" name="new_price[]" id="price" placeholder="Price"
                                        value="{{ old('price[]') }}">
                                </div>

                                <div class="col-md-4 col-12 g-0" style="padding-right:5px!important">
                                    <input type="date" class="form-control" name="new_active_date[]" value="{{ date('Y-m-d') }}" id="active_date">
                                </div>

                                <div class="col-md-2 col-12 d-flex align-items-end g-0">
                                    <a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
                                </div>

                            </div>

                        @endforelse

                        <div class="row">
                            <div class="col-12 mt-2">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- For Add New Input Row -->
            <div class="row pricesCopy" style="display: none;">

                <div class="col-md-3 col-12 g-0" style="padding-right:5px!important">
                    <select class="form-select" name="price_type_new_id[]" id="price_type_id">
                        <option value="" selected>Select Price Type</option>

                        @foreach ($price_types as $ptype)
                        <option value="{{ $ptype->id }}">{{ $ptype->name }}</option>
                        @endforeach

                    </select>
                </div>

                <div class="col-md-3 col-12 g-0" style="padding-right:5px!important">
                    <input type="number" min="0" class="form-control" name="new_price[]" id="price" placeholder="Price"
                        value="{{ old('new_price[]') }}">
                </div>

                <div class="col-md-4 col-12 g-0" style="padding-right:5px!important">
                    <input type="date" class="form-control" name="new_active_date[]" value="{{ date('Y-m-d') }}" id="active_date">
                </div>

                <div class="col-md-2 col-12 d-flex align-items-end g-0">
                    <a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove"
                            aria-hidden="true"></span> Remove</a>
                </div>

            </div>

        </div> <!-- Close Card Body-->
    </div>

@endsection

@push('scripts')
    <script type="text/javascript">
        $(document).ready(function (e) {
            $('#image').change(function(){
                let reader = new FileReader();
                reader.onload = (e) => {
                    $('#preview-image-before-upload').attr('src', e.target.result);
                }
                reader.readAsDataURL(this.files[0]);
            });

            // Hide Message After 5 Sec
            $("#successMessage").delay(5000).slideUp(300);

            //add more fields group
            $(".addMore").click(function(){
                    var fieldHTML='<div class="row prices g-0" style="margin-top:5px!important">'
                    +$(".pricesCopy").html()+'</div>';
                    $('body').find('.prices:last').after(fieldHTML);
                });

            //remove fields group
            $("body").on("click",".remove",function(){
                    $(this).parents(".prices").remove();
                });
        });

        // Delete Price List Data
        $('.deleteRecord').click(function() {

            var price_id = $(this).data('id');
            var token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                type: "POST",
                dataType: "json",
                cache: false,
                url: "{{ url('product/price-list') }}/"+price_id,
                data: {'price_id': price_id , '_token': token,},
                beforeSend:function(){
                    return confirm("Are you sure want to delete this price ?");
                },

                success: function(data){
                    $(".del_row" + price_id).remove();
                    $("#successMessage").html(data.success).show().delay(3000).fadeOut(400);
                }
            });
        })
    </script>
@endpush
