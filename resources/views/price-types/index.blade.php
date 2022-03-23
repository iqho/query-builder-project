@extends('layouts.master')

@section('title', 'All Price Types | Test Project March 2022')

@section('content')
    <div class="card mt-2 w-100 w-lg-75">
        <div class="card-header">
            <h3 class="d-inline-block">All Price Types</h3>
            <a href="{{ route('price-type.create') }}" class="btn btn-success float-end">Create New Price Type</a>
        </div>
        <div class="card-body">

            <div class="row">
                <div class="col-12">
                    @if ($message = Session::get('success'))
                        <div id="success" class="alert alert-success alert-dismissible fade show p-2 m-3" role="alert">
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
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Price Type Name</th>
                                    <th class="align-middle text-center">Actvie Status</th>
                                    <th style="text-align:right; padding-right:50px">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                                @php $i = 1; @endphp

                                @foreach ($priceTypes as $ptype)
                                <tr>
                                    <td class="align-middle">{{ $i++ }}</td>
                                    <td class="align-middle">{{ $ptype->name }}</td>
                                    <td class="align-middle text-center">
                                        <input data-id="{{$ptype->id}}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="Inactive" {{ $ptype->is_active ? 'checked' : '' }}>
                                    </td>
                                    <td style="max-width: 150px; text-align:right">
                                        <div class="btn-group" role="group">
                                            <a class="btn btn-primary me-1" href="{{ route('price-type.edit', $ptype->id) }}">Edit</a>

                                            <form action="{{ route('price-type.destroy', $ptype->id) }}" method="DELETE">
                                                @csrf

                                                <button type="submit" onclick="return confirm('Are you sure ?')" class="btn btn-danger btn-block">Delete</button>
                                            </form>

                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div> <!-- Close Responsive Table -->
                </div>
            </div> <!-- Close Table Row -->

        </div>
    </div>
@endsection

@push('scripts')
<script>
    $(function() {
        $('.toggle-class').change(function() {
            var status = $(this).prop('checked') == true ? 1 : 0;
            var id = $(this).data('id');
            //console.log(status);
            $.ajax({
                type: "GET",
                dataType: "json",
                url: '{{ route('price-type.changeStatus') }}',
                data: {'status': status, 'id': id},
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
