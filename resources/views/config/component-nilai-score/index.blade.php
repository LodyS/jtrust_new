@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Component Scoring</h4></div>
        </div>
    </div>
</div>

<div class="card border-white" style="width: 100rem;">

    <div class="card-body">

        @include('flash-message')
        <table class="display table dataTable table-striped table-bordered"  id="table">
            <tr>
                <th>No</th>
                <th>Score Min</th>
                <th>Score Max</th>
                <th>Description</th>
                <th>Aksi</th>
            </tr>

            @foreach ($data as $key =>$d)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $d->score_min }}</td>
                <td>{{ $d->score_max }}</td>
                <td>{{ $d->description }}</td>
                <td><button type="button" class="btn btn-danger edit" data-id="{{ $d->id }}">Edit</button></td>
            </tr>
            @endforeach
        </table>

    </div>
</div>

<div class="modal inmodal fade" id="modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form class="form-horizontal" action="{{ url('update-component-nilai-scoring') }}" method="POST">@csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit</h4></div>


                    <div class="form-group row">
		                <label class="col-md-3">Score Min</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" id="score_min" name="score_min" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Score Max</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" id="score_max" name="score_max" required>
                        </div>
	                </div>

                    <div class="form-group row">
		                <label class="col-md-3">Description</label>
			                <div class="col-md-7">
                            <input type="text" class="form-control" id="description" name="description" required>
                        </div>
	                </div>

                    <div class="modal-footer">
                        <input type="hidden" name="id" id="id">
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

    $('.edit').on("click",function() {
        var id = $(this).attr('data-id');

        $.ajax({
            url : "{{route('edit-component-nilai-scoring')}}?id="+id,
            type: "GET",
            dataType: "JSON",
            success: function(data){
                $('#id').val(data.id);
                $('#score_min').val(data.score_min);
                $('#score_max').val(data.score_max);
                $('#description').val(data.description);
                $('#modal-edit').modal('show');
            }
        });
    });
});

</script>
@endpush
