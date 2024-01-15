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
        <div class="card border-white">
            <div class="card-body">
                <h5 style="text-align:center;">
                    INPUT PROFIL <br/>{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}<br/>{{ strtoupper(bulan($bulan)) }} {{ $tahun }}
                </h5>
                <div style="height:30px"></div>

                @include('menu-cari-laporan-bulanan')
                @include('flash-message')
            </div> 
        </div>

        <div style="height:10px"></div>

        <form action="{{ url('search-input-profil') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            <div class="card border-white">
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-md-3">Pilih Bulan</label>
                            <div class="col-md-7">
                            <select name="bulan" class="form-control">
                                <option>Pilih</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                    </div>

                    <?php $tahun = date('Y'); ?>
                    <div class="form-group row">
                        <label class="col-md-3">Pilih Tahun</label>
                            <div class="col-md-7">
                            <select name="tahun" id="tahun" class="form-control select">
                                <option value="">Pilih</option>
                                @for($i=2019; $i<=$tahun; $i++)
                                <option value="{{ $i }}">{{ $i}} </option>
                                @endfor
                            </select>
                        </div>
                    </div>

                 
                    <button type="submit" class="btn btn-primary" name="action" value="cari">Cari</button>
                   
                </div> 
            </div>
        </form>

        <div style="height:10px"></div> 

        <div class="card border-white">
            <div class="card-body">

                <form action="{{ url('update-input-profil') }}" method="POST">@csrf

                    <div style="height:20px"></div>

                    <table class="table table-stripped" id="table">

                        <input type="hidden" name="id" value="{{ $data->id ?? ''}}">
                        <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

                        <tr>
                            <td style="font-size:11px">Jumlah Peminjam</td>
                            <td style="font-size:11px"><input type="number" name="jumlah_peminjam" class="form-control" value="{{ $data->jumlah_peminjam ?? '' }}"></td>
                        </tr>

                        <tr>
                            <td style="font-size:11px">Jumlah Nasabah Simpanan</td>
                            <td style="font-size:11px"><input type="number" name="jumlah_nasabah_simpanan" class="form-control" value="{{ $data->jumlah_nasabah_simpanan ?? ''}}"></td>
                        </tr>

                    </table>

                    <div style="height:30px"></div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" name="action" value="edit">Edit</button>
                    </div>
                </form>
            </div> 
        </div>
    </div>
</div>
@endsection
