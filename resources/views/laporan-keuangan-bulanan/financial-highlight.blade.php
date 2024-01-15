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

<meta name="csrf-token" content="{{ csrf_token() }}" />

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h5 style="text-align:center;">INPUT FINANCIAL HIGHLIGHT <br/>{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) ?? '' }}</h5>

        <div style="height:30px"></div>

        <form action="{{ url('store-input-financial-highlight') }}" method="POST">@csrf

            <input type="hidden" name="sandi_bpr" id="sandi_bpr" value="{{ $sandi_bpr ?? '' }}">

            @include('menu-laporan-bulanan')
            <div style="height:30px"></div>
            @include('flash-message')

            <div class="form-group row">
                <label class="col-md-3">Pilih Bulan </label>
                    <div class="col-md-7">
                    <select name="bulan" id="bulan" class="form-control" required>
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
                        @for($i=2015; $i<=$tahun+1; $i++)
                        <option value="{{ $i }}">{{ $i}} </option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3">Jenis Laporan</label>
                    <div class="col-md-7">
                    <select name="jenis" class="form-control select" required>
                        <option value="">Pilih</option>
                        <option value="Realisasi">Realisasi</option>
                        <option value="RKAT">RKAT</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-md-3">Sub Jenis Laporan</label>
                    <div class="col-md-7">
                    <select name="sub_jenis" class="form-control select" required>
                        <option value="">Pilih</option>
                        <option value="Audit">Audit</option>
                        <option value="OJK Publikasi">OJK Publikasi</option>
                        <option value="Disampaikan ke OJK">Disampaikan ke OJK</option>
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button class="btn btn-primary cari-data">Cari</button>
            </div>

            <div style="height:30px"></div>

            <span id="result"></span>
            <table class="table" id="table">
                <tr>
                    <th>Keterangan</th>
                    <th>Nominal</th>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Asset" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="aset"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Penempatan pada Bank Lain" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" id="penempatan_pada_bank_lain" value="0"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Pembiayaan yang diberikan" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="pembiayaan_yang_diberikan"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Pembiayaan yang diberikan bermasalah" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="pembiayaan_yang_diberikan_bermasalah"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Dana pihak ketiga" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" id="dana_pihak_ketiga" value="0"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Tabungan" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="tabungan"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Deposito" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="deposito"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Pinjaman Diterima" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="pinjaman_diterima"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Modal Disetor" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="modal_disetor"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Laba Ditahan" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="laba_ditahan"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Laba Tahun Berjalan" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="laba_tahun_berjalan"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="EBIT (Earning Before Interest & Tax)" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="ebit"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="EBITDA (Earning Before Interest & Tax, Depreciation & Amortisation)" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="ebitda"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="PPAP - Kredit yang diberikan" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="ppap_yang_diberikan"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Pemulihan PPAP - Kredit yang diberikan" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="ppap_yang_dipulihkan"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Penghapusan Kredit (WO) Tahun Berjalan" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="aktiva_produktif_yang_dihapus"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Pemulihan WO" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0" id="pemulihan_wo"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Agunan Yang Diambil Alih (AYDA)" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control nominal" style="text-align:right" value="0"></td>
                </tr>

                <tr>
                    <td colspan="2">Rasio Keuangan</td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="LDR" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="ldr"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Alat Likuid/Hutang Lancar (Cash Ratio)" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="cash_ratio"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="CAR" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="car"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="ROA (Laba sebelum pajak)" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="roa"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="ROE" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="roe"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="BOPO" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="bopo"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="Debt Equity Ratio (DER)" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="der"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="NPL Gross" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="npl"></td>
                </tr>

                <tr>
                    <td><input type="text" name="keterangan[]" class="form-control" value="NPL Nett" readonly style="background-color:white;"></td>
                    <td><input type="text" name="nominal[]" class="form-control" style="text-align:right" id="npl_nett"></td>
                </tr>
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

function numberFormat(nominal)
{
    return nominal.toString().replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

$(".cari-data").click(function(event){
    event.preventDefault();

    let tahun = $("#tahun").val();
    let bulan = $("#bulan").val();
    let sandi_bpr = $("#sandi_bpr").val();
    let _token = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: "/cari-financial-highlight",
        type:"POST",
        data:{
            tahun:tahun,
            bulan:bulan,
            sandi_bpr:sandi_bpr,
            _token: _token
        },
        dataType: 'json',

        success:function(response){
            console.log(response);
            if(response) {
                var res = JSON.stringify(response);
                res = JSON.parse(res)

                for(var i =0; i < res.length; i++)
                {
                    $('#penempatan_pada_bank_lain').val(numberFormat(res[i]['penempatan_pada_bank_lain']));
                    $('#pembiayaan_yang_diberikan').val(numberFormat(res[i]['pembiayaan_yang_diberikan']));
                    $('#pembiayaan_yang_diberikan_bermasalah').val(numberFormat(res[i]['pembiayaan_yang_diberikan_bermasalah']));
                    $('#tabungan').val(numberFormat(res[i]['tabungan']));
                    $('#deposito').val(numberFormat(res[i]['deposito']));
                    
                    $('#pinjaman_diterima').val(numberFormat(
                        Number(res[i]['kredit_kurang_tiga_bulan']) + Number(res[i]['kredit_lebih_tiga_bulan'])
                    ));

                    $('#dana_pihak_ketiga').val(numberFormat(res[i]['simpanan']));
                    $('#modal_disetor').val(numberFormat(res[i]['modal_dasar']));
                    $('#laba_tahun_berjalan').val(numberFormat(res[i]['laba_tahun_berjalan']));
                    $('#ebit').val(numberFormat(res[i]['ebit']));
                    $('#ebitda').val(numberFormat(res[i]['ebitda']));
                    $('#ppap_yang_diberikan').val(numberFormat(res[i]['ppap_yang_diberikan']));
                    $('#aktiva_produktif_yang_dihapus').val(numberFormat(res[i]['aktiva_produktif_yang_dihapus']));
                    $('#aset').val(numberFormat(res[i]['aset']));
                    $('#ldr').val(res[i]['ldr']);
                    $('#cash_ratio').val(res[i]['cash_ratio']);
                    $('#car').val(res[i]['car']);
                    $('#roa').val(res[i]['roa']);
                    $('#roe').val(res[i]['roe']);
                    $('#bopo').val(res[i]['bopo']);
                    $('#der').val(res[i]['der']);
                    $('#npl').val(res[i]['npl']);
                    $('#npl_nett').val(res[i]['npl_nett']);
                    $('#laba_ditahan').val(numberFormat(res[i]['laba_ditahan']));
                    $('#ppap_yang_dipulihkan').val(numberFormat(res[i]['ppap_yang_dipulihkan']));
                    $('#pemulihan_wo').val(numberFormat(res[i]['pemulihan_wo']));
                }
            }
            
        },
        error: function(error) {
            console.log(error);
            $('#posError').text(response.responseJSON.errors.pos);
            $('#emailError').text(response.responseJSON.errors.email);
        }
    });
});
</script>
@endpush


