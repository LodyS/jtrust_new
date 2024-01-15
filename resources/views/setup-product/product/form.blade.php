@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>Form Product</h4>
        <div style="height:30px" align="centre"></div>
        <form action="{{ (empty($product)) ? route('product.store') : route('product.update', [$product->id]) }}" method="POST">@csrf

            @if(!empty($product)) @method('PUT') @endif

            <input type="hidden" value="{{ $product->id ?? '' }}" class="form-control" name="id" readonly>
            <input type="hidden" value="{{ (empty($product)) ? 'Create' : 'Update' }}" name="aksi">
            <input type="hidden" value="product" name="tabel">

            @include('error-message')

            <div class="form-group row">
		        <label class="col-md-3">Code</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="code" value="{{ $product->code ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Product Title</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="product_title" value="{{ $product->product_title ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Bunga</label>
			        <div class="col-md-7">
                    <input type="number" class="form-control" name="bunga" value="{{ $product->bunga ?? '' }}" required>
                </div>
	        </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>

        </form>
    </div>
</div>
@endsection
