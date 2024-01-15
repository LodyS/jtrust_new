@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Form Skema Kredit</h4>

            <div style="height:30px" align="centre"></div>
            <form action="{{ (empty($skemaKredit)) ? route('skema-kredit.store') : route('skema-kredit.update', [$skemaKredit->id]) }}" method="POST" name="form">@csrf

            <input type="hidden" value="{{ $skemaKredit->id ?? '' }}" class="form-control" name="id" readonly>
            <input type="hidden" value="skema_kredit" name="tabel">
            <input type="hidden" value="{{ (empty($skemaKredit)) ? 'Create' : 'Update' }}" name="aksi">

            @if(!empty($skemaKredit)) @method('PUT') @endif
            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-1">Nama</label>
			        <div class="col-md-9">
                    <input type="text" class="form-control" name="skema_kredit" value="{{ $skemaKredit->skema_kredit ?? '' }}" required>
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
        skema_kredit : "required",
    },
  
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush
