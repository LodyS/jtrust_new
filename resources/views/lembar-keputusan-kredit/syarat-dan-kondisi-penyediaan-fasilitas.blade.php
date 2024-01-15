<!DOCTYPE html>
@extends('tema.app')
@section('content')


<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="card border-white">
            <div class="card-body">
                <h5 align="center">SYARAT DAN KONDISI PENYEDIAAN FASILITAS KREDIT - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}</h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('menu-lkk')
            </div> 
        </div>

        <div style="height:10px"></div>
        
        <form action="{{ url('store-syarat-dan-kondisi-penyediaan-fasilitas') }}" method="POST">@csrf

            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
            <input type="hidden" name="aksi" value="create">

            <div class="card border-white">
                <div class="card-body">
                    <table class="table table">
                        <tr>
                            <td colspan="5" style="text-align:center"><b>Condition</b></td>
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

                        @foreach($pertanyaan->where('sub_bagian', 'Sebelum Aktivitasi Kredit/Setting Plafond/Perpanjangan Fasilitas Kredit') as $d)
                            <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">

                            <tr>    
                                <td>{{ $d->no_urut }}</td>
                                <td><textarea class="form-control" rows="10" readonly >{{ (strpos(strip_tags($d->pertanyaan), 'PT BPR Nasabah')) ? str_replace('PT BPR Nasabah', $nama_bpr, strip_tags($d->pertanyaan)) : ''  }}</textarea></td>
                                <td><textarea rows="10" name="pelaksana[]" class="form-control"></textarea></td>
                                <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control"></textarea></td>
                                <td><textarea class="form-control" rows="10" name="keterangan[]" ></textarea></td>
                            </tr>
                        @endforeach
                    </table>
                </div> 
            </div>

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                                              
                    <table class="table table-hover">
                        <tr>
                            <td colspan="5" style="text-align:center"><b>Condition</b></td>
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

                        @foreach($pertanyaan->where('sub_bagian', 'Prasyarat (setiap) Penarikan/Pencairan Kredit KAB') as $d)
                            <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                            
                            <tr>                       
                                <td>{{ $d->no_urut }}</td>
                                <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                                <td><textarea rows="10" name="pelaksana[]" class="form-control"></textarea></td>
                                <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control"></textarea></td>
                                <td><textarea class="form-control" rows="10" name="keterangan[]" ></textarea></td>
                            </tr>
                        @endforeach
                    </table>
                </div> 
            </div> 

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                                            
                    <table class="table table-hover">
                        <tr>
                            <td colspan="5" style="text-align:center"><b>Covenant</b></td>
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

                        @foreach($pertanyaan->where('sub_bagian', 'Setelah pencairan kredit (Post Disbursement Credit Monitoring & Maintenance)') as $d)
                            <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                            
                            <tr>                     
                                <td>{{ $d->no_urut }}</td>
                                <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                                <td><textarea rows="10" name="pelaksana[]" class="form-control"></textarea></td>
                                <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control"></textarea></td>
                                <td><textarea class="form-control" rows="10" name="keterangan[]" ></textarea></td>
                            </tr>
                        @endforeach
                    </table>
                </div> 
            </div>

            <div style="height:10px"></div>
            
            <div class="card border-white">
                <div class="card-body">

                    <table class="table table-hover">
                        <tr>
                            <td colspan="5" style="text-align:center"><b>Others</b></td>
                        </tr>

                        <tr>
                            <th>No</th>
                            <th>Dokumen/Data/Pencapaian/Proses <br/>tertentu yang wajib dipenuhi debitur</th>
                            <th>Pelaksana</th>
                            <th>Sifat/Frekuensi/Target Waktu</th>
                            <th>Keterangan</th>
                        </tr>

                        @foreach($pertanyaan->where('sub_jenis_pertanyaan', 'Others') as $d)
                            <input type="hidden" name="pertanyaan_id[]" value="{{ $d->id }}">
                                                    
                            <tr>  
                                <td>{{ $d->no_urut }}</td>
                                <td><textarea class="form-control" rows="10" readonly >{{ strip_tags($d->pertanyaan) }}</textarea></td>
                                <td><textarea rows="10" name="pelaksana[]" class="form-control"></textarea></td>
                                <td><textarea rows="10" name="sifat_frekuensi_target_waktu[]" class="form-control"></textarea></td>
                                <td><textarea class="form-control" rows="10" name="keterangan[]" ></textarea></td>
                            </tr>
                        @endforeach
                    </table>

                    <div style="height:30px"></div>
                                            
                    @if(Auth::user()->divisi == 'Credit Risk Reviewer')
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div>
			</div>
        </div> 
    </div>   
</div>       
@endsection



