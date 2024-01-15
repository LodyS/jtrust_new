@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
		<div class="card border-white">
			<div class="card-body">
				<h5 style="text-align:center">INFORMASI DEBITUR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($applicant->sandi_bpr)->nama_bpr) }}</h5>

				<div style="height:30px"></div>
				@include('flash-message')
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
								<label class="control-label">Nama Debitur</label>
								<input type="text" class="form-control"  value="{{ $data->nama_bpr ?? '' }}" readonly>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">No Rekening</label>
								<input type="text" class="form-control" value="{{ $data->tanggal_nak_short ?? '' }}" readonly>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Nama Perusahaan <small><i>(Diisi apabila Debitur Percabangan)</i></small></label>
								<input type="text" class="form-control" readonly>
							</div>
						</div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
								<label class="control-label">No KTP <small><i>(Diisi apabila Debitur Perorangan)</i></label>
								<input type="text" class="form-control" readonly>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					<div class="row">
						<div class="col-sm-6">
                            <div class="form-group">
								<label class="control-label">Tahun Pendirian</label>
								<input type="text" class="form-control" value="{{ $data->tahun_pendirian_usaha ?? '' }}" readonly>
							</div>
						</div><!-- Col -->

                        <div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">No NPWP</label>
								<input type="text" class="form-control" value="{{ $data->npwp ?? ''  }}" readonly>
							</div>
						</div><!-- Col -->
                    </div>

                    <div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Menjadi Debitur sejak</label>
								<input type="text" class="form-control" value="{{ date('Y', strtotime($data->created_at)) ?? '' }}" readonly>
							</div>
						</div><!-- Col -->

                        <div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">No CIF</label>
								<input type="text" class="form-control" value="{{ $data->nomor_cif ?? '' }}" readonly>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->
                </form>
			</div>
		</div>
	</div>
</div>
@endsection
