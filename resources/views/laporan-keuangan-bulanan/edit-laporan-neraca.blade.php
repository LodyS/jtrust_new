@extends('tema.app')
@section('content')

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 style="text-align:center;">Edit Laporan Neraca {{ \App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr ?? '' }}</h4>

        <div style="height:40px" align="centre"></div>

        <form action="{{ url('update-laporan-keuangan-bulanan') }}" method="POST">@csrf

        <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
        <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

        @include('menu-laporan-bulanan')
        @include('flash-message')

        <div style="height:40px" align="centre"></div>

        <div class="form-group row">
		    <label class="col-md-3">POS</label>
			    <div class="col-md-7">
                <input type="text" class="form-control" value="{{ $data->pos ?? ''}}" readonly>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Nominal</label>
			    <div class="col-md-7">
                <input type="text" name="nominal" class="form-control nominal" value="{{ number_format((int) $data->posisi_tanggal_laporan) ?? ''}}">
		    </div>
	    </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-primary" name="search">Update</button>
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
</script>
@endpush
