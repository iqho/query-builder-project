@extends('layouts.master')

@section('title', 'Update Category | Test Project March 2022')

@section('content')
    <div class="card w-100 w-lg-50 mt-2">
        <div class="card-header"><h3>Update Category</h3></div>
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
                    <form action="{{ route('categories.update', $category->id) }}" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="col-12 mb-3 mt-1">
                            <label for="name" class="form-label">Category Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name" placeholder="Category Name" value="{{ $category->name }}">
                        </div>
                        <div class="col-12 my-2">
                            <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" style="transform: scale(1.5); margin-right:8px" @if($category->is_active == 1) checked @endif>
                            <label class="form-check-label" for="is_active">
                              Is Active
                            </label>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Update Category</button>
                        </div>
                    </form>
                </div>
            </div>
        </div> <!-- Close Card Body -->
    </div> <!-- Close Card -->
@endsection
