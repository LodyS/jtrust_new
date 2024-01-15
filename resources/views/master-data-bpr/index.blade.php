@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">List BPR
                @if(Auth::user()->jabatan_user->nama_jabatan == 'Account Officer')
                    <span style="float:right;">
                        <a href="{{ url('form-data-bpr') }}" class="btn btn-primary btn-sm" align="right">Create</a>
                    </span>
                @endif
            </h4>
        </p>

        <div style="height:30px"></div>

        @include('flash-message')
        <div class="table-responsive">
            <table class="table" style="width:100%" id="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Sandi BPR</th>
                        <th>Nama BPR</th>
                        <th>Alamat</th>
                        @if(Auth::user()->jabatan_user->kode == 'account_officer')
                            <th>Action</th>
                        @endif
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
        ajax: "{{ url('list-data-bpr') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'sandi_bpr', name: 'sandi_bpr' },
            { data: 'nama_bpr', name: 'nama_bpr'},
            { data: 'alamat_bpr', name: 'alamat_bpr', searchable:false },
            @if(Auth::user()->jabatan_user->kode == 'account_officer')
                { data: 'action', name: 'action', orderable: false},
            @endif
        ],
        order: [[0, 'asc']]
    });
});

function hapus(id)
{
    if (confirm("Are you sure want to delete this data ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('hapus-list-bpr') }}",
        data: {
                id: id,
                _token : "{{ csrf_token() }}",
            },

            dataType: 'json',
            success: function(res){
                location.reload();
            }
        });
    }
}
</script>
@endpush



