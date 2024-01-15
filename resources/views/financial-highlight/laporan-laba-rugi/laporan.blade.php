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
            <h4 class="mb-0" align="center">LAPORAN LABA RUGI / PROFIT & LOSS</h4>
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
                <td>A. PENDAPATAN OPERASIONAL</td>
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

            <tr>
                <td><b>1. Pendapatan Bunga</b></td>
                <td></td>

                <?php

                $pendapatanOperasionalSekarang = $laporanTiga->sum('sekarang') + $laporanSatu->sum('sekarang') - $laporanDua->sum('sekarang');
                $bungaKontraktual = $laporanSatu->whereNotIn('sandi_coa', [4101020000])->sum('sekarang');
                $pendapatanBunga = $bungaKontraktual - $laporanSatu->where('sandi_coa', 4101020000)->sum('sekarang');
                ?>
                <td>
                    <b>{{ ($pendapatanOperasionalSekarang == 0 || $pendapatanBunga == 0) ? 0 : number_format(($pendapatanBunga/ $pendapatanOperasionalSekarang) * 100) }} %
                    </b>
                </td>
                <td><b>Rp. {{ number_format($pendapatanBunga) }}</b></td>

                <?php
                $pendapatanBungaSatu = $laporanSatu->sum('satu') - $laporanDua->sum('satu');
                $pendapatanOperasionalSatu = $laporanTiga->sum('satu') + $laporanSatu->sum('satu') - $laporanDua->sum('satu');
                $bungaKontraktualSatu = $laporanSatu->whereNotIn('sandi_coa', [4101020000])->sum('satu');
                ?>
                <td>
                    <b>{{ ($pendapatanOperasionalSatu ==0  || $pendapatanBungaSatu == 0) ? 0 : number_format(($pendapatanBungaSatu/ $pendapatanOperasionalSatu) * 100) }} %
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanSatu->sum('satu') - $laporanDua->sum('satu') ) }}</b></td>

                <?php
                $pendapatanBungaDua = $laporanSatu->sum('dua') - $laporanDua->sum('dua');
                $pendapatanOperasionalDua = $laporanTiga->sum('dua') + $laporanSatu->sum('dua') - $laporanDua->sum('dua');
                $bungaKontraktualDua = $laporanSatu->whereNotIn('sandi_coa', [4101020000])->sum('dua');
                ?>
               <td>
                    <b>{{ ($pendapatanOperasionalDua ==0 || $pendapatanBungaDua ==0) ? 0 : number_format(($pendapatanBungaDua/ $pendapatanOperasionalDua) * 100) }} %
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanSatu->sum('dua') - $laporanDua->sum('dua') ) }}</b></td>

                <?php
                $pendapatanBungaTiga = $laporanSatu->sum('tiga') - $laporanDua->sum('tiga');
                $pendapatanOperasionalTiga = $laporanTiga->sum('tiga') + $laporanSatu->sum('tiga') - $laporanDua->sum('tiga');
                $bungaKontraktualTiga = $laporanSatu->whereNotIn('sandi_coa', [4101020000])->sum('tiga');
                ?>
                 <td>
                    <b>{{ ($pendapatanOperasionalTiga ==0 || $pendapatanBungaTiga ==0) ? 0 : number_format(($pendapatanBungaTiga/ $pendapatanOperasionalTiga) * 100)
                        }} %
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanSatu->sum('tiga') - $laporanDua->sum('tiga') ) }}</b></td>
            </tr>

            <tr>
                <td><b>A. Bunga Kontraktual</b></td>
                <td></td>

                <td>
                    <b>{{ ($bungaKontraktual == 0 || $pendapatanOperasionalSekarang ==0) ? 0 : number_format(($bungaKontraktual/$pendapatanOperasionalSekarang)* 100) }} %</b>
                </td>
                <td><b>Rp. {{ number_format($bungaKontraktual) }}</b></td>

                <td>
                    <b>{{ ($bungaKontraktualSatu == 0 || $pendapatanOperasionalSatu ==0) ? 0 : number_format(($bungaKontraktualSatu/$pendapatanOperasionalSatu)* 100) }} %</b>
                </td>
                <td><b>Rp. {{ number_format($bungaKontraktualSatu) }}</b></td>

                <td>
                    <b>{{ ($bungaKontraktualDua == 0 || $pendapatanOperasionalDua ==0) ? 0 : number_format(($bungaKontraktualDua/$pendapatanOperasionalDua)* 100) }} %</b>
                </td>
                <td><b>Rp. {{ number_format($bungaKontraktualDua) }}</b></td>

                <td>
                    <b>{{ ($bungaKontraktualTiga == 0 || $pendapatanOperasionalTiga ==0) ? 0 : number_format(($bungaKontraktualTiga/$pendapatanOperasionalTiga)* 100) }} %</b>
                </td>
                <td><b>Rp. {{ number_format($bungaKontraktualTiga) }}</td>
            </tr>

            @foreach($laporanSatu as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 && $pendapatanOperasionalSekarang == 0) ? 0 : number_format(($data->sekarang/$pendapatanOperasionalSekaran) * 100) }}</b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $pendapatanOperasionalSatu == 0) ? 0 : number_format(($data->satu/ $pendapatanOperasionalSatu) * 100) }}</b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $pendapatanOperasionalDua == 0) ? 0 : number_format(($data->dua/ $pendapatanOperasionalDua) * 100) }}</b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $pendapatanOperasionalTiga == 0) ? 0 : number_format(($data->tiga/ $pendapatanOperasionalTiga) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>C. Biaya Transaksi</b></td>
                <td></td>

                <td>
                    <b> {{
                            ($laporanSatu->sum('sekarang') =='0.0' &&
                            $laporanDua->sum('sekarang') =='0.0' && $laporanTiga->sum('sekarang') =='0.0') ? 0 :

                            number_format(($laporanDua->sum('sekarang')/
                            $laporanTiga->sum('sekarang') + $laporanSatu->sum('sekarang') - $laporanDua->sum('sekarang')) * 100)
                        }}%
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanDua->sum('sekarang')) }}</b></td>

                <td>
                    <b> {{
                            ($laporanSatu->sum('satu') =='0.0' &&
                            $laporanDua->sum('satu') =='0.0' && $laporanTiga->sum('satu') =='0.0') ? 0 :

                            number_format(($laporanDua->sum('satu')/
                            $laporanTiga->sum('satu') + $laporanSatu->sum('satu') - $laporanDua->sum('satu')) * 100)
                        }}%
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanDua->sum('satu')) }}</b></td>

                <td>
                    <b>
                        {{
                            ($laporanSatu->sum('dua') =='0.0' &&
                            $laporanDua->sum('dua') =='0.0' && $laporanTiga->sum('dua') =='0.0') ? 0 :

                            number_format(($laporanDua->sum('dua')/
                            $laporanTiga->sum('dua') + $laporanSatu->sum('dua') - $laporanDua->sum('dua')) * 100)
                        }}%
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanDua->sum('dua')) }}</b></td>

                <td>
                    <b>
                        {{
                            ($laporanSatu->sum('tiga') =='0.0' &&
                            $laporanDua->sum('tiga') =='0.0' && $laporanTiga->sum('tiga') =='0.0') ? 0 :

                            number_format(($laporanDua->sum('tiga')/
                            $laporanTiga->sum('tiga') + $laporanSatu->sum('tiga') - $laporanDua->sum('tiga')) * 100)
                        }}%
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanDua->sum('tiga')) }}</b></td>
            </tr>

            @foreach($laporanDua as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 && $pendapatanOperasionalSekarang == 0) ? 0 : number_format(($data->sekarang/ $pendapatanOperasionalSekarang) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $pendapatanOperasionalSatu == 0) ? 0 : number_format(($data->satu/ $pendapatanOperasionalSatu) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $pendapatanOperasionalDua == 0) ? 0 : number_format(($data->dua/ $pendapatanOperasionalDua) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $pendapatanOperasionalTiga == 0) ? 0 : number_format(($data->tiga/ $pendapatanOperasionalTiga) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>2. Pendapatan Lainnya</b></td>
                <td></td>

                <td>
                    <b> {{
                            ($laporanSatu->sum('sekarang') =='0.0' &&
                            $laporanDua->sum('sekarang') =='0.0' && $laporanTiga->sum('sekarang') =='0.0') ? 0 :

                            number_format(($laporanTiga->sum('sekarang')/
                            $laporanTiga->sum('sekarang') + $laporanSatu->sum('sekarang') - $laporanDua->sum('sekarang')) * 100)
                        }}%
                    </b>
                </td>
                <td>{{ number_format($laporanTiga->sum('sekarang')) }}</td>

                <td>
                    <b> {{
                            ($laporanSatu->sum('satu') =='0.0' &&
                            $laporanDua->sum('satu') =='0.0' && $laporanTiga->sum('satu') =='0.0') ? 0 :

                            number_format(($laporanTiga->sum('satu')/
                            $laporanTiga->sum('satu') + $laporanSatu->sum('satu') - $laporanDua->sum('satu')) * 100)
                        }}%
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanTiga->sum('satu')) }}</b></td>

                <td>
                    <b>{{
                            ($laporanSatu->sum('dua') =='0.0' &&
                            $laporanDua->sum('dua') =='0.0' && $laporanTiga->sum('dua') =='0.0') ? 0 :

                         number_format(($laporanTiga->sum('dua')/
                            $laporanTiga->sum('dua') + $laporanSatu->sum('dua') - $laporanDua->sum('dua')) * 100)
                        }}%
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanTiga->sum('dua')) }}</b></td>

                <td>
                    <b> {{
                            ($laporanSatu->sum('tiga') =='0.0' &&
                            $laporanDua->sum('tiga') =='0.0' && $laporanTiga->sum('tiga') =='0.0') ? 0 :

                            number_format(($laporanTiga->sum('tiga')/
                            $laporanTiga->sum('tiga') + $laporanSatu->sum('tiga') - $laporanDua->sum('tiga')) * 100)
                        }}%
                    </b>
                </td>
                <td><b>Rp. {{ number_format($laporanTiga->sum('tiga')) }}</b></td>
            </tr>

            @foreach($laporanTiga as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>{{ ($data->sekarang ==0 && $pendapatanOperasionalSekarang == 0) ? 0 : number_format(($data->sekarang/ $pendapatanOperasionalSekarang) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>{{ ($data->satu ==0 && $pendapatanOperasionalSatu == 0) ? 0 : number_format(($data->satu/ $pendapatanOperasionalSatu) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>{{ ($data->dua ==0 && $pendapatanOperasionalDua == 0) ? 0 : number_format(($data->dua/ $pendapatanOperasionalDua) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>{{ ($data->tiga ==0 && $pendapatanOperasionalTiga == 0) ? 0 : number_format(($data->tiga/ $pendapatanOperasionalTiga) * 100) }}</b></b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>TOTAL PENDAPATAN OPERASIONAL</b></td>
                <td></td>

                <td></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalSekarang)  }}</b></td>

                <td></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalSatu)  }}</b></td>

                <td></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalDua) }}</b></td>

                <td></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalTiga) }}</b></td>
            </tr>

            <hr/>

            <tr>
                <td>B. BEBAN OPERASIONAL</td>
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

            <tr>
                <td><b>1. Beban Bunga</b></td>
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

            <tr>
                <td><b>A. Beban Bunga Kontraktual</b></td>
                <td></td>
                <?php
                    $bebanBungaKontraktualSekarang = $laporanEmpat->sum('sekarang') +
                    $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('sekarang') +
                    $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('sekarang');

                    $bSekarang =$laporanEnam->where('sandi_coa', 4101040000)->sum('sekarang') +
                    $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('sekarang') +
                    $laporanEmpat->sum('sekarang') +
                    $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('sekarang') +
                    $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('sekarang');
                ?>

                <td><b>{{ ($bebanBungaKontraktualSekarang || $bSekarang == 0) ? 0 : number_format(($bebanBungaKontraktualSekarang/$bSekarang) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanBungaKontraktualSekarang)}}</b></td>

                <?php
                $bebanBungaKontraktualSatu= $laporanEmpat->sum('satu') +
                $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('satu') +
                $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('satu');

                $bSatu =$laporanEnam->where('sandi_coa', 4101040000)->sum('satu') +
                $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('satu') +
                $laporanEmpat->sum('satu') +
                $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('satu') +
                $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('satu'); ?>
                <td><b>{{ ($bebanBungaKontraktualSatu == 0 || $bSatu == 0) ? 0 : number_format(($bebanBungaKontraktualSatu/$bSatu) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanBungaKontraktualSatu)}}</b></td>

                <?php
                $bebanBungaKontraktualDua= $laporanEmpat->sum('dua') +
                $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('dua') +
                $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('dua');

                $bDua =$laporanEnam->where('sandi_coa', 4101040000)->sum('dua') +
                $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('dua') +
                $laporanEmpat->sum('dua') +
                $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('dua') +
                $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('dua'); ?>
                <td><b>{{ ($bebanBungaKontraktualDua == 0 || $bDua == 0) ? 0 : number_format(($bebanBungaKontraktualDua/$bDua) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanBungaKontraktualDua)}}</b></td>

                <?php
                $bebanBungaKontraktualTiga= $laporanEmpat->sum('tiga') +
                $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('tiga') +
                $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('tiga');

                $bTiga =$laporanEnam->where('sandi_coa', 4101040000)->sum('tiga') +
                $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('tiga') +
                $laporanEmpat->sum('tiga') +
                $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('tiga') +
                $laporanLima->whereIn('sandi_coa', [5101010404, 5101019900])->sum('tiga'); ?>
                <td><b>{{ ($bebanBungaKontraktualTiga == 0 || $bTiga == 0) ? 0 : number_format(($bebanBungaKontraktualTiga/$bTiga) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanBungaKontraktualTiga)}}</b></td>
            </tr>

            @foreach($laporanEmpat as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>{{ ($data->sekarang ==0 || $bSekarang == 0) ? 0 : number_format(($data->sekarang/$bSekarang) * 100,2)}}%</td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>{{ ($data->satu ==0 || $bSatu == 0) ? 0 : number_format(($data->satu/$bSatu) * 100,2)}}%</td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>{{ ($data->dua ==0 || $bDua == 0) ? 0 : number_format(($data->dua/$bDua) * 100,2)}}%</td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td><b>{{ ($data->tiga ==0 || $bTiga == 0) ? 0 : number_format(($data->tiga/$bTiga) * 100,2)}}%</td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>iv. Pinjaman yang Diterima</b></td>
                <td></td>

                <?php $pinjamanDiterima = $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('sekarang'); ?>
                <td><b>{{ ($pinjamanDiterima ==0 && $bSekarang ==0) ?0 : number_format(($pinjamanDiterima/$bSekarang) *100,2)}}</b> %</td>
                <td><b>Rp. {{ number_format($pinjamanDiterima) }} </b></td>

                <?php $pinjamanDiterimaSatu = $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('satu'); ?>
                <td><b>{{ ($pinjamanDiterimaSatu ==0 || $bSatu ==0) ? 0 : number_format(($pinjamanDiterimaSatu/$bSatu)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($pinjamanDiterimaSatu) }} </b></td>

                <?php $pinjamanDiterimaDua = $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('dua'); ?>
                <td><b>{{ ($pinjamanDiterimaDua ==0 || $bDua == 0) ?0 : number_format(($pinjamanDiterimaDua/$bDua) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($pinjamanDiterimaDua) }} </b></td>

                <?php $pinjamanDiterimaTiga = $laporanLima->whereIn('sandi_coa', [5101010401, 5101010402])->sum('tiga'); ?>
                <td><b>{{ ($pinjamanDiterimaTiga ==0 || $bTiga) ?0 : number_format(($pinjamanDiterimaTiga/$bTiga)*100,2)}} %</td>
                <td><b>Rp. {{ number_format($pinjamanDiterimaTiga) }} </b></td>
            </tr>

            @foreach($laporanLima as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td><b>{{ ($data->sekarang ==0 || $bSekarang ==0) ?0 : number_format(($data->sekarang/$bSekarang)*100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td><b>{{ ($data->satu ==0 || $bSatu ==0) ?0 : number_format(($data->satu/$bSatu)*100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td><b>{{ ($data->dua ==0 || $bDua ==0) ?0 : number_format(($data->dua/$bDua)*100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td><b>{{ ($data->tiga ==0 || $bTiga ==0) ?0 : number_format(($data->tiga/$bTiga)*100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>b. Biaya Transaksi</b></td>
                <td></td>

                <?php $biayaTransaksi = $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('sekarang'); ?>
                <td><b>{{ ($biayaTransaksi ==0 || $bSekarang==0) ?0 : number_format(($biayaTransaksi/$bSekarang)*100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($biayaTransaksi) }} </b></td>

                <?php $biayaTransaksiSatu = $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('satu'); ?>
                <td><b>{{ ($biayaTransaksiSatu ==0 || $bSatu==0) ?0 : number_format(($biayaTransaksiSatu/$bSatu)*100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($biayaTransaksiSatu) }} </b></td>

                <?php $biayaTransaksiDua = $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('dua'); ?>
                <td><b>{{ ($biayaTransaksiDua ==0 || $bDua==0) ?0 : number_format(($biayaTransaksiDua/$bDua)*100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($biayaTransaksiDua) }} </b></td>

                <?php $biayaTransaksiTiga = $laporanEnam->whereIn('sandi_coa', [4101020100, 4101020200])->sum('tiga'); ?>
                <td><b>{{ ($biayaTransaksiTiga ==0 || $bTiga==0) ?0 : number_format(($biayaTransaksiTiga/$bTiga)*100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($biayaTransaksiTiga) }} </b></td>
            </tr>

            @foreach($laporanEnam as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>{{ ($data->sekarang == 0 || $bSekarang ==0) ?0 : number_format(($data->sekarang/$bSekarang) *100,2)}} %</td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>{{ ($data->satu == 0 || $bSatu ==0) ?0 : number_format(($data->satu/$bSatu) *100,2)}} %</td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>{{ ($data->dua == 0 || $bDua ==0) ?0 : number_format(($data->dua/$bDua) *100,2)}} %</td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>{{ ($data->tiga == 0 || $bTiga ==0) ?0 : number_format(($data->tiga/$bTiga) *100,2)}} %</td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>Sub Total Beban Bunga</b></td>
                <td></td>

                <?php
                $subTotalBebanBunga = $bebanBungaKontraktualSekarang + $biayaTransaksi + $laporanEnam->where('sandi_coa', 4101040000)->sum('sekarang');
                $bebanPenyisihan = $laporanEmpatbelas->sum('sekarang');
                $bebanLainnya = $laporanSepuluh->whereIn('sandi_coa', [5199010000, 5199020000])->sum('sekarang');

                $bebanAdministrasi=
                $bebanTenagaKerja = $laporanDelapan->sum('sekarang') +
                $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('sekarang') +
                $laporanSembilan->where('sandi_coa', 5106040000)->sum('sekarang') +
                $laporanSembilan->where('sandi_coa', 5106050000)->sum('sekarang') +
                $laporanSembilan->where('sandi_coa', 5106060000)->sum('sekarang') +
                $laporanSembilan->where('sandi_coa', 5106070000)->sum('sekarang') +
                $laporanSembilan->where('sandi_coa', 5106080000)->sum('sekarang') +
                $laporanSembilan->where('sandi_coa', 5106090000)->sum('sekarang');


                $subTotalBebanOperasional = $subTotalBebanBunga+ $bebanPenyisihan+
                $laporanTujuh->where('sandi_coa', 5104000000)->sum('sekarang')+
                $laporanTujuh->where('sandi_coa', 5105000000)->sum('sekarang')+
                $bebanAdministrasi + $bebanLainnya; ?>

                <td><b>{{ ($subTotalBebanBunga ==0 || $subTotalBebanOperasional ==0) ?0 : number_format(($subTotalBebanOperasional/$subTotalBebanBunga) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanBunga) }} </b></td>

                <?php
                $subTotalBebanBungaSatu = $bebanBungaKontraktualSatu + $biayaTransaksiSatu + $laporanEnam->where('sandi_coa', 4101040000)->sum('satu');
                $bebanPenyisihanSatu = $laporanEmpatbelas->sum('satu');
                $bebanLainnyaSatu = $laporanSepuluh->whereIn('sandi_coa', [5199010000, 5199020000])->sum('satu');

                $bebanAdministrasiSatu =
                $bebanTenagaKerjaSatu = $laporanDelapan->sum('satu') +
                $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('satu') +
                $laporanSembilan->where('sandi_coa', 5106040000)->sum('satu') +
                $laporanSembilan->where('sandi_coa', 5106050000)->sum('satu') +
                $laporanSembilan->where('sandi_coa', 5106060000)->sum('satu') +
                $laporanSembilan->where('sandi_coa', 5106070000)->sum('satu') +
                $laporanSembilan->where('sandi_coa', 5106080000)->sum('satu') +
                $laporanSembilan->where('sandi_coa', 5106090000)->sum('satu');

                $subTotalBebanOperasionalSatu = $subTotalBebanBungaSatu + $bebanPenyisihanSatu+
                $laporanTujuh->where('sandi_coa', 5104000000)->sum('satu')+
                $laporanTujuh->where('sandi_coa', 5105000000)->sum('satu')+
                $bebanAdministrasiSatu + $bebanLainnyaSatu; ?>

                <td><b>{{ ($subTotalBebanBungaSatu ==0 || $subTotalBebanOperasionalSatu ==0) ?0 : number_format(($subTotalBebanOperasionalSatu/$subTotalBebanBungaSatu) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanBungaSatu) }} </b></td>

                <?php
                $subTotalBebanBungaDua = $bebanBungaKontraktualDua + $biayaTransaksiDua + $laporanEnam->where('sandi_coa', 4101040000)->sum('dua');
                $bebanPenyisihanDua = $laporanEmpatbelas->sum('dua');
                $bebanLainnyaDua = $laporanSepuluh->whereIn('sandi_coa', [5199010000, 5199020000])->sum('dua');

                $bebanAdministrasiDua =
                $bebanTenagaKerjaDua = $laporanDelapan->sum('dua') +
                $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('dua') +
                $laporanSembilan->where('sandi_coa', 5106040000)->sum('dua') +
                $laporanSembilan->where('sandi_coa', 5106050000)->sum('dua') +
                $laporanSembilan->where('sandi_coa', 5106060000)->sum('dua') +
                $laporanSembilan->where('sandi_coa', 5106070000)->sum('dua') +
                $laporanSembilan->where('sandi_coa', 5106080000)->sum('dua') +
                $laporanSembilan->where('sandi_coa', 5106090000)->sum('dua');


                $subTotalBebanOperasionalDua = $subTotalBebanBungaDua + $bebanPenyisihanDua+
                $laporanTujuh->where('sandi_coa', 5104000000)->sum('dua')+
                $laporanTujuh->where('sandi_coa', 5105000000)->sum('dua')+
                $bebanAdministrasiDua + $bebanLainnyaDua; ?>
                <td><b>{{ ($subTotalBebanBungaDua ==0 || $subTotalBebanOperasionalDua ==0) ?0 : number_format(($subTotalBebanOperasionalDua/$subTotalBebanBungaDua) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanBungaDua) }} </b></td>

                <?php
                $subTotalBebanBungaTiga = $bebanBungaKontraktualTiga + $biayaTransaksiTiga + $laporanEnam->where('sandi_coa', 4101040000)->sum('tiga');
                $bebanPenyisihanTiga = $laporanEmpatbelas->sum('tiga');
                $bebanLainnyaTiga = $laporanSepuluh->whereIn('sandi_coa', [5199010000, 5199020000])->sum('tiga');

                $bebanAdministrasiTiga =
                $bebanTenagaKerjaTiga = $laporanDelapan->sum('tiga') +
                $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('tiga') +
                $laporanSembilan->where('sandi_coa', 5106040000)->sum('tiga') +
                $laporanSembilan->where('sandi_coa', 5106050000)->sum('tiga') +
                $laporanSembilan->where('sandi_coa', 5106060000)->sum('tiga') +
                $laporanSembilan->where('sandi_coa', 5106070000)->sum('tiga') +
                $laporanSembilan->where('sandi_coa', 5106080000)->sum('tiga') +
                $laporanSembilan->where('sandi_coa', 5106090000)->sum('tiga');

                $subTotalBebanOperasionalTiga = $subTotalBebanBungaTiga + $bebanPenyisihanTiga+
                $laporanTujuh->where('sandi_coa', 5104000000)->sum('tiga')+
                $laporanTujuh->where('sandi_coa', 5105000000)->sum('tiga')+
                $bebanAdministrasiTiga + $bebanLainnyaTiga; ?>
                <td><b>{{ ($subTotalBebanBungaTiga ==0 || $subTotalBebanOperasionalTiga ==0) ?0 : number_format(($subTotalBebanOperasionalTiga/$subTotalBebanBungaTiga) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanBungaTiga) }} </b></td>
            </tr>

            <tr>
                <td><b>Pendapatan Operasional Setelah Beban Bunga</b></td>
                <td></td>

                <?php $pendapatanOperasionalSetelahBungaSekarang = $pendapatanOperasionalSekarang - $laporanEmpat->sum('sekarang') + $laporanLima->sum('sekarang') + $laporanEnam->sum('sekarang'); ?>
                <td><b>{{ ($pendapatanOperasionalSetelahBungaSekarang == 0 || $pendapatanOperasionalSekarang) ? 0 : number_format(($pendapatanOperasionalSetelahBungaSekarang/$pendapatanOperasionalSekarang) * 100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalSetelahBungaSekarang) }} </b></td>

                <?php $pendapatanOperasionalSetelahBungaSatu = $pendapatanOperasionalSatu - $laporanEmpat->sum('satu') + $laporanLima->sum('satu') + $laporanEnam->sum('satu'); ?>
                <td><b>{{ ($pendapatanOperasionalSetelahBungaSatu == 0 || $pendapatanOperasionalSatu) ? 0 : number_format(($pendapatanOperasionalSetelahBungaSatu/$pendapatanOperasionalSatu) * 100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalSetelahBungaSatu) }} </b></td>

                <?php $pendapatanOperasionalSetelahBungaDua = $pendapatanOperasionalDua - $laporanEmpat->sum('dua') + $laporanLima->sum('dua') + $laporanEnam->sum('dua'); ?>
                <td><b>{{ ($pendapatanOperasionalSetelahBungaDua == 0 || $pendapatanOperasionalDua) ? 0 : number_format(($pendapatanOperasionalSetelahBungaDua/$pendapatanOperasionalDua) * 100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalSetelahBungaDua) }} </b></td>

                <?php $pendapatanOperasionalSetelahBungaTiga = $pendapatanOperasionalTiga - $laporanEmpat->sum('tiga') + $laporanLima->sum('tiga') + $laporanEnam->sum('tiga'); ?>
                <td><b>{{ ($pendapatanOperasionalSetelahBungaTiga == 0 || $pendapatanOperasionalTiga) ? 0 : number_format(($pendapatanOperasionalSetelahBungaTiga/$pendapatanOperasionalTiga) * 100,2) }} %</b></td>
                <td><b>Rp. {{ number_format($pendapatanOperasionalSetelahBungaTiga) }} </b></td>
            </tr>

            <tr>
                <td><b>2. Beban Kerugian Rekrontruksi Kredit</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. 0 </b></td>
                <td></td>
                <td><b>Rp. 0 </b></td>
                <td></td>
                <td><b>Rp. 0 </b></td>
                <td></td>
                <td><b>Rp. 0  </b></td> <!-- Data masing kosong -->
            </tr>

            <tr>
                <td><b>3. Beban Penyisihan Penghapusan Aset Produktif</b></td>
                <td></td>

                <?php $bebanPenyisihan = $laporanEmpatbelas->sum('sekarang'); ?>
                <td><b>{{ ($bebanPenyisihan == 0 || $subTotalBebanOperasional == 0) ?0 : number_format(($bebanPenyisihan/$subTotalBebanOperasional) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanPenyisihan )}} </b></td>

                <?php $bebanPenyisihanSatu = $laporanEmpatbelas->sum('satu'); ?>
                <td><b>{{ ($bebanPenyisihanSatu == 0 || $subTotalBebanOperasionalSatu == 0) ?0 : number_format(($bebanPenyisihanSatu/$subTotalBebanOperasionalSatu) *100,2) }}%</b></td>
                <td><b>Rp. {{ number_format($bebanPenyisihanSatu )}} </b></td>

                <?php $bebanPenyisihanDua = $laporanEmpatbelas->sum('dua'); ?>
                <td><b>{{ ($bebanPenyisihanDua == 0 || $subTotalBebanOperasionalDua == 0) ?0 : number_format(($bebanPenyisihanDua/$subTotalBebanOperasionalDua) *100,2)}}% </b></td>
                <td><b>Rp. {{ number_format($bebanPenyisihanDua )}} </b></td>

                <?php $bebanPenyisihanTiga = $laporanEmpatbelas->sum('tiga'); ?>
                <td><b>{{ ($bebanPenyisihanTiga == 0 || $subTotalBebanOperasionalTiga == 0) ?0 : number_format(($bebanPenyisihanTiga/$subTotalBebanOperasionalTiga) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanPenyisihanTiga )}} </b></td>
            </tr>

            @foreach($laporanEmpatbelas as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td><b>{{ ($data->sekarang == 0 || $subTotalBebanOperasional ==0) ? 0 : number_format(($data->sekarang/$subTotalBebanOperasional) *100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td><b>{{ ($data->satu == 0 || $subTotalBebanOperasionalSatu ==0) ? 0 : number_format(($data->satu/$subTotalBebanOperasionalSatu) *100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td><b>{{ ($data->dua == 0 || $subTotalBebanOperasionalDua ==0) ? 0 : number_format(($data->dua/$subTotalBebanOperasionalDua) *100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td><b>{{ ($data->tiga == 0 || $subTotalBebanOperasionalTiga ==0) ? 0 : number_format(($data->tiga/$subTotalBebanOperasionalTiga) *100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>c. Kredit yang diberikan</b></td>
                <td></td>

                <?php $kreditDiberikan = $laporanTujuh->whereIn('sandi_coa', [4101020100, 4101020200])->sum('sekarang'); ?>
                <td><b>{{ ($kreditDiberikan == 0 || $subTotalBebanOperasional ==0) ?0 : number_format(($kreditDiberikan/$subTotalBebanOperasional) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($kreditDiberikan )}} </b></td>

                <?php $kreditDiberikanSatu = $laporanTujuh->whereIn('sandi_coa', [4101020100, 4101020200])->sum('satu'); ?>
                <td><b>{{ ($kreditDiberikanSatu == 0 || $subTotalBebanOperasionalSatu ==0) ?0 : number_format(($kreditDiberikanSatu/$subTotalBebanOperasionalSatu) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($kreditDiberikanSatu )}} </b></td>

                <?php $kreditDiberikanDua = $laporanTujuh->whereIn('sandi_coa', [4101020100, 4101020200])->sum('dua'); ?>
                <td><b>{{ ($kreditDiberikanDua == 0 || $subTotalBebanOperasionalDua ==0) ?0 : number_format(($kreditDiberikanDua/$subTotalBebanOperasionalDua) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($kreditDiberikanDua )}} </b></td>

                <?php $kreditDiberikanTiga = $laporanTujuh->whereIn('sandi_coa', [4101020100, 4101020200])->sum('tiga'); ?>
                <td><b>{{ ($kreditDiberikanTiga == 0 || $subTotalBebanOperasionalTiga ==0) ?0 : number_format(($kreditDiberikanTiga/$subTotalBebanOperasionalTiga) *100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($kreditDiberikanTiga )}} </b></td>
            </tr>

            @foreach($laporanTujuh as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td><b>{{ ($data->sekarang == 0 || $subTotalBebanOperasional == 0) ? 0 : number_format(($data->sekarang/$subTotalBebanOperasional)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td><b>{{ ($data->satu == 0 || $subTotalBebanOperasionalSatu == 0) ? 0 : number_format(($data->satu/$subTotalBebanOperasionalSatu)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td><b>{{ ($data->dua == 0 || $subTotalBebanOperasionalDua == 0) ? 0 : number_format(($data->dua/$subTotalBebanOperasionalDua)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td><b>{{ ($data->tiga == 0 || $subTotalBebanOperasionalTiga == 0) ? 0 : number_format(($data->tiga/$subTotalBebanOperasionalTiga)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>6. Beban Administrasi Umum</b></td>
                <td></td>

                <td><b>{{ ($bebanAdministrasi == 0 || $subTotalBebanOperasional ==0) ?0 : number_format(($bebanAdministrasi/$subTotalBebanOperasional)*100,2) }}%</b></td>
                <td><b>Rp. {{ number_format( $bebanAdministrasi) }}</b></td>

                <td><b>{{ ($bebanAdministrasiSatu == 0 || $subTotalBebanOperasionalSatu ==0) ?0 : number_format(($bebanAdministrasiSatu/$subTotalBebanOperasionalSatu)*100,2) }}%</b></td>
                <td><b>Rp. {{ number_format( $bebanAdministrasiSatu)}}</b></td>

                <td><b>{{ ($bebanAdministrasiDua == 0 || $subTotalBebanOperasionalDua ==0) ?0 : number_format(($bebanAdministrasiDua/$subTotalBebanOperasionalDua)*100,2) }}%</b></td>
                <td><b>Rp. {{ number_format( $bebanAdministrasiDua) }}</b></td>

                <td><b>{{ ($bebanAdministrasiTiga == 0 || $subTotalBebanOperasionalTiga ==0) ?0 : number_format(($bebanAdministrasiTiga/$subTotalBebanOperasionalTiga)*100,2) }}%</b></td>
                <td><b>Rp. {{ number_format( $bebanAdministrasiTiga)}}</b></td>
            </tr>

            <tr>
                <td><b>A. Beban Tenaga Kerja</b></td>
                <td></td>

                <td><b>{{ ($bebanTenagaKerja ==0|| $subTotalBebanOperasional ==0) ? 0 : number_format(($bebanTenagaKerja/$subTotalBebanOperasional)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanTenagaKerja) }} </b></td>

                <td><b>{{ ($bebanTenagaKerjaSatu ==0|| $subTotalBebanOperasionalSatu ==0) ? 0 : number_format(($bebanTenagaKerjaSatu/$subTotalBebanOperasionalSatu)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanTenagaKerjaSatu ) }} </b></td>

                <td><b>{{ ($bebanTenagaKerjaDua ==0|| $subTotalBebanOperasionalDua ==0) ? 0 : number_format(($bebanTenagaKerjaDua/$subTotalBebanOperasionalDua)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanTenagaKerjaDua )}} </b></td>

                <td><b>{{ ($bebanTenagaKerjaTiga ==0|| $subTotalBebanOperasionalTiga ==0) ? 0 : number_format(($bebanTenagaKerjaTiga/$subTotalBebanOperasionalTiga)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($bebanTenagaKerjaDua)}} </b></td>
            </tr>

            @foreach($laporanDelapan as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td><b>{{ ($data->sekarang ==0|| $subTotalBebanOperasional==0) ? 0 : number_format(($data->sekarang/$subTotalBebanOperasional)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td><b>{{ ($data->satu ==0|| $subTotalBebanOperasionalSatu==0) ? 0 : number_format(($data->satu/$subTotalBebanOperasionalSatu)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td><b>{{ ($data->dua ==0|| $subTotalBebanOperasionalDua==0) ? 0 : number_format(($data->dua/$subTotalBebanOperasionalDua)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td><b>{{ ($data->tiga ==0|| $subTotalBebanOperasionalTiga==0) ? 0 : number_format(($data->tiga/$subTotalBebanOperasionalTiga)*100,2)}}%</b></td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>c. Beban Sewa</b></td>
                <td></td>

                <?php $bebanSewa = $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('sekarang'); ?>
                <td>{{ ($bebanSewa ==0 || $subTotalBebanOperasional ==0) ? 0 : number_format(($bebanSewa/$subTotalBebanOperasional)*100,2)}}</td>
                <td><b>Rp. {{ number_format($bebanSewa)}} </b></td>

                <?php $bebanSewaSatu = $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('satu'); ?>
                <td>{{ ($bebanSewaSatu ==0 || $subTotalBebanOperasionalSatu ==0) ? 0 : number_format(($bebanSewaSatu/$subTotalBebanOperasionalSatu)*100,2)}}</td>
                <td><b>Rp. {{ number_format($bebanSewaSatu )}} </b></td>

                <?php $bebanSewaDua = $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('dua'); ?>
                <td>{{ ($bebanSewaDua ==0 || $subTotalBebanOperasionalDua ==0) ? 0 : number_format(($bebanSewaDua/$subTotalBebanOperasionalDua)*100,2)}}</td>
                <td><b>Rp. {{ number_format($bebanSewaDua)}} </b></td>

                <?php $bebanSewaTiga = $laporanSembilan->whereIn('sandi_coa', [5106030100, 5106039900])->sum('tiga'); ?>
                <td>{{ ($bebanSewaTiga ==0 || $subTotalBebanOperasionalTiga ==0) ? 0 : number_format(($bebanSewaTiga/$subTotalBebanOperasionalTiga)*100,2)}}</td>
                <td><b>Rp. {{ number_format($bebanSewaTiga)}} </b></td>
            </tr>

            @foreach($laporanSembilan as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>{{ ($data->sekarang == 0 || $subTotalBebanOperasional ==0) ?0 : number_format(($data->sekarang/$subTotalBebanOperasional)*100,2)}}%</td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>{{ ($data->satu == 0 || $subTotalBebanOperasionalSatu ==0) ?0 : number_format(($data->satu/$subTotalBebanOperasionalSatu)*100,2)}}%</td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>{{ ($data->dua == 0 || $subTotalBebanOperasionalDua ==0) ?0 : number_format(($data->dua/$subTotalBebanOperasionalDua)*100,2)}}%</td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>{{ ($data->tiga == 0 || $subTotalBebanOperasionalTiga ==0) ?0 : number_format(($data->tiga/$subTotalBebanOperasionalTiga)*100,2) }}%</td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>7. Beban Lainnya</b></td>
                <td></td>

                <td><b>{{ ($bebanLainnya == 0 || $subTotalBebanOperasional ==0) ?0 : number_format(($bebanLainnya/$subTotalBebanOperasional)*100,2) }}%</b<</td>
                <td><b>Rp. {{ ($bebanLainnya) }} </b></td>

                <td><b>{{ ($bebanLainnyaSatu == 0 || $subTotalBebanOperasionalSatu ==0) ?0 : number_format(($bebanLainnyaSatu/$subTotalBebanOperasionalSatu)*100,2) }}%</b></td>
                <td><b>Rp. {{ $bebanLainnyaSatu  }} </b></td>

                <td><b>{{ ($bebanLainnyaDua == 0 || $subTotalBebanOperasionalDua ==0) ?0 : number_format(($bebanLainnyaDua/$subTotalBebanOperasionalDua)*100,2) }}%</b></td>
                <td><b>Rp. {{ $bebanLainnyaDua  }} </b></td>

                <td><b>{{ ($bebanLainnyaTiga == 0 || $subTotalBebanOperasionalTiga ==0) ?0 : number_format(($bebanLainnyaTiga/$subTotalBebanOperasionalTiga)*100,2) }}%</b></td>
                <td><b>Rp. {{ $bebanLainnyaTiga  }} </b></td>
            </tr>

            @foreach($laporanSepuluh as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>{{ ($data->sekarang == 0 || $subTotalBebanOperasional ==0) ?0 : number_format(($data->sekarang/$subTotalBebanOperasional)*100,2)}}%</td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>{{ ($data->satu == 0 || $subTotalBebanOperasionalSatu ==0) ?0 : number_format(($data->satu/$subTotalBebanOperasionalSatu)*100,2)}}%</td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td><b>{{ ($bebanLainnyaDua == 0 || $subTotalBebanOperasionalDua ==0) ?0 : number_format(($bebanLainnyaDua/$subTotalBebanOperasionalDua)*100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td><b>{{ ($bebanLainnyaTiga == 0 || $subTotalBebanOperasionalTiga ==0) ?0 : number_format(($bebanLainnyaTiga/$subTotalBebanOperasionalTiga)*100,2) }}%</b></td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>SUB TOTAL BEBAN OPERASIONAL</b></td>
                <td></td>

                <?php $cSekarang = $subTotalBebanOperasional+$subTotalBebanBunga; ?>
                <td><b>{{ ($subTotalBebanOperasional ==0 || $subTotalBebanBunga ==0) ? 0 : number_format(($subTotalBebanOperasional/$cSekarang)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanOperasional) }}</b></td>

                <?php $cSatu = $subTotalBebanOperasionalSatu+$subTotalBebanBungaSatu; ?>
                <td><b>{{ ($subTotalBebanOperasionalSatu ==0 || $subTotalBebanBungaSatu ==0) ? 0 : number_format(($subTotalBebanOperasionalSatu/$cSatu)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanOperasionalSatu ) }}</b></td>

                <?php $cDua = $subTotalBebanOperasionalDua+$subTotalBebanBungaDua; ?>
                <td><b>{{ ($subTotalBebanOperasionalDua ==0 || $subTotalBebanBungaDua ==0) ? 0 : number_format(($subTotalBebanOperasionalDua/$cDua)*100,2)}} %</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanOperasionalDua ) }}</b></td>

                <?php $cTiga = $subTotalBebanOperasionalTiga+$subTotalBebanBungaTiga; ?>
                <td><b>{{ ($subTotalBebanOperasionalTiga ==0 || $subTotalBebanBungaTiga ==0) ? 0 : number_format(($subTotalBebanOperasionalTiga/$cTiga)*100,2)}} &</b></td>
                <td><b>Rp. {{ number_format($subTotalBebanOperasionalTiga ) }} </b>
                </td>
            </tr>

            <tr>
                <td><b>LABA/(RUGI) OPERASIONAL</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiOperasional = $pendapatanOperasionalSekarang - $subTotalBebanOperasional)}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiOperasionalSatu = $pendapatanOperasionalSatu - $subTotalBebanOperasionalSatu)}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiOperasionalDua = $pendapatanOperasionalDua - $subTotalBebanOperasionalDua)}}</b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiOperasionalTiga = $pendapatanOperasionalTiga - $subTotalBebanOperasionalTiga)}}</b></td>
            </tr>

            <tr>
                <td><b>PENDAPATAN NON OPERASIONAL</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($pendapatanNonOperasional = $laporanSebelas->whereIn('sandi_coa', [4299000000])->sum('sekarang')) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($pendapatanNonOperasionalSatu = $laporanSebelas->whereIn('sandi_coa', [4299000000])->sum('satu')) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($pendapatanNonOperasionalDua = $laporanSebelas->whereIn('sandi_coa', [4299000000])->sum('dua')) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($pendapatanNonOperasionalTiga = $laporanSebelas->whereIn('sandi_coa', [4299000000])->sum('tiga')) }} </b></td>
            </tr>

            @foreach($laporanSebelas as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td>
                    <b>0%
                    </b>
                </td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td>
                    <b>0%
                    </b>
                </td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td>
                    <b>0%
                    </b>
                </td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td>
                    <b>0%
                    </b>
                </td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>BEBAN NON OPERASIONAL</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($bebanNonOperasional = $laporanDuabelas->whereIn('sandi_coa', [5201000000, 5299000000])->sum('sekarang')) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($bebanNonOperasionalSatu = $laporanDuabelas->whereIn('sandi_coa', [5201000000, 5299000000])->sum('satu')) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($bebanNonOperasionalDua = $laporanDuabelas->whereIn('sandi_coa', [5201000000, 5299000000])->sum('dua')) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($bebanNonOperasionalTiga = $laporanDuabelas->whereIn('sandi_coa', [5201000000, 5299000000])->sum('tiga')) }} </b></td>
            </tr>

            @foreach($laporanDuabelas as $key=>$data)
            <tr>
                <td>{{ $data->nama_coa }}</td>
                <td>{{ $data->sandi_coa }}</td>

                <td></td>
                <td>Rp. {{ number_format($data->sekarang) }}</td>

                <td></td>
                <td>Rp. {{ number_format($data->satu) }}</td>

                <td></td>
                <td>Rp. {{ number_format($data->dua) }}</td>

                <td></td>
                <td>Rp. {{ number_format($data->tiga) }}</td>
            </tr>
            @endforeach

            <tr>
                <td><b>LABA/(RUGI) NON OPERASIONAL</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiNonOperasional = $pendapatanNonOperasional-$bebanNonOperasional)}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiNonOperasionalSatu = $pendapatanNonOperasionalSatu-$bebanNonOperasionalSatu)}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiNonOperasionalDua = $pendapatanNonOperasionalDua-$bebanNonOperasionalDua)}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiNonOperasionalTiga = $pendapatanNonOperasionalTiga-$bebanNonOperasionalTiga)}} </b></td>
            </tr>

            <tr>
                <td><b>LABA/(RUGI) TAHUN BERJALAN SEBELUM PAJAK</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajak =($labaRugiOperasional +$pendapatanNonOperasional)-$bebanNonOperasional)}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajakSatu = ($labaRugiOperasionalSatu +$pendapatanNonOperasionalSatu)-$bebanNonOperasionalSatu)}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajakDua = ($labaRugiOperasionalDua +$pendapatanNonOperasionalDua)-$bebanNonOperasionalDua)}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajakTiga = ($labaRugiOperasionalTiga +$pendapatanNonOperasionalTiga)-$bebanNonOperasionalTiga)}} </b></td>
            </tr>

            <tr>
                <td>TAKSIRAN PAJAK PENGHASILAN</b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($laporanTigabelas->sekarang) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($laporanTigabelas->satu) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($laporanTigabelas->dua) }} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($laporanTigabelas->tiga) }} </b></td>
            </tr>

            <tr>
                <td><b>LABA/(RUGI) BERSIH TAHUN BERJALAN </b></td>
                <td></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajak-$laporanTigabelas->sekarang )}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajakSatu-$laporanTigabelas->satu )}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajakDua-$laporanTigabelas->dua )}} </b></td>
                <td></td>
                <td><b>Rp. {{ number_format($labaRugiBerjalanSebelumPajakTiga-$laporanTigabelas->tiga )}} </b></td>
            </tr>

        </table>
    </div>
</div>
@endsection
