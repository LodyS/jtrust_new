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
        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">USULAN PERSETUJUAN KREDIT - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')
                @include('menu-lkk')
            </div> 
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <form action="{{ url('usulan-dan-persetujuan-kredit') }}" method="POST" name="form">@csrf
                    <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">

                    <table class="table">
                        <tr>
                            <th>No</th>
                            <th style="text-align:center">Usulan Fasilitas Kredit</th>
                            <th style="text-align:center">Usulan Bisnis Unit</th>
                            <th style="text-align:center">Rekomendasi CCRD</th>
                            <th style="text-align:center">Keputusan Komite</th>
                        </tr>

                        <tr>
                            <td>1</td>
                            <td>Jenis Fasilitas Kredit</td>
                            <td style="text-align:right">{{ $data->jenis_fasilitas_kredit }}</td>
                            <td style="text-align:right">{{ $crrd->jenis_fasilitas_kredit ?? '' }}</td>
                            <td>
                                <select class="form-control select" name="jenis_fasilitas_kredit" required>
                                    <option value="">Silahkan Pilih</option>
                                    @foreach ($jenis_fasilitas_kredit as $b)
                                        <option value="{{ $b->fasilitas_kredit }}" {{ ($b->fasilitas_kredit == optional($komite)->jenis_fasilitas_kredit) ? 'selected' : '' }}>{{ $b->fasilitas_kredit }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Limit Fasilitas Kredit</td>
                            <td style="text-align:right">Rp. {{ number_format($data->limit_fasilitas_kredit ?? 0) }}</td>
                            <td style="text-align:right">Rp. {{ ($crrd == null) ? 0 : number_format($crrd->limit_fasilitas_kredit ?? 0) }}</td>
                            <td><input type="text" style="text-align:right" class="form-control nominal" name="limit_fasilitas_kredit" value="{{ number_format($komite->limit_fasilitas_kredit ?? 0) }}" required></td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Sifat Fasilitas Kredit</td>
                            <td style="text-align:right">{{ $data->sifat_fasilitas_kredit ?? '' }}</td>
                            <td style="text-align:right">{{ $crrd->sifat_fasilitas_kredit ?? '' }}</td>
                            <td ><input type="text" class="form-control" name="sifat_fasilitas_kredit" value="{{ $komite->sifat_fasilitas_kredit ?? ''}}" style="text-align:right"></td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Tujuan Penggunaan</td>
                            <td style="text-align:right">{{ $data->tujuan_penggunaan ?? '' }}</td>
                            <td style="text-align:right">{{ $crrd->tujuan_penggunaan ?? '' }}</td>
                            <td><input type="text" class="form-control" name="tujuan_penggunaan" style="text-align:right" value="{{ $komite->tujuan_penggunaan ?? ''}}" required></td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Jangka Waktu Fasilitas Kredit</td>
                            <td style="text-align:right">{{ $data->jangka_waktu_fasilitas_kredit ?? '' }} bulan<br/>sejak tanggal efektif <br/>fasilitas kredit </td>
                            <td style="text-align:right">{{ $crrd->jangka_waktu_fasilitas_kredit ?? '' }} bulan<br/>sejak tanggal efektif <br/>fasilitas kredit </td>
                            <td><input type="text" class="form-control" style="text-align:right" name="jangka_waktu_fasilitas_kredit" value="{{ $komite->jangka_waktu_fasilitas_kredit ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Jangka Waktu Penarikan Fasilitas <br/>(Availibilty Period)</td>
                            <td style="text-align:right">Maks {{ $data->jangka_waktu_penarikan_fasilitas_kredit ?? '' }} bulan <br/>sejak tanggal efektif <br/> fasilitas kredit</td>
                            <td style="text-align:right">Maks {{ $crrd->jangka_waktu_penarikan_fasilitas_kredit ?? '' }} bulan<br/>sejak tanggal efektif <br/>fasilitas kredit</td>
                            <td style="text-align:right"><input type="text" class="form-control" style="text-align:right" name="jangka_waktu_penarikan_fasilitas_kredit" value="{{ $komite->jangka_waktu_penarikan_fasilitas_kredit ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>7</td>
                            <td>Jangka Waktu Angsuran</td>
                            <td style="text-align:right">{{ $data->tenor ?? '' }} bulan</td>
                            <td style="text-align:right">{{ $crrd->jangka_waktu_angsuran ?? '' }} bulan</td>
                            <td><input type="text" class="form-control" style="text-align:right" name="jangka_waktu_angsuran" value="{{ $komite->jangka_waktu_angsuran ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>8</td>
                            <td>Suku Bunga</td>
                            <td style="text-align:right">{{ $data->bunga ?? '' }} %</td>
                            <td style="text-align:right">{{ $crrd->suku_bunga ?? '' }} %</td>
                            <td><input type="text" class="form-control" name="suku_bunga" value="{{ $komite->suku_bunga ?? ''}}" style="text-align:right" required></td>
                        </tr>

                        <tr>
                            <td>9</td>
                            <td>Provisi</td>
                            <td style="text-align:right">{{ $data->provisi ?? '' }} %</td>
                            <td style="text-align:right">{{ $crrd->provisi ?? '' }} %</td>
                            <td><input type="text" class="form-control" name="provisi" value="{{ $komite->provisi ?? ''}}" style="text-align:right" required></td>
                        </tr>

                        <tr>
                            <td>10</td>
                            <td>Biaya Administrasi</td>
                            <td style="text-align:right">Rp. {{ number_format($data->biaya_administrasi) ?? 0}}</td>
                            <td style="text-align:right">Rp. {{ number_format($crrd->biaya_administrasi ?? 0) }}</td>
                            <td><input type="text" class="form-control nominal" name="biaya_administrasi" style="text-align:right" value="{{ number_format($komite->biaya_administrasi ?? 0) }}" required></td>
                        </tr>

                        <tr>
                            <td>11</td>
                            <td>Grace Period</td>
                            <td style="text-align:right">{{ $data->grace_period ?? '' }}</td>
                            <td style="text-align:right">{{ $crrd->grace_period ?? '' }}</td>
                            <td><input type="text" class="form-control" name="grace_period" value="{{ $komite->grace_period ?? ''}}" style="text-align:right"></td>
                        </tr>

                        <tr>
                            <td>12</td>
                            <td>Lain-lain</td>
                            <td style="text-align:right">{{ $data->lain_lain ?? ''}}</td>
                            <td style="text-align:right">{{ $crrd->lain_lain ?? ''}}</td>
                            <td><input type="text" class="form-control" name="lain_lain" value="{{ $komite->lain_lain ?? ''}}" style="text-align:right"></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><b>TOTAL FASILITAS KREDIT</b></td>
                            <td style="text-align:right">Rp. {{ number_format($data->plafond) ?? 0}}</td>
                            <td style="text-align:right">Rp. {{ number_format($crrd->total_fasilitas_kredit ?? 0)}}</td>
                            <td><input type="text" class="form-control nominal" name="total_fasilitas_kredit" style="text-align:right" value="{{ number_format($komite->total_fasilitas_kredit ?? 0) }}" required></td>
                        </tr>
                    </table>
                                                
                    <div style="height:30px"></div>

                    @if (Auth::user()->divisi == 'Credit Risk Reviewer')
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </form>
            </div>
        </div>
	</div>
</div>
@endsection

@push('scripts')
<script>
$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush
