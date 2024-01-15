<link rel="stylesheet" href="{{ url('css/nak-css.css') }}">

<title>ANALISIS RISIKO REKOMENDASI - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</title>

<div class="ariel">
    
    <table border="1" style="width:100%;  border-collapse: collapse;">
        <tr>
            <td colspan="3" style="text-align:center; width:70%;"><b>ANALISIS RISIKO REKOMENDASI </b></td>
            <td style="width:30%"><img src="{{ url('logo/jtrust.jpg') }}" width="290px"></td>
        </tr>
    </table>

    <div style="height:30px"></div>

    <div id="header">
        <h5 style="text-align:center;"><b>HEADER</b></h5>
    </div>

    <table border="1" style="width:100%;  border-collapse: collapse;">
        <tr>
            <td>No NAK Long Form</td>
            <td>{{ $data->no_nak_long_form ?? '' }}</td>
            <td>No</td>
            <td>{{ $data->no_arr ?? '' }}</td>
        </tr>

        </tr>
            <td>Tanggal</td>
            <td style="width:20%">{{ ($data->tanggal_nak == null) ? '' : $tanggal }}</td>
            <td>Perihal</td>
            <td>{{ $jenis_pengajuan ?? '' }}</td>
        </tr>

        <tr>
            <td>Catatan</td>
            <td>-</td>
            <td>BWMK</td>
            <td>{{ App\Models\Bwmk::statusBwmk($bwmk) ?? ''  }}</td>
        </tr>

        <tr>
            <td>Divisi Pengusul</td>
            <td>{{ $data->divisi_bisnis_pengusul ?? '' }}</td>
            <td>Dokumen Lengkap Diterima</td>
            <td>-</td>
        </tr>
    </table>
          
    <div style="height:30px"></div>
    <!-- Informasi Debitur dan Group -->
                
    <div id="header">
        <h5 style="text-align:center;">A. INFORMASI DEBITUR DAN GROUP</b></h5>
    </div>

    <table border="1" style="width:100%;  border-collapse: collapse;">
        <tr>
            <td>Nama Debitur/Mitra Kerja Sama</td>
            <td>{{ $informasiPokokBprPelapor->nama_bpr ?? '' }}</td>
            <td>Group Usaha</td>
            <td>{{ ($informasiPokokBprPelapor->group_usaha != null) ? 'Ada' : 'Tidak Ada' }}</td>
        </tr>

        <tr>
            <td>Catatan Group Usaha</td>
            <td colspan="3"></td>
        </tr>

        <tr>
            <td>Bidang Usaha</td>
            <td>{{ $informasiPokokBprPelapor->bidang_usaha_group ?? '' }}</td>
            <td>Debitur</td>
            <td>-</td>
        </tr>

        <tr>
            <td>Catatan Debitur</td>
            <td colspan="3">-</td>
        </tr>

        <tr>
            <td>Kolektibilitas Debitur (SLIK)</td>
            <td>{{ $informasiPokokBprPelapor->kol_di_bank_jtrust ?? '' }} - {{ kategoriKolektibilitas($informasiPokokBprPelapor->kol_di_bank_jtrust)}}</td>
            <td>Risk Profile Debitur</td>
            <td>N/A</td>
        </tr>
                    
        <tr>
            <td>Kondisi Khusus</td>
            <td colspan="3">{{ $informasiPokokBprPelapor->kondisi_khusus ?? '' }}</td>
        </tr>
    </table>

    <div style="height:30px"></div>
    <!-- Informasi Fasilitas Kredit dan Group -->
    <div id="header">
        <h5 style="text-align:center;"><b>B. INFORMASI FASILITAS KREDIT DAN GROUP</b></h5>
    </div>

    <table border="1" style="width:100%;  border-collapse: collapse;">
        <tr>
            <th width="20%">Fasilitas</th>
            <th>Plafon Eksiting</th>
            <th>O/S</th>
            <th>Usulan Bisnis  +/- (Total Plafond)</th>
            <th>Rekomendasi CCRD</th>
            <th>Jatuh Tempo</th>
        </tr>

        <tr>
            <td>KAB</td>
            <td>-</td>
            <td>-</td>
            <td></td>
            <td></td>
            <td>{{ $data->tenor ?? '' }} Bulan sejak fasilitas kredit efektif</td>
        </tr>

        <tr>
            <td colspan="1"></td>
            <td>-</td>
            <td>-</td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
    </table>

    <div class="form-group">
        <label>Catatan Tambahan Fasilitas Kredit (Opsional) :</label>
        {!! $data->catatan_tambahan_fasilitas_kredit ?? '' !!}
    </div>

    <div style="height:auto; page-break-before: always"></div>
    <!-- Financial Highlight -->
    <div id="header">
        <h5 style="text-align:center;"><b>C. FINANCIAL HIGHLIGHT</b></h5>
    </div>
                
    <div id="contentt">
        <p>{!! $financialHighlight->keterangan ?? '' !!}</p>
    </div>

    <div style="height:auto; page-break-before: always"></div>
                
    <div id="header">
        <h5 style="text-align:center;"><b>D. KEY RISK ISSUE</b></h5>
    </div>

    <table border="1" style="width:100%;  border-collapse: collapse;">
        <tr>
            <th style="width:5%">No</th>
            <th>Risk Issue</th>
            <th>Answer</th>
        </tr>

        <tr>
            <th colspan="3" style="text-align:center;">Character</th>
        </tr>

        @foreach($keyRiskIssue->where('sub_jenis_pertanyaan', 'Character') as $key=>$d)
            <tr>
                <td style="vertical-align:top">{{ ++$key }}</td>
                <td>Pertanyaan : {!! $d->pertanyaan !!}
                    <label>Risk Mitigation</label>
                    {!! $d->risk_mitigation ?? '' !!}
                </td>
                <td style="vertical-align:top">{{ $d->jawaban }}</td>
            </tr>
        @endforeach

        <tr>
            <th colspan="3" style="text-align:center;">Capital</th>
        </tr>

        @foreach($keyRiskIssue->where('sub_jenis_pertanyaan', 'Capital') as $key=>$d)
            <tr>
                <td style="vertical-align:top">{{ ++$key }}</td>
                <td style="font-size: 11px;">Pertanyaan : {!! $d->pertanyaan !!}
                    <label>Risk Mitigation</label>
                    {!! $d->risk_mitigation ?? '' !!}
                </td>
                <td style="vertical-align:top">{{ $d->jawaban }}</td>
            </tr>
        @endforeach

        <tr>
            <th colspan="3" style="text-align:center;">Capacity</th>
        </tr>

        @foreach($keyRiskIssue->where('sub_jenis_pertanyaan', 'Capacity') as $key=>$d)
            <tr>
                <td style="vertical-align:top">{{ ++$key }}</td>
                <td style="font-size: 11px;">Pertanyaan : {!! $d->pertanyaan !!}
                    <label>Risk Mitigation</label>
                    {!! $d->risk_mitigation ?? '' !!}
                </td>
                <td style="vertical-align:top">{{ $d->jawaban }}</td>
            </tr>
        @endforeach

        <tr>
            <th colspan="3" style="text-align:center;">Collateral</th>
        </tr>

        @foreach($keyRiskIssue->where('sub_jenis_pertanyaan', 'Collateral') as $key=>$d)
            <tr>
                <td style="vertical-align:top">{{ ++$key }}</td>
                <td style="font-size: 11px;">Pertanyaan : {!! $d->pertanyaan !!}
                    <label>Risk Mitigation</label>
                    {!! $d->risk_mitigation ?? '' !!}
                </td>
                <td style="vertical-align:top">{{ $d->jawaban }}</td>
            </tr>
        @endforeach

        <tr>
            <th colspan="3" style="text-align:center;">Condition of Economic</th>
        </tr>

        @foreach($keyRiskIssue->where('sub_jenis_pertanyaan', 'Condition of Economic') as $key=>$d)
            <tr>
                <td style="vertical-align:top">{{ ++$key }}</td>
                <td style="font-size: 11px;">Pertanyaan : {!! $d->pertanyaan !!}
                    <label>Risk Mitigation</label>
                    {!! $d->risk_mitigation ?? '' !!}
                </td>
                <td style="vertical-align:top">
                    {{ $d->jawaban }}
                </td>
            </tr>
        @endforeach
    </table>

    <div style="height:auto; page-break-before: always"></div>
    <!-- Covenent -->
    <div id="header">
        <h5 style="text-align:center;"><b>E. COVENANT CHECK LIST</b></h5>
    </div>

    <table border="1" style="width:100%;  border-collapse: collapse;">
        <tr>
            <th style="width:5%">No</th>
            <th>Covenant</th>
            <th>Kondisi Persyaratan</th>
        </tr>

        <tr>
            <th colspan="4" style="text-align:center;">Kewajiban Kesanggupan Bagi Debitur</th>
        </tr>

        @php($i =1)
        @foreach($covenent->where('sub_jenis_pertanyaan', 'Kewajiban Kesanggupan Bagi Debitur') as $key=>$d)
            <tr>
                <td>{{ $i }}</td>
                <td style="font-size: 11px;">{!! $d->pertanyaan !!}
                    <input type="hidden" name="id[]" value="{{ $d->id }}">
                    <label>Keterangan Opsional</label>
                    <textarea class="form-control content" name="keterangan[]" rows="4" readonly>{!! $d->keterangan !!}</textarea>
                </td>
                <td style="font-size: 11px;">{!! $d->catatan !!}</td>
            </tr>
            @php($i++)
        @endforeach

        <tr>
            <th colspan="4" style="text-align:center;">Larangan Bagi Debitur (kecuali Mendapat Persetujuan Bank Terlebih Dahulu)</th>
        </tr>

        @php($i =1)
        @foreach($covenent->where('sub_jenis_pertanyaan', 'Larangan Bagi Debitur (kecuali Mendapat Persetujuan Bank Terlebih Dahulu)') as $key=>$d)
            <tr>
                <td>{{ $i }}</td>
                <td style="font-size: 11px;">{!! $d->pertanyaan !!}
                    <input type="hidden" name="id[]" value="{{ $d->id }}">
                    <label>Keterangan Opsional</label>
                    <textarea class="form-control content" name="keterangan[]" rows="4">{{ $d->keterangan}}</textarea>
                </td>
                <td style="font-size: 11px;">{!! $d->catatan !!}</td>
            </tr>
            @php($i++)
        @endforeach
    </table>

    <table border="1" style="width:100%;  border-collapse: collapse;">
        <tr>
            <th colspan="4" style="text-align:center;">Covenant Tambahan (opsional) - Pre Disbursement/ Syarat Pembukuan/ Pencairan</td>
        </tr>

        <tr>
            <th style="width:5%">No</th>
            <td>Dokumen/Data/Pencapaian/Proses Tertentu<br/>yang wajib dipenuhi Debitur</td>
            <td>Sifat/Frekuensi</td>
            <td>Target Waktu</td>
        </tr>

        @php($i =1)
        @foreach($covenent->where('sub_jenis_pertanyaan', 'Covenant Tambahan (opsional) - Pre Disbursement/ Syarat Pembukuan/ Pencairan') as $d)
            <tr>
                <td>{{ $i }}</td>
                <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}" readonly></td>
                <td style="font-size: 11px;">  {!! $d->catatan !!}</td>
            </tr>
            @php($i++)
         @endforeach

        <tr>
            <th colspan="4" style="text-align:center;">Prasyarat (setiap) Penarikan/Pencairan Kredit KAB</td>
        </tr>

        @php($i =1)
        @foreach($covenent->where('sub_jenis_pertanyaan', 'Prasyarat (setiap) Penarikan/Pencairan Kredit KAB') as $d)
            <tr>
                <td>{{ $i }}</td>
                <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}" readonly></td>
                <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" value="{!! $d->catatan !!}" readonly></td>
            </tr>
            @php($i++)
        @endforeach

        <tr>
            <th colspan="4" style="text-align:center;">Covenant Tambahan (opsional) - Post Disbursement</td>
        </tr>

        @php($i =1)
        @foreach($covenent->where('sub_jenis_pertanyaan', 'Covenant Tambahan (opsional) - Post Disbursement') as $d)
            <tr>
                <td>{{ $i }}</td>
                <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}" readonly></td>
                <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" value="{!! $d->catatan !!}" readonly></td>
            </tr>
            @php($i++)
        @endforeach

        <tr>
            <th colspan="4" style="text-align:center;">Others</td>
        </tr>

        @php($i =1)
        @foreach($covenent->where('sub_jenis_pertanyaan', 'Others') as $d)
            <tr>
                <td>{{ $i }}</td>
                <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}" readonly></td>
                <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" value="{!! $d->catatan !!}" readonly></td>
            </tr>
            @php($i++)
        @endforeach
    </table>

    <div style="height:auto; page-break-before: always"></div>
    <!-- Catatan penting lainnya -->
    <div id="header">
        <h5 style="text-align:center;"><b>F. CATATAN PENTING LAINNYA</b></h5>
    </div>

    <div id="contentt">
        <p>{!! $catatanPentingLainnya->keterangan ?? '' !!}</p>
    </div>

    <div style="height:auto; page-break-before: always"></div>
                
    <div id="header">
        <h5 style="text-align:center;"><b>G. REKOMENDASI</b></h5>
    </div>

    <div id="contentt">
        {!!$rekomendasi ?? '' !!} 
    </div>
</div>