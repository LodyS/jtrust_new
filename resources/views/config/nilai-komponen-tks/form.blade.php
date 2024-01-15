@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>Form Nilai Komponen TKS</h4>
        <div style="height:30px" align="centre"></div>
        <form action="{{ (empty($data)) ? route('nilai-komponen-tks.store') : route('nilai-komponen-tks.update', [$data->id]) }}" method="POST">@csrf

            <input type="hidden" value="{{ $data->id ?? ''}}" class="form-control" name="id">
            <input type="hidden" value="{{ (empty($data)) ? 'Create' : 'Update' }}" name="aksi">
            <input type="hidden" value="nilai_komponen_tks" name="tabel">

            @if(!empty($data)) @method('PUT') @endif
            @include('flash-message')
            @include('error-message')

            @if (empty($data))
                <div class="form-group row">
		            <label class="col-md-3">Sub Komponen</label>
			            <div class="col-md-7">
                        <select class="form-control" name="sub_komponen" required>
                            <option value="">Pilih</option>
                            @foreach ($komponen as $kom)
                            <option value="{{ $kom->id}}">{{ $kom->sub_komponen }}</option>
                            @endforeach
                        </select>
                    </div>
	            </div>
            @else
                <div class="form-group row">
		            <label class="col-md-3">Sub Komponen</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" value="{{ $data->komponen->sub_komponen ?? '' }}" readonly>
                    </div>
	            </div>
            @endif

            <div class="form-group row">
		        <label class="col-md-3">Nilai Minimal</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nilai_min" value="{{ $data->nilai_min ?? ''}}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Nilai Maksimal</label>
			        <div class="col-md-7">
                    <input type="text" class="form-control" name="nilai_max" value="{{ $data->nilai_max ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Kategori</label>
			        <div class="col-md-7">
                    <select class="form-control" name="kategori" required>
                        @if ($data)
                            <option value="">Pilih</option>
                            <option value="Sehat" {{ ($data->kategori == 'Sehat')?'selected':''}}>Sehat</option>
                            <option value="Cukup Sehat" {{ ($data->kategori == 'Cukup Sehat')?'selected':''}}>Cukup Sehat</option>
                            <option value="Kurang Sehat" {{ ($data->kategori == 'Kurang Sehat')?'selected':''}}>Kurang Sehat</option>
                            <option value="Tidak Sehat" {{ ($data->kategori == 'Tidak Sehat')?'selected':''}}>Tidak Sehat</option>
                        @else
                            <option value="">Pilih</option>
                            <option value="Sehat" >Sehat</option>
                            <option value="Cukup Sehat" >Cukup Sehat</option>
                            <option value="Kurang Sehat">Kurang Sehat</option>
                            <option value="Tidak Sehat">Tidak Sehat</option>
                        @endif
                    </select>
                </div>
	        </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('komponen-tks') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection
