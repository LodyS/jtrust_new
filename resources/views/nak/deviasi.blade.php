<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">DEVIASI - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</h5>
                <div style="height:30px"></div>
        
                @include('flash-message')
                @include('error-message')
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

        @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
            
            <form action="{{ url('save-deviasi') }}" method="POST" enctype="multipart/form-data">@csrf
                <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? ''  }}">
                <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">

                <input type="hidden" name="tabel" value="deviasi">
                <input type="hidden" name="aksi" value="Create">
                <input type="hidden" name="bagian" value="Nak">

                <div class="card border-white">
                    <div class="card-body">  
                        <table class="table table-hover" id="tambah_form">
                            <tr>
                                <th>Ketentuan</th>
                                <th>Deviasi</th>
                                <th>Pertimbangan dan Mitigasi</th>
                                <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button></th>
                            </tr>

                            <tbody></tbody>
                        </table>

                        <div style="height:10px"></div>
                
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </form>
        @endif
     
        <div style="height:30px"></div>

        <div class="card border-white">
            <div class="card-body">  
                <table class="table table-hover">
                    <tr>
                        <th colspan="5" style="text-align:center">LIST DEVIASI</th>
                    </tr>

                    <tr>
                        <th>No</th>
                        <th>Ketentuan</th>
                        <th>Deviasi</th>
                        <th>Pertimbangan dan Mitigasi</th>
                        <th>Aksi</th>
                    </tr>

                    @foreach($deviasi as $key=> $d)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td><textarea class="form-control" readonly rows="5">{{ $d->ketentuan }}</textarea></td>
                        <td><textarea class="form-control" readonly rows="5">{{ $d->deviasi }}</textarea></td>
                        <td><textarea class="form-control" readonly rows="5">{{ $d->pertimbangan_dan_mitigasi }}</textarea></td>
                        <td><a href="{{ url('edit-deviasi', [$d->id, $id]) }}" class="btn btn-primary">Edit</a>
                            <a href="javascript:void(0);" onClick="hapus({{ $d->id }})" class="hapus btn btn-danger">Hapus</a></td></td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</html>
@endsection

@push('scripts')
<script>
var i = 0;

$("#add").on("click", function() {

    var newRow = $("<tr>");
    var cols = "";

    cols += '<td><textarea name="ketentuan[]" class="form-control" rows="10"></textarea></td>';
    cols += '<td><textarea name="deviasi[]" class="form-control" rows="10"></textarea></td>';
    cols += '<td><textarea class="form-control content" name="pertimbangan_dan_mitigasi[]" rows="10"></textarea></td>';
    cols += '<td style="text-align:right"><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';
    newRow.append(cols);

    $("#tambah_form").append(newRow);
    i++;
});

$("#tambah_form").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
});

function hapus(id){
    if (confirm("Are you sure want to delete this data ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('destroy-deviasi') }}",
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
