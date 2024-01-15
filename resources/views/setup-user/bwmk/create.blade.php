@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Simpan BWMK</h4>

            <div style="height:40px" align="centre"></div>
                <form action="{{ route('bwmk.store') }}" method="POST">@csrf

                <input type="hidden" name="aksi" value="Create">
                <input type="hidden" name="tabel" value="bwmk">

                @include('error-message')

                <div class="form-group row">
		            <label class="col-sm-3">&nbsp;&nbsp;&nbsp;Kategori</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="karakter" required >
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-sm-3">&nbsp;&nbsp;&nbsp;Nilai Kredit Minimum</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control nominal" name="nilai_kredit_minimum"  required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-sm-3">&nbsp;&nbsp;&nbsp;Nilai Kredit Maksimum</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control nominal" name="nilai_kredit_maksimum" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-sm-3">&nbsp;&nbsp;&nbsp;Voting Member</label>
			            <div class="col-md-7">
                        @foreach($jabatan as $j)
                        <label><input type="checkbox" name="voting_member[]" value="{{ $j->nama_jabatan }}"> {{ $j->nama_jabatan}}</label>
                        @endforeach
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-sm-3">&nbsp;&nbsp;&nbsp;Non Voting Member</label>
			            <div class="col-md-7">
                        @foreach($jabatan as $j)
                        <label><input type="checkbox" name="non_voting_member[]" value="{{ $j->nama_jabatan }}"> {{ $j->nama_jabatan}}</label>
                        @endforeach
                    </div>
	            </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <a href="{{ url('bwmk') }}" class="btn btn-danger">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>

<script type="text/javascript">
$(document).ready(function(){

    $('.nominal').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value) {
            return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    }));
});
</script>
