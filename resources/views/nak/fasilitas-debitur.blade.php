<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border border-white" style="width: 100rem;">
    <div class="card-body">
       
        @include('flash-message')
        @include('error-message')
       
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">FASILITAS DEBITUR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) ?? '' }}</h5>
                
                <div style="height:30px"></div>
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

        <div class="card border border-white" >
            <div class="card-body">
                <form action="{{ url('simpan-fasilitas-debitur') }}" method="POST">@csrf
                    <input type="hidden" name="id" value="{{ $id ?? '' }}">
                    <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? '' }}">
                    <input type="hidden" name="tabel" value="loan_applicants">
                    <input type="hidden" name="aksi" value="Update">
                    <input type="hidden" name="bagian" value="Nak">

                    <table class="table table-bordered  table-sm" style="width:100%">
                        <tr>
                            <th>No</th>
                            <th>Fasilitas</th>
                            <th>Status</th>
                            <th>Kol</th>
                            <th>Suku Bunga</th>
                            <th>CCY*</th>
                            <th colspan="3" style="text-align:center;">Plafon (eq. IDR)</th>
                            <th>O/S (eq. IDR)</th>
                            <th>Jatuh Tempo</th>
                        </tr>

                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td style="text-align:center">Sebelum</td>
                            <td style="text-align:center">+/-</td>
                            <td style="text-align:center">Sesudah</td>
                            <td></td>
                            <td></td>
                        </tr>

                        <?php
                        $sebelum =0;
                        $pemakaian =0;
                        $sesudah =0;
                        ?>
                        @foreach($fasilitas_debitur as $key=>$fd)
                            <tr>
                                <td>{{ ++$key }}</td>
                                <td style="font-size:11px">{{ \App\Models\ProductType::namaProduk($fd->produk_id) ?? '' }}</td>
                                <td style="font-size:11px">{{ $fd->jenis_pengajuan }}</td>
                                <td style="font-size:11px"></td>
                                <td style="font-size:11px">{{ $fd->bunga }} % p.a.eff</td>
                                <td style="font-size:11px">IDR</td>
                                <?php $sebelum_array = ($fd->jenis_pengajuan == 'Existing') ? $fd->plafon_lama :  0 ?>
                                <td style="width:10%; text-align:right; font-size:11px">{{ number_format($sebelum_array) }}</td>
                                <?php $pemakaian_array = ($fd->jenis_pengajuan == 'Existing') ? ($fd->pemakaian/-1) :$fd->plafond ?>
                                <td style="width:15%; text-align:right; font-size:11px">{{ number_format($pemakaian_array) }}</td>
                                <?php $sesudah_array = $sebelum_array + $pemakaian_array; ?>
                                <td style="width:10%; text-align:right; font-size:11px">{{ number_format($sesudah_array) }}</td>
                                <td style="width:10%; text-align:right; font-size:11px">{{ number_format($sesudah_array) }}</td>
                                <td style="font-size:11px">{{ $fd->tenor }} Bulan<br/> Sejak Fasilitas kredit <br/> efektif</td>
                            </tr>
                            <?php
                            $sebelum += $sebelum_array;
                            $pemakaian += $pemakaian_array;
                            $sesudah += $sesudah_array;
                            ?>                            
                        @endforeach

                        <tr>
                            <td colspan="6"><b>Total</td>
                            <td style="font-size:11px; text-align:right">{{ number_format($sebelum) }}</td>
                            <td style="font-size:11px; text-align:right">{{ number_format($pemakaian) }}</td>
                            <td style="text-align:right; font-size:11px">{{ number_format($sesudah) }}</td>
                            <td style="text-align:right; font-size:11px">{{ number_format($sesudah) }}</td>
                            <td></td>
                        </tr>
                    </table>

                    <div style="height:30px"></div>
                </div>
            </div>

            <div style="height:10px"></div>

            <div class="card border border-white">
                <div class="card-body">             
                    <h5 style="text-align:center">FORM RIWAYAT PINJAMAN GRUP USAHA</h5>
                    <div style="height:30px"></div>
                       
                    <input type="hidden" name="informasi_grup_usaha" value="{{ $informasi_grup_usaha ?? '' }}">
                                
                    <table class="table-hover" id="tambah_form" style="width:100%">
                        <tr>
                            <th>Nama Perusahaan</th>
                            <th>Fasilitas</th>
                            <th style="width:10%">Kol</th>
                            <th style="width:20%">Plafond</th>
                            <th style="text-align:right;"><button class="btn btn-danger btn-xs" type="button" id="form_add">Tambah</button></th>
                        </tr>
                    </table>
                </div>
            </div> 

            <div style="height:10px"></div>

            <div class="card border border-white">
                <div class="card-body">   

                    <?php $rowspan = $total_grup_usaha +5; ?>
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <th rowspan="{{ $rowspan }}" style="font-size:12px;">Total Fasilitas<br/> a/n Debitur beserta <br/>Group Usaha<br/> (one obligor concepts)</th>
                                <th style="width:40%">Nama Debitur & Group Usaha</th>
                                <th>Fasilitas</th>
                                <th>Kol</th>
                                <th>Plafond (eq. IDR)</th>
                            </tr>

                            <tr>
                                <td style="font-size: 11px;">{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr ?? '' }}</td>
                                <td style="font-size: 11px;">{{ \App\Models\ProductType::namaProduk($data->produk_id) ?? '' }}</td>
                                <td style="font-size: 11px;">{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->kol_di_bank_jtrust }}</td>
                                <td><input type="text" style="text-align:right; font-size: 11px;" id="plafond_debitur" value="{{ number_format($data->plafond) }}" class="form-control" readonly></td>
                            </tr>

                            @foreach($grup_usaha as $gu)
                            <tr>
                                <td style="font-size: 11px;">{{ $gu->nama_bpr }}</td>
                                <td style="font-size: 11px;">{{ $gu->fasilitas ?? '' }}</td>
                                <td style="font-size: 11px;">{{ $gu->kol_di_bank_jtrust }}</td>
                                <td style="font-size: 11px; text-align:right;"><input type="text" style="text-align:right; font-size: 11px;" id="plafond_debitur" class="form-control" readonly value=" {{ number_format($gu->plafond) }}"></td>
                            </tr>
                            @endforeach

                            <tr>
                                <td colspan="3" style="font-size: 11px;"><b>Total Plafon Debitur & Group Usaha </b></td>
                                <td><input type="text" style="text-align:right; font-size: 11px;" class="form-control" id="plafond_debitur_grup_usaha" value="{{ number_format($data->plafond + $plafond_debitur_grup_usaha) }}" readonly></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="font-size: 11px;"><b>Plafon Permohonan Debitur (Tambahan)(KAB)</b></td>
                                <td><input type="text" style="text-align:right; font-size: 11px;" class="form-control nominal" name="plafond_permohonan_debitur_tambahan_kab" id="plafond_tambahan"></td>
                            </tr>

                            <tr>
                                <td colspan="3" style="font-size: 11px;"><b>Total Plafond Setelah Tambahan</b></td>
                                <td><input type="text" class="form-control" style="text-align:right; font-size:11px" readonly id="total_plafond"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div style="height:20px"></div>
            
            <div class="card border border-white">
                <div class="card-body">    
                    <h5 style="text-align:center;">FORM BMPK</h5>

                    </div style="height:10px"></div>

                    <table class="table table-bordered table-responsive">
                        <tr>
                            <th rowspan="3">Batas Maksimum <br/>Pemberian Kredit (BMPK)</th>
                            <th style="width:15%" rowspan="2">Keterangan</th>
                            <th style="width:40%">BMPK</th>
                            <th colspan="2" style="width:45%">Inhouse Limit</th>
                        </tr>

                        <tr>
                            <td></td>
                            <td>%</td>
                            <td></td>
                        </tr>

                        <tr>
                            <td>Modal Inti Bank</td>
                            <td><input type="text" name="modal_inti_bank" id="modal_inti_bank" class="form-control nominal" style="text-align:right"></td>
                            <td style="text-align:right">100</td>
                            <td><input type="text" class="form-control" name="inhouse_modal_inti_bank" id="inhouse_modal_inti_bank" readonly style="text-align:right"></td>
                        </tr>

                        <tr>
                            <td>Posisi <div style="height:20px"></div><input type="date" name="tanggal_posisi" class="form-control"></td>
                            <td>Debitur Individu (25%)</td>
                            <td><input type="text" name="debitur_individu" id="debitur_individu" class="form-control nominal" style="text-align:right"></td>
                            <td style="text-align:right">80</td>
                            <td><input type="text" class="form-control" name="inhouse_debitur_individu" id="inhouse_debitur_individu" readonly style="text-align:right"></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>Debitur Group (25%)</td>
                            <td><input type="text" name="debitur_group" id="debitur_group" class="form-control nominal" style="text-align:right"></td>
                            <td style="text-align:right">80</td>
                            <td><input type="text" class="form-control" name="inhouse_debitur_group" id="inhouse_debitur_group" readonly style="text-align:right"></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td><input type="text" class="form-control total" readonly style="text-align:right"></td>
                        </tr>
                    </table>
              
                    <div style="height:30px"></div>
                </div>
            </div> 

            <div class="card border border-white">
                <div class="card-body">  
                    <h5 style="text-align:center;">HASIL BMPK</h5>
                    <div style="height:30px"></div>

                    <table class="table table-bordered table-responsive">
                        <tr>
                            <td>No</td>
                            <td>Tanggal Posisi</td>
                            <td>Modal Inti Bank</td>
                            <td>Inhouse Modal Inti Bank</td>
                            <td>Debitur Individu</td>
                            <td>Inhouse Debitur Individu</td>
                            <td>Debitur Group</td>
                            <td>Inhouse Debitur Group</td>
                            <td>Aksi</td>
                        </tr>

                        @foreach($bmpk as $key=>$d)
                        <tr>
                            <td>{{ ++$key }}</td>
                            <td>{{ ($d->tanggal_posisi == null) ? '' : date('d-m-Y', strtotime($d->tanggal_posisi))  }}</td>
                            <td style="text-align:right">Rp. {{ number_format($d->modal_inti_bank) }}</td>
                            <td style="text-align:right">Rp. {{ number_format($d->inhouse_modal_inti_bank) }}</td>
                            <td style="text-align:right">Rp. {{ number_format($d->debitur_individu) }}</td>
                            <td style="text-align:right">Rp. {{ number_format($d->inhouse_debitur_individu) }}</td>
                            <td style="text-align:right">Rp. {{ number_format($d->debitur_group) }}</td>
                            <td style="text-align:right">Rp. {{ number_format($d->inhouse_debitur_group) }}</td>
                            <td>
                                <a href="{{ url('edit-bmpk', [$d->id, $id]) }}" class="btn btn-success">Edit</a>
                                <a href="javascript:void(0);" id="reject" onClick="hapusBmpk({{ $d->id }})" class="hapus btn btn-danger">Hapus</a></td>
                            </td>
                        </tr>
                        @endforeach
                    </table>

                    <div style="height:30px"></div>

                    <h5 align="center">CATATAN BMPK</h5>
                    <div style="height:30px"></div>

                    <div class="form-group">
                        <textarea class="form-control {{ (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1) ? 'content' : 'read' }}" name="fasilitas_debitur" rows="6">{{ $data->fasilitas_debitur ?? '' }}</textarea>
                    </div>

                    @if (Auth::user()->jabatan_user->kode == 'account_officer' && $data->status_level_proses == 1)
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div>
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

function numberFormat(number)
{
    return number.toString().replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}

function imposeMinMax(el)
{
    if(parseInt(el.value) < parseInt(el.min))
        el.value = el.min;
    else if(parseInt(el.value) > parseInt(el.max))
        el.value = el.max;
}


$(document).ready(function(){

    var i = 0;

    $("#form_add").on("click", function() {
        var row = $("<tr>");
        var cols = "";
        cols += '<td><input type="text" name="nama_perusahaan[]" class="form-control" required>';
        cols += '<td><select class="form-control select" name="fasilitas[]"><option value="">Pilih</option>@foreach($produk as $p)<option value="{{ $p->id }}">{{ $p->product_title }}</option>@endforeach</select></td>';
        cols += '<td><input type="number" name="kol[]" min="1" max="5" onkeyup=imposeMinMax(this) class="form-control" style="text-align:right"></td>'
        cols += '<td><input type="text" name="plafond_satu[]" data-action="plafond" style="text-align:right" class="form-control nominal" required></td>'
        cols += '<td style="text-align:right"><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';

        row.append(cols);

        row.find('.nominal').on('change click keyup input paste',(function (event) {
            $(this).val(function (index, value) {
                return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        }));

        $("#tambah_form").append(row);
        i++;
    });

    $("#tambah_form").on("click", ".ibtnDel", function(_event) {
        $(this).closest("tr").remove();
        i -= 1
        hitung();
    });

    $('body').on('change keyup', '[data-action="plafond"], #plafond_debitur, #plafond_debitur_grup_usaha, #plafond_tambahan', function() {
        hitung();
    });

    function hitung()
    {
        var total = 0;

        var plafond_debitur = $('#plafond_debitur').val().replace(/[^0-9]/g, "");
        var plafond_debitur_grup_usaha = $('#plafond_debitur_grup_usaha').val().replace(/[^0-9]/g, "");
        var plafond_tambahan = $('#plafond_tambahan').val().replace(/[^0-9]/g, "");

        var totalitas = Number(plafond_debitur) + Number(plafond_debitur_grup_usaha) + Number(plafond_tambahan);

        $('[data-action="plafond"]').each(function(_i, e) {

            var val = Number(e.value.replace(/[^0-9,-]+/g,""));
            if (!isNaN(val))
                total += val;
        });

        $('#total_plafond').val(numberFormat(total + totalitas));
    }

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

function hapusBmpk(id)
{
    if (confirm("Are you sure want to delete this data ?") == true)

        var id = id;
        $.ajax({
            type:"POST",
            url: "{{ url('destroy-bmpk') }}",
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
</script>
@endpush
