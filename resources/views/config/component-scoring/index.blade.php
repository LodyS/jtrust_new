@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Component Scoring</h4></div>

            <span style="float:right;"><button type="button" class="btn btn-primary btn-sm" id="tambah" align="right">Create</button></span>
        </div>
    </div>
</div>

<div class="card border-white" style="width: 100rem;">

    <div class="card-body">

        @include('flash-message')

        <div style="height:10px"></div>


        <table class="display table dataTable table-striped table-bordered"  id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Komponen</th>
                    <th>Uniq Code</th>
                    <th>Pertanyaan</th>
                    <th>Tipe Pertanyaan</th>
                    <th>Tipe Inputan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>

    </div>
</div>

<div class="modal inmodal fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" action="{{ url('component-scoring-store') }}" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Component Scoring</h4></div>

                    <div class="form-group row">
		                <label class="col-md-3">Component</label>
			                <div class="col-md-7">
                            <select class="select" data-width="100%" name="id_komponen">
                                <option>Silahkan Pilih</option>
                                @foreach ($component as $tipe)
                                <option value="{{ $tipe->id}}">{{ $tipe->nama_komponen }}</option>
                                @endforeach
                            </select>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Uniq Code</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" name="uniq_code" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Pertanyaan</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" name="pertanyaan" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Labeling Hasil Jawaban</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" name="labeling_hasil_jawaban" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Tipe Pertanyaan</label>
			                <div class="col-md-7">
                            <select  name="tipe_pertanyaan" required>
                                <option value="">Silahkan Pilih</option>
                                <option value="Range">Range</option>
                                <option value="Select">Select</option>
                                <option value="Input">Input</option>
                            </select>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Format Rupiah</label>
			                <div class="col-md-7">
                            <select class="form-control" name="rupiah_format" required>
                                <option>Silahkan Pilih</option>
                                <option value="Tidak">Tidak</option>
                                <option value="Ya">Ya</option>
                            </select>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">ID Applicant Collection</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" name="id_applicant_collection" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Formula</label>
			                <div class="col-md-7">
                            <textarea class="form-control" name="formula" rows="3" required></textarea>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Jenis Formula</label>
			                <div class="col-md-7">
                            <select class="form-control" name="jenis_formula" required>
                                <option>Silahkan Pilih</option>
                                <option value="None">None</option>
                                <option value="Conditional">Conditional</option>
                            </select>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Tipe Inputan</label>
			                <div class="col-md-7">
                            <select class="form-control" name="tipe_inputan" required>
                                <option>Silahkan Pilih</option>
                                <option value="String">String</option>
                                <option value="Decimal">Decimal</option>
                            </select>
                        </div>
	                </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#tambah').on("click",function() {
        $('#modal-create').modal('show');
    });

    $('.select').select2({  theme: 'bootstrap4'});

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('component-scoring-data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'nama_komponen', name: 'nama_komponen' },
                { data: 'uniq_code', name: 'uniq_code' },
                { data: 'pertanyaan', name: 'pertanyaan' },
                { data: 'tipe_pertanyaan', name: 'tipe_pertanyaan' },
                { data: 'tipe_inputan', name: 'tipe_inputan' },
                { data: 'action', name: 'action', orderable: false},
            ],
        order: [[0, 'asc']]
    });
});

function hapus(id)
{
    if (confirm("Apakah Anda yakin akan hapus product ini ?") == true) {
    var id = id;

    $.ajax({
        type:"POST",
        url: "{{ url('component-scoring-delete') }}",
        data: {
                id: id,
                _token : "{{ csrf_token() }}",
            },

        dataType: 'json',
        success: function(res){
            var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            }
        });
    }
}
</script>
@endpush
