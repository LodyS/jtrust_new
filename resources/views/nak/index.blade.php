@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        @include('flash-message')
        @include('error-message')

        <div class="card border-white">
			<div class="card-body">
                
                <h5 style="text-align:center">HEADER NAK - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>
                <div style="height:30px"></div>
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">

                <form action="{{ route('update-main-page') }}" method="POST">@csrf
                <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
                <input type="hidden" name="uuid" value="{{ $data->uuid ?? '' }}">
                <input type="hidden" name="header" value="Yes">
                <input type="hidden" name="tabel" value="loan_applicants">
                <input type="hidden" name="aksi" value="Update">
                <input type="hidden" name="bagian" value="Nak">

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">No NAK Long Form</label>
                            <input type="text" class="form-control" name="no_nak_long_form" value="{{ $data->no_nak_long_form ?? '' }}">
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Jenis Pengajuan</label>
                            <input type="text" class="form-control"  value="{{ $data->jenis_pengajuan }}" readonly>                        
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal_nak" value="{{ $data->tanggal_nak ?? ''}}">
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="control-label">BWMK</label>
                                <select class="form-control" name="bwmk">
                                <option value="">Pilih</option>
                                <option value="A1" {{ ($data->bwmk == 'A1') ? 'selected' : '' }}>A1</option>
                                <option value="A2" {{ ($data->bwmk == 'A2') ? 'selected' : '' }}>A2</option>
                                <option value="A3" {{ ($data->bwmk == 'A3') ? 'selected' : '' }}>A3</option>
                            </select>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Jenis Fasilitas Kredit</label>
                            <input type="text" class="form-control"  value="{{ $data->jenis_fasilitas_kredit }}" readonly>
                        </div><!-- Col -->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Divisi Pengusul</label>
                            <input type="text" class="form-control" name="divisi_bisnis_pengusul" value="{{ $data->divisi_bisnis_pengusul ?? '' }}">
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Departemen Head</label>
                            <input type="text" class="form-control" value="{{ $departemenHead->name ?? '' }}" readonly>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Kode BUC</label>
                            <input type="text" class="form-control" name="kode_buc" value="{{ $data->kode_buc ?? '' }}">
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Relationship Manager</label>
                            <input type="text" class="form-control" value="{{  $relationshipManager->name ?? ''}}" readonly>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Division Head</label>
                            <input type="text" class="form-control" value="{{ $divisionHead->name ?? '' }}" readonly>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-4">
                        <div class="form-group">
                            <label class="control-label">Kode RM/AO/BM</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->kode_rm ?? '' }}" readonly>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div style="height:20px"></div>

                @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
                <button type="submit" class="btn btn-primary">Save</button>
                @endif
            </form>
        </div> 
    </div>
</div>

@endsection
