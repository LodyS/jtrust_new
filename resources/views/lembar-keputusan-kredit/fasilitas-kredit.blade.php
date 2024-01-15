@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
            <div class="card-body">
                <h5 align="center">AGUNAN FASILITAS KREDIT - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>

                <div style="height:30px"></div>
                @include('flash-message')
                @include('menu-lkk')
            </div> 
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">

                <div style="height:30px"></div>

                <table class="table table table-sm">
                    <tr>
                        <th style="text-align:center;" colspan="10">PERSETUJUAN STRUKTUR KREDIT</th>
                    </tr>

                    <tr>
                        <td rowspan="2">Jenis Fasilitas</td>
                        <td rowspan="2">Status</td>
                        <td rowspan="2">CCY</td>
                        <td style="text-align:center;" colspan="4">Plafon</td>
                        <td>Bunga</td>
                        <td colspan="2">Jangka Waktu</td>
                    </tr>

                    <tr>
                        <td>Plafond (existing)</td>
                        <td>Pemakaian (outstanding)</td>
                        <td>Pengajuan Baru (+/-)</td>
                        <td>Disetujui (Approved)</td>
                        <td>(%) p.a</td>
                        <td>Tenor Bulan</td>
                        <td>Tanggal Fasilitas</td>
                    </tr>

                    <tr>
                        <td>{{ \App\Models\ProductType::namaProduk($data->produk_id) ?? '' }}</td>
                        <td>{{ $data->jenis_pengajuan ?? '' }}</td>
                        <td>IDR</td>
                        <td style="text-align:right">{{ number_format(substr($data->plafond, 0,-3)) ?? '' }}</td>
                        <td>-</td>
                        <td style="text-align:right">{{ number_format(substr($data->plafond, 0,-3)) ?? '' }}</td>
                        <td style="text-align:right">{{ number_format(substr($data->plafond, 0, -3)) ?? '' }}</td>
                        <td>{{ $data->bunga ?? '' }}</td>
                        <td>-</td>
                        <td>{{ $data->tenor ?? '' }}</td>
                    </tr>

                    <tr>
                        <td rowspan="2"><b>TOTAL</b></td>
                        <td colspan="2">IDR</td>
                        <td style="text-align:right">{{ number_format(substr($data->plafond, 0,-3)) ?? '' }}</td>
                        <td>-</td>
                        <td style="text-align:right">{{ number_format(substr($data->plafond, 0,-3)) ?? '' }}</td>
                        <td style="text-align:right">{{ number_format(substr($data->plafond, 0, -3)) ?? '' }}</td>
                    </tr>

                    <tr>
                        <td colspan="2">USD</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td colspan="6">*) angka dalam jutaan rupiah</td>
                    </tr>
                </table>
            </div> 
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <p><b>Biaya-biaya</b></p>
                <span style="width:150px; display: inline-block;">Provisi</span>: {{ number_format((float)$data->provisi) ?? '' }}<br/>
                <span style="width:150px; display: inline-block;">Biaya Administrasi </span>: {{ number_format((float)$data->biaya_administrasi) ?? '' }}
            </div> 
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

    $('.nominal').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value) {
            return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    }));
</script>
@endpush
