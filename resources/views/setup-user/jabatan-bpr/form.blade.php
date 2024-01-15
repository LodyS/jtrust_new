@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Form Jabatan BPR</h4>


    <div style="height:40px" align="centre"></div>
        <form action="{{ (empty($jabatanBpr)) ? route('jabatan-bpr.store') : route('jabatan-bpr.update', [$jabatanBpr->id]) }}" method="POST">@csrf

            @if(!empty($jabatanBpr)) @method('PUT') @endif
            <input type="hidden" value="{{ $jabatanBpr->id ?? '' }}" class="form-control" name="id" readonly>
            <input type="hidden" value="{{ empty($jabatanBpr) ? 'Create' : 'Update' }}" name="aksi">
            <input type="hidden" value="jabatan_bpr" name="tabel">

            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Kode</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="kode" value="{{ $jabatanBpr->kode ?? '' }}" required>
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Jabatan</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="jabatan" value="{{ $jabatanBpr->jabatan ?? '' }}" required>
		        </div>
	        </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('jabatan-bpr') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection
