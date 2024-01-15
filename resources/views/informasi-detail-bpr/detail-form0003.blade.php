@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

		<div class="card border-white">
			<div class="card-body">
				<h5 align="center">ORGAN PELAKSANA BPR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($id)->nama_bpr) }}</h5>

				<div style="height:30px" ></div>

				@include('flash-message')

				<div>
					<ul>@include('list-menu-edit-bpr')</ul>
				</div>
			</div> 
		</div>

        <div style="height:10px"></div>

		<div class="card border-white">
            <div class="card-body">
				<form action="{{ route('organ-pelaksana-bpr.store') }}" method="post" enctype="multipart/form-data" name="form">@csrf
					<input type="hidden" name="aksi" value="Create">
					<input type="hidden" name="tabel" value="form_003">
					<input type="hidden" name="bagian" value="Organ Pelaksana BPR">
					<input type="hidden" name="sandi_bpr" value="{{ $id }}">

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Nama </label>
								<input type="text" class="form-control" name="nama_organ_pelaksana" required>
							</div>
						</div><!-- Col -->
					
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Alamat </label>
								<textarea class="form-control" rows = "3" name="alamat" required></textarea>
							</div>
						</div><!-- Col -->
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">NIK </label>
								<input type="text" class="form-control" name="nik" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Jabatan Kepatuhan </label>
								<input type="text" class="form-control" name="kepatuhan" required>
							</div>
						</div><!-- Col -->
					</div>

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Jabatan Manajemen Risiko </label>
								<input type="text" class="form-control" name="manajemen_resiko" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Jabatan Audit Intern </label>
								<input type="text" class="form-control" name="audit_intern" required>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Tanggal Mulai Menjabat </label>
								<input type="date" class="form-control" name="tanggal_mulai_menjabat" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">No Surat Pengangkatan </label>
								<input type="text" class="form-control" name="no_surat_pengangkatan" required>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Tanggal Surat Pengangkatan </label>
								<input type="date" class="form-control" name="tanggal_surat_pengangkatan" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">No Surat Penegasan </label>
								<input type="text" class="form-control" name="no_surat_penegasan" required>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Tanggal Surat Penegasan </label>
								<input type="date" class="form-control" name="tanggal_no_surat_penegasan" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Keanggotaan Komite Audit </label>
								<input type="text" class="form-control" name="komite_audit" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Keanggotaan Komite Pemantauan </label>
								<input type="text" class="form-control" name="komite_pemantauan_resiko" required>
							</div>
						</div><!-- Col -->

						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Keanggotaan Komite Renumerasi dan Nominasi </label>
								<input type="text" class="form-control" name="komite_remunerasi_dan_nominasi" required>
							</div>
						</div><!-- Col -->
					</div><!-- Row -->

					

            		<div style="height:10px"></div>

           	 		<button type="submit" class="btn btn-primary submit">Save</button>
				</form>
			</div>
		</div>

		<div style="height:10px"></div>
          
		<div class="card border-white">
            <div class="card-body">
            	<h5 style="text-align:center">DAFTAR ORGAN PELAKSANA</h5>

				<div style="height:30px"></div>

				<table class="table" width="100%" id="table">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Alamat</th>
							<th>NIK</th>
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
<script>
$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});

$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    ajax: "{{ url('organ-pelaksana-bpr', $id) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data: 'nama_organ_pelaksana', name: 'nama'},
        { data: 'alamat', name:'alamat'},
        { data: 'nik', name:'nik'},
        { data: 'action', name: 'action'},
    ],
    order: [[0, 'asc']]
});
</script>
@endpush
