@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
    <h4 class="modal-title">Form Region Listing</h4>
    <div style="height:40px" align="centre"></div>
        <form action="{{  ($aksi == 'Create') ? route('region.store') : route('region.update', [$data->id]) }}" method="POST">@csrf

            @if($aksi == 'Update')@method('PUT')@endif

            <input type="hidden" value="{{ $data->id ?? '' }}" class="form-control" name="id" >
            <input type="hidden" name="aksi" value="{{ $aksi }}">
            <input type="hidden" name="tabel" value="region_listing">

            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Region Code</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="region_code" value="{{ $data->region_code ?? '' }}">
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Region Title</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="region_title" value="{{ $data->region_title ?? '' }}">
		        </div>
	        </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
