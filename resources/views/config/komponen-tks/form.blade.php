@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>Form Komponen TKS</h4>
        <div style="height:30px" align="centre"></div>
        <form action="{{ (empty($komponen_tk)) ? route('komponen-tks.store') : route('komponen-tks.update', [$komponen_tk->id]) }}" method="POST" name="form">@csrf

            <input type="hidden" value="{{ $komponen_tk->id ?? '' }}" class="form-control" name="id">
            <input type="hidden" value="{{ (empty($komponen_tk)) ? 'Create' : 'Update' }}" name="aksi">
            <input type="hidden" value="komponen_tks" name="tabel">

            @if(!empty($komponen_tk)) @method('PUT') @endif
            @include('flash-message')
            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Komponen</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="komponen" value="{{ $komponen_tk->komponen ?? ''}}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Sub Komponen</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="sub_komponen" value="{{ $komponen_tk->sub_komponen ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Bobot Persentase</label>
			        <div class="col-md-7">
                    <input type="number" class="form-control" name="bobot" min="0" value="{{ $komponen_tk->bobot ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Minimum Ratio</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="minimum_ratio" value="{{ $komponen_tk->minimum_ratio ?? '' }}"  required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Perubahan Ratio</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="perubahan_ratio" value="{{ $komponen_tk->perubahan_ratio ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Nilai Minimum Kredit</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nilai_minimum_kredit" value="{{ $komponen_tk->nilai_minimum_kredit ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Perubahan Nilai Kredit</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="perubahan_nilai_kredit" value="{{ $komponen_tk->perubahan_nilai_kredit ?? '' }}" required>
                </div>
	        </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('komponen-tks') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$("form[name='form']").validate({
    rules: {
        komponen : "required",
        sub_komponen : "required",
        bobot : "required",
        minimum_ratio : "required",
        perubahan_ratio : "required",
        nilai_minimum_kredit : "required",
        perubahan_nilai_kredit : "required",
    },
   
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush
