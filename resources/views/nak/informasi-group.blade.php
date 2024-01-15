@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        @include('flash-message')
        @include('error-message')

        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">INFORMASI GRUP USAHA - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($app->sandi_bpr)->nama_bpr) ?? '' }}</h5>
                <div style="height:30px"></div>
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">

                <form action="{{ url('update-informasi-group') }}" method="POST">@csrf

                <input type="hidden" name="sandi_bpr" value="{{ $app->sandi_bpr ?? '' }}">
                <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
                <input type="hidden" name="tabel" value="informasi_grup_usaha">
                <input type="hidden" name="aksi" value="Create">
                <input type="hidden" name="bagian" value="Nak">

                <div class="form-group">
                    <table class="table table" id="tambah_form">
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Bidang Usaha</th>
                            <th>Tahun Pendirian</th>
                            <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button></th>
                        </tr>

                        <tbody></tbody>
                    </table>
                </div>

                <div style="height:10px"></div>

                @if (Auth::user()->jabatan_user->kode == 'account_officer' && $app->status_level_proses == '1')
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
            </div>
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <table class="table table-hover">
                    <tr>
                        <th colspan="4" style="text-align:center">INFORMASI GROUP USAHA</th>
                    </tr>

                    <tr>
                        <td><b>NO</b></td>
                        <td><b>Nama Perusahaan</b></td>
                        <td><b>Bidang Usaha</b></td>
                        <td><b>Tahun Pendirian</b></td>
                    </tr>

                    @foreach($data as $key=>$d)
                    <tr>
                        <td>{{ ($key++) + 1 }}</td>
                        <td>{{ $d->nama_perusahaan ?? '' }}</td>
                        <td>{{ $d->bidang_usaha ?? '' }}</td>
                        <td>{{ $d->tahun_pendirian ?? '' }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </form>
</div>

@endsection

@push('scripts')
<script>

$("#add").on("click", function() {
    var newRow = $("<tr>");
    var cols = "";
    cols += '<td><input type="text" name="nama_perusahaan[]" class="form-control"></td>';
    cols += '<td><input type="text" name="bidang_usaha[]" class="form-control"></td>';
    cols += '<td><input type="text" class="form-control" name="tahun_pendirian[]"/></td>';
    cols += '<td style="text-align:right"><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';
    newRow.append(cols);

    $("#tambah_form").append(newRow);
    i++;
});

$("#tambah_form").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
    //hitung();
});

</script>
@endpush
