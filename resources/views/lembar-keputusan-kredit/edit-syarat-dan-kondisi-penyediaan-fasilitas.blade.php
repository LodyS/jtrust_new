<!DOCTYPE html>
@extends('tema.app')
@section('content')

<style>
.v4 { list-style: none outside none; margin:0; padding: 0; text-align: center }
.inline { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>Lembar Keputusan Kredit - Syarat Dan Kondisi Penyediaan Fasilitas Kredit</h4>
        <div style="height:20px"></div>
        <nav class="page-breadcrumb">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ url('list-data-bpr') }}">List Data BPR</a></li>
				<li class="breadcrumb-item"><a href="{{ url('data-applicant')}}">Loan Application</a></li>
			</ol>
		</nav>

        <h4 class="modal-title"></h4>
        <div style="height:30px" align="centre"></div>

            @include('flash-message')


            <div>
            @include('menu-lkk')
            </div>

            <div style="height:30px"></div>

                <div class="row">
					<div class="col-md-12 grid-margin stretch-card">
                        <div class="card">


				            <div class="row">
					            <div class="col-md-12 stretch-card">
					    	        <div class="card">
							            <div class="card-body">

                                        <form action="{{ url('store-syarat-dan-kondisi-penyediaan-fasilitas') }}" method="POST">@csrf

                                            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
                                            <input type="hidden" name="aksi" value="edit">

                                                <table class="table table-hover" >
                                                    <tr>
                                                        <td colspan="5"><b>Condition</b></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="5"><b><i>Sebelum Aktivitasi Kredit/Setting Plafond/Perpanjangan Fasilitas Kredit</i></b></td>
                                                    </tr>

                                                    <tr>
                                                        <th>No</th>
                                                        <th>Dokumen/Data/Pencapaian/Proses <br/>tertentu yang wajib dipenuhi debitur</th>
                                                        <th>Pelaksana</th>
                                                        <th>Sifat/Frekuensi/Target Waktu</th>
                                                        <th>Keterangan</th>
                                                    </tr>

                                                    @foreach($data->where('sub_bagian', 'Sebelum Aktivitasi Kredit/Setting Plafond/Perpanjangan Fasilitas Kredit') as $d)
                                                    <tr>
                                                        <input type="hidden" name="id[]" value="{{ $d->id }}">
                                                        <td>{{ $d->no_urut }}</td>
                                                        <td><textarea class="form-control" rows="10" readonly >{{ (strpos(strip_tags($d->pertanyaan), 'PT BPR Nasabah')) ? str_replace('PT BPR Nasabah', $nama_bpr, strip_tags($d->pertanyaan)) : ''  }}</textarea></td>
                                                        <td><textarea rows="10" name="pelaksana[]" class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                                                        <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                                                        <td><textarea class="form-control" rows="10" name="keterangan[]" >{{ $d->keterangan ?? '' }}</textarea></td>
                                                    </tr>
                                                    @endforeach
                                                </table>

                                                <table class="table table-hover" >
                                                    <tr>
                                                        <td colspan="5"><b>Condition</b></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="5"><b><i>Prasyarat (setiap) Penarikan/Pencairan Kredit KAB</i></b></td>
                                                    </tr>

                                                    <tr>
                                                        <th>No</th>
                                                        <th>Dokumen/Data/Pencapaian/Proses <br/>tertentu yang wajib dipenuhi debitur</th>
                                                        <th>Pelaksana</th>
                                                        <th>Sifat/Frekuensi/Target Waktu</th>
                                                        <th>Keterangan</th>
                                                    </tr>

                                                    @foreach($data->where('sub_bagian', 'Prasyarat (setiap) Penarikan/Pencairan Kredit KAB') as $d)
                                                    <tr>
                                                        <input type="hidden" name="id[]" value="{{ $d->id }}">
                                                        <td>{{ $d->no_urut }}</td>
                                                        <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                                                        <td><textarea rows="10" name="pelaksana[]" class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                                                        <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                                                        <td><textarea class="form-control" rows="10" name="keterangan[]" >{{ $d->keterangan ?? '' }}</textarea></td>
                                                    </tr>
                                                    @endforeach
                                                </table>

                                                <table class="table table-hover" >
                                                    <tr>
                                                        <td colspan="5"><b>Covenant</b></td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="5"><b><i>Setelah pencairan kredit (Post Disbursement Credit Monitoring & Maintenance)</i></b></td>
                                                    </tr>

                                                    <tr>
                                                        <th>No</th>
                                                        <th>Dokumen/Data/Pencapaian/Proses <br/>tertentu yang wajib dipenuhi debitur</th>
                                                        <th>Pelaksana</th>
                                                        <th>Sifat/Frekuensi/Target Waktu</th>
                                                        <th>Keterangan</th>
                                                    </tr>

                                                    @foreach($data->where('sub_bagian', 'Setelah pencairan kredit (Post Disbursement Credit Monitoring & Maintenance)') as $d)
                                                    <tr>
                                                        <input type="hidden" name="id[]" value="{{ $d->id }}">
                                                        <td>{{ $d->no_urut }}</td>
                                                        <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                                                        <td><textarea rows="10" name="pelaksana[]" class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                                                        <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                                                        <td><textarea class="form-control" rows="10" name="keterangan[]" >{{ $d->keterangan ?? '' }}</textarea></td>
                                                    </tr>
                                                    @endforeach
                                                </table>

                                                <table class="table table-hover" >
                                                    <tr>
                                                        <td colspan="5"><b>Others</b></td>
                                                    </tr>

                                                    <tr>
                                                        <th>No</th>
                                                        <th>Dokumen/Data/Pencapaian/Proses <br/>tertentu yang wajib dipenuhi debitur</th>
                                                        <th>Pelaksana</th>
                                                        <th>Sifat/Frekuensi/Target Waktu</th>
                                                        <th>Keterangan</th>
                                                    </tr>

                                                    @foreach($data->where('sub_jenis_pertanyaan', 'Others') as $d)
                                                    <tr>
                                                        <input type="hidden" name="id[]" value="{{ $d->id }}">
                                                        <td>{{ $d->no_urut }}</td>
                                                        <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                                                        <td><textarea rows="10" name="pelaksana[]" class="form-control">{{ $d->pelaksana ?? ''}}</textarea></td>
                                                        <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control">{{ $d->sifat_frekuensi_target_waktu ?? '' }}</textarea></td>
                                                        <td><textarea class="form-control" rows="10" name="keterangan[]" >{{ $d->keterangan ?? '' }}</textarea></td>
                                                    </tr>
                                                    @endforeach
                                                </table>


                                            <div style="height:20px"></div>
                                            @if(Auth::user()->divisi == 'Credit Risk Reviewer')

                                            <button type="submit" class="btn btn-primary">Save</button>
                                            @endif

                                        </div>
							        </div>
						        </div>
					        </div>
				        </div>
			        </div>
                </div>
            </div>
        </div>
    </html>
@endsection



