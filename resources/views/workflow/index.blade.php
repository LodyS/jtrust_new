@extends('tema.app')
@section('content')

<style>
.dataTable td {
    height: 2em;
}
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">Loan Application
                @if(Auth::user()->jabatan_user->nama_jabatan == 'Account Officer')
                    <span style="float:right;">
                        <a href="{{ url('tambah-pengajuan-pinjaman') }}" class="btn btn-primary btn-sm" align="right">Form Loan Proposal</a>
                    </span>
                @endif
            </h4>
        </p>
   
        <div style="height:30px"></div>
        @include('flash-message')
        <div style="height:30px"></div>

        <div class="table-responsive">
            <table class="table align-items-center table-flus" style="width:100%;" id="table">
                <thead style="background-color:rgb(240, 245, 255)30, 245, 245)">
                    <tr>
                        <th>No</th>
                        <th>Apply Date</th>
                        <th>BPR Name</th>
                        <th>Status</th>
                        <th>Loan Amount</th>
                        <th>Tenor</th>
                        <th>Action</th>
                    </tr>
                <thead>
            </table>
        </div>
    </div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">

$(document).ready(function(){
    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('proses-workflow') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'tanggal_apply', name: 'tanggal_apply'},
            { data: 'nama_bpr', name: 'form_00.nama_bpr' },
            { data: 'status', name: 'status'},
            { data: 'plafond', name: 'plafond'},
            { data: 'tenor', name: 'tenor'},
            //{ data: 'name', name: 'users.name'},
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});

</script>
@endpush




