<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">


     
      
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">KONDISI KEUANGAN DEBITUR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</h4>
                <div style="height:30px"></div>
                @include('flash-message')
                @include('error-message')
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

        <form action="{{ url('save-kondisi-keuangan-debitur') }}" method="POST" enctype="multipart/form-data">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? ''  }}">
            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
            <input type="hidden" name="tabel" value="kondisi_keuangan_debitur">
            <input type="hidden" name="aksi" value="{{ (isset($kondisiKeuanganDebitur->id)) ? 'Update' : 'Create' }}">
            <input type="hidden" name="bagian" value="Nak">

            <div class="card border-white">
                <div class="card-body">
                    <div class="form-group">
                        <textarea class="form-control {{ (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1) ? 'content' : 'read' }}" name="keterangan"  rows="6">{{ $kondisiKeuanganDebitur->keterangan ?? '' }}</textarea>
                    </div>

                    <div style="height:20px"></div>

                    @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div>
            </div>

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <h6 align="center">LIST SLIK</h6>
                    <div style="height:30px"></div>

                    <table class="table" id="table" width="100%">
                        <thead>    
                            <tr>
                                <th>No</th>
                                <th>Nama Lembaga Keuangan</th>
                                <th>Plafond</th>
                                <th>Jenis Periode</th>
                                <th>Jenis Fasilitas</th>
                                <th>Baki Debet</th>
                                <th>Suku Bunga</th>
                                <th>Jaminan</th>
                                <th>KOL</th>
                                @if(Auth::user()->jabatan_user->kode == 'account_officer')
                                    <th>Aksi</th>
                                @endif
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection


@push('scripts')
<script type="text/javascript">
$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    scrollX: true,
    ajax: "{{ url('slik', $data->sandi_bpr) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data: 'nama_lembaga_keuangan', name:'nama_lembaga_keuangan'},
        { data: 'plafon', name:'plafon'},
        { data: 'periode', name:'periode'},
        { data: 'jenis', name:'jenis'},
		{ data: 'baki_debet', name:'baki_debet' },
		{ data: 'suku_bunga', name:'suku_bunga' },
		{ data: 'jenis_agunan_yang_dijaminkan', name:'jenis_agunan_yang_dijaminkan' },
		{ data: 'kol', name:'kol' },
        @if(Auth::user()->jabatan_user->kode == 'account_officer')
            { data: 'action', name: 'action'},
        @endif

    ],
    order: [[0, 'asc']]
});

</script>
@endpush