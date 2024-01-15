@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <form action="{{ route('slik.store') }}" method="POST" name="form">@csrf
			
			<input type="hidden" name="aksi" value="Create">
			<input type="hidden" name="tabel" value="form_007">
			<input type="hidden" name="bagian" value="Master BPR">
			
			<div class="card border-white">

				<div style="height:30px"></div>

				<h5 align="center">INPUT SLIK - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}</h5>

				<div class="card-body">
					@include('flash-message')

					<div>@include('list-menu-edit-bpr')</div>
				</div> 
			</div>

        	<div style="height:10px"></div>

			<input type="hidden" class="form-control" name="sandi_bpr" value="{{ $sandi_bpr}}" >

			<div class="card border-white">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Nama Lembaga Keuangan</label>
								<input type="text" class="form-control" name="nama_lembaga_keuangan" id="nama_lembaga_keuangan" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Plafon</label>
								<input type="text" class="form-control nominal" name="plafon" required>
							</div>
						</div><!-- Col -->
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Jenis Fasilitas</label>
								<input type="text" class="form-control" name="jenis" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Baki Debet</label>
								<input type="text" class="form-control nominal" name="baki_debet" required>
							</div>
						</div><!-- Col -->
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Tanggal Pencairan</label>
								<input type="date" class="form-control" name="tanggal_mulai" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Tanggal Jatuh Tempo</label>
								<input type="date" class="form-control" name="tanggal_jatuh_tempo" required>
							</div>
						</div><!-- Col -->
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Suku Bunga</label>
								<input type="text" class="form-control bunga" name="suku_bunga_persentase" required maxlength="5">
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Jangka Waktu</label>
								<input type="text" class="form-control" name="jangka_waktu" required>
							</div>
						</div><!-- Col -->
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Jaminan <span style="color:red">*</label>
								<input type="text" class="form-control" name="jenis_agunan_yang_dijaminkan" required>
							</div>
						</div><!-- Col -->
				
						<div class="col-sm-6">
							<label class="col-md-3">Kol</label>
							<div class="form-group">
								<select class="form-control select" name="kol" required>
									<option value="">Silahkan Pilih</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
									<option value="5">5</option>
								</select>
							</div>
						</div>
					</div>
						
					<div style="height:30px"></div>

					<button type="submit" class="btn btn-primary submit">Save </button>
					<button type="button" class="btn btn-primary submit" style="background-color: red;border-color: red">Cancel</button>
				</div> 
			</div> 
		</form>

		<div style="height:10px"></div>

		<div class="card border-white">
            <div class="card-body">
				<h5 style="text-align:center">DATA SLIK</h5>
				<div style="height:30px"></div>

				<input type="hidden" class="form-control" name="sandi_bpr" value="{{ $sandi_bpr}}" >

				<table class="table" id="table" width="100%">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama Lembaga Keuangan</th>
							<th>Plafon</th>
							<th>Periode</th>
							<th>Jenis Fasilitas</th>
							<th>Baki Debet</th>
							<th>Suku Bunga</th>
							<th>Jaminan</th>
							<th>KOL</th>
							<th>Aksi</th>
						</tr>
					</thead>
				</table>
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

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,)\./g, "").replace(/(?<=\.\d\d)./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

$('.bunga').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{2})+(?!\d))/g, ".");
    });
}));

$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    scrollX: true,
    ajax: "{{ url('slik', $id) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data: 'nama_lembaga_keuangan', name:'nama_lembaga_keuangan'},
        { data: 'plafon', name:'plafon'},
        { data: 'periode', name:'periode'},
        { data: 'jenis', name:'jenis'},
		{ data: 'baki_debet', name:'baki_debet' },
		{ data: 'suku_bunga', name:'suku_bunga' },
		{ data: 'jenis_agunan_yang_dijaminkan', name:'jenis_agunan_yang_dijaminkan' },
		{ data: 'kol', name:'kol' },
        { data: 'action', name: 'action'},

    ],
    order: [[0, 'asc']]
});
</script>
@endpush


<!-- Tambah Kode RM/AO pada table user -->
