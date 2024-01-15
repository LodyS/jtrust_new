@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Product</h4></div>

            <span style="float:right;"><a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">Create</a></span>
        </div>
    </div>

    <div class="card-body">

        @include('flash-message')

        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>Code</th>
                    <th width="50%">Product Title</th>
                    <th>Bunga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('product.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'code', name: 'code' },
            { data: 'product_title', name: 'product_title' },
            { data: 'bunga', 'name': 'bunga'},
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush
