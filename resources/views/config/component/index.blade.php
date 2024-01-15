@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Component</h4></div>

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
                    <th>NO</th>
                    <th>Product Title</th>
                    <th>Nama Komponen</th>
                    <th>Bobot Persentase</th>
                    <th>Max Score</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>

    </div>
</div>
@endsection

<div class="modal inmodal fade" id="modal-create" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" action="{{ url('component-store') }}" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add Component</h4></div>

                    <div class="form-group row">
		                <label class="col-md-3">Product ID</label>
			                <div class="col-md-7">
                            <select class="form-control" name="product_id">
                                <option value="">Silahkan Pilih</option>
                                @foreach ($produk as $tipe)
                                <option value="{{ $tipe->id}}">{{ $tipe->product_title }}</option>
                                @endforeach
                            </select>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Nama Komponen</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" name="nama_komponen" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Bobot Persentase</label>
			                <div class="col-md-7">
                            <input type="number" class="form-control" name="bobot_persentase" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Max Score</label>
			                <div class="col-md-7">
                            <input type="number" class="form-control" name="max_score" required>
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


@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#tambah').on("click",function() {
        $('#modal-create').modal('show');
    });

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('component-data') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'product_title', name: 'product_title' },
                { data: 'nama_komponen', name: 'nama_komponen' },
                { data: 'bobot_persentase', name: 'bobot_persentase' },
                { data: 'max_score', name: 'max_score' },
                { data: 'action', name: 'action', orderable: false},
            ],
        order: [[0, 'asc']]
    });
});

function hapus(id){
    if (confirm("Apakah Anda yakin akan hapus product ini ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('component-delete') }}",
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
