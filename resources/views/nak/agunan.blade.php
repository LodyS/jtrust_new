<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
       
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">AGUNAN - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($app->sandi_bpr)->nama_bpr) }}</h5>
                <div style="height:30px"></div>
                @include('flash-message')
                @include('error-message')
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>
        
        <form action="{{ url('save-agunan') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $app->sandi_bpr ?? '' }}">
            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">

            <input type="hidden" name="tabel" value="agunan">
            <input type="hidden" name="aksi" value="Create">
            <input type="hidden" name="bagian" value="Nak">

            @if (Auth::user()->jabatan_user->kode == 'account_officer' && $app->status_level_proses == '1')

                <div class="card border-white" >
                    <div class="card-body">  
                        <div class="form-group">
                            <table class="table table-hover" id="tambah_form">

                                <tr>
                                    <th colspan="5" style="text-align:center">FORM AGUNAN</th>
                                </tr>

                                <tr>
                                    <th>Jenis Agunan</th>
                                    <th>Nilai Pasar</th>
                                    <th>Nilai Bank</th>
                                    <th>Nilai Pengikat</th>
                                    <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button></th>
                                </tr>

                                <tbody></tbody>
                            </table>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            @endif
        
            <div style="height:20px"></div>

            <div class="card border-white">
                <div class="card-body">  
                    <table class="table table">

                        <tr>
                            <th colspan="5" style="text-align:center">LIST AGUNAN</th>
                        </tr>

                        <tr>
                            <th>NO</th>
                            <th>Jenis Agunan</th>
                            <th>Nilai Pasar</th>
                            <th>Nilai Bank</th>
                            <th>Nilai Pengikat</th>
                        </tr>

                        @forelse($agunan as $key=>$a)
                        <tr>
                            <td>{{ ($key++) + 1 }}</td>
                            <td>{{ $a->jenis_agunan }}</td>
                            <td>Rp. {{ number_format($a->nilai_pasar) }}</td>
                            <td>Rp. {{ number_format($a->nilai_bank) }}</td>
                            <td>{{ $a->nilai_pengikat }}%</td>
                        </tr>
                        @empty

                        @endforelse
                    </table>
                </div>
            </div>
        </form>
	</div>
</div>
@endsection

@push('scripts')
<script>

var i = 0;

$("#add").on("click", function() {
    var newRow = $("<tr>");
    var cols = "";

    cols += '<td><input type="text" name="jenis_agunan[]" class="form-control"></td>';
    cols += '<td><input type="text" name="nilai_pasar[]" class="form-control nominal"></td>';
    cols += '<td><input type="text" class="form-control nominal" name="nilai_bank[]"/></td>';
    cols += '<td><input type="number" class="form-control" name="nilai_pengikat[]"/></td>';
    cols += '<td style="text-align:right"><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';
    newRow.append(cols);

    newRow.find('.nominal').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value) {
            return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    }));

    $("#tambah_form").append(newRow);
    i++;
});

$("#tambah_form").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
    evaluateTotal()
});

</script>
@endpush
