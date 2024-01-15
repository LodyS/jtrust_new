@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;"><h4 class="mb-0">Loan Application</h4></p>

        @include('flash-message')
        <div style="height:30px"></div>

        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>BPR Name</th>
                    <th>Sandi BPR</th>
                    <th>Loan Amount & Tenor</th>
                    <th>Diproses Oleh</th>
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
        ajax: "{{ url('workflow-departemen-head') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'nama_bpr', name: 'form_00.nama_bpr' },
            { data: 'sandi_bpr', name: 'sandi_bpr' },
            { data: 'plafond_tenor', name: 'plafond_tenor', searchable:false},
            { data: 'status', name: 'loan_applicants.status'},
            { data: 'action', name: 'action', orderable: false},

        ],
        order: [[0, 'asc']]
    });
});

</script>
@endpush




