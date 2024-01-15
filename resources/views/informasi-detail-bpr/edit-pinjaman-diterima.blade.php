@extends('tema.app')
@section('content')

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

		<h5 align="center">EDIT SLIK - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>
		<div style="height:30px"></div>

        <form action="{{ route('slik.update', [$data->id]) }}" method="POST">@csrf

			@method('PUT')

            <input type="hidden" name="aksi" value="Update">
            <input type="hidden" name="tabel" value="form_007">
            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="bagian" value="SLIK">

            @include('flash-message')
            @include('error-message')

            <div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Nama Lembaga Keuangan</label>
						<input type="text" class="form-control" name="nama_lembaga_keuangan" id="nama_lembaga_keuangan" value="{{ $data->nama_lembaga_keuangan ?? '' }}" required>
					</div>
				</div><!-- Col -->

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Plafon</label>
						<input type="text" class="form-control nominal" name="plafon" required value="{{ number_format($data->plafon) }}">
					</div>
				</div><!-- Col -->
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jenis Fasilitas</label>
						<input type="text" class="form-control" name="jenis" required value="{{ $data->jenis ?? '' }}">
					</div>
				</div><!-- Col -->

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Baki Debet</label>
						<input type="text" class="form-control nominal" name="baki_debet" required value="{{ number_format($data->baki_debet) }}">
					</div>
				</div><!-- Col -->
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Tanggal Pencairan</label>
						<input type="date" class="form-control" name="tanggal_mulai" required value="{{ $data->tanggal_mulai }}">
					</div>
				</div><!-- Col -->

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Tanggal Jatuh Tempo</label>
						<input type="date" class="form-control" name="tanggal_jatuh_tempo" required value="{{ $data->tanggal_jatuh_tempo }}">
					</div>
				</div><!-- Col -->
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Suku Bunga</label>
						<input type="text" class="form-control bunga" name="suku_bunga_persentase" required maxlength="5" value="{{ $data->suku_bunga_persentase ?? '' }}">
					</div>
				</div><!-- Col -->

				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jangka Waktu</label>
						<input type="text" class="form-control" name="jangka_waktu" required value="{{ $data->jangka_waktu ?? '' }}">
					</div>
				</div><!-- Col -->
			</div>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Jaminan <span style="color:red">*</label>
						<input type="text" class="form-control" name="jenis_agunan_yang_dijaminkan" required value="{{ $data->jenis_agunan_yang_dijaminkan ?? '' }}">
					</div>
				</div><!-- Col -->
		
				<div class="col-sm-6">
					<label class="col-md-3">Kol</label>
					<div class="form-group">
						<select class="form-control" name="kol" required>
							<option value="">Silahkan Pilih</option>
							<option value="1" {{ ($data->kol == '1') ? 'selected' : '' }}>1</option>
							<option value="2" {{ ($data->kol == '2') ? 'selected' : '' }}>2</option>
							<option value="3" {{ ($data->kol == '3') ? 'selected' : '' }}>3</option>
							<option value="4" {{ ($data->kol == '4') ? 'selected' : '' }}>4</option>
							<option value="5" {{ ($data->kol == '5') ? 'selected' : '' }}>5</option>
						</select>
					</div>
				</div>
			</div>
				
			<div style="height:20px"></div>

			<button type="submit" class="btn btn-primary submit">Save</button>
		</form>
	</div> 
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.select').select2({  theme: 'bootstrap4'});

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,)\./g, "").replace(/(?<=\.\d\d)./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));
</script>
@endpush

<!-- Tambah Kode RM/AO pada table user -->
