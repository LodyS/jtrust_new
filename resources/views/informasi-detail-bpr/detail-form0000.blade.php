@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

		<div class="card border-white">
			<div class="card-body">
				<h5 align="center">INFORMASI POKOK BPR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->uuid)->nama_bpr) }}</h5>

				<div style="height:30px"></div>

				<form action="{{ url('master-data-bpr-update') }}" method="POST" enctype="multipart/form-data">@csrf
				<input type="hidden" name="id" value="{{ $data->id ?? '' }}">
				<input type="hidden" name="uuid" value="{{ $data->uuid ?? '' }}">
				<input type="hidden" name="tabel" value="form_00">
				<input type="hidden" name="aksi" value="Update">
				<input type="hidden" name="bagian" value="Master BPR">

				@include('flash-message')
				@include('error-message')

				<div>
					<ul>@include('list-menu-edit-bpr')</ul>
				</div>
			</div> 
		</div>

		<div style="height:10px"></div>

		<div class="card border-white">
			<div class="card-body">

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Sandi Bank</span></label>
							<input type="text" class="form-control" name="sandi_bpr" value="{{ $data->sandi_bpr ?? '' }}">
						</div>
					</div><!-- Col -->

					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">Nama BPR </label>
							<input type="text" class="form-control" name="nama_bpr" value="{{ $data->nama_bpr ?? '' }}" >
						</div>
					</div><!-- Col -->
				</div><!-- Row -->

				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Alamat</label>
							<textarea class="form-control" rows = "3" name="alamat_bpr" value="{{ $data->alamat_bpr ?? '' }}" >{{ $data->alamat_bpr ?? '' }}</textarea>
						</div>
					</div><!-- Col -->

					<div class="col-sm-12">
						<div class="form-group">
							<label class="control-label">Kabupaten/Kota BPR </label>
							<input type="text" class="form-control" name="kabupaten_kota_bpr" value="{{ $data->kabupaten_kota_bpr ?? '' }}">
						</div>
					</div><!-- Col -->
				</div>

				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">No. Telepon </label>
							<input type="text" class="form-control" name="no_telepon" value="{{ $data->no_telepon ?? '' }}">
						</div>
					</div><!-- Col -->

					<div class="col-sm-6">
						<div class="form-group">
							<label class="control-label">NPWP</label>
							<input type="text" class="form-control" name="npwp" value="{{ $data->npwp ?? '' }}">
						</div>
					</div><!-- Col -->
				</div><!-- Row -->

				<div class="row">
					<div class="col-sm-6">
						<label class="control-label">Informasi Grup Usaha</label>
							<select name="informasi_grup_usaha" class="form-control">
							<option value="">Pilih</option>
							@foreach($informasi_grup_usaha as $j)
							<option value="{{ $j->id }}" {{ (optional($data)->informasi_grup_usaha == $j->id)?'selected':''}}>{{ $j->nama_perusahaan }}</option>
							@endforeach
						</select>
					</div><!-- Col -->

					<div class="col-sm-6">
						<label class="control-label">UPLOAD NPWP</label>
						<input type="file" class="form-control" name="npwp_file" style="width:100%" >
						<input type="text" name="npwp_file_old" class="form-control" value="{{ $data->npwp_file ?? '' }}" readonly>
					</div><!-- Col -->
				</div><!-- Row -->

				<button type="submit" class="btn btn-primary">Save</button>
			</div>
		</div>
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


$('.select').select2({  theme: 'bootstrap4'});

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,)\./g, "").replace(/(?<=\.\d\d)./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));
</script>
@endpush

<!-- Tambah Kode RM/AO pada table user -->
