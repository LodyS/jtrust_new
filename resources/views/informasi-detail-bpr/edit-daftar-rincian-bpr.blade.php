@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

		<h5 align="center">EDIT DAFTAR RINCIAN KANTOR BPR - {{ $nama_bpr = strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}</h5>
        <form action="{{ route('rincian-kantor-bpr.update', [$data->id]) }}" method="POST" name="form">@csrf

			@method('PUT')

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr }}">
            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="aksi" value="Update">
            <input type="hidden" name="tabel" value="form_004">
            <input type="hidden" name="bagian" value="Rincian Kantor BPR {{ $nama_bpr }}">

           	@include('error-message')

            <div style="height:30px"></div>

            <div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Sandi Kantor</label>
						<input type="text" class="form-control" name="sandi_kantor" value="{{ $data->sandi_kantor ?? '' }}" required>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Nama Kantor</label>
						<input type="text" class="form-control" name="nama_kantor" value="{{ $data->nama_kantor ?? '' }}" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Alamat</label>
						<textarea class="form-control" name="nama_jalan_dan_no" rows ="3" required>{{ $data->nama_jalan_dan_no ?? '' }}</textarea>
					</div>
				</div>
            </div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Desa/Kecamatan</label>
						<input type="text" class="form-control" name="desa_kecamatan" value="{{ $data->desa_kecamatan ?? '' }}" required>
					</div>
				</div>
											
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Kabupaten/Kota</label>
						<input type="text" class="form-control" name="kab_kota" value="{{ $data->kab_kota ?? '' }}" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Kode Pos</label>
						<input type="text" class="form-control" name="kode_pos" value="{{ $data->kode_pos ?? '' }}" required>
					</div>
				</div>
											
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Koordinat Kantor</label>
						<input type="text" class="form-control" name="koordinat_kantor" value="{{ $data->koordinat_kantor ?? '' }}">
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Nama Pimpinan </label>
						<input type="text" class="form-control" name="nama_pimpinan" value="{{ $data->nama_pimpinan ?? '' }}" required>
					</div>
				</div>
				
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">No Telepon </label>
						<input type="text" class="form-control" name="no_telp" value="{{ $data->no_telp ?? '' }}" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jumlah Kantor Kas </label>
						<input type="text" class="form-control" name="jumlah_kantor_kas" value="{{ $data->jumlah_kantor_kas ?? '' }}">
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Status Kepemilikan Gedung </label>
						<input type="text" class="form-control" name="status_kepemilikan_gedung" value="{{ $data->status_kepemilikan_gedung ?? '' }}" required>
					</div>
				</div>
			</div>

            <div style="height:10px"></div>
							
			<button type="submit" class="btn btn-primary submit"> Save  </button>
                               
		</form>
	</div> 
</div>
@endsection

@push('scripts')
<script>

$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});

</script>
@endpush