@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">Loan Application</h4>
        </p>

        @include('flash-message')
        <div style="height:30px"></div>

        <table class="table table-hover" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Apply Date</th>
                    <th>Sandi BPR</th>
                    <th>BPR Name</th>
                    <th>Loan Amount</th>
                    <th>Tenor</th>
                    <th>Diproses Oleh</th>
                    <th>AO</th>
                    <th>Action</th>
                </tr>
            <thead>
        </table>
    </div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">

$(document).ready(function(){

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        scrollX: true,
        ajax: "{{ url('workflow-bussiness-division-head') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'tanggal_apply', name: 'tanggal_apply'},
            { data: 'sandi_bpr', name: 'form_00.sandi_bpr' },
            { data: 'nama_bpr', name: 'form_00.nama_bpr' },
            { data: 'plafond', name: 'plafond'},
            { data: 'tenor', name: 'tenor'},
            { data: 'status', name: 'status'},
            { data: 'name', name: 'users.name'},

            { data: 'action', name: 'action', orderable: false},

        ],
        order: [[0, 'asc']]
    });
});

</script>
@endpush




