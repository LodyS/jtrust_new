@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <form action="{{ route('kepemilikan-bpr.update', [$data->id]) }}" method="POST" name="form">@csrf

            @method('PUT')

            <input type="hidden" name="aksi" value="Update">
            <input type="hidden" name="tabel" value="form_001">
            <input type="hidden" name="bagian" value="Master BPR">
            <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? '' }}">

            <h5 align="center">EDIT KEPEMILIKAN BPR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>

            @include('error-message')
            @include('flash-message')

            <div style="height:30px"></div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Nama </span></label>
                        <input type="text" class="form-control" name="nama" value="{{ $data->nama ?? '' }}" required>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Jabatan</span></label>
                        <input type="text" class="form-control" name="jabatan" value="{{ $data->jabatan ?? '' }}" required>
                    </div>
                </div><!-- Col -->
            </div><!-- Row -->

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">Alamat</label>
                        <textarea class="form-control" rows = "3" name="alamat" required>{{ $data->alamat ?? '' }}</textarea>
                    </div>
                </div><!-- Col -->
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">Jenis</label>
                        <input type="text" class="form-control" name="jenis" value="{{ $data->jenis ?? ''}}">
                    </div>
                </div><!-- Col -->

                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label">No Identitas</label>
                            <input type="text" class="form-control" name="no_identitas" value="{{ $data->no_identitas ?? '' }}" required>
                        </div>
                    </div><!-- Col -->
                </div>

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">PSP </label>
                            <input type="text" class="form-control" name="psp" value="{{ $data->psp ?? '' }}">
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Jumlah Nominal</label>
                            <input type="text" class="form-control nominal" name="jumlah_nominal" value="{{ number_format((float)$data->jumlah_nominal) ?? '' }}" required>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label class="control-label">Persentase Kepemilikan</label>
                            <input type="text" class="form-control bunga" name="persentase_kepemilikan" value="{{ $data->persentase_kepemilikan ?? ''}}" required>
                        </div>
                    </div><!-- Col -->
                </div><!-- Row -->

                <div style="height:10px"></div>

                <button type="submit" class="btn btn-primary submit">Save</button>
            </form>
		</div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});

$('.select').select2({  theme: 'bootstrap4'});

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,)\./g, "").replace(/(?<=\.\d\d)./g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

$('.bunga').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{2})+(?!\d))/g, ".");
    });
}));
</script>
@endpush
