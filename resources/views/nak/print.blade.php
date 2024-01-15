<link rel="stylesheet" href="{{ url('css/nak-css.css') }}">

<title>NAK - {{ strtoupper($data_informasi_debitur->nama_bpr) ?? '' }}</title>

<div class="ariel">
    <div style="height:30px"></div>

    <div class="card border-white">
        <div class="card-body">
            <table border="1" style="width:100%;  border-collapse: collapse;">
                <tr>
                    <td colspan="3" style="text-align:center; width:70%;"><b>NOTA ANALISA KREDIT (NAK)<br/><i>Long Form</i></b></td>
                    <td rowspan="6" style="width:30%"><img src="{{ asset('logo/jtrust.jpg') }}" width="290px"></td>
                </tr>

                <tr>
                    <td width="70%" colspan="2"><b>No NAK Long Form </b></td>
                    <td width="30%" >{{ $data_header->no_nak_long_form ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2"><b>Perihal</b></td>
                    <td>{{ $data_header->jenis_pengajuan }}</td>
                </tr>

                <tr>
                    <td colspan="2"><b>Tanggal</b></td>
                    <td>{{ ($data_header->tanggal_nak == null)  ? '' : $tanggal  }}</td>
                </tr>

                <tr>
                    <td colspan="2"><b>BWMK</b></td>
                    <td>{{ $data_header->bwmk ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2"><b>Jenis Fasilitas Kredit</b></td>
                    <td> {{ $data_header->jenis_fasilitas_kredit }}</td>
                </tr>
            </table>

            <div style="height:10px"></div>

            <div id="header">
                <h4>A. INFORMASI DEBITUR</h4>
            </div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">

                <tr>
                    <td colspan="2">Nama Debitur/Mitra Kerja Sama</td>
                    <td colspan="8" style="coslpan:2">{{ $data_informasi_debitur->nama_bpr ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Tahun Pendirian Usaha</td>
                    <td colspan="8" >{{ $data_informasi_debitur->tahun_pendirian_usaha ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Nomor dan tanggal NPWP</td>
                    <td colspan="8" >{{ $data_informasi_debitur->npwp ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Nomor CIF</td>
                    <td colspan="4">{{ $data_informasi_debitur->nomor_cif  ?? '651000' }}</td>
                    <td colspan="2">Kol</td>
                    <td colspan="2" style="font-size: 13px;">{{ $data_informasi_debitur->kol_di_bank_jtrust ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Bulan dan tahun CIF</td>
                    <td colspan="4">{{ $data_informasi_debitur->bulan_tahun_cif ?? '' }}</td>
                    <td colspan="2">Kol</td>
                    <td colspan="2">{{ $data_informasi_debitur->kol_di_bank_jtrust ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Bidang Usaha</td>
                    <td colspan="8" >{{ $data_informasi_debitur->bidang_usaha ?? 'BPR' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Bidang/Sektor Ekonomi</td>
                    <td colspan="4">{{ $data_informasi_debitur->bidang_ekonomi ?? 'Perantara Keuangan' }}</td>
                    <td colspan="2">Kode Sektor BI</td>
                    <td colspan="2" >{{ $data_informasi_debitur->kode_sektor_bi ?? 'BPR' }}</td>
                </tr>

                <tr>
                    <td colspan="2" width="40%">Sub Bidang Ekonomi</td>
                    <td colspan="4">{{ $data_informasi_debitur->sub_bidang_ekonomi ?? 'Perantara Moneter (Bank)' }}</td>
                    <td colspan="2">Kode Sektor BI</td>
                    <td colspan="2" >{{ $data_informasi_debitur->kode_sektor_bi ?? '659009' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Jenis Usaha</td>
                    <td colspan="8">{{ $data_informasi_debitur->jenis_usaha ?? '' }}</td>
                </tr>

                <tr>
                    <td rowspan="2">Manajemen Inti (Key Person)</td>
                    <td>Nama</td>
                    <td colspan="8">{{ $data_informasi_debitur->manajemen_inti_nama ?? '' }}</td>
                </tr>

                <tr>
                    <td>Jabatan</td>
                    <td colspan="8">{{ $data_informasi_debitur->manajemen_inti_jabatan ?? '' }}</td>
                </tr>

                <tr>
                    <td rowspan="4"><i>Contact Person</i></td>
                    <td>Nama</td>
                    <td colspan="8" >{{ $data_informasi_debitur->cp_nama ?? '' }}</td>
                </tr>

                <tr>
                    <td>Nomor Telepon/HP</td>
                    <td colspan="8">{{ $data_informasi_debitur->cp_no_telp ?? '' }}</td>
                </tr>

                <tr>
                    <td>Jabatan</td>
                    <td colspan="8">{{ $data_informasi_debitur->cp_jabatan ?? '' }}</td>
                </tr>

                <tr>
                    <td>E-mail</td>
                    <td colspan="8" >{{ $data_informasi_debitur->cp_email ?? '' }}</td>
                </tr>

                <tr>
                    <td>Alamat Kantor</td>
                    <td colspan="9">{{ $data_informasi_debitur->alamat_bpr ?? '' }}</td>
                </tr>

                <tr>
                    <td>Group Usaha/Perusahaan Terkait</td>
                    <td colspan="9">{{ $data_informasi_debitur->group_usaha ?? '' }}</td>
                </tr>
            </table>

            <div style="height:10px"></div>

            <div id="header">
                <h4>Pemegang Saham Dan Susunan Pengurus</h4>
            </div>

            <div id="contentt">
                <p class="arial">{!! $data_informasi_debitur->keterangan ?? '' !!}</p>
            </div>

            <div style="height:auto; page-break-before: always"></div>
       
            <div id="header">
                <h4>LIST PEMEGANG SAHAM</h4>
            </div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th colspan="2">Nama</th>
                    <th colspan="2">Jabatan</th>
                    <th colspan="2">Nominal Kepemilikan (Rp)</th>
                    <th colspan="2">% Kepemilikan</th>
                </tr>

                @foreach($pemegangSaham as $saham)
                    <tr>
                        <td colspan="2" style="width:30%">{{ $saham->nama }}</td>
                        <td colspan="2">{{ $saham->jabatan }}</td>
                        <td colspan="2" style="text-align:right">Rp. {{ number_format($saham->jumlah_nominal) }}</td>
                        <td colspan="2" style="text-align:right">{{ $saham->persentase_kepemilikan }}%</td>
                    </tr>
                @endforeach
            </table>

            <!--<div style="height:auto; page-break-before: always"></div>-->
            <div style="height:10px;"></div>
           
            <div id="header">
                <h4>B. PERMOHONAN DEBITUR</h4>
            </div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th colspan="2">Surat Debitur</th>
                    <th>Permohonan Debitur</th>
                </tr>

                <tr>
                    <td style="width:120px">Nomor Surat</td>
                    <td>{{ $data_header->no_surat ?? '' }}</td>
                    <td>{{ $data_header->permohonan_debitur ?? '' }}</td>
                </tr>

                <tr>
                    <td>Tanggal Surat</td>
                    <td>{{ ($data_header->tanggal_surat == null) ? '' : date('d-m-Y', strtotime($data_header->tanggal_surat)) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td>Tanggal Surat Diterima</td>
                    <td>{{ ($data_header->tanggal_surat_diterima == null) ? '' : date('d-m-Y', strtotime($data_header->tanggal_surat_diterima)) }}</td>
                    <td></td>
                </tr>

                <tr>
                    <td colspan="3" ><b>Tujuan Proposal</b></td>
                </tr>
                    
                <tr>
                    <td colspan="3" height="50">{{ $data_header->tujuan_proposal ?? '' }}</td>
                </tr>
            </table>

            <div style="height:10px;"></div>
            <!-- Fasilitas Debitur -->
            <div id="header">
                <h4>C. FASILITAS DEBITUR</h4>
            </div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th>No</th>
                    <th>Fasilitas</th>
                    <th>Status</th>
                    <th>Kol</th>
                    <th>Suku Bunga</th>
                    <th>CCY*</th>
                    <th colspan="3" style="text-align:center;">Plafon (eq. IDR)</th>
                    <th>O/S (eq. IDR)</th>
                    <th>Jatuh Tempo</th>
                </tr>

                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td style="text-align:center">Sebelum</td>
                    <td style="text-align:center">+/-</td>
                    <td style="text-align:center">Sesudah</td>
                    <td></td>
                    <td></td>
                </tr>

               
                <?php
                $sebelum =0;
                $pemakaian =0;
                $sesudah =0;
                ?>
                @foreach($fasilitas_debitur as $key=>$fd)
                    <tr>
                        <td>{{ ++$key }}</td>
                        <td style="font-size:11px">{{ \App\Models\ProductType::namaProduk($fd->produk_id) ?? '' }}</td>
                        <td style="font-size:11px">{{ $fd->jenis_pengajuan }}</td>
                        <td style="font-size:11px"></td>
                        <td style="font-size:11px">{{ $fd->bunga }} % p.a.eff</td>
                        <td style="font-size:11px">IDR</td>
                        <?php $sebelum_array = ($fd->jenis_pengajuan == 'Existing') ? $fd->plafon_lama :  0 ?>
                        <td style="width:10%; text-align:right; font-size:11px">{{ number_format($sebelum_array) }}</td>
                        <?php $pemakaian_array = ($fd->jenis_pengajuan == 'Existing') ? ($fd->pemakaian/-1) :$fd->plafond ?>
                        <td style="width:15%; text-align:right; font-size:11px">{{ number_format($pemakaian_array) }}</td>
                        <?php $sesudah_array = $sebelum_array + $pemakaian_array; ?>
                        <td style="width:10%; text-align:right; font-size:11px">{{ number_format($sesudah_array) }}</td>
                        <td style="width:10%; text-align:right; font-size:11px">{{ number_format($sesudah_array) }}</td>
                        <td style="font-size:11px">{{ $fd->tenor }} Bulan<br/> Sejak Fasilitas kredit <br/> efektif</td>
                    </tr>
                    <?php
                    $sebelum += $sebelum_array;
                    $pemakaian += $pemakaian_array;
                    $sesudah += $sesudah_array;
                    ?>                            
                @endforeach

                <tr>
                    <td colspan="6"><b>Total</td>
                    <td style="font-size:11px; text-align:right">{{ number_format($sebelum) }}</td>
                    <td style="font-size:11px; text-align:right">{{ number_format($pemakaian) }}</td>
                    <td style="text-align:right; font-size:11px">{{ number_format($sesudah) }}</td>
                    <td style="text-align:right; font-size:11px">{{ number_format($sesudah) }}</td>
                    <td></td>
                </tr>
            </table>

            <div style="height:10px"></div>

            <?php $rowspan = $total_grup_usaha +5; ?>
            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tbody>
                    <tr>
                        <th rowspan="{{ $rowspan }}" style="font-size:12px;">Total Fasilitas<br/> a/n Debitur beserta <br/>Group Usaha<br/> (one obligor concepts)</th>
                        <th style="width:40%">Nama Debitur & Group Usaha</th>
                        <th>Fasilitas</th>
                        <th>Kol</th>
                        <th>Plafond (eq. IDR)</th>
                    </tr>

                    <tr>
                        <td>{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data_header->sandi_bpr)->nama_bpr ?? '' }}</td>
                        <td>{{ \App\Models\ProductType::namaProduk($data_header->produk_id) ?? '' }}</td>
                        <td>{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data_header->sandi_bpr)->kol_di_bank_jtrust }}</td>
                        <td style="text-align:right;">{{ number_format($data_header->plafond) }}</td>
                    </tr>

                    @foreach($grup_usaha as $gu)
                        <tr>
                            <td>{{ $gu->nama_bpr }}</td>
                            <td>{{ $gu->fasilitas ?? '' }}</td>
                            <td style="text-align:right">{{ $gu->kol_di_bank_jtrust }}</td>
                            <td style="text-align:right;">{{ number_format($gu->plafond) }}</td>
                        </tr>
                    @endforeach

                    <tr>
                        <td colspan="3" ><b>Total Plafon Debitur & Group Usaha </b></td>
                        <td style="text-align:right;">{{ number_format($plafond_debitur_grup_usaha ?? 0) }}</td>
                    </tr>

                    <?php $kab = ($data_header->plafond_permohonan_debitur_tambahan_kab == '') ? 0 : $data_header->plafond_permohonan_debitur_tambahan_kab; ?>

                    <tr>
                        <td colspan="3" ><b>Plafon Permohonan Debitur (Tambahan)(KAB)</b></td>
                        <td style="text-align:right;">{{ number_format($kab) }}</td>
                    </tr>

                    <tr>
                        <td colspan="3" ><b>Total Plafond Setelah Tambahan</b></td>
                        <td style="text-align:right;">{{ number_format($data_header->plafond + $plafond_debitur_grup_usaha + $kab) }}</td>
                    </tr>
                </tbody>
            </table>

            <div style="height:10px"></div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th rowspan="3" >Batas Maksimum <br/>Pemberian Kredit (BMPK)</th>
                    <th style="width:30%;" rowspan="2">Keterangan</th>
                    <th style="width:20%;">BMPK</th>
                    <th style="text-align:center" colspan="4">Inhouse Limit</th>
                </tr>

                <tr>
                    <td></td>
                    <td colspan="2" style="text-align:right">%</td>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td >Modal Inti Bank</td>
                    <td style="text-align:right;">Rp. {{ number_format($bmpk->modal_inti_bank ?? 0) }}</td>
                    <td style="text-align:right;" colspan="2">100</td>
                    <td style="text-align:right;" colspan="2">Rp. {{ number_format($bmpk->inhouse_modal_inti_bank ?? 0) }}</td>
                </tr>

                <tr>
                    <td >Posisi {{ date('d', strtotime(optional($bmpk)->tanggal_posisi)) }}-{{ bulan(date('m', strtotime(optional($bmpk)->tanggal_posisi))) ?? '' }}-{{ date('Y', strtotime(optional($bmpk)->tanggal_posisi)) ?? '' }}</td>
                    <td>Debitur Individu (25%)</td>
                    <td style="text-align:right;">Rp. {{ number_format($bmpk->debitur_individu ?? 0) }}</td>
                    <td style="text-align:right;" colspan="2">80</td>
                    <td style="text-align:right;" colspan="2">Rp. {{ number_format($bmpk->inhouse_debitur_individu ?? 0) }}</td>
                </tr>

                <tr>
                    <td ></td>
                    <td>Debitur Group (25%)</td>
                    <td style="text-align:right; ">Rp. {{ number_format($bmpk->debitur_group ?? 0) }}</td>
                    <td style="text-align:right; " colspan="2">80</td>
                    <td style="text-align:right; " colspan="2">Rp. {{ number_format($bmpk->inhouse_debitur_group ?? 0) }}</td>
                </tr>
            </table>

            <div style="height:10px"></div>

            <div id="header">
                <h4>KETERANGAN</h4>
            </div>

            <p class="arial">{!! $data_header->fasilitas_debitur ?? '' !!}</p>

            <!-- Akhir fasilitas debitur -->
            <div style="height:auto; page-break-before: always"></div>
         
            <div id="header">
                <h4>D. Informasi Group Usaha</h4>
            </div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <td><b>NO</b></td>
                    <td><b>Nama Perusahaan</b></td>
                    <td><b>Bidang Usaha</b></td>
                    <td><b>Tahun Pendirian</b></td>
                </tr>

                @foreach($info_grup_usaha as $key=>$d)
                    <tr>
                        <td>{{ ($key++) + 1 }}</td>
                        <td>{{ $d->nama_perusahaan ?? '' }}</td>
                        <td>{{ $d->bidang_usaha ?? '' }}</td>
                        <td>{{ $d->tahun_pendirian ?? '' }}</td>
                    </tr>
                @endforeach
            </table>

            <div style="height:auto; page-break-before: always"></div>
           
            <div id="header">
                <h4>E. FINANACIAL HIGHLIGHT</h4>
            </div>

            <div style="height:30px"></div>
            @if($bulan_berjalan == null)
                Belum ada data Financial highlight
            @else
                <div id="test">
                    <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                        <tr>
                            <th style="text-align:center;">Keterangan</th>
                            <th colspan="{{ isset($fh_berjalan->sub_jenis) ? '4' : '3'}} " style="text-align:center;">Realisasi </th>
                            <th colspan="2" style="text-align:center;">RKAT</th>
                        </tr>

                        <tr>
                            <td></td>

                            @if(isset($fh_berjalan->sub_jenis))
                                <td style="text-align:center;"><b>{{ tanggalAkhirBulan($fh_berjalan->bulan) }} {{ bulan($fh_berjalan->bulan) }} <br/>{{ $fh_berjalan->tahun ?? '' }}</b></td>
                            @endif

                            <td style="text-align:center;"><b>31 Desember {{ $tahun_ini  }}</b></td>
                            <td style="text-align:center;"><b>31 Desember {{ ($tahun_ini == null) ? '' : $tahun_ini - 1}}</b></td>
                            <td style="text-align:center;"><b>31 Desember {{ ($tahun_ini == null) ? '' : $tahun_ini - 2}}</b></td>
                            <td style="text-align:center;"><b>31 Desember {{ $tahun_max_rkat ?? '' }}</b></td>
                            <td style="text-align:center;"><b>31 Desember {{ $tahun_rkat_sebelumnya ?? '' }}</b></td>
                        </tr>

                        <tr>
                            <td></td>
                            @if(isset($fh_berjalan->sub_jenis))
                                <td style="text-align:center;"><b>OJK PUBLIKASI</b></td>
                            @endif
                            <td style="text-align:center;"><b>AUDIT</b></td>
                            <td style="text-align:center;"><b>AUDIT</b></td>
                            <td style="text-align:center;"><b>AUDIT<b></td>
                            <td style="text-align:center;"><b>DISAMPAIKAN KE OJK</b></td>
                            <td style="text-align:center;"><b>DISAMPAIKAN KE OJK</b></td>
                        </tr>

                        @foreach($dataa as $key=>$d)
                        <tr>
                            @if($d->keterangan == 'EBITDA (Earning Before Interest & Tax, Depreciation & Amortisation)')
                                <td>EBITDA <br/>(Earning Before Interest & Tax, Depreciation & Amortisation)</td>
                            @else
                                <td>{{ $d->keterangan }}</td>
                            @endif

                            @if(isset($fh_berjalan->sub_jenis))
                                <td style="text-align:right;">{{ $nominal['ojk_publikasi'][$key]->nominal ?? ''}}</td>
                            @endif

                            <td style="text-align:right;">{{ $nominal['audit_satu'][$key]->nominal ?? '' }}</td>
                            <td style="text-align:right;">{{ $nominal['audit_dua'][$key]->nominal ?? ''}}</td>
                            <td style="text-align:right;">{{ $nominal['audit_tiga'][$key]->nominal ?? ''}}</td>
                            <td style="text-align:right;">{{ $nominal['rkat'][$key]->nominal ?? ''}}</td>
                            <td style="text-align:right;">{{ $nominal['rkat_tahun_depan'][$key]->nominal ?? '' }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div>
            @endif

            <p class="arial">{!! $data_header->financial_highlight !!}</p>

            <div style="height:auto; page-break-before: always"></div>

            <div id="header">
                <h4>Berikut Ini Adalah Ikhtisar Laporan Keuangan <i>Audited, Inhouse</i> dan RKAT:</h4>
            </div>

            <div style="height:30px"></div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th >Periode</th>
                    <th colspan="1">KAP</th>
                    <th colspan="1">Registered</th>
                    <th colspan="1">Auditor</th>
                    <th >Opinion</th>
                </tr>

                @forelse($ikhtisarLaporanKeuangan as $d)
                    <tr>
                        <td>{{ $d->periode }}</td>
                        <td colspan="1">{{ $d->kap }}</td>
                        <td colspan="1">{{ $d->registered }}</td>
                        <td colspan="1">{{ $d->auditor }}</td>
                        <td>{{ $d->opinion }}</td>
                    </tr>
                @empty

                @endforelse
            </table>

            <div style="height:auto; page-break-before: always"></div>
           
            <div id="header">
                <h4>F. KONDISI KEUANGAN DEBITUR</h4>
            </div>
      
            <p class="arial">{!! $kondisiKeuanganDebitur->keterangan ?? '' !!}</p>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th>No</th>
                    <th>Nama Lembaga Keuangan</th>
                    <th>Jenis Kredit</th>
                    <th>Plafond</th>
                    <th>Baki Debet</th>
                    <th>Periode</th>
                    <th>Suku Bunga (%)</th>
                    <th>Jaminan</th>
                </tr>

                @forelse($daftarPinjamanYangDiterima as $key=>$d)
                    <tr>
                        <td>{{ ++$key}}</td>
                        <td>{{ $d->nama_lembaga_keuangan }}</td>
                        <td>{{ $d->jenis }}</td>
                        <td style="text-align:right">{{ ($d->plafon == 'Data Kosong') ? 'Data Kosong' : number_format($d->plafon) }}</td>
                        <td style="text-align:right">{{ ($d->baki_debet == 'Data Kosong') ? 'Data Kosong' : number_format((float)$d->baki_debet_neto) }}</td>
                        <td>{{ date('d-m-Y', strtotime($d->tanggal_mulai)) }} / {{ date('d-m-Y', strtotime($d->tanggal_jatuh_tempo)) }}</td>
                        <td style="text-align:right">{{ $d->suku_bunga_persentase }}</td>
                        <td>{{ $d->jenis_agunan_yang_dijaminkan }}</td>
                    </tr>
                @empty
                    Data slik tidak ada
                @endforelse
            </table>

            <div style="height:auto; page-break-before: always"></div>
            
            <div id="header">
                <h4>G. PROSPEK DAN KINERJA USAHA</h4>
            </div>
            
            <div style="height:30px"></div>
            
            <p class="arial">{!! $prospekDanKinerjaUsaha->keterangan ?? '' !!}</p>
            
            <div style="height:auto; page-break-before: always"></div>
         
            <div id="header">
                <h4>H. KEGIATAN USAHA</h4>
            </div>
            
            <div style="height:30px"></div>
            
            <p class="arial">{!! $kegiatanUsaha->keterangan ?? '' !!}</p>
            
            <div style="height:auto; page-break-before: always"></div>
        
            <div id="header">
                <h4>I. MANAJEMEN PERUSAHAAN</h4>
            </div>

            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th >Nama</th>
                    <th >Jabatan</th>
                    <th >Keterangan</th>
                </tr>

                @forelse($manajemenPerusahaan as $d)
                    <tr>
                        <td>
                            {{ $d->nama }}
                            <div style="height:20px"></div>
                            @if($d->status_foto == 'Y')
                                <img src="{{ url('protected/storage/manajemen_perusahaan/'. $d->foto )}}" width="150" height="150">
                            @else 
                                <img src="{{ url('storage/manajemen-perusahaan/'. $d->foto )}}" width="150" height="150">
                            @endif
                        </td>

                        <td valign="top">{{ $d->jabatan }} </td>
                        <td valign="top">
                            <b>Pendidikan</b>
                            <div style="height:10px"></div>
                            <textarea disabled class="form-control" rows="5" style="border: none">{!! $d->pendidikan !!}</textarea>

                            <div style="height:10px"></div>

                            <b>Pengalaman Kerja</b>
                            <div style="height:10px"></div>
                            <textarea disabled class="form-control" rows="5" style="border: none">{!! $d->pengalaman_kerja !!}</textarea>
                        </td>
                    </tr>
                @empty
               
                @endforelse
            </table>

            <div style="height:auto; page-break-before: always"></div>
        
            <div id="header">
                <h4>J. PEMASARAN</h4>
            </div>
            
            <div style="height:20px"></div> 
            
            <p class="arial">{!! $pemasaran->keterangan ?? '' !!}</p>
            
            <div style="height:auto; page-break-before: always"></div>
            
            <div id="header">
                <h4>K. PERHITUNGAN KEBUTUHAN KREDIT</h4>
            </div>
            
            <div style="height:20px"></div>
            
            <p class="arial">{!! $perhitunganKebutuhanKredit->keterangan ?? '' !!}</p>
            
            <div style="height:auto; page-break-before: always"></div>
          
            <div id="header">
                <h4>L. LEGALITAS</h4>
            </div>
            
            <div style="height:20px"></div>
            
            <p class="arial">{!! $legalitas->keterangan ?? '' !!}</p>
            
            <div style="height:auto; page-break-before: always"></div>
            
            <div id="header">
                <h4>M. RESUME HASIL OBSERVASI</h4>
            </div>
            
            <div style="height:20px"></div> 
            
            <p>{!! $resumeHasilObservasi->keterangan ?? '' !!}</p>

            <div style="30px"></div>
                
            <div style="height:auto; page-break-before: always"></div>
       
            <div id="header">
                <h4>N. AGUNAN</h4>
            </div>
                
            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th >Jenis Agunan</th>
                    <th >Nilai Pasar</th>
                    <th >Nilai Bank</th>
                    <th >Nilai Pengikat</th>
                </tr>

                @forelse($agunan as $a)
                    <tr>
                        <td>{{ $a->jenis_agunan }}</td>
                        <td>Rp. {{ number_format($a->nilai_pasar) }}</td>
                        <td>Rp. {{ number_format($a->nilai_bank) }}</td>
                        <td>{{ $a->nilai_pengikat }}%</td>
                    </tr>
                @empty

                @endforelse
            </table>

            <div style="height:auto; page-break-before: always"></div>

            <div id="header">
                <h4>O. KEPATUHAN</h4>
            </div>
            
            <div style="height:20px"></div> 
            
            <p class="arial">{!! $kepatuhan->keterangan ?? ''!!}</p>
            
            <div style="height:auto; page-break-before: always"></div>
         
            <div id="header">
                <h4>P. DEVIASI</h4>
            </div>

            <div style="height:20px"></div>
            
            <table border="1" style="width:100%; border-style: ridge;  border-collapse: collapse;">
                <tr>
                    <th>Ketentuan</th>
                    <th>Deviasi</th>
                    <th>Pertimbangan dan Mitigasi</th>
                </tr>

                @foreach($deviasi as $key=> $d)
                    <tr>
                        <td>{{ $d->ketentuan }}</td>
                        <td>{{ $d->deviasi }}</td>
                        <td>{{ $d->pertimbangan_dan_mitigasi }}</td>
                    </tr>
                @endforeach
            </table>

            <div style="height:auto; page-break-before: always"></div>
            
            <div id="header">
                <h4>Q. USULAN KREDIT</h4>
            </div>

            <div style="height:20px"></div>
            
            <p  class="arial">{!! $usulanKredit->keterangan ?? '' !!}</p>
            
            <div style="height:auto; page-break-before: always"></div>
        
            <div id="header">
                <h4>R. DISCLAIMER</h4>
            </div>
    
            <p class="arial">
                <ul>
                    <li class="paragraf">
                        Business Unit bertanggung jawab terhadap kebenaran, validasi, dan kekinian data yang digunakan untuk menyusun NAK long form.
                    </li>
                    
                    <li class="paragraf">
                        Masa berlaku NAK long form adalah 90 (Sembilan puluh) hari yang dihitung sejak tanggal NAK disetujui oleh Komite Kredit
                        (setelah approval kredit) sampai dengan tanggal penandatanganan Perjanjian Kredit.
                
                        <ul>
                            <li class="paragraf">
                                Apabila Debitur mengajukan ketentuan dan kondisi yang berbeda,
                                maka NAK harus dilakukan perubahan dan wajib dilakukan kaji ulang oleh Credit Risk Reviewer
                                awal dan diajukan kembali kepada Komite Kredit awal. Kecuali,
                                apabila terdapat perubahan ketentuan dan kondisi yang khusus berkaitan dengan perubahan suku bunga;
                                provisi; biaya admin dan jaminan atas fasilitas kredit maka Business Unit membuat Memo Internal tanpa
                                NAK Short Form tidak melebihi 90 hari dari Perjanjian Kredit.
                                Memo internal merupakan memo persetujuan sirkuler by Garoon sesuai BWMK.
                            </li>

                            <li class="paragraf">
                                Apabila Perjanjian Kredit ditandatangani lebih dari 30 (tiga puluh)
                                hari sampai dengan 90 (sembilan puluh) hari, maka NAK long form wajib dilakukan analisa kembali yang dituangkan
                                ke dalam NAK short form dan wajib dilakukan kaji ulang oleh Credit Risk Reviewer awal dan diajukan kembali
                                kepada Komite Kredit awal dengan melampirkan SLIK checking dan rekening koran posisi terakhir.
                            </li>
                        </ul>
                    </li>

                    <li class="paragraf">
                        Apabila Perjanjian Kredit belum ditandatangani setelah 90 (sembilan puluh) hari,
                        maka NAK long form dianggap sudah tidak berlaku lagi.
                    </li>
                </ul>
            </p>
        </div>
    </div>
</div>