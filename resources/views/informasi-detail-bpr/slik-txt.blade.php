@extends('tema.app')
@section('content')

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <form action="{{ url('upload-slik-txt') }}" method="POST" enctype="multipart/form-data" name="form">@csrf

            <input type="hidden" name="aksi" value="Create">
            <input type="hidden" name="tabel" value="form_007">
            <input type="hidden" name="id" value="{{ $id }}">
            <input type="hidden" name="bagian" value="Master BPR">

			<div class="card border-white">
				<div class="card-body">
					@include('flash-message')
					@include('error-message')

					<h5 align="center">IMPORT SLIK TXT - {{ \App\Models\InformasiPokokBprPelapor::namaBpr($id)->nama_bpr }}</h5>
					<div style="height:30px"></div>

					<div>
						<ul>@include('list-menu-edit-bpr')</ul>
					</div>

					<div style="height:10px"></div>
				</div> 
			</div>

            <input type="hidden" class="form-control" name="sandi_bpr" value="{{ $id }}" >

			<div class="card border-white">
				<div class="card-body">
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">File <span style="color:red">*</label>
								<input type="file" class="form-control" name="file" id="file" accept=".txt" required>
							</div>
						</div>								
					</div>

					<div style="height:10px"></div>
					<button type="submit" class="btn btn-primary submit">Save </button>
				</div>
			</div> 
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
