@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        @if(Auth::user()->jabatan_user->nama_jabatan == 'Account Officer')
        <p style="text-align:left;">
            <h4 class="mb-0">Loan Application
                <span style="float:right;">
                    <a href="{{ url('tambah-pengajuan-pinjaman') }}" class="btn btn-primary btn-sm" align="right">Add Loan Proposal</a>
                </span>
            </h4>
        </p>
        @endif

        <div style="height:30px"></div>
        @include('flash-message')
        <div style="height:30px"></div>

        <table class="table table-hover" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>BPR Name</th>
                    <th>Sandi BPR</th>
                    <th>Loan Amount & Tenor</th>
                    <th>AO</th>
                    <th>Diproses Oleh</th>
                    <th>Report</th>
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
        ajax: "{{ url('workflow-ao') }}",
        scrollX: true,
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'nama_bpr', name: 'form_00.nama_bpr' },
            { data: 'sandi_bpr', name:'sandi_bpr'},
            { data: 'plafond_tenor', name: 'plafond_tenor'},
            { data: 'name', name: 'users.name' },
            { data: 'status', name: 'loan_applicants.status'},
            { data: 'report', name: 'report', orderable: false},
            { data: 'aksi', name: 'aksi', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush




