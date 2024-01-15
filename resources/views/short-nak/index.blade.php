@extends('tema.app')
@section('content')

<body>
	<div class="card border-white" style="width: 100rem;">
		<div class="card-body">
       
            @include('flash-message')
			<div class="card border-white">
				<div class="card-body">
					<h5 style="text-align:center">HEADER SHORT NAK - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>

					<div style="height:30px"></div>
            		@include('short-nak')
				</div> 
			</div>
     
            <div style="height:10px"></div>

			<div class="card border-white">
				<div class="card-body">
					<form action="{{ url('update-loan-applicant') }}" method="POST">@csrf
						<input type="hidden" name="id" value="{{ $data->id }}">

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">No NAK Short Form</label>
									<input type="text" class="form-control" name="no_nak_short" value="{{ $data->no_nak_short ?? '' }}">
								</div>
							</div><!-- Col -->

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Tanggal NAK Short</label>
									<input type="date" class="form-control" name="tanggal_nak_short" value="{{ $data->tanggal_nak_short ?? '' }}">
								</div>
							</div><!-- Col -->
						</div><!-- Row -->

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">No Surat Debitur</label>
									<input type="text" class="form-control" name="no_surat_debitur" value="{{ $data->no_surat_debitur ?? '' }}">
								</div>
							</div><!-- Col -->

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Tanggal Surat Debitur</label>
									<input type="date" class="form-control" name="tanggal_surat_debitur" value="{{ $data->tanggal_surat_debitur ?? '' }}">
								</div>
							</div><!-- Col -->
						</div><!-- Row -->

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Jenis Pengajuan</label>
								
									<input type="text" class="form-control" value="{{ $data->jenis_pengajuan }}" readonly>
								
								</div>
							</div><!-- Col -->

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">BWMK</label>
									<input type="text" class="form-control" value="{{ App\Models\Bwmk::statusBwmk($data->baki_debet) ?? ''  }}" readonly>
								</div>
							</div><!-- Col -->
						</div>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Divisi/Cabang Pengusul</label>
									<input type="text" class="form-control" name="divisi_bisnis_pengusul" value="{{ $data->divisi_bisnis_pengusul ?? '' }}">
								</div>
							</div><!-- Col -->

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Kode BUC</label>
									<input type="text" class="form-control" name="kode_buc" value="{{ $data->kode_buc ?? '' }}">
								</div>
							</div><!-- Col -->
						</div><!-- Row -->

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">AO/RM/BM</label>
									<input type="text" class="form-control" value="{{  $relationshipManager->name ?? ''}}" readonly>
								</div>
							</div><!-- Col -->

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Kode RM/AO/BM</label>
									<input type="text" class="form-control" value="{{ $relationshipManager->kode_rm ?? '' }}" readonly>
								</div>
							</div><!-- Col -->
						</div><!-- Row -->

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Departemen Head</label>
									<input type="text" class="form-control" value="{{ $departemenHead->name ?? '' }}" readonly>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Kode Departemen Head</label>
									<input type="text" class="form-control" value="{{ $departemenHead->kode_rm ?? '' }}" readonly>
								</div>
							</div>
						</div><!-- Row -->

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Division Head</label>
									<input type="text" class="form-control" value="{{ $divisionHead->name ?? '' }}" readonly>
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Kode Division Head</label>
									<input type="text" class="form-control" value="{{ $divisionHead->kode_rm ?? '' }}" readonly>
								</div>
							</div>
						</div><!-- Row -->

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Tanggal Kunjungan Terakhir</label>
									<input type="date" class="form-control" name="tanggal_kunjungan_terakhir" value="{{ $data->tanggal_kunjungan_terakhir ?? '' }}" >
								</div>
							</div>

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Tanggal Call Report</label>
									<input type="date" class="form-control" value="{{ $data->tanggal_call_report ?? '' }}" name="tanggal_call_report">
								</div>
							</div>
						</div><!-- Row -->

						<div style="height:10px"></div>
											
						@if (Auth::user()->jabatan_user->kode== 'account_officer')
							<button type="submit" class="btn btn-primary">Save</button>
						@endif
					</form>
				</div> 
			</div>
		</div>
	</div>
</body>
@endsection
