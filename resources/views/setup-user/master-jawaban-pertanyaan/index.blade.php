@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">Master Pertanyaan
                <span style="float:right;">
                <span style="float:right;"><a href="{{ route('master-jawaban-pertanyaan.create') }}" class="btn btn-primary btn-sm">Create</a></span>
                </span>
            </h4>
        </p>

        <div style="height:30px"></div>
        <body>
            @include('flash-message')
            <div class="table-responsive">
                <table class="table table-stripped" style="width:100%" id="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pertanyaan</th>
                            <th>Jenis Pertanyaan</th>
                            <th>No Urut</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </body>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$(document).ready(function(){
    $('.dropdown a.test').on("click", function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('master-jawaban-pertanyaan.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'pertanyaan', name: 'pertanyaan'},
            { data: 'jenis_pertanyaan', name: 'jenis_pertanyaan' },
            { data: 'no_urut', name: 'no_urut' },
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});

</script>
@endpush
