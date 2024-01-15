@extends('tema.app')
@section('content')

<style>
.dataTables_wrapper .dataTables_paginate .paginate_button {
    padding : 0px;
    margin-left: 0px;
    display: inline;
    border: 0px;
}
.dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    border: 0px;
}
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">KEPEMILIKAN BPR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($id)->nama_bpr) }}</h5>
                <div style="height:30px"></div>
                @include('flash-message')

                <div>
                    <ul>@include('list-menu-edit-bpr')</ul>
                </div>
            </div> 
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <form action="{{ route('kepemilikan-bpr.store') }}" method="POST" name="form">@csrf

                    <input type="hidden" name="sandi_bpr" value="{{ $id }}">
                    <input type="hidden" name="aksi" value="Create">
                    <input type="hidden" name="tabel" value="form_001">
                    <input type="hidden" name="bagian" value="Master BPR">

                    <div style="height:30px" ></div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control" name="nama" required>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Jabatan</label>
                                <input type="text" class="form-control" name="jabatan" required>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">No Identitas</label>
                                <input type="text" class="form-control" name="no_identitas" required>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Alamat</label>
                                <textarea class="form-control" rows="3" name="alamat" required></textarea>
                            </div>
                        </div><!-- Col -->
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                             <div class="form-group">
                                <label class="control-label">Jenis</label>
                                <input type="text" class="form-control" name="jenis">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">PSP</label>
                                <input type="text" class="form-control" name="psp">
                            </div>
                        </div><!-- Col -->
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Jumlah Nominal</label>
                                <input type="text" class="form-control nominal" name="jumlah_nominal" required>
                            </div>
                        </div><!-- Col -->
                 
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Persentase Kepemilikan </label>
                                <input type="text" class="form-control bunga" name="persentase_kepemilikan" required>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div style="height:10px"></div>
                            
                    <button type="submit" class="btn btn-primary submit">Save</button>
                </form>
            </div> 
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <h5 style="text-align:center">DAFTAR KEPEMILIKAN BPR</h5>

                <div style="height:30px"></div>

                <div class="table-responsive">
                    <table class="table" style="width:100%" id="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Nominal Kepemilikan (Rp)</th>
                                <th>% Kepemilikan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,)\./g, "").replace(/(?<=\.\d\d)./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

$('.bunga').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{2})+(?!\d))/g, ".");
    });
}));

$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    ajax: "{{ url('kepemilikan-bpr', $id) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data: 'nama', name: 'nama'},
        { data: 'jabatan', name: 'jabatan' },
        { data: 'jumlah_nominal', name: 'jumlah_nominal' },
        { data: 'persentase_kepemilikan', name: 'persentase_kepemilikan'},
        { data: 'action', name: 'action'},
    ],
    order: [[0, 'asc']]
});
</script>
@endpush