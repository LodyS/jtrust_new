<!DOCTYPE html>
@extends('tema.app')
@section('content')

<style>
.v4 { list-style: none outside none; margin:0; padding: 0; text-align: center }
.inline { display: inline; margin: 0 10px; }

.feather {
    width:16px;
    height:10px;
}

</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <div class="card border-white">
			<div class="card-body">
                <h5 align="center">REKOMENDASI - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h5>

                <div style="height:30px"></div>

                @include('flash-message')
                @include('error-message')
        		@include('menu-arr')
			</div> 
		</div>

        <div style="height:10px"></div>

        <form action="{{ url('arr-rekomendasi') }}" method="POST" enctype="multipart/form-data">@csrf
            <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? ''  }}">
            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">

            <div class="card border-white">
                <div class="card-body">
                    <table class="table table">
                        <tr>
                            <td style="text-align:center;" colspan="4"><b>USULAN DAN PERSETUJUAN KREDIT</b></td>
                        </tr>

                        <tr>
                            <th>No</th>
                            <th>Usulan Fasilitas Kredit</th>
                            <th>Usulan Bisnis Unit</th>
                            <th>Rekomendasi CCRD</th>
                        </tr>

                        <tr>
                            <td>1</td>
                            <td>Jenis Fasilitas Kredit</td>
                            <td style="text-align:right">{{ $data->jenis_fasilitas_kredit ?? '' }}</td>
                            <td> 
                                <select class="form-control select" name="jenis_fasilitas_kredit" required>
                                    <option value="">Silahkan Pilih</option>
                                    @foreach ($jenis_fasilitas_kredit as $b)
                                        <option value="{{ $b->fasilitas_kredit }}" {{ ($keterangan->jenis_fasilitas_kredit == $b->fasilitas_kredit)?'selected':''}}>{{ $b->fasilitas_kredit }}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>2</td>
                            <td>Limit Fasilitas Kredit</td>
                            <td style="text-align:right">Rp. {{ number_format($data->limit_fasilitas_kredit) ?? ''}}</td>
                            <td><input type="text" style="text-align:right" class="form-control nominal" name="limit_fasilitas_kredit" value="{{ number_format($keterangan->limit_fasilitas_kredit ?? 0) }}"></td>
                        </tr>

                        <tr>
                            <td>3</td>
                            <td>Sifat Fasilitas Kredit</td>
                            <td style="text-align:right">{{ $data->sifat_fasilitas_kredit ?? '' }}</td>
                            <td><input type="text" style="text-align:right" class="form-control" name="sifat_fasilitas_kredit" value="{{ $keterangan->sifat_fasilitas_kredit ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>4</td>
                            <td>Tujuan Penggunaan</td>
                            <td style="text-align:right">{{ $data->tujuan_penggunaan ?? '' }}</td>
                            <td><input type="text" style="text-align:right" class="form-control" name="tujuan_penggunaan" value="{{ $keterangan->tujuan_penggunaan ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>5</td>
                            <td>Jangka Waktu Fasilitas Kredit</td>
                            <td style="text-align:right">{{ $data->jangka_waktu_fasilitas_kredit ?? '' }} bulan<br/>sejak tanggal efektif <br/>fasilitas kredit </td>
                            <td><input type="text" style="text-align:right" class="form-control" name="jangka_waktu_fasilitas_kredit" value="{{ $keterangan->jangka_waktu_fasilitas_kredit ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>6</td>
                            <td>Jangka Waktu Penarikan Fasilitas <br/>(Availibilty Period)</td>
                            <td style="text-align:right">Maks {{ $data->jangka_waktu_penarikan_fasilitas_kredit ?? '' }} bulan <br/>sejak tanggal efektif <br/> fasilitas kredit</td>
                            <td><input type="text" style="text-align:right" class="form-control" name="jangka_waktu_penarikan_fasilitas_kredit" value="{{ $keterangan->jangka_waktu_penarikan_fasilitas_kredit ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>7</td>
                            <td>Jangka Waktu Angsuran</td>
                            <td style="text-align:right">{{ $data->tenor ?? '' }} bulan</td>
                            <td><input type="text" style="text-align:right" class="form-control" name="jangka_waktu_angsuran" value="{{ $keterangan->jangka_waktu_angsuran ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>8</td>
                            <td>Suku Bunga</td>
                            <td style="text-align:right">{{ $data->bunga ?? '' }} %</td>
                            <td><input type="text" class="form-control" style="text-align:right" name="suku_bunga" value="{{ $keterangan->suku_bunga ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>9</td>
                            <td>Provisi</td>
                            <td style="text-align:right">Rp. {{ number_format($data->provisi ?? 0) }} </td>
                            <td><input type="text" class="form-control nominal" style="text-align:right" name="provisi" value="{{ $keterangan->provisi ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>10</td>
                            <td>Biaya Administrasi</td>
                            <td style="text-align:right">Rp. {{ number_format($data->biaya_administrasi) ?? ''}}</td>
                            <td><input type="text" class="form-control nominal" style="text-align:right" name="biaya_administrasi" value="{{ number_format($keterangan->biaya_administrasi ?? 0) }}"></td>
                        </tr>

                        <tr>
                            <td>11</td>
                            <td>Grace Period</td>
                            <td style="text-align:right">{{ $data->grace_period ?? '' }}</td>
                            <td><input type="text" class="form-control" name="grace_period" style="text-align:right" value="{{ $keterangan->grace_period ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td>12</td>
                            <td>Lain-lain</td>
                            <td style="text-align:right">{{ $data->lain_lain ?? ''}}</td>
                            <td><input type="text" class="form-control" name="lain_lain" style="text-align:right" value="{{ $keterangan->lain_lain ?? ''}}"></td>
                        </tr>

                        <tr>
                            <td></td>
                            <td><b>TOTAL FASILITAS KREDIT</b></td>
                            <td style="text-align:right">Rp. {{ number_format($data->plafond) ?? ''}}</td>
                            <td><input type="text" class="form-control nominal" style="text-align:right" name="total_fasilitas_kredit" value="{{ number_format($keterangan->total_fasilitas_kredit ?? 0) }}"></td>
                        </tr>
                    </table>

                    <div style="height:10px"></div>

                    <div class="form-group">
                        <textarea class="form-control content" name="keterangan"  rows="6">{{ $keterangan->keterangan ?? '' }}</textarea>
                    </div>

                    @if(Auth::user()->divisi == 'Credit Risk Reviewer' && $data->crrd_section_head == null)
                        <button type="submit" class="btn btn-primary">Save</button>
                    @endif
                </div> 
            </div>
        </form>
	</div>
</html>
@endsection

@push('scripts')
<script>
$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

</script>
@endpush
