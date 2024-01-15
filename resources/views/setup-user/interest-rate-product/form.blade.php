@extends('theme.app')
@section('content')

<div class="card">
    <div class="card-body">
    <h4 class="modal-title">{{ ($aksi == 'create') ? 'Tambah' : 'Edit' }} Interest Rate Setting</h4>
    <div style="height:40px" align="centre"></div>
        <form action="{{ ($aksi == 'create') ? url('interest-rate-product-simpan') : url('interest-rate-product-update')  }}" method="POST">{{ @csrf_field() }}

        @foreach ($errors->all() as $error)

            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>
                    {{ $error }}
                </div>
            </div>

            @endforeach
            <input type="hidden" value="{{ optional($data)->id }}" class="form-control" name="id" readonly>

            <div class="form-group row">
		        <label class="col-md-3">Produk</label>
			        <div class="col-md-7">
                    <select class="form-control" name="t_credit_type_id">
                        <option value="">Pilih Produk</option>
                        @foreach ($produk as $id =>$p)
                        <option value="{{$id}}" {{ (optional($data)->t_credit_type_id==$id )?'selected':''}}>{{ $p }}</option>
                        @endforeach
                    </select>
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Bulan</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="bulan" value="{{ optional($data)->bulan }}">
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Flat Per Tahun</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="flat_rates" value="{{ optional($data)->flat_rates }}">
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Anuitas Rate</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="anuitas_rates" value="{{ optional($data)->anuitas_rates }}">
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Persentase Biaya Admin</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="admin_fee" value="{{ optional($data)->admin_fee }}">
		        </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Persentase Biaya Asuransi</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="asuransi_fee" value="{{ optional($data)->asuransi_fee }}">
		        </div>
	        </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
