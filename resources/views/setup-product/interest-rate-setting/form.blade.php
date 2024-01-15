@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
    <h4 class="modal-title">{{ ($aksi == 'create') ? 'Create' : 'Edit' }} RAC Setting</h4>
    <div style="height:40px" align="centre"></div>
        <form action="{{ ($aksi == 'create') ? url('interest-rate-setting-save') : url('update-interest-rate-setting') }}" method="POST">{{ @csrf_field() }}


        @include('flash-message')
        @foreach ($errors->all() as $error)

            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                This is a danger alert.
                </div>
            </div>

            @endforeach
            <input type="hidden" value="{{ $data->id ?? '' }}" class="form-control" name="id" readonly>

                <div class="form-group row">
		            <label class="col-md-3">Title</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="title" value="{{ $data->title ?? ''}}">
		            </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Maksimal RPC Persentase</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="maksimal_rpc_persentase" value="{{ $data->maksimal_rpc_persentase ?? '' }}">
		            </div>
	            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>

        </form>
    </div>
</div>
@endsection
