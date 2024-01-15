@extends('tema.app')
@section('content')

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h5 style="text-align:center;">Edit Input Profil {{ \App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr ?? '' }}</h5>

        <div style="height:30px" align="centre"></div>

        <form action="{{ url('update-input-profil') }}" method="POST">@csrf

        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
        <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? '' }}">

        @include('menu-laporan-bulanan')
        <div style="height:30px"></div>
        @include('flash-message')
        <div style="height:30px"></div>

        <table class="table table-stripped" id="table">

            <tr>
                <td style="font-size:11px">Jumlah Peminjam</td>
                <td style="font-size:11px"><input type="number" name="jumlah_peminjam" class="form-control" value="{{ $data->jumlah_peminjam ?? '' }}"></td>
            </tr>

            <tr>
                <td style="font-size:11px">Jumlah Nasabah Pinjaman</td>
                <td style="font-size:11px"><input type="number" name="jumlah_nasabah_simpanan" class="form-control" value="{{ $data->jumlah_nasabah_simpanan ?? '' }}"></td>
            </tr>

        </table>

        <div style="height:30px"></div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ url('list-data-bpr') }}" class="btn btn-danger">Back</a>
        </div>

    </div>
</div>
@endsection



