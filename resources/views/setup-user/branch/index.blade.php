@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">BRANCH
                <span style="float:right;"><a href="{{ route('branch.create') }}" class="btn btn-primary btn-sm">Create</a></span>
            </h4>
            <div style="height:10px"></div>
        </div>

        <div style="height:10px"></div>

        @include('flash-message')
        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Region</th>
                    <th>Branch Code</th>
                    <th>Branch Title</th>
                    <th>Publish</th>
                    <th>Aksi</th>
                </tr>
            <thead>
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
        ajax: "{{ route('branch.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'region_title', name: 'region_listing.region_title'},
                { data: 'branch_code', name: 'branch_code' },
                { data : 'branch_title', name : 'branch_title' },
                { data : 'publish', name : 'branch.publish' },
                { data: 'action', name: 'action', orderable: false},
            ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush
