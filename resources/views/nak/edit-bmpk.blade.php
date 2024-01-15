<!DOCTYPE html>
@extends('tema.app')
@section('content')

<style>
ul { list-style: none outside none; margin:0; padding: 0; text-align: center }
li { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

table
{
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

th, td
{
    text-align: left;
    padding: 10px;
}

tr:nth-child(even)
{
    background-color: #f2f2f2
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 align="center">EDIT BWMK - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($bmpk->sandi_bpr)->nama_bpr) }}</h4>
      
        <div style="height:30px"></div>

        @include('flash-message')
        @include('error-message')

		<form action="{{ url('update-bmpk') }}" method="POST">@csrf
            <input type="hidden" name="id" value="{{ $bmpk->id ?? '' }}">
            <input type="hidden" name="nak_id" value="{{ $loan_applicant ?? '' }}">

            <table class="table table-bordered table-responsive">
                <tr>
                    <th rowspan="3">Batas Maksimum <br/>Pemberian Kredit (BMPK)</th>
                    <th style="width:15%" rowspan="2">Keterangan</th>
                    <th style="width:40%">BMPK</th>
                    <th colspan="2" style="width:45%">Inhouse Limit</th>
                </tr>

                <tr>
                    <td>Rp Juta</td>
                    <td>%</td>
                    <td>Rp Juta</td>
                </tr>

                <tr>
                    <td>Modal Inti Bank</td>
                    <td><input type="text" name="modal_inti_bank" style="text-align:right" value="{{ number_format($bmpk->modal_inti_bank) }}" id="modal_inti_bank" class="form-control nominal"></td>
                    <td  style="text-align:right">100</td>
                    <td><input type="text" class="form-control" style="text-align:right" value="{{ number_format($bmpk->inhouse_modal_inti_bank) }}" name="inhouse_modal_inti_bank" id="inhouse_modal_inti_bank" readonly></td>
                </tr>

                <tr>
                    <td>Posisi <div style="height:20px"></div><input type="date" name="tanggal_posisi" value="{{ $bmpk->tanggal_posisi }}" class="form-control"></td>
                    <td>Debitur Individu (25%)</td>
                    <td><input type="text" name="debitur_individu"  style="text-align:right" value="{{ number_format($bmpk->debitur_individu) }}" id="debitur_individu" class="form-control nominal"></td>
                    <td  style="text-align:right">80</td>
                    <td><input type="text" class="form-control"  style="text-align:right" value="{{ number_format($bmpk->inhouse_debitur_individu) }}" name="inhouse_debitur_individu" id="inhouse_debitur_individu" readonly></td>
                </tr>

                <tr>
                    <td></td>
                    <td>Debitur Group (25%)</td>
                    <td><input type="text" name="debitur_group"  style="text-align:right" value="{{ number_format($bmpk->debitur_group) }}" id="debitur_group" class="form-control nominal"></td>
                    <td  style="text-align:right">80</td>
                    <td><input type="text" class="form-control"  style="text-align:right" value="{{ number_format($bmpk->inhouse_debitur_group) }}" name="inhouse_debitur_group" id="inhouse_debitur_group" readonly></td>
                </tr>

                <?php $total = $bmpk->inhouse_modal_inti_bank + $bmpk->inhouse_debitur_individu + $bmpk->inhouse_debitur_group; ?>
                <tr>
                    <td></td>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td><input type="text" class="form-control total"  style="text-align:right" value="{{ number_format($total) }}" readonly></td>
                </tr>
            </table>

            <div style="height:30px"></div>
            <button type="submit" class="btn btn-primary">Save</button>

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

function numberFormat(number)
{
    return number.toString().replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

$(document).ready(function(){

    $('#modal_inti_bank').on('change keyup', function(){
        var modal_inti_bank = $('#modal_inti_bank').val().replace(/\D/g, "");
        var persen = 100;
        var inhouse_modal_inti_bank = Number(modal_inti_bank) * Number(100/100);

        $('#inhouse_modal_inti_bank').val(numberFormat(inhouse_modal_inti_bank)).change();
    });

    $('#debitur_individu').on('change keyup', function(){
        var debitur_individu = $('#debitur_individu').val().replace(/\D/g, "");
        var persen = 80;
        var inhouse_debitur_individu = Number(debitur_individu) * Number(80/100);

        $('#inhouse_debitur_individu').val(numberFormat(inhouse_debitur_individu)).change();
    });

    $('#debitur_group').on('change keyup', function(){
        var debitur_group = $('#debitur_group').val().replace(/\D/g, "");
        var persen = 80;
        var inhouse_debitur_group = Number(debitur_group) * Number(80/100);

        $('#inhouse_debitur_group').val(numberFormat(inhouse_debitur_group)).change();
    });

    $('#modal_inti_bank, #debitur_individu, #debitur_group').on('change keyup', function(){
        var modal_inti_bank = $('#modal_inti_bank').val().replace(/\D/g, "");
        var debitur_individu = $('#debitur_individu').val().replace(/\D/g, "");
        var debitur_group = $('#debitur_group').val().replace(/\D/g, "");

        var total = Number(modal_inti_bank) + Number(debitur_individu) + Number(debitur_group);

        $('.total').val(numberFormat(total)).change();
    });
});


</script>
@endpush
