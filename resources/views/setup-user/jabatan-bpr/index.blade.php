@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">Jabatan BPR
                <span style="float:right;">
                <span style="float:right;"><a href="{{ route('jabatan-bpr.create') }}" class="btn btn-primary btn-sm">Create</a></span>
                </span>
            </h4>
        </p>

        <div style="height:30px"></div>
    
        @include('flash-message')
        <div class="table-responsive">
           <table class="table table" style="width:100%" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Jabatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
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
        ajax: "{{ route('jabatan-bpr.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'kode', name: 'kode'},
            { data: 'jabatan', name: 'jabatan'},
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});

</script>
@endpush
