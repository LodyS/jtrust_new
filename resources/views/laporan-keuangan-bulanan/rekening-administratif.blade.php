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
        <h5 style="text-align:center;">INPUT REKENING ADMINISTRATIF</h5>
        <h5 style="text-align:center;">{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}</h5>

        <div style="height:30px"></div>

        <form action="{{ url('rekening-administratif-store') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            @include('menu-laporan-bulanan')
            <div style="height:30px"></div>
            @include('flash-message')

            <div class="form-group row">
                <label class="col-md-3">Pilih Bulan</label>
                    <div class="col-md-7">
                    <select name="bulan" class="form-control">
                        <option>Pilih</option>
                        <option value="1">Januari</option>
                        <option value="2">Februari</option>
                        <option value="3">Maret</option>
                        <option value="4">April</option>
                        <option value="5">Mei</option>
                        <option value="6">Juni</option>
                        <option value="7">Juli</option>
                        <option value="8">Agustus</option>
                        <option value="9">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
            </div>


            <?php $tahun = date('Y'); ?>
            <div class="form-group row">
                <label class="col-md-3">Pilih Tahun</label>
                    <div class="col-md-7">
                    <select name="tahun" id="tahun" class="form-control select" required>
                        <option value="">Pilih</option>
                        @for($i=2019; $i<=$tahun; $i++)
                        <option value="{{ $i }}">{{ $i}} </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div style="height:20px"></div>

            <table class="table table-stripped" id="table">
                <tr>
                    <th>POS/AKTIVITAS/ACCOUNT</th>
                    <th>Sandi</th>
                    <th>Nominal</th>
                </tr>

                @foreach($coa as $c)
                <tr>
                    <td style="font-size:11px"><input type="hidden" name="coa_id[]" value="{{ $c->nama_coa }}">{{ $c->nama_coa }}</td>
                    <td style="font-size:11px"><input type="hidden" name="sandi_coa[]" value="{{ $c->sandi_coa }}">{{ $c->sandi_coa }}</td>
                    <td style="font-size:11px"><input type="text" name="nominal[]" id="nominal" value="0" class="form-control nominal" style="text-align:right"></td>
                </tr>
                @endforeach

            </table>

            <div style="height:30px"></div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('list-data-bpr') }}" class="btn btn-danger">Back</a>
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


