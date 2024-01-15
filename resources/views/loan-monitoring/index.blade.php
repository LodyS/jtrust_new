@extends('tema.app')
@section('content')

<style>
table {
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2
}
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">Loan Monitoring
            </h4>
        </p>

        <div style="height:30px"></div>

        <div style="overflow-x:auto;">
            @include('flash-message')
            <table class="table table-hover" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Apply Date</th>
                        <th>Sandi BPR</th>
                        <th>BPR Name</th>
                        <th>Loan Amount</th>
                        <th>Tenor</th>
                        <th>Status</th>
                        <th>AO</th>
                        <th>Reports</th>
                        <th>Action</th>
                    </tr>
                <thead>
            </table>
        </div>
    </div>
</div>
@endsection


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>
<script type="text/javascript">

$(document).ready(function(){

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('loan-monitoring') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'tanggal_apply', name: 'tanggal_apply'},
            { data: 'sandi_bpr', name: 'form_00.sandi_bpr' },
            { data: 'nama_bpr', name: 'form_00.nama_bpr' },
            { data: 'plafond', name: 'plafond'},
            { data: 'tenor', name: 'tenor'},
            { data: 'status', name: 'loan_applicants.status'},
            { data: 'name', name: 'users.name'},
            { data: 'report', name: 'report', orderable: false},
            { data: 'action', name: 'action', orderable: false},

        ],
        order: [[0, 'asc']]
    });
});
</script>





