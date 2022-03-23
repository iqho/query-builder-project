@extends('layouts.master')

@section('title', 'Add New Price Type | Test Project March 2022')

@section('content')

    <div class="card mt-2 w-100 w-lg-50">
        <div class="card-header"><h3>Add New Price Type</h3></div>
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
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <form action="{{ route('price-type.store') }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-12 mb-3 mt-1">
                                <label for="name" class="form-label">Price Type Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Price Type Name" value="{{ old('name') }}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3 mt-1">
                                <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" style="transform: scale(1.5); margin-right:8px" checked >
                                <label class="form-check-label" for="is_active">
                                Is Active
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Add Price Type</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
