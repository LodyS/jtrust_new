@extends('tema.app')
@section('content')

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <form action="{{ route('rincian-kantor-bpr.store')}}" method="POST" name="form">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $id }}">
            <input type="hidden" name="aksi" value="Create">
            <input type="hidden" name="tabel" value="form_004">
            <input type="hidden" name="bagian" value="Master BPR">

            <div class="card border-white">
                <div class="card-body">
                    @include('error-message')
                    @include('flash-message')

                    <h5 align="center">DAFTAR RINCIAN KANTOR BPR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($id)->nama_bpr) }}</h5>

                    <div style="height:30px"></div>

                    <div>
                        <ul>@include('list-menu-edit-bpr')</ul>
                    </div>
                </div> 
            </div>

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Sandi Kantor </label>
                                <input type="text" class="form-control" name="sandi_kantor" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nama Kantor </label>
                                <input type="text" class="form-control" name="nama_kantor" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Alamat</label>
                                <textarea class="form-control" name="nama_jalan_dan_no" rows = "3" required></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Desa/Kecamatan </label>
                                <input type="text" class="form-control" name="desa_kecamatan" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Kota/Kabupaten</label>
                                <input type="text" class="form-control" name="kab_kota" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Kode Pos</label>
                                <input type="text" class="form-control" name="kode_pos" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Koordinat Kantor </label>
                                <input type="text" class="form-control" name="koordinat_kantor">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nama Pimpinan </label>
                                <input type="text" class="form-control" name="nama_pimpinan" required>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">No Telepon </label>
                                <input type="text" class="form-control" name="no_telp" required>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Jumlah Kantor Kas </label>
                                <input type="text" class="form-control" name="jumlah_kantor_kas">
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Status Kepemilikan Gedung </label>
                                <input type="text" class="form-control" name="status_kepemilikan_gedung" required>
                            </div>
                        </div>
                    </div>

                    <div style="height:10px"></div>

                    <button type="submit" class="btn btn-primary submit"> Save  </button>
                </div>
            </div> 
        </form>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <h5 style="text-align:center">DAFTAR RINCIAN KANTOR BPR</h5>

                <div style="height:30px"></div>

                <table class="table" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Sandi Kantor</th>
                            <th>Nama Kantor</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>

$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});
	
$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    ajax: "{{ url('rincian-kantor-bpr', $id) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data: 'sandi_kantor', name: 'sandi_kantor'},
        { data: 'nama_kantor', name:'nama_kantor'},
        { data: 'action', name: 'action'},
    ],
    order: [[0, 'asc']]
});

</script>
@endpush
