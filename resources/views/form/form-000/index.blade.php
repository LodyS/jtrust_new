@extends('tema.app')
@section('content')

<div class="card" style="width: 100rem; ">
    <div class="card-body">
        @include('flash-message')
        <h4>Form 000 - Informasi Pokok BPR Pelapor</h4>

        <div style="height:40px"></div>

        <form action="{{ url('simpan-informasi-pokok-bpr-pelapor') }}" method="POST"  enctype="multipart/form-data">{{ @csrf_field() }}

        <ul>
            @foreach ($errors->all() as $error)

            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert"><span>&times;</span></button>{{ $error }}
                </div>
            </div>
            @endforeach
        </ul>

        <div class="form-group row">
		    <label class="col-md-3">File (Txt format)</label>
			    <div class="col-md-7">
                <input type="file" class="form-control" name="file" accept=".txt" required>
		    </div>
	    </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ url('list-data-bpr') }}" class="btn btn-danger">Cancel</a>
        </div>

    </div>
</div>
@endsection





