@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="modal-title">Edit Component</h4>
        <div style="height:40px" align="centre"></div>
        <form action="{{  url('component-scoring-update') }}" method="POST">{{ @csrf_field() }}

            <input type="hidden" value="{{ $data->id }}" class="form-control" name="id" readonly>

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
		            <label class="col-md-3">Component</label>
			            <div class="col-md-7">
                        <select class="select" data-width="100%" name="id_komponen">
                            <option>Silahkan Pilih</option>
                            @foreach ($component as $tipe)
                            <option value="{{ $tipe->id}}" {{  ($data->id_komponen == $tipe->id)?'selected':''}}>{{ $tipe->nama_komponen }}</option>
                            @endforeach
                        </select>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Uniq Code</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="uniq_code" value="{{ optional($data)->uniq_code }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Pertanyaan</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="pertanyaan" value="{{ optional($data)->pertanyaan }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Labeling Hasil Jawaban</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="labeling_hasil_jawaban" value="{{ optional($data)->labeling_hasil_jawaban }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Tipe Pertanyaan</label>
			            <div class="col-md-7">
                        <select  name="tipe_pertanyaan" required>
                            <option value="">Silahkan Pilih</option>
                            <option value="Range" {{ ($data->tipe_pertanyaan == 'Range')?'selected':''}}>Range</option>
                            <option value="Select" {{ ($data->tipe_pertanyaan == 'Select')?'selected':''}}>Select</option>
                            <option value="Input" {{ ($data->tipe_pertanyaan == 'Input')?'selected':''}}>Input</option>
                        </select>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Format Rupiah</label>
			            <div class="col-md-7">
                            <select class="form-control" name="rupiah_format" required>
                            <option>Silahkan Pilih</option>
                            <option value="Tidak" {{ ($data->rupiah_format == 'Tidak')?'selected':''}}>Tidak</option>
                            <option value="Ya" {{ ($data->rupiah_format == 'Ya')?'selected':''}}>Ya</option>
                        </select>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">ID Applicant Collection</label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="id_applicant_collection" value="{{ optional($data)->id_applicant_collection }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Formula</label>
			            <div class="col-md-7">
                        <textarea class="form-control" name="formula" rows="3" required value="{{ optional($data)->formula}}">{{optional($data)->formula}}</textarea>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Jenis Formula</label>
			            <div class="col-md-7">
                        <select class="form-control" name="jenis_formula" required>
                            <option>Silahkan Pilih</option>
                             <option value="None" {{ ($data->jenis_formula == 'None')?'selected':''}}>None</option>
                            <option value="Conditional"  {{ ($data->jenis_formula == 'Conditional')?'selected':''}}>Conditional</option>
                        </select>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Tipe Inputan</label>
			            <div class="col-md-7">
                        <select class="form-control" name="tipe_inputan" required>
                            <option>Silahkan Pilih</option>
                            <option value="String" {{ ($data->tipe_inputan == 'String')?'selected':''}}>String</option>
                            <option value="Decimal" {{ ($data->tipe_inputan == 'Decimal')?'selected':''}}>Decimal</option>
                        </select>
                    </div>
	            </div>

            <div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('.select').select2({  theme: 'bootstrap4'});
</script>
@endpush
