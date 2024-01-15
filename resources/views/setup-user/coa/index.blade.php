@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">COA</h4>
            <span style="float:right;">
                <a href="{{ route('coa.create')}}" class="btn btn-primary btn-sm" align="right">Create</a>
            </span><br/>
        </div>

        <div style="height:30px"></div>

        @include('flash-message')
        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Sandi COA</th>
                    <th>Nama COA</th>
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
        ajax: "{{ url('coa') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'sandi_coa', name:'sandi_coa'},
            { data: 'nama_coa', name: 'nama_coa' },
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush
