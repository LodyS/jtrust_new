@extends('tema.app')
@section('content')

<style>
table
{
  border-collapse: collapse;
  border-spacing: 0;
  width: 100%;
  border: 1px solid #ddd;
}

th, td
{
  text-align: left;
  padding: 8px;
}

tr:nth-child(even)
{
background-color: #f2f2f2
}
</style>

<div class="card">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0" align="center">LAPORAN ASET PRODUKTIF</h4>
        </div>

        <table class="table table-bordered table-responsive">
            <tr>
                <th>POS/AKTIVITAS</th>
                <th>Sandi/Jenis LBU</th>
                <th colspan="2">{{ bulan(date('m', strtotime($date))) }} {{ date('Y', strtotime($date)) }}</th>
                <th colspan="2">{{ bulan($satuBulan) }} {{ $satuTahun }}</th>
                <th colspan="2">{{ bulan($duaBulan)  }} {{ $duaTahun }}</th>
                <th colspan="2">{{ bulan($tigaBulan) }} {{ $tigaTahun }}</th>
            </tr>

            <tr>
                <td><b>AKTIVA</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            @foreach($laporanSatu as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 &&  $totalAktivaSekarang == 0) ? 0 : number_format(($data->sekarang/  $totalAktivaSekarang) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $data->dua == 0) ? 0 : number_format(($data->satu/ $totalAktivaSatu) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $data->dua == 0) ? 0 : number_format(($data->dua/ $totalAktivaDua) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $data->dua == 0) ? 0 : number_format(($data->tiga/ $totalAktivaTiga) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>4. Pendapatan Bunga yang Akan Diterima</b></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            @foreach($laporanTiga as $key=>$data)
            <tr>
                @if ($data->sandi_coa == 1103010000)
                <td><b>5. Penempatan Pada Bank Lain</b></td>
                @else
                <td>{{ $data->nama_coa }}</td>
                @endif

                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 &&  $totalAktivaSekarang ==0) ? 0 : number_format(($data->sekarang/  $totalAktivaSekarang) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $totalAktivaSatu == 0) ? 0 : number_format(($data->satu/ $totalAktivaSatu) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $totalAktivaDua ==0) ? 0 : number_format(($data->dua/ $totalAktivaDua) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $totalAktivaTiga ==0) ? 0 : number_format(($data->tiga/ $totalAktivaTiga) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            @foreach($laporanEmpat as $key=>$data)
            <tr>
                @if ($data->sandi_coa == 1104010100)
                <td><b>6. Kredit Yang Diberikan </b></td>
                @else
                <td>{{ $data->nama_coa }}</td>
                @endif

                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 &&  $totalAktivaSekarang == 0) ? 0 : number_format(($data->sekarang/  $totalAktivaSekarang) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $totalAktivaSatu ==0) ? 0 : number_format(($data->satu/ $totalAktivaSatu) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $totalAktivaDua == 0) ? 0 : number_format(($data->dua/ $totalAktivaDua) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $totalAktivaTiga ==0) ? 0 : number_format(($data->tiga/ $totalAktivaTiga) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>TOTAL AKTIVA</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalAktivaSekarang )}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalAktivaSatu )}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalAktivaDua )}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalAktivaTiga )}}</b></td>
            </tr>

            @foreach($laporanLima as $key=>$data)
            <tr>
                @if ($data->sandi_coa == 2102010000)
                <td><b>4.Simpanan </b></td>
                @elseif ($data->sandi_coa == 2103010000)
                <td><b>5. Simpanan dari bank lain</b></td>
                @elseif ($data->sandi_coa == 2201010000)
                <td><b>6. Pinjaman yang diterima</b></td>
                @else
                <td>{{ $data->nama_coa }}</td>
                @endif

                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 &&  $totalAktivaSekarang == 0) ? 0 : number_format(($data->sekarang/  $totalAktivaSekarang) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $totalAktivaSatu ==0) ? 0 : number_format(($data->satu/ $totalAktivaSatu) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $totalAktivaDua == 0) ? 0 : number_format(($data->dua/ $totalAktivaDua) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $totalAktivaTiga ==0) ? 0 : number_format(($data->tiga/ $totalAktivaTiga) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>Jumlah Kewajiban</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalKewajibanSekarang )}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalKewajibanSatu) }}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalKewajibanDua) }}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($totalKewajibanTiga) }}</b></td>
            </tr>

            <tr>
                <td><b>1. Komponen Modal</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($komponenModalSekarang )}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($komponenModalSatu) }}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($komponenModalDua) }}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($komponenModalTiga) }}</b></td>
            </tr>

            @foreach($laporanEnam as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 &&  $totalAktivaSekarang == 0) ? 0 : number_format(($data->sekarang/  $totalAktivaSekarang) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $totalAktivaSatu ==0) ? 0 : number_format(($data->satu/ $totalAktivaSatu) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $totalAktivaDua == 0) ? 0 : number_format(($data->dua/ $totalAktivaDua) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $totalAktivaTiga ==0) ? 0 : number_format(($data->tiga/ $totalAktivaTiga) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            @foreach($laporanTujuh as $key=>$data)
            <tr>
                <td><b>{{ $data->nama_coa }}</b></td>
                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 &&  $totalAktivaSekarang == 0) ? 0 : number_format(($data->sekarang/  $totalAktivaSekarang) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $totalAktivaSatu ==0) ? 0 : number_format(($data->satu/ $totalAktivaSatu) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $totalAktivaDua == 0) ? 0 : number_format(($data->dua/ $totalAktivaDua) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $totalAktivaTiga ==0) ? 0 : number_format(($data->tiga/ $totalAktivaTiga) * 100) }} %</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

        </table>
    </div>
</div>
@endsection
