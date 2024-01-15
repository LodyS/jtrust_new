<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">COVENANT CHECKLIST - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }} </h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')
        		@include('menu-arr')
			</div> 
		</div>

        <div style="height:10px"></div> 

		<form action="{{ url('store-covenant-checklist') }}" method="POST">@csrf

            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
            <input type="hidden" name="aksi" value="create">

            <div class="card border-white">
                <div class="card-body">
                    <table class="table table table-sm">
                        <tr>
                            <th>No</th>
                            <th>Covenant</th>
                            <th>Kondisi Persyaratan</th>
                        </tr>

                        <tr>
                            <th colspan="4" style="text-align:center;">Kewajiban Kesanggupan Bagi Debitur</th>
                        </tr>

                        @php($i =1)
                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Kewajiban Kesanggupan Bagi Debitur') as $key=>$d)
                            <tr>
                                <td>{{ $i }}</td>
                                <td style="font-size: 11px;">{!! $d->pertanyaan !!}
                                    <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">

                                    <label>Keterangan Opsional</label>
                                    <textarea class="form-control content" name="keterangan[]" rows="4"></textarea>
                                </td>
                                <td style="font-size: 11px;">
                                    <input type="hidden" name="catatan[]" value="{{ $d->keterangan }}">
                                    {!! $d->keterangan !!}
                                </td>
                            </tr>
                        @php($i++)
                        @endforeach

                        <tr>
                            <th colspan="4" style="text-align:center;">Larangan Bagi Debitur (kecuali Mendapat Persetujuan Bank Terlebih Dahulu)</th>
                        </tr>

                        @php($i =1)
                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Larangan Bagi Debitur (kecuali Mendapat Persetujuan Bank Terlebih Dahulu)') as $key=>$d)
                            <tr>
                                <td>{{ $i }}</td>
                                <td style="font-size: 11px;">{!! $d->pertanyaan !!}
                                    <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                                    <label>Keterangan Opsional</label>
                                    <textarea class="form-control content" name="keterangan[]" rows="4"></textarea>
                                </td>
                                <td style="font-size: 11px;">
                                    <input type="hidden" name="catatan[]" value="{{ $d->keterangan }}">
                                    {!! $d->keterangan !!}
                                </td>
                            </tr>
                        @php($i++)
                        @endforeach
                    </table>
                </div> 
            </div>

            <div style="height:10px"></div> 

            <div class="card border-white">
                <div class="card-body">

                    <table class="table table table-sm">
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
                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Covenant Tambahan (opsional) - Pre Disbursement/ Syarat Pembukuan/ Pencairan') as $d)
                            <tr>
                                <td>{{ $i }}</td>
                                <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                    <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                                <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" ></td>
                                <td style="font-size: 11px;"><input type="hidden" name="catatan[]" value="{{ $d->keterangan }}">{!! $d->keterangan !!}</td>
                            </tr>
                        @php($i++)
                        @endforeach

                        <tr>
                            <th colspan="4" style="text-align:center;">Prasyarat (setiap) Penarikan/Pencairan Kredit KAB</td>
                        </tr>

                        @php($i =1)
                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Prasyarat (setiap) Penarikan/Pencairan Kredit KAB') as $d)
                            <tr>
                                <td>{{ $i }}</td>
                                <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                    <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                                <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" ></td>
                                <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" ></td>
                            </tr>
                        @php($i++)
                        @endforeach

                        <tr>
                            <th colspan="4" style="text-align:center;">Covenant Tambahan (opsional) - Post Disbursement</td>
                        </tr>

                        @php($i =1)
                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Covenant Tambahan (opsional) - Post Disbursement') as $d)
                            <tr>
                                <td>{{ $i }}</td>
                                    <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                    <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                                <td style="font-size: 11px;"><input type="text" name="keterangan[]"class="form-control" ></td>
                                <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" ></td>
                            </tr>
                        @php($i++)
                        @endforeach

                        <tr>
                            <th colspan="4" style="text-align:center;">Others</td>
                        </tr>

                        @php($i =1)
                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Others') as $d)
                            <tr>
                                <td>{{ $i }}</td>
                                <td style="font-size: 11px;">{!! $d->pertanyaan !!}</td>
                                    <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                                <td style="font-size: 11px;"><input type="text" name="keterangan[]" class="form-control" ></td>
                                <td style="font-size: 11px;"><input type="text" name="catatan[]" class="form-control" ></td>
                            </tr>
                        @php($i++)
                        @endforeach
                    </table>

                    <div style="height:30px"></div>

                    @if (Auth::user()->divisi == 'Credit Risk Reviewer' && $statusLevelProses == null)
                        <div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    @endif

					</div>
				</div>
            </div>
        </form>
    </div>
</div>
@endsection
