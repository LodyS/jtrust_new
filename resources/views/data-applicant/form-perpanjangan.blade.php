@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <h4>Form Perpanjangan Loan Applicant</h4>
        <div style="height:30px"></div>

            <form action="{{ ($aksi == 'Create') ? url('simpan-perpanjangan-pinjaman') : url('update-perpanjangan-pinjaman') }}" method="POST" name="form">@csrf

            @include('flash-message')
            @include('error-message')

            <input type="hidden" name="id" value="{{ $data->id }}">
            <input type="hidden" name="aksi" value="Tambah">
            <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr }}">
            <input type="hidden" name="tabel" value="loan_applicants">

            <div class="form-group row">
		        <label class="col-md-3">Tanggal Apply</label>
			        <div class="col-md-7">
                    <input type="date" class="form-control" name="tanggal_apply" value="{{ date('Y-m-d') }}" id="tanggal_apply" required>
                </div>
	        </div>

            <div class="form-group row">
                <label class="col-md-3">Nama BPR</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="bak" value="{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr  }}" readonly>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3">Baki Debet</label>
                <div class="col-md-7">
                    <input type="text" class="form-control nominal" name="baki_debet" value="{{ number_format($data->baki_debet ?? 0)  }}" id="baki_debet" required>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3">Tenor Perpanjang (bulan)</label>
                <div class="col-md-7">
                    <input type="text" class="form-control" name="tenor_perpanjang" value="{{ optional($data)->tenor_perpanjang ?? ''}}" id="tenor_perpanjang" required>
                </div>
            </div>
        
            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('workflow-ao') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')

<script type="text/javascript">
$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

$("form[name='form']").validate({
    rules: {
        tanggal_apply: "required",
        sandi_bpr: "required",
        jenis_pengajuan : "required",
        produk_id : "required",
        skema_kredit : "required",
        bunga : "required",
        biaya_administrasi : "required",
    },
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush
