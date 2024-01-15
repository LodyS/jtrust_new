@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

		<h5>PIHAK TERKAIT BPR - {{ $nama_bpr = \App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr }}</h5>

        <form action="{{ route('pihak-terkait-bpr.update', [$data->id]) }}" method="POST" name="form">@csrf

			@method('PUT')

            <input type="hidden" name="aksi" value="Update">
            <input type="hidden" name="tabel" value="form_005">
            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr }}">

            <input type="hidden" name="bagian" value="Pihak Terkait BPR {{ $nama_bpr }}">
            @include('flash-message')

            <div style="height:30px"></div>

            <div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Nama Pihak Terkait</label>
						<input type="text" class="form-control" name="nama_pihak_terkait" value="{{ $data->nama_pihak_terkait ?? '' }}" required>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Hubungan Pihak Terkait</label>
						<input type="text" class="form-control" name="hubungan_pihak_terkait" value="{{ $data->hubungan_pihak_terkait ?? '' }}" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">No Identitas</label>
						<input type="number" class="form-control" name="no_identitas" value="{{ $data->no_identitas ?? '' }}" required>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jenis Pihak Terkait </label>
						<input type="text" class="form-control" name="jenis_pihak_terkait" value="{{ $data->jenis_pihak_terkait ?? '' }}" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12">
					<div class="form-group">
						<label class="control-label">Alamat</label>
						<textarea class="form-control" rows="3" name="alamat_pihak_terkait" required>{{ $data->alamat_pihak_terkait ?? '' }}</textarea>
					</div>
				</div>
            </div>

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

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,)\./g, "").replace(/(?<=\.\d\d)./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));
</script>
@endpush
