@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        @if(Auth::user()->jabatan_user->nama_jabatan == 'Account Officer')
            <div class="card border-white">
                <div class="card-body">
                    <h5 style="text-align:center;">IMPORT FIDUCIA {{ $fiducia= strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($app)->nama_bpr) ?? '' }}</h5>

                    <div style="height:30px"></div>

                    <form action="{{ url('store-fiducia') }}" method="POST"  enctype="multipart/form-data">@csrf

                        @include('flash-message')

                        <div class="form-group row">
                            <label class="col-md-3">File (Excel format)</label>
                                <div class="col-md-7">
                                <input type="file" class="form-control" name="file" required accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                            </div>
                        </div>

                        <input type="hidden" class="form-control" name="loan_applicant_id" value="{{ $app ?? '' }}" >

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        @endif

        <div style="height:30px"></div>

        <div class="card border-white">
            <div class="card-body">

                <h5 style="text-align:center;">DAFTAR FIDUCIA</h5>
                <div style="height:30px"></div>

                <table class="table"  id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Menjadi Anggota</th>
                            <th>No Akad</th>
                            <th>Produk</th>
                            <th>Nama Peminjam</th>
                            <th>Cabang</th>
                            <th>Kota</th>
                            <th>Plafond</th>
                            <th>OS</th>
                            <th>Tanggal Pencairan</th>
                            <th>Jangka Waktu</th>
                            <th>Status</th>
                            <th>Tujuan Penggunaan</th>
                            <th>Hari Tunggakan</th>
                            <th>Kolektibilitas</th>
                        </tr>
                    </thead>
                </table>
            </div> 
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 20,
        scrollX: true,
        ajax: "{{ url('fiducia', $id) }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'tanggal_menjadi_anggota', name: 'tanggal_menjadi_anggota'},
            { data: 'no_akad', name: 'no_akad' },
            { data: 'produk', name: 'produk' },
            { data: 'nama_peminjam', name: 'nama_peminjam'},
            { data: 'cabang', name: 'cabang'},
            { data: 'kota', name: 'kota'},
            { data: 'plafond', name: 'plafond'},
            { data: 'os', name: 'os'},
            { data: 'tanggal_pencairan', name: 'tanggal_pencairan'},
            { data: 'jangka_waktu', name: 'jangka_waktu'},
            { data: 'status', name: 'status'},
            { data: 'tujuan_penggunaan', name: 'tujuan_penggunaan'},
            { data: 'hari_tunggakan', name: 'hari_tunggakan'},
            { data: 'kolektibilitas', name: 'kolektibilitas'},
        ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush



