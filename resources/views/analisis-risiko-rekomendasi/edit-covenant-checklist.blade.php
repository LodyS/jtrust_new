<!DOCTYPE html>
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
        <h4>ARR - COVENANT CHECKLIST - {{ \App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr }} </h4>
        <div style="height:20px"></div>


        <h4 class="modal-title"></h4>
        <div style="height:30px" align="centre"></div>

            @include('flash-message')
            <ul>
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                        </button>
                        This is a danger alert.
                    </div>
                </div>
                @endforeach
            </ul>

            <div>
            @include('menu-arr')
            </div>

            <div style="height:30px"></div>



									<form action="{{ url('store-covenant-checklist') }}" method="POST">@csrf

                                    <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
                                    <input type="hidden" name="aksi" value="edit">

                                    <table class="table table-bordered table-sm">

                                        <tr>
                                            <th>No</th>
                                            <th>Covenant</th>
                                            <th>Kondisi Persyaratan</th>
                                        </tr>

                                        <tr>
                                            <th colspan="4" style="text-align:center;">Kewajiban Kesanggupan Bagi Debitur</th>
                                        </tr>

                                        @php($i =1)
                                        @foreach($data->where('sub_jenis_pertanyaan', 'Kewajiban Kesanggupan Bagi Debitur') as $key=>$d)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td style="font-size: 11px;">{!! $d->pertanyaan !!}
                                                <input type="hidden" name="id[]" value="{{ $d->id }}">

                                                <label>Keterangan Opsional</label>
                                                <textarea class="form-control content" name="keterangan[]" rows="4">{!! $d->keterangan !!}</textarea>
                                            </td>
                                            <td style="font-size: 11px;">

                                            <input type="hidden" name="catatan[]" class="form-control" value="{!! $d->catatan !!}">  {!! $d->catatan !!}
                                            </td>
                                        </tr>
                                        @php($i++)
                                        @endforeach

                                        <tr>
                                            <th colspan="4" style="text-align:center;">Larangan Bagi Debitur (kecuali Mendapat Persetujuan Bank Terlebih Dahulu)</th>
                                        </tr>

                                        @php($i =1)
                                        @foreach($data->where('sub_jenis_pertanyaan', 'Larangan Bagi Debitur (kecuali Mendapat Persetujuan Bank Terlebih Dahulu)') as $key=>$d)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td style="font-size: 11px;">{!! $d->pertanyaan !!}
                                                <input type="hidden" name="id[]" value="{{ $d->id }}">
                                                <label>Keterangan Opsional</label>
                                                <textarea class="form-control content" name="keterangan[]" rows="4">{{ $d->keterangan}}</textarea>
                                            </td>
                                            <td style="font-size: 11px;">

                                            <input type="hidden" name="catatan[]" class="form-control" value="{!! $d->catatan !!}">  {!! $d->catatan !!}
                                            </td>
                                        </tr>
                                        @php($i++)
                                        @endforeach
                                    </table>

                                    <table class="table table-bordered table-sm">
                                        <tr>
                                            <th colspan="4" style="text-align:center;">Covenant Tambahan (opsional) - Pre Disbursement/ Syarat Pembukuan/ Pencairan</td>
                                        </tr>

                                        <tr>
                                            <td>No</td>
                                            <td>Dokumen/Data/Pencapaian/Proses Tertentu<br/>yang wajib dipenuhi Debitur</td>
                                            <td>Sifat/Frekuensi</td>
                                            <td>Target Waktu</td>
                                        </tr>

                                        @php($i =1)
                                        @foreach($data->where('sub_jenis_pertanyaan', 'Covenant Tambahan (opsional) - Pre Disbursement/ Syarat Pembukuan/ Pencairan') as $d)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                            <input type="hidden" name="id[]" value="{{ $d->id }}">
                                            <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}"></td>
                                            <td style="font-size: 11px;"><input type="hidden" name="catatan[]" class="form-control" value="{!! $d->catatan !!}">  {!! $d->catatan !!}</td>
                                        </tr>
                                        @php($i++)
                                        @endforeach

                                        <tr>
                                            <th colspan="4" style="text-align:center;">Prasyarat (setiap) Penarikan/Pencairan Kredit KAB</td>
                                        </tr>

                                        @php($i =1)
                                        @foreach($data->where('sub_jenis_pertanyaan', 'Prasyarat (setiap) Penarikan/Pencairan Kredit KAB') as $d)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                            <input type="hidden" name="id[]" value="{{ $d->id }}">
                                            <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}"></td>
                                            <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" value="{!! $d->catatan !!}"></td>
                                        </tr>
                                        @php($i++)
                                        @endforeach

                                        <tr>
                                            <th colspan="4" style="text-align:center;">Covenant Tambahan (opsional) - Post Disbursement</td>
                                        </tr>

                                        @php($i =1)
                                        @foreach($data->where('sub_jenis_pertanyaan', 'Covenant Tambahan (opsional) - Post Disbursement') as $d)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                            <input type="hidden" name="id[]" value="{{ $d->id }}">
                                            <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}"></td>
                                            <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" value="{!! $d->catatan !!}"></td>
                                        </tr>
                                        @php($i++)
                                        @endforeach

                                        <tr>
                                            <th colspan="4" style="text-align:center;">Others</td>
                                        </tr>

                                        @php($i =1)
                                        @foreach($data->where('sub_jenis_pertanyaan', 'Others') as $d)
                                        <tr>
                                            <td>{{ $i }}</td>
                                            <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                            <input type="hidden" name="id[]" value="{{ $d->id }}">
                                            <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" value="{{ $d->keterangan }}"></td>
                                            <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" value="{!! $d->catatan !!}"></td>
                                        </tr>
                                        @php($i++)
                                        @endforeach
                                    </table>


                                    <div style="height:20px"></div>
                                    @if (Auth::user()->divisi == 'Credit Risk Reviewer' && $statusLevelProses == null)
                                    <div>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                    @endif
							    </div>

</html>
@endsection
