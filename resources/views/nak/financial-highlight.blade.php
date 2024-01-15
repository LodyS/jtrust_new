<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
      
        @include('flash-message')
        @include('error-message')

        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">FINANCIAL HIGHLIGHT - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }} </h5>
                <div style="height:30px"></div>
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>
   
        <form action="{{ url('update-nak-financial-highlight') }}" method="POST" enctype="multipart/form-data">@csrf
            <div class="card border-white">
                <div class="card-body">

               
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? '' }}">
                    <input type="hidden" name="tabel" value="loan_applications">
                    <input type="hidden" name="aksi" value="Update">
                    <input type="hidden" name="bagian" value="Nak">

                    @if($bulan_berjalan == null)
                        Belum ada data Financial highlight
                    @else
                        <div id="test">
                            <table class="table table-bordered" width="100%" id="table">
                                <tr>
                                    <th style="text-align:center;">Keterangan</th>
                                    <th colspan="{{ isset($fh_berjalan->sub_jenis) ? '4' : '3'}} " style="text-align:center;">Realisasi </th>
                                    <th colspan="2" style="text-align:center;">RKAT</th>
                                </tr>

                                <tr>
                                    <td></td>

                                    @if(isset($fh_berjalan->sub_jenis))
                                        <td style="font-size: 10px; text-align:center;"><b>{{ tanggalAkhirBulan($fh_berjalan->bulan) }} {{ bulan($fh_berjalan->bulan) }} {{ $fh_berjalan->tahun ?? '' }}</b></td>
                                    @endif

                                    <td style="font-size: 10px; text-align:center;"><b>31 Desember {{ $tahun_ini  }}</b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>31 Desember {{ ($tahun_ini == null) ? '' : $tahun_ini - 1}}</b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>31 Desember {{ ($tahun_ini == null) ? '' : $tahun_ini - 2}}</b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>31 Desember {{ $tahun_max_rkat ?? '' }}</b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>31 Desember {{ $tahun_rkat_sebelumnya ?? '' }}</b></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    @if(isset($fh_berjalan->sub_jenis))
                                        <td style="font-size: 10px; text-align:center;"><b>OJK PUBLIKASI</b></td>
                                    @endif
                                    <td style="font-size: 10px; text-align:center;"><b>AUDIT</b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>AUDIT</b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>AUDIT<b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>DISAMPAIKAN KE OJK</b></td>
                                    <td style="font-size: 10px; text-align:center;"><b>DISAMPAIKAN KE OJK</b></td>
                                </tr>

                                @foreach($dataa as $key=>$d)
                                    <tr>
                                        @if($d->keterangan == 'EBITDA (Earning Before Interest & Tax, Depreciation & Amortisation)')
                                            <td style="font-size:10px;">EBITDA <br/>(Earning Before Interest & Tax, Depreciation & Amortisation)</td>
                                        @else
                                            <td style="font-size: 10px;">{{ $d->keterangan }}</td>
                                        @endif

                                        @if(isset($fh_berjalan->sub_jenis))
                                            <td style="text-align:right; font-size: 10px;">{{ $nominal['ojk_publikasi'][$key]->nominal ?? ''}}</td>
                                        @endif

                                        <td style="text-align:right; font-size: 10px;">{{ $nominal['audit_satu'][$key]->nominal ?? '' }}</td>
                                        <td style="text-align:right; font-size: 10px;">{{ $nominal['audit_dua'][$key]->nominal ?? ''}}</td>
                                        <td style="text-align:right; font-size: 10px;">{{ $nominal['audit_tiga'][$key]->nominal ?? ''}}</td>
                                        <td style="text-align:right; font-size: 10px;">{{ $nominal['rkat'][$key]->nominal ?? ''}}</td>
                                        <td style="text-align:right; font-size: 10px;">{{ $nominal['rkat_tahun_depan'][$key]->nominal ?? '' }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                    @endif
                
                    <div style="height:10px"></div>

                    <div class="card border-white">
                        <div class="card-body">
                            <div class="form-group">
                                <textarea class="form-control {{ (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1) ? 'content' : 'read' }}" name="financial_highlight"  rows="6">{{ $data->financial_highlight ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div style="height:10px"></div>

                    @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
                        <div class="card border-white">
                            <div class="card-body">
                                <h5 style="text-align:center">FORM IKHTISAR LAPORAN KEUANGAN</h5>
                                <div style="height:10px"></div>

                                <table class="table table-hover" id="tambah_form">
                                    <tr>
                                        <th>Periode</th>
                                        <th>KAP</th>
                                        <th>Registered</th>
                                        <th>Auditor</th>
                                        <th>Opinion</th>
                                        <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button></th>
                                    </tr>
                                    <tbody></tbody>
                                </table>

                                <div style="height:10px"></div>

                                <button type="submit" class="btn btn-primary">Save</button>                            
                            </div>
                        </div>
                    @endif
                </div>
            </div> 
        </form>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <table class="table table-hover">
                    <tr>
                        <th colspan="5" style="text-align:center">LIST IKHTISAR LAPORAN KEUANGAN</th>
                    </tr>

                    <tr>
                        <th>Periode</th>
                        <th>KAP</th>
                        <th>Registered</th>
                        <th>Auditor</th>
                        <th>Opinion</th>
                    </tr>

                    @forelse($ikhtisarLaporanKeuangan as $d)
                        <tr>
                            <td>{{ $d->periode }}</td>
                            <td>{{ $d->kap }}</td>
                            <td>{{ $d->registered }}</td>
                            <td>{{ $d->auditor }}</td>
                            <td>{{ $d->opinion }}</td>
                        </tr>
                    @empty
                    @endforelse
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>

$("#add").on("click", function() {
    var newRow = $("<tr>");
    var cols = "";

    cols += '<td><input type="text" name="periode[]" class="form-control"></td>';
    cols += '<td><input type="text" name="kap[]" class="form-control"></td>';
    cols += '<td><input type="text" class="form-control" name="registered[]"/></td>';
    cols += '<td><input type="text" class="form-control" name="auditor[]"/></td>';
    cols += '<td><input type="text" class="form-control" name="opinion[]"/></td>';
    cols += '<td><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';
    newRow.append(cols);

    $("#tambah_form").append(newRow);
    i++;
});

$("#tambah_form").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
});

var i = 0;

</script>
@endpush
