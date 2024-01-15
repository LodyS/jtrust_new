@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">{{ $aksi }} Jabatan</h4>


    <div style="height:40px" align="centre"></div>
        <form action="{{ ($aksi == 'Create') ? route('jabatan.store') : route('jabatan.update', [$data->id]) }}" method="POST">@csrf

            @if($aksi == 'Update')@method('PUT')@endif

            <input type="hidden" value="{{ $data->id ?? '' }}" class="form-control" name="id" readonly>
            <input type="hidden" value="{{ $aksi }}" name="aksi">
            <input type="hidden" value="jabatan" name="tabel">
            @include('flash-message')

            <div class="form-group row">
		        <label class="col-md-3">Nama Jabatan</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nama_jabatan" value="{{ $data->nama_jabatan ?? '' }}" required>
		        </div>
	        </div>

            @if(isset($data))
            <div class="form-group row">
		        <label class="col-sm-3">Member Of Credit Committe</label>
			        <div class="col-md-7">
                    <input type="radio" value="Yes" {{ ($data->member_of_credit_committee=="Yes")? "checked" : "" }} name="member_of_credit_committee" required>
                    <label>Yes</label>

                    <input type="radio" value="No" {{ ($data->member_of_credit_committee=="No")? "checked" : "" }} name="member_of_credit_committee">
                    <label>No</label><br>
                </div>
	        </div>
            @else
            <div class="form-group row">
		        <label class="col-sm-3">Member Of Credit Committe</label>
			        <div class="col-md-7">
                    <input type="radio" value="Yes" name="member_of_credit_committee" required>
                    <label>Yes</label>

                    <input type="radio" value="No" name="member_of_credit_committee">
                    <label>No</label><br>
                </div>
	        </div>
            @endif

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('jabatan') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection
