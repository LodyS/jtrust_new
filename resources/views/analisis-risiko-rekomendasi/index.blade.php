@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
		<div class="card border-white">
            <div class="card-body">
        		<h5 align="center">HEADER - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>
				<div style="height:30px"></div>
			
        		@include('flash-message')
       	 		@include('error-message')

        		@include('menu-arr')
			</div> 
		</div>

		<div style="height:10px"></div>

		<div class="card border-white">
            <div class="card-body">

				<form action="{{ url('store-loan-applicant') }}" method="POST">@csrf
					<input type="hidden" name="id" value="{{ $id ?? '' }}">

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">No NAK Long Form</label>
								<input type="text" class="form-control" name="no_nak_long_form" value="{{ $data->no_nak_long_form }}" readonly>
							</div>
						</div><!-- Col -->

						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">No</label>
								<input type="text" class="form-control" name="no_arr" value="{{ $data->no_arr ?? '' }}">
							</div>
						</div><!-- Col -->

						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Tanggal</label>
								<input type="text" class="form-control" value="{{ ($data->tanggal_nak == null) ? '' : $tanggal }}" readonly>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Perihal</label>
								<input type="text" class="form-control"  value="{{ $jenis_pengajuan }}" readonly>
							</div>
						</div><!-- Col -->

						<div class="col-sm-4">
							<div class="form-group">
								<label class="control-label">Catatan</label>
									<input type="text" class="form-control" value="-" readonly>
								</div>
							</div><!-- Col -->

							<div class="col-sm-4">
								<div class="form-group">
									<label class="control-label">BWMK</label>
									<input type="text" class="form-control" value="{{ App\Models\Bwmk::statusBwmk($bwmk) ?? ''  }}" readonly>
								</div>
							</div><!-- Col -->
						</div>

						<hr/>

						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Divisi Pengusul</label>
									<input type="text" class="form-control" value="{{ $data->divisi_bisnis_pengusul ?? '' }}" readonly>
								</div>
							</div><!-- Col -->

							<div class="col-sm-6">
								<div class="form-group">
									<label class="control-label">Dokumen Lengkap Diterima</label>
									<input type="text" class="form-control" readonly>
								</div>
							</div><!-- Col -->
						</div><!-- Row -->

						@if (Auth::user()->divisi == 'Credit Risk Reviewer' )
							<button type="submit" class="btn btn-primary">Save</button>
						@endif
					</div>
				</form>
			</div> 
		</div>
	</div>
</div>
@endsection
