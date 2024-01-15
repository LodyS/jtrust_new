@extends('tema.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">Manajemen Pertanyaan</h4></div>

            <span style="float:right;"><a href="{{ route('manajemen-pertanyaan.create') }}" class="btn btn-primary btn-sm">Create</a></span>
        </div>
    </div>

    <div class="card-body">

        @include('flash-message')

        <div style="height:10px"></div>

        <div style="overflow-x:auto;">
            <table class="table" style="width:100%" id="table">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Kelompok Pertanyaan</th>
                        <th>Sub Kelompok Pertanyaan</th>
                        <th>Detail Pertanyaan</th>
                        <th>Min - Max Score</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$(document).ready( function () {

    $('#table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('manajemen-pertanyaan.index') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
                { data: 'kelompok_pertanyaan', name: 'kelompok_pertanyaan' },
                { data: 'sub_kelompok_pertanyaan', name: 'sub_kelompok_pertanyaan' },
                { data: 'detail_pertanyaan', name: 'detail_pertanyaan' },
                { data: 'min_max', name: 'min_max' },
                { data: 'action', name: 'action', orderable: false},
            ],
        order: [[0, 'asc']]
    });
});
</script>
@endpush
