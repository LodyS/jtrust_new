@extends('tema.app')
@section('content')


<meta name="csrf-token" content="{{ csrf_token() }}">

<div style="display: flex; justify-content: flex-end">
</div>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">RAC Setting
                <span style="float:right;"><a href="{{ url('interest-rate-setting-form') }}" class="btn btn-primary">Create</a></span>
            </h4>
            <div style="height:10px"></div>
        </div>

        <div style="height:10px"></div>
        @include('flash-message')
        <table class="display table dataTable table-striped table-bordered"  id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>T Product ID</th>
                    <th>Code</th>
                    <th>Title</th>
                    <th>Maksimal RPC Persentase</th>
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
    ajax: "{{ url('interest-rate-setting-data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'product_title', name: 't_product_type.product_title'},
            { data : 'code', name : 't_credit_type.code' },
            { data : 'title', name : 'title' },
            { data : 'maksimal_rpc_persentase', name : 'maksimal_rpc_persentase'},
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});

</script>
@endpush
