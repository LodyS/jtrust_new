@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="modal-title">Master Data BPR</h4>
        <div style="height:40px" align="centre"></div>

            <form action="{{ url('master-data-bpr-store') }}" name="master_bpr" method="POST">@csrf
            <input type="hidden" name="tabel" value="form_00">
            <input type="hidden" name="aksi" value="Create">
            <input type="hidden" name="bagian" value="Master BPR">

            @include('flash-message')
            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Nama BPR</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nama_bpr" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Sandi BPR</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="sandi_bpr" required>
                </div>
	        </div>

            <div class="form-group row">
                <label class="col-md-3">Informasi Grup Usaha</label>
                    <div class="col-md-7">
                        <select name="informasi_grup_usaha" class="form-control select" required>
                        <option value="">Pilih</option>
                        @foreach($informasi_grup_usaha as $j)
                        <option value="{{ $j->id }}" >{{ $j->nama_perusahaan }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group row">
		        <label class="col-md-3">Alamat BPR</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="alamat_bpr" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Kabupaten/Kota BPR</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="kabupaten_kota_bpr" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">No Telepon</label>
			        <div class="col-md-7">
                    <input type="number" class="form-control" name="no_telepon" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">NPWP</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="npwp" required>
                </div>
	        </div>

            <div style="height:20px"></div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('list-data-bpr') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$('.select').select2({theme: 'bootstrap-5'});

$("form[name='master_bpr']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush
