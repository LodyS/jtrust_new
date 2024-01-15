@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        @include('flash-message')
        <h4>Form 005 - Data Pihak Terkait BPR</h4>

        <div style="height:40px" align="centre"></div>

        <form action="{{ url('simpan-data-pihak-terkait-bpr') }}" method="POST"  enctype="multipart/form-data">@csrf

        @include('error-message')

        <div class="form-group row">
		    <label class="col-md-3">File (Txt format)</label>
			    <div class="col-md-7">
                <input type="file" class="form-control" name="file" accept=".txt" required>
		    </div>
	    </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>

    </div>
</div>
@endsection





