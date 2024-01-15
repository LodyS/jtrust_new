@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        @include('flash-message')
        @include('error-message')

		<div class="card border-white">
			<div class="card-body">
				<h5 style="text-align:center">PERMOHONAN DEBITUR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>
				<div style="height:30px" ></div>
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

		<div class="card border-white">
			<div class="card-body">
				<form action="{{ url('update-permohonan-debitur') }}" method="POST">@csrf
					<input type="hidden" name="id" value="{{ $data->uuid }}">
					<input type="hidden" name="tabel" value="loan_applicants">
					<input type="hidden" name="aksi" value="Update">
					<input type="hidden" name="bagian" value="Nak">

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Nomor Surat</label>
								<input type="text" class="form-control" name="no_surat" value="{{ $data->no_surat ?? '' }}">
							</div>
						</div><!-- Col -->

						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Tanggal Surat</label>
								<input type="date" class="form-control" name="tanggal_surat" value="{{ $data->tanggal_surat }}">
							</div>
						</div><!-- Col -->

						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Tanggal Surat Diterima</label>
								<input type="date" class="form-control" name="tanggal_surat_diterima" value="{{ $data->tanggal_surat_diterima }}">
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Permohonan Debitur</label>
								<textarea class="form-control" name="permohonan_debitur" rows="6">{{ $data->permohonan_debitur ?? '' }}</textarea>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Tujuan Proposal</label>
								<textarea class="form-control" name="tujuan_proposal" rows="6">{{ $data->tujuan_proposal ?? '' }}</textarea>
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
</div>
@endsection
