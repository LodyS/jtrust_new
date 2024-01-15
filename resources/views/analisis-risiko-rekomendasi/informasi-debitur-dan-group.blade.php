<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">INFORMASI DEBITUR DAN GROUP - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($app->sandi_bpr)->nama_bpr) }}</h5>

                <div style="height:30px"></div>

                @include('flash-message')
        		@include('menu-arr')
			</div> 
		</div>

		<div style="height:10px"></div>
        
        <div class="card border-white">
            <div class="card-body">

		        <form action="{{ url('store-loan-applicant') }}" method="POST">@csrf

                    <input type="hidden" name="id" value="{{ $id ?? '' }}">

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nama Debitur/Mitra Kerja Sama</label>
                                <input type="text" class="form-control"  value="{{ $data->nama_bpr ?? '' }}" readonly>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Group Usaha</label>
                                <input type="text" class="form-control"  value="{{ (optional($data)->group_usaha == null) ?  'Tidak Ada' : 'Ada' }}" readonly>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Catatan Group Usaha</label>
                                <textarea class="form-control"  readonly row="4"></textarea>
                            </div>
                        </div><!-- Col -->
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Bidang Usaha</label>
                                <input type="text" class="form-control" value="{{ $data->bidang_usaha_group ?? '' }}" readonly>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Debitur</label>
                                <input type="text" class="form-control"  readonly>
                            </div>
                        </div><!-- Col -->
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Catatan Debitur</label>
                                <textarea class="form-control"  readonly row="4"></textarea>
                            </div>
                        </div><!-- Col -->
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Kolektibilitas Debitur (SLIK)</label>
                                <input type="text" class="form-control"  value="{{ $data->kol_di_bank_jtrust ?? '' }} - {{ kategoriKolektibilitas(optional($data)->kol_di_bank_jtrust)}}" readonly>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Risk Profile Debitur</label>
                                <input type="text" class="form-control"  value="N/A" readonly>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Kondisi Khusus</label>
                                <textarea class="form-control content" name="kondisi_khusus">{{ $app->kondisi_khusus ?? '' }}</textarea>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    @if(Auth::user()->divisi == 'Credit Risk Reviewer' && $app->crrd_section_head == null)
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </form>
            </div> 
        </div>
	</div>
</html>
@endsection

@push('scripts')
<script>
$('.jenis_usaha').click(function(){
    var status = $(this).val();

	if(status !== "Lainnya")
    {
        $('#jenis_usaha_lainnya').val('').change();
	}
});

var i = 0;

$("#add").on("click", function() {
    var newRow = $("<tr>");
    var cols = "";
    cols += '<td><input type="text" name="nama[]" class="form-control"><input type="hidden" name="aksi" value="aksi" class="form-control"></td>';
    cols += '<td><input type="text" name="jabatan[]" class="form-control"></td>';
    cols += '<td><input type="text" class="form-control nominal" name="jumlah_nominal[]"/></td>';
    cols += '<td><input type="text" class="form-control" name="persentase_kepemilikan[]"/></td>';
    cols += '<td><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';
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
