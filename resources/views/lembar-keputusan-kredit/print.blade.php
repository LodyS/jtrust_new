<style>
.center {
    display: block;
    margin-left: auto;
    margin-right: auto;
}
</style>

<link rel="stylesheet" href="{{ url('css/nak-css.css') }}">

<title>LEMBAR KEPUTUSAN KREDIT - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</title>

<body>
    <div class="ariel">
       
        <div style="height:30px"></div>

        <div class="card border-white">
            <div class="card-body">
                <div id="header">
                    <h4>LEMBAR KEPUTUSAN KREDIT</h4>
                </div>

                <?php $plafond = ($data->pengajuan_induk_id == null) ? $data->plafond : $data->baki_debet ?>
                            
                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <td style="width:30%">BWMK</td>
                        <td>{{ \App\Models\Bwmk::statusBwmk($plafond) ?? '' }}</td>
                    </tr>

                    <tr>
                        <td style="10%">No Lembar Keputusan Kredit</td>
                        <td>{{ $data->no_lembar_keputusan_kredit ?? ''}}</td>
                    </tr>

                    <tr>
                        <td style="10%">Tanggal Lembar Keputusan Kredit</td>
                        <td>{{ ($data->tanggal_lkk == null) ? '' : date('d-m-Y', strtotime($data->tanggal_lkk)) ?? '' }}</td>
                    </tr>

                    <tr>
                        <td style="10%">Tanggal Rapat</td>
                        <td>{{ ($pelaksanaanRapat->tanggal == null) ? '' : date('d-m-Y', strtotime($pelaksanaanRapat->tanggal ?? '' )) ?? '' }}</td>
                    </tr>

                    <tr>
                        <td style="10%">Ruang Alamat</td>
                        <td>{{ $pelaksanaanRapat->ruang_alamat ?? '' }}</td>
                    </tr>

                    <tr>
                        <td style="10%">Waktu Rapat</td>
                        <td>{{ $pelaksanaanRapat->waktu_rapat ?? '' }}</td>
                    </tr>
                </table>

            
                <div style="height:30px"></div>

                <div id="header">
                    <h4 align="center">PESERTA UNDANGAN</h4>
                </div>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <th style="width:60%">Nama</th>
                        <th>Jabatan</th>
                    </tr>

                    @foreach($pesertaUndangan as $d)
                    <tr>
                        <td>{{ $d->nama }}</td>
                        <td>{{ $d->jabatan }}</td>
                    </tr>
                    @endforeach
                </table>

                <div style="height:auto; page-break-before: always"></div>

                <div id="header">
                    <h4 align="center">INFORMASI DEBITUR/CALON DEBITUR</h4>
                </div>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <td><b>Nama Debitur</b></td>
                        <td>{{ $informasiDebitur->nama_bpr ?? '' }}</td>
                        <td>Perseroan Terbatas</td>
                    </tr>

                    <tr>
                        <td><b>Nomor CIF</b></td>
                        <td colspan="2">{{ $informasiDebitur->nomor_cif ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><b>Alamat</b></td>
                        <td colspan="2">{{ $informasiDebitur->alamat_bpr ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><b>Debitur Sejak</b></td>
                        <td colspan="2">{{ date('Y', strtotime($informasiDebitur->created_at)) ?? '' }}</td>
                    </tr>

                    <tr>
                        <td><b>Unit/Segmen Bisnis</b></td>
                        <td>{{ $informasiDebitur->jenis_usaha ?? '' }}</td>
                        <td>Nama BM/AO/RM : {{ $depHead = \App\User::depHead($data->user_id) ?? ''}}/{{ \App\User::username($data->user_id)->name ?? ''}}</td>
                    </tr>

                    <tr>
                        <td><b>Cabang</b></td>
                        <td>-</td>
                        <td>Nama Div Head : {{ \App\User::divHead($depHead) ?? ''}}</td>
                    </tr>

                    <tr>
                        <td><b>Nomor NAK</b></td>
                        <td>{{ $data->no_nak_long_form ?? '' }}</td>
                        <td>Tanggal : {{ ($data->tanggal_nak == null) ? '' : date('d-m-Y', strtotime($data->tanggal_nak)) }}</td>
                    </tr>

                    <tr>
                        <td><b>Status</b></td>
                        <td colspan="2">{{ $data->jenis_pengajuan ?? ''}}</td>
                    </tr>
                </table>

                <div style="height:10px"></div>

                <label><b>Catatan Lembar Keputusan Kredit</b></label>
               
                <div class="contentt">
                    {!! strip_tags($data->catatan_lkk) ?? '' !!}
                </div>

                <div style="height:auto; page-break-before: always"></div>
                <!-- Fasilitas Kredit -->
                <div id="header">
                    <h4 style="text-align:center;">A. FASILITAS KREDIT</h4>
                </div>

                <table border="1" style="width:100%;  border-collapse: collapse;">
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
                        <td>Plafon (existing)</td>
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
                        <td colspan="3"></td>
                    </tr>

                    <tr>
                        <td colspan="2">USD</td>
                        <td colspan="7"></td>
                    </tr>

                    <tr>
                        <td></td>
                        <td colspan="9">*) angka dalam jutaan rupiah</td>
                    </tr>
                </table>

                <div style="height:10px"></div>

                <p><b>Biaya-biaya</b></p>

                <span style="width:150px; display: inline-block;">Provisi</span>: {{ number_format((float)$data->provisi) ?? '' }}<br/>
                <span style="width:150px; display: inline-block;">Biaya Administrasi </span>: {{ number_format((float)$data->biaya_administrasi) ?? '' }}
                
                <div style="height:auto; page-break-before: always"></div>

                <!-- Agunan Fasilitas Kredit -->
                <div id="header">
                    <h4 style="text-align:center;">B. AGUNAN FASILITAS KREDIT</h4>
                </div>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <th>Jenis Agunan</th>
                        <th>Nilai Pasar</th>
                        <th>Nilai Bank</th>
                        <th>Nilai Pengikat</th>
                    </tr>

                    @forelse($agunan as $a)
                        <tr>
                            <td>{{ $a->jenis_agunan }}</td>
                            <td>Rp. {{ number_format($a->nilai_pasar) }}</td>
                            <td>Rp. {{ number_format($a->nilai_bank) }}</td>
                            <td>{{ $a->nilai_pengikat }}</td>
                        </tr>
                    @empty

                    @endforelse
                </table>

                <div style="height:30px"></div>

                <ul>
                    <li align="justify">
                        Fasilitas {{ $data->jenis_fasilitas_kredit ?? '' }} ({{ $data->jenis_pengajuan ?? '' }})
                        yang diajukan debitur sebesar Rp. {{ number_format($data->plafond) ?? '' }} dengan SCR
                        {{ $data->bunga ?? '' }} % berdasarkan RAC BJI PT.
                        {{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr ?? '' }}
                        termasuk dalam tier 1
                    </li>

                    <li align="justify">
                        Piutang yang dijadikan jaminan ke BJI adalah piutang kepada PNS atau ASN aktif dan atau pensiunan
                        dengan sumber pembiayaan dari gaji dan atau uang pensiunan
                    </li>

                    <li align="justify">
                        Jaminan yang dapat dijaminkan harus dalam kondisi lancar dan tidak sedang dalam keadaan dijaminkan atau dijadikan jaminan kepada pihak lain
                    </li>
                </ul>

                <div style="height:auto; page-break-before: always"></div>
                <!-- Syarat dan kondisi penyediaan fasilitas kredit -->
                <div id="header">
                    <h4 style="text-align:center">C. SYARAT DAN KONDISI PENYEDIAAN FASILITAS KREDIT</h4>
                </div>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <td colspan="5" style="text-align:center"><b>Condition</b></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align:center"><b><i>Sebelum Aktivitasi Kredit/Setting Plafon/Perpanjangan Fasilitas Kredit</i></b></td>
                    </tr>
                </table>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Dokumen/Data/Pencapaian/Proses tertentu yang wajib dipenuhi debitur</th>
                        <th>Pelaksana</th>
                        <th>Sifat/Frekuensi/Target Waktu</th>
                        <th>Keterangan</th>
                    </tr>
 
                    @foreach($syarat->where('sub_bagian', 'Sebelum Aktivitasi Kredit/Setting Plafond/Perpanjangan Fasilitas Kredit') as $d)
                        <tr>
                            <td style="width:5%">{{ $d->no_urut }}</td>
                            <td><textarea class="form-control" rows="10" readonly >{{ (strpos(strip_tags($d->pertanyaan), 'PT BPR Nasabah')) ? str_replace('PT BPR Nasabah', $nama_bpr, strip_tags($d->pertanyaan)) : ''  }}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                            <td><textarea class="form-control" rows="10" readonly >{{ $d->keterangan ?? '' }}</textarea></td>
                        </tr>
                    @endforeach
                </table>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <td colspan="5" style="text-align:center"><b>Condition</b></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align:center"><b><i>Prasyarat (setiap) Penarikan/Pencairan Kredit KAB</i></b></td>
                    </tr>
                </table>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Dokumen/Data/Pencapaian/Proses tertentu yang wajib dipenuhi debitur</th>
                        <th>Pelaksana</th>
                        <th>Sifat/Frekuensi/Target Waktu</th>
                        <th>Keterangan</th>
                    </tr>

                    @foreach($syarat->where('sub_bagian', 'Prasyarat (setiap) Penarikan/Pencairan Kredit KAB') as $d)
                        <tr>
                            <td style="width:5%">{{ $d->no_urut }}</td>
                            <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                            <td><textarea class="form-control" rows="10" readonly >{{ $d->keterangan ?? '' }}</textarea></td>
                        </tr>
                    @endforeach
                </table>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <td colspan="5" style="text-align:center"><b>Covenant</b></td>
                    </tr>

                    <tr>
                        <td colspan="5" style="text-align:center"><b><i>Setelah pencairan kredit (Post Disbursement Credit Monitoring & Maintenance)</i></b></td>
                    </tr>
                </table>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Dokumen/Data/Pencapaian/Proses <br/>tertentu yang wajib dipenuhi debitur</th>
                        <th>Pelaksana</th>
                        <th>Sifat/Frekuensi/Target Waktu</th>
                        <th>Keterangan</th>
                    </tr>

                    @foreach($syarat->where('sub_bagian', 'Setelah pencairan kredit (Post Disbursement Credit Monitoring & Maintenance)') as $d)
                        <tr>
                            <td style="width:5%">{{ $d->no_urut }}</td>
                            <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                            <td><textarea class="form-control" rows="10" readonly >{{ $d->keterangan ?? '' }}</textarea></td>
                        </tr>
                    @endforeach
                </table>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <td colspan="5" style="text-align:center"><b>Others</b></td>
                    </tr>
                </table>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <th style="width:5%">No</th>
                        <th>Dokumen/Data/Pencapaian/Proses <br/>tertentu yang wajib dipenuhi debitur</th>
                        <th>Pelaksana</th>
                        <th>Sifat/Frekuensi/Target Waktu</th>
                        <th>Keterangan</th>
                    </tr>
              
                    @foreach($syarat->where('sub_jenis_pertanyaan', 'Others') as $d)
                        <tr>
                            <td style="width:5%">{{ $d->no_urut }}</td>
                            <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                            <td><textarea rows="10" readonly class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                            <td><textarea class="form-control" rows="10" readonly >{{ $d->keterangan ?? '' }}</textarea></td>
                        </tr>
                    @endforeach
                </table>

                <div style="height:auto; page-break-before: always"></div>
                <!-- Persetujuan khusus dan deviasi -->
                <div id="header">
                    <h4 style="text-align:center;">D. PERSETUJUAN KHUSUS DAN DEVIASI</h4>
                </div>

                <div id="contentt">
                   {!! $persetujuan->keterangan ?? '' !!}
                </div>

                <div style="height:auto; page-break-before: always"></div>
                <!-- Usulan dan persetujuan kredit -->
                <div id="header">
                    <h4 style="text-align:center;">E. USULAN DAN PERSETUJUAN KREDIT</h4>
                </div>

                <table border="1" style="width:100%;  border-collapse: collapse;">
                    <tr>
                        <th>No</th>
                        <th style="width:24%">Usulan Fasilitas Kredit</th>
                        <th style="width:24%">Usulan Bisnis Unit</th>
                        <th style="width:24%">Rekomendasi CCRD</th>
                        <th style="width:24%">Keputusan Komite</th>
                    </tr>

                    <tr>
                        <td>1</td>
                        <td>Jenis Fasilitas Kredit</td>
                        <td style="text-align:right">{{ $data->jenis_fasilitas_kredit ?? '' }}</td>
                        <td style="text-align:right">{{ $crrd->jenis_fasilitas_kredit ?? '' }}</td>
                        <td style="text-align:right">{{ $komite->jenis_fasilitas_kredit ?? '' }}</td>
                    </tr>

                    <tr>
                        <td>2</td>
                        <td>Limit Fasilitas Kredit</td>
                        <td style="text-align:right">Rp. {{ number_format($data->limit_fasilitas_kredit ?? 0) }}</td>
                        <td style="text-align:right">Rp. {{ number_format($crrd->limit_fasilitas_kredit ?? 0)  }}</td>
                        <td style="text-align:right">Rp. {{ number_format($komite->limit_fasilitas_kredit ?? 0)  }}</td>
                    </tr>

                    <tr>
                        <td>3</td>
                        <td>Sifat Fasilitas Kredit</td>
                        <td style="text-align:right">{{ $data->sifat_fasilitas_kredit ?? '' }}</td>
                        <td style="text-align:right">{{ $crrd->sifat_fasilitas_kredit ?? '' }}</td>
                        <td style="text-align:right">{{ $komite->sifat_fasilitas_kredit ?? '' }}</td>
                    </tr>

                    <tr>
                        <td>4</td>
                        <td>Tujuan Penggunaan</td>
                        <td style="text-align:right">{{ $data->tujuan_penggunaan ?? '' }}</td>
                        <td style="text-align:right">{{ $crrd->tujuan_penggunaan ?? '' }}</td>
                        <td style="text-align:right">{{ $komite->tujuan_penggunaan ?? '' }}</td>
                    </tr>

                    <tr>
                        <td>5</td>
                        <td>Jangka Waktu Fasilitas Kredit</td>
                        <td style="text-align:right">{{ $data->jangka_waktu_fasilitas_kredit ?? '' }} bulan sejak tanggal efektif fasilitas kredit </td>
                        <td style="text-align:right">{{ $crrd->jangka_waktu_fasilitas_kredit ?? '' }} bulan sejak tanggal efektif fasilitas kredit </td>
                        <td style="text-align:right">{{ $komite->jangka_waktu_fasilitas_kredit ?? '' }} bulan sejak tanggal efektif fasilitas kredit </td>
                    </tr>

                    <tr>
                        <td>6</td>
                        <td>Jangka Waktu Penarikan Fasilitas <br/>(Availibilty Period)</td>
                        <td style="text-align:right">Maks {{ $data->jangka_waktu_penarikan_fasilitas_kredit ?? '' }} bulan sejak tanggal efektif fasilitas kredit</td>
                        <td style="text-align:right">Maks {{ $crrd->jangka_waktu_penarikan_fasilitas_kredit ?? '' }} bulan sejak tanggal efektif fasilitas kredit</td>
                        <td style="text-align:right">Maks {{ $komite->jangka_waktu_penarikan_fasilitas_kredit ?? '' }} bulan sejak tanggal efektif fasilitas kredit</td>
                    </tr>

                    <tr>
                        <td>7</td>
                        <td>Jangka Waktu Angsuran</td>
                        <td style="text-align:right">{{ $data->tenor ?? '' }} bulan</td>
                        <td style="text-align:right">{{ $crrd->jangka_waktu_angsuran ?? '' }} bulan</td>
                        <td style="text-align:right">{{ $komite->provisi ?? '' }} %</td>
                    </tr>

                    <tr>
                        <td>8</td>
                        <td>Suku Bunga</td>
                        <td style="text-align:right">{{ $data->bunga ?? '' }} %</td>
                        <td style="text-align:right">{{ $crrd->suku_bunga ?? '' }} %</td>
                        <td style="text-align:right">{{ $komite->provisi ?? '' }} %</td>
                    </tr>

                    <tr>
                        <td>9</td>
                        <td>Provisi</td>
                        <td style="text-align:right">{{ $data->provisi ?? '' }} %</td>
                        <td style="text-align:right">{{ $crrd->provisi ?? '' }} %</td>
                        <td style="text-align:right">{{ $komite->provisi ?? '' }} %</td>
                    </tr>

                    <tr>
                        <td>10</td>
                        <td>Biaya Administrasi</td>
                        <td style="text-align:right">Rp. {{ number_format($data->biaya_administrasi ?? 0) }}</td>
                        <td style="text-align:right">Rp. {{ number_format($crrd->biaya_administrasi ?? 0) }}</td>
                        <td style="text-align:right">Rp. {{ number_format($komite->biaya_administrasi ?? 0) }}</td>
                    </tr>

                    <tr>
                        <td>11</td>
                        <td>Grace Period</td>
                        <td style="text-align:right">{{ $data->grace_period ?? '' }}</td>
                        <td style="text-align:right">{{ $crrd->grace_period ?? '' }}</td>
                        <td style="text-align:right">{{ $komite->grace_period ?? '' }}</td>
                    </tr>

                    <tr>
                        <td>12</td>
                        <td>Lain-lain</td>
                        <td style="text-align:right">Rp. {{ number_format($data->lain_lain ?? 0) }}</td>
                        <td style="text-align:right">Rp. {{ number_format($crrd->lain_lain ?? 0) }}</td>
                        <td style="text-align:right">Rp. {{ number_format($komite->lain_lain ?? 0) }}</td>
                    </tr>

                    <tr>
                        <td></td>
                        <td style="font-size:12px"><b>TOTAL FASILITAS KREDIT</b></td>
                        <td style="text-align:right">Rp. {{ number_format($data->plafond) }}</td>
                        <td style="text-align:right">Rp. {{ number_format($crrd->total_fasilitas_kredit ?? 0) }}</td>
                        <td style="text-align:right">Rp. {{ number_format($komite->total_fasilitas_kredit ?? 0)}}</td>
                    </tr>
                </table>
            </div> 
        </div>
    </div>
</body>