@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Form Fasilitas Kredit</h4>

            <div style="height:30px" align="centre"></div>
            <form action="{{ (empty($fasilitasKredit)) ? route('fasilitas-kredit.store') : route('fasilitas-kredit.update', [$fasilitasKredit->id]) }}" method="POST" name="form">@csrf

            <input type="hidden" value="{{ $fasilitasKredit->id ?? '' }}" class="form-control" name="id" readonly>
            <input type="hidden" value="fasilitas_kredit" name="tabel">
            <input type="hidden" value="{{ (empty($fasilitasKredit)) ? 'Create' : 'Update' }}" name="aksi">

            @if(!empty($fasilitasKredit)) @method('PUT') @endif
            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Fasilitas Kredit</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="fasilitas_kredit" id="fasilitas_kredit" value="{{ $fasilitasKredit->fasilitas_kredit ?? '' }}">
                </div>
	        </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection


@push('scripts')
<script type="text/javascript">
$("form[name='form']").validate({
    rules: {
        fasilitas_kredit : "required",
    },
  
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush
