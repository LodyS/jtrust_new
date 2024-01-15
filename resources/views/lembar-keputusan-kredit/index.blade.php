<!DOCTYPE html>

@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">LEMBAR KEPUTUSAN KREDIT - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')
                @include('menu-lkk')
            </div> 
        </div>

        <div style="height:10px"></div>

		<form action="{{ url('lembar-keputusan-kredit-header') }}" method="POST">@csrf
            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">

            <div class="card border-white">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">BWMK</label>
                                <?php $plafond = ($data->pengajuan_induk_id == null) ? $data->plafond : $data->baki_debet ?>
                                <input type="text" class="form-control" value="{{ \App\Models\Bwmk::statusBwmk($plafond) ?? '' }}" readonly>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">No Lembar Keputusan Kredit</label>
                                <input type="text" class="form-control" name="no_lembar_keputusan_kredit" value="{{ $data->no_lembar_keputusan_kredit ?? ''}}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Tanggal Lembar Keputusan Kredit</label>
                                <input type="date" class="form-control" name="tanggal_lkk" value="{{ $data->tanggal_lkk ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Tanggal Rapat</label>
                                <input type="date" class="form-control"  name="tanggal" value="{{ $pelaksanaanRapat->tanggal ?? '' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Ruang Alamat</label>
                                <input type="text" class="form-control" name="ruang_alamat" value="{{ $pelaksanaanRapat->ruang_alamat ?? '' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Waktu Rapat</label>
                                <input type="text" class="form-control" name="waktu_rapat" value="{{ $pelaksanaanRapat->waktu_rapat ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                </div>
            </div>

            <div style="height:30px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table" id="tambah">
                            <tr>
                                <th colspan="3" style="text-align:center">Form Undangan Pelaksanaan Rapat</th>
                            </tr>
                                                    
                            <tr>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button></th>
                            </tr>
                        </table>
                    </div>
                </div> 
            </div>

            <div style="height:30px"></div>
                       
            <div class="card border-white">
                <div class="card-body">
                    <table class="table table">
                        <tr>
                            <td style="text-align:center;" colspan="2"><b>Peserta Pelaksana Rapat</b></td>
                        </tr>

                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                        </tr>

                        @foreach($pesertaUndangan as $d)
                        <tr>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->jabatan }}</td>
                        </tr>
                        @endforeach
                    </table>
                </div> 
            </div>

            <div style="height:30px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <table class="table table">
                        <tr>
                            <td style="text-align:center;" colspan="3"><b>INFORMASI DEBITUR/CALON DEBITUR</b></td>
                        </tr>

                        <tr>
                            <td><b>Nama Debitur</b></td>
                            <td>{{ $informasiDebitur->nama_bpr ?? '' }}</td>
                            <td>Perseroan Terbatas</td>
                        </tr>

                        <tr>
                            <td><b>Nomor CIF</b></td>
                            <td>{{ $informasiDebitur->nomor_cif ?? '' }}</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><b>Alamat</b></td>
                            <td style="font-size:12px">{{ $informasiDebitur->alamat_bpr ?? '' }}</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td><b>Debitur Sejak</b></td>
                            <td>{{ date('Y', strtotime(optional($informasiDebitur)->created_at)) ?? ''  }}</td>
                            <td></td>
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
                            <td>Tanggal : {{ date('d-m-Y', strtotime($data->tanggal_nak)) ?? ''}}</td>
                        </tr>

                        <tr>
                            <td><b>Status</b></td>
                            <td>{{ $jenis_pengajuan }}</td>
                            <td></td>
                        </tr>
                    </table>
                </div> 
            </div>

            <div style="height:30px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <label>Catatan Lembar Keputusan Kredit</label>
                    <textarea class="form-control content" name="catatan_lkk">{{ $data->catatan_lkk ?? '' }}</textarea>
            
                    <div style="height:30px"></div>

                    @if (Auth::user()->divisi == 'Credit Risk Reviewer')
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div> 
            </div>
        </form>
	</div>
</div>
@endsection

@push('scripts')
<script>

var i = 0;

$("#add").on("click", function() {
    var row = $("<tr>");
    var cols = "";

        cols += '<td><input type="text" name="nama[]" class="form-control"></td>';
        cols += '<td><input type="text" name="jabatan[]" class="form-control"></td>';
        cols += '<td style="text-align:right"><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';

        row.append(cols);
        $("#tambah").append(row);
    i++;
});

$("#tambah").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
});

</script>
@endpush
