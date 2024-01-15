@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">Skema Kredit
                <span style="float:right;"><a href="{{ route('skema-kredit.create') }}" class="btn btn-primary btn-sm">Create</a></span>
            </h4>
            <div style="height:10px"></div>
        </div>

        <div style="height:10px"></div>

        @include('flash-message')
        <table class="table" style="width:100%" id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Aksi</th>
                </tr>
            <thead>
        </table>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('skema-kredit') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'skema_kredit', name: 'skema_kredit'},
                { data: 'action', name: 'action', orderable: false},
            ],
        order: [[0, 'asc']]
    });
});

</script>
@endpush
