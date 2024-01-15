@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        @include('error-message')
 
		<form action="{{ route('organ-pelaksana-bpr.update', [$data->id]) }}" method="post" enctype="multipart/form-data" name="form">@csrf

			@method('PUT')
            <input type="hidden" name="tabel" value="form_003">
            <input type="hidden" name="aksi" value="Update">
            <input type="hidden" name="bagian" value="Anggota Pelaksana BPE">

            <h5 style="text-align:center">EDIT ANGGOTA ORGAN PELAKSANA - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>

			<div style="height:30px"></div>
                                        
            <input type="hidden" name="id" value="{{ $data->id }}">
                                       
            <div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Nama <span style="color:red">*</span></label>
						<input type="text" class="form-control" name="nama_organ_pelaksana" value="{{ $data->nama_organ_pelaksana ?? '' }}" required>
					</div>
				</div>
		
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Alamat <span style="color:red">*</span></label>
						<textarea class="form-control" rows = "3" name="alamat" required>{{ $data->alamat ?? '' }}</textarea>
					</div>
				</div>
            </div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">NIK<span style="color:red">*</span></label>
						<input type="number" class="form-control" name="nik" value="{{ $data->nik ?? ''}}" required>
					</div>
				</div>
											
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jabatan Kepatuhan</label>
						<input type="text" class="form-control" name="kepatuhan" value="{{ $data->kepatuhan ?? '' }}">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jabatan Manajemen Risiko</label>
						<input type="text" class="form-control" name="manajemen_resiko" value="{{ $data->manajemen_resiko ?? '' }}">
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jabatan Audit Intern</label>
						<input type="text" class="form-control" name="audit_intern" value="{{ $data->audit_intern ?? '' }}">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Tanggal Mulai Menjabat</label>
						<input type="date" class="form-control" name="tanggal_mulai_menjabat" value="{{ $data->tanggal_mulai_menjabat ?? '' }}">
					</div>
				</div>
		
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">No Surat Pengangkatan</label>
						<input type="text" class="form-control" name="no_surat_pengangkatan" value="{{ $data->no_surat_pengangkatan ?? '' }}">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Tanggal Surat Pengangkatan</label>
						<input type="date" class="form-control" name="tanggal_surat_pengangkatan" value="{{ $data->tanggal_surat_pengangkatan ?? '' }}">
					</div>
				</div>
			
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">No Surat Penegasan</label>
						<input type="text" class="form-control" name="no_surat_penegasan" value="{{ $data->no_surat_penegasan ?? '' }}">
					</div>
				</div>
			</div> 

			<div class="row">				
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Tanggal Surat Penegasan</label>
						<input type="date" class="form-control" name="tanggal_no_surat_penegasan" value="{{ $data->tanggal_no_surat_penegasan ?? '' }}">
					</div>
				</div><!-- Col -->
	
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Keanggotaan Komite Audit</label>
						<input type="text" class="form-control" name="komite_audit" value="{{ $data->komite_audit ?? '' }}">
					</div>
				</div>
			</div> 
						
			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Keanggotaan Komite Pemantauan</label>
						<input type="text" class="form-control" name="komite_pemantauan_resiko" value="{{ $data->komite_pemantauan_resiko ?? '' }}">
					</div>
				</div><!-- Col -->
	
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Keanggotaan Komite Renumerasi dan Nominasi</label>
						<input type="text" class="form-control" name="komite_remunerasi_dan_nominasi" value="{{ $data->komite_remunerasi_dan_nominasi ?? '' }}">
					</div>
				</div><!-- Col -->
			</div><!-- Row -->
							
            <div style="height:10px"></div>
			
			<button type="submit" class="btn btn-primary submit">Save</button>                       
		</form>
	</div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush