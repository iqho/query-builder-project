@extends('layouts.master')

@section('title', 'Add New Product | Test Project March 2022')

@section('content')

    <div class="card mt-3 w-100 w-lg-75">
        <div class="card-header"><h3>Add New Product</h3></div>
        <div class="card-body">

            <div class="row">
                <div class="col-12">
                    @if ($errors->any())
                        <div id="successMessage" class="alert alert-danger p-1 m-0">
                            <ul class="g-0">
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('products.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                            <div class="col-12">
                                    <label for="title" class="form-label">Product Title</label>
                                    <input type="text" class="form-control" name="title" id="title" placeholder="Product Title" value="{{ old('title') }}" required/>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" name="description" id="description" rows="3">{{ old('description') }}</textarea>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="image" class="form-label">Product Image</label>
                                <input class="form-control" type="file" id="image" name="image">
                            </div>
                            <div class="col-12">
                                <img id="preview-image-before-upload" src="{{ asset('assets/images/image-not-available.jpg') }}"
                                alt="preview image" style="max-height: 95px; max-width:100px">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-8">
                                <label for="category_id" class="form-label">Product Category</label>
                                <select class="form-select" name="category_id" id="category_id">
                                    <option value="" selected>Please Select Product Category</option>

                                    @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="col-4 align-self-end text-center pb-2">
                                    <input class="form-check-input" type="checkbox" name="is_active" value="1" id="flexCheckChecked" style="transform: scale(1.5); margin-right:8px" checked>
                                    <label class="form-check-label" for="flexCheckChecked"> Product Is Active ?</label>
                            </div>
                        </div>

                        <div class="row prices g-0">

                            <div class="col-md-3 col-12 g-0" style="padding-right:5px!important">
                                <label for="price_type_id" class="form-label">Product Price Type</label>
                                <select class="form-select" name="price_type_id[]" id="price_type_id">
                                    <option value="" selected>Select Price Type</option>
                                    @foreach ($price_types as $ptype)
                                    <option value="{{ $ptype->id }}">{{ $ptype->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-12 col-md-3 g-0" style="padding-right:5px!important">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" min="0" class="form-control" name="price[]" id="price" placeholder="Price"
                                        value="{{ old('price[]') }}">
                            </div>

                            <div class="col-12 col-md-4 g-0" style="padding-right:5px!important">
                                <label for="active_date" class="form-label">Price Active From</label>
                                <input type="date" class="form-control" name="active_date[]" value="{{ date('Y-m-d') }}"
                                    id="active_date">
                            </div>

                            <div class="col-12 col-md-2 d-flex align-items-end g-0">
                                <a href="javascript:void(0)" class="btn btn-success addMore"><span class="glyphicon glyphicon glyphicon-plus"
                                        aria-hidden="true"></span> Add More</a>
                            </div>

                        </div>

                        <div class="row mb-2 mt-3">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Add New Product</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>

            <!-- For Add New Input Row -->
            <div class="row pricesCopy" style="display: none;">

                <div class="col-12 col-md-3 g-0" style="padding-right:5px!important">
                    <select class="form-select" name="price_type_id[]" id="price_type_id">
                        <option value="" selected>Select Price Type</option>
                        @foreach ($price_types as $ptype)
                        <option value="{{ $ptype->id }}">{{ $ptype->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12 col-md-3 g-0" style="padding-right:5px!important">
                    <input type="number" min="0" class="form-control" name="price[]" id="price" placeholder="Price"
                            value="{{ old('price[]') }}">
                </div>

                <div class="col-12 col-md-4 g-0" style="padding-right:5px!important">
                    <input type="date" class="form-control" name="active_date[]" value="{{ date('Y-m-d') }}"
                        id="active_date">
                </div>

                <div class="col-md-2 col-12 d-flex align-items-end g-0">
                    <a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove"
                            aria-hidden="true"></span> Remove</a>
                </div>

            </div>

        </div> <!-- Close Card-body -->
    </div> <!-- Close Card -->

@endsection

@push('scripts')
    <script type="text/javascript">

        // Upload Image Preview
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

    </script>
@endpush

