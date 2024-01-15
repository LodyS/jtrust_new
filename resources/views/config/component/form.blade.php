@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="modal-title">Edit Component</h4>
        <div style="height:40px" align="centre"></div>
        <form action="{{  url('component-update') }}" method="POST">{{ @csrf_field() }}

            <input type="hidden" value="{{ optional($data)->id }}" class="form-control" name="id" readonly>

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

            <div class="form-group row">
		        <label class="col-md-3">Product ID</label>
			        <div class="col-md-7">
                        <select class="form-control" name="product_id">
                            <option value="">Silahkan Pilih</option>
                            @foreach ($produk as $tipe)
                            <option value="{{ $tipe->id}}" {{ ($data->product_id == $tipe->id)?'selected':''}}>{{ $tipe->product_title }}</option>
                            @endforeach
                        </select>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Nama Komponen</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nama_komponen" value="{{optional($data)->nama_komponen}}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Bobot Persentase</label>
			            <div class="col-md-7">
                        <input type="number" class="form-control" name="bobot_persentase" value="{{ optional($data)->bobot_persentase }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Max Score</label>
			            <div class="col-md-7">
                        <input type="number" class="form-control" name="max_score" value="{{ optional($data)->max_score }}" required>
                    </div>
	            </div>

            <div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
