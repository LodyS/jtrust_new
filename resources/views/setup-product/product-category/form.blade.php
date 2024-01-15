@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="modal-title">{{ ($aksi == 'create') ? 'Create' : 'Edit' }} Product Category</h4>
        <div style="height:40px" align="centre"></div>
        <form action="{{ ($aksi == 'Create') ? url('product-category-store') : url('product-category-update') }}" method="POST">@csrf

            <input type="hidden" value="{{ $data->id ?? '' }}" class="form-control" name="id" readonly>

            @include('flash-message')
            <ul>
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
            </ul>

                    @if ($aksi == 'create')
                    <div class="form-group row">
		                <label class="col-md-3">Product ID</label>
			                <div class="col-md-7">
                            <select class="form-control" name="t_product_id">
                                <option value="">Silahkan Pilih</option>
                                @foreach ($produkTipe as $tipe)
                                <option value="{{ $tipe->id}}">{{ $tipe->product_title }}</option>
                                @endforeach
                            </select>
                        </div>
	                </div>
                    @else
                    <div class="form-group row">
		                <label class="col-md-3">Product ID</label>
			                <div class="col-md-7">
                            <select class="form-control" name="t_product_id">
                                <option value="">Silahkan Pilih</option>
                                @foreach ($produkTipe as $tipe)
                                <option value="{{ $tipe->id}}" {{ ($data->t_product_id == $tipe->id)?'selected':''}}>{{ $tipe->product_title }}</option>
                                @endforeach
                            </select>
                        </div>
	                </div>
                    @endif

                    <div class="form-group row">
		                <label class="col-md-3">Code</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" name="code" value="{{ $data->code ?? '' }}" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Title</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" name="title" value="{{ $data->title ?? '' }}"required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Maksimal RPC Persentase</label>
			                <div class="col-md-7">
                            <input type="number" class="form-control" name="maksimal_rpc_persentase" value="{{ $data->maksimal_rpc_persentase ?? '' }}" required>
                        </div>
	                </div>

            <div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
