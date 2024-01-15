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
        <?php $query_param = \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr);?>
        <h4 class="modal-title">LEMBAR OPINI - CREDIT ADMINISTRATION - {{ $query_param->nama_bpr ?? '' }}</h4>

        @if($opini)
        <span style="float:right;">
            <a href="{{ url('print-opini-credit-administration', $data->id)}}" class="btn btn-primary btn-sm" align="right"> Print</a>
        </span>
        @endif

        <div style="height:30px"></div>
            <div>
            @include('list-menu')
            </div>

            <div style="height:40px"></div>

            <form action="{{ url('lembar-opini-cad') }}" method="POST">@csrf
            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
            <input type="hidden" name="aksi" value="create">

            @include('flash-message')

            <hr/>
                <h5 align="center">KAJIAN OPINI ATAS USULAN KREDIT <br/><i>Credit Administration Unit</i></h5><hr/>
               

         
            <p align="justify" style="position:relative; left:3%">Rekomendasi dan mitigasi di bawah ini adalah kesimpulan dan catatan yang didapat sesuai dengan kajian atas dokumen,
            <br/>informasi serta data yang disampaikan oleh pihak pengusul kredit dalam bentuk; <br/>Dokumen NAK, Dokumen Pendukung lainnya serta
            penjelasan lisan dalam forum RATEK.<br/>

            Validitas dan verifikasi atas kebenaran, keakuratan dan kekinian atas data, <br/>dokumen serta bentuk lain
            informasi yang disampaikan sepenuhnya menjadi tanggung jawab Pengusul.<br/>

            Fokus Bidang Hukum : <br/>

            </p>

            <div style="height:30px"></div>
            
            <p style="position:relative; left:4%">
                    <b>Legalitas</b>, yang berupa kelengkapan dan kesesuaian dokumen legalitas atas subyek hukum, <br/>badan usaha,perijinan, dan agunan.<br/>
                    <b>Risiko Hukum</b>, yang berupa potensi dan/atau indikasi potensi masalah atau sengketa hukum <br/>
                        terkait status kepemilikan, subyek hukum, perijinan, dan agunan.
                </ul>
            </p>

            <div style="height:30px"></div>

            <table class="table table-bordered table-sm">
                <tr>
                    <th colspan="3" style="text-align:center;">PENGUSUL KREDIT</th>
                </tr>

                <tr>
                    <td width="30%">Nama RM/BM/AO</td>
                    <td>{{ \App\User::username($data->user_id)->name ?? '' }}</td>
                </tr>

                <tr>
                    <td width="30%">Nama SRM/SBM/TL</td>
                    <td>{{ \App\User::depHead($data->user_id) ?? '' }}</td>
                </tr>

                <tr>
                    <td width="30%">Segmen Pengelola/Bussiness Unit</td>
                    <td>-</td>
                </tr>

                <tr>
                    <td width="30%">Nomor NAK</td>
                    <td>{{ $data->no_nak_long_form ?? '' }}</td>
                </tr>

                <tr>
                    <td width="30%">Tanggal NAK</td>
                    <td>{{ date('d') }} {{ bulan(date('m')) }} {{ date('Y') }}</td>
                </tr>

                <tr>
                    <td width="30%">Perihal</td>
                    <td>@foreach($jenis_pengajuan as $d) {{ $d  }}<br/>@endforeach</td>
                </tr>
            </table>

            <table class="table table-bordered table-sm">
                <tr>
                    <th colspan="3" style="text-align:center;">INFORMASI DEBITUR/CALON DEBITUR</th>
                </tr>

                <tr>
                    <td width="30%">Nama</td>
                    <td>{{ $query_param->nama_bpr ?? ''}}</td>
                </tr>

                <tr>
                    <td width="30%">Alamat</td>
                    <td>{{ $query_param->alamat_bpr ?? '' }}</td>
                </tr>
            </table>

            <div style="height:30px"></div>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Informasi Agunan Fixed Asset</th>
                </tr>

                <tr>
                    <th colspan="3">Penjelasan Agunan Fixed Asset</th>
                    <th colspan="2">Review Internal :</th>
                </tr>

                <tr>
                    <td>Jenis Agunan</td>
                    <td>Alamat</td>
                    <td>Nilai Pasar</td>
                    <td colspan="2">Nilai Pasar</td>
                </tr>

                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td colspan="2"></td>
                </tr>

                <tr>
                    <td colspan="2" style="text-align:center;">Jumlah</td>
                    <td></td>
                    <td colspan="2"></td>
                </tr>
            </table>

            <div style="height:30px"></div>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Penjelasan Agunan Fixed Asset</th>
                </tr>

                <tr>
                    <td>
                        @if($hak_akses == 'Yes')
                            <textarea class="form-control content" name="penjelasan_agunan_fixed_asset">{{ $opini->penjelasan_agunan_fixed_asset ?? '' }}</textarea>
                        @else
                            <textarea class="form-control read" name="penjelasan_agunan_fixed_asset">{{ $opini->penjelasan_agunan_fixed_asset ?? '' }}</textarea>
                        @endif
                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Fixed Asset Non Marketable</th>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Agunan Tidak Memiliki Akses Jalan" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Agunan Tidak Memiliki Akses Jalan') ? 'checked' : '' }}@endif> Agunan Tidak Memiliki Akses Jalan </label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Daerah Hitam" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Daerah Hitam') ? 'checked' : '' }}@endif> Daerah Hitam</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Dekat Kabel Terluar Tegangan Tinggi, BTS, Rel Kereta dan Pipas Gas(-/+25)" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Dekat Kabel Terluar Tegangan Tinggi, BTS, Rel Kereta dan Pipas Gas(-/+25)') ? 'checked' : '' }}@endif> Dekat Kabel Terluar Tegangan Tinggi, BTS, Rel Kereta dan Pipas Gas(-/+25)</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Daerah Rawan Longsor" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Daerah Rawan Longsor') ? 'checked' : '' }}@endif> Daerah Rawan Longsor</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Akses Jalan Berupa Gang" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Akses Jalan Berupa Gang') ? 'checked' : '' }}@endif> Akses Jalan Berupa Gang</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Agunan Dipergunakan Untuk Kepentingan Umum" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Agunan Dipergunakan Untuk Kepentingan Umum') ? 'checked' : '' }}@endif> Agunan Dipergunakan Untuk Kepentingan Umum</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Lokasi Jaminan Tidak Mendapat Ijin Mendirikan Bangunan Permanen" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Lokasi Jaminan Tidak Mendapat Ijin Mendirikan Bangunan Permanen') ? 'checked' : '' }}@endif> Lokasi Jaminan Tidak Mendapat Ijin Mendirikan Bangunan Permanen</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Jaminan Sedang Dalam Status Sengketa" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Jaminan Sedang Dalam Status Sengketa') ? 'checked' : '' }}@endif> Jaminan Sedang Dalam Status Sengketa</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Dekat TPA/TPU(+/- 150)" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Dekat TPA/TPU(+/- 150)') ? 'checked' : '' }}@endif> Dekat TPA/TPU(+/- 150)</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Bukti Kepemilikan Telah Jatuh Tempo" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Bukti Kepemilikan Telah Jatuh Tempo') ? 'checked' : '' }}@endif> Bukti Kepemilikan Telah Jatuh Tempo</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Dekat Bantaran Sungai" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Dekat Bantaran Sungai') ? 'checked' : '' }}@endif> Dekat Bantaran Sungai</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Jaminan Terkena Proyek Peremajaan Kota Yang Menjadikan Agunan Tidak Proposional"  @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Jaminan Terkena Proyek Peremajaan Kota Yang Menjadikan Agunan Tidak Proposional') ? 'checked' : '' }}@endif> Jaminan Terkena Proyek Peremajaan Kota Yang <br/>Menjadikan Agunan Tidak Proposional</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Agunan Berada Di Tepi Laut (<20m)" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Agunan Berada Di Tepi Laut (<20m)') ? 'checked' : '' }}@endif> Agunan Berada Di Tepi Laut (<20m)</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Letak Fisik Berbeda Dengan Bukti Kepemilikan" @if($opini){{ str_contains($opini->fixed_asset_non_marketable, 'Letak Fisik Berbeda Dengan Bukti Kepemilikan') ? 'checked' : '' }}@endif> Letak Fisik Berbeda Dengan Bukti Kepemilikan</label></td>
                </tr>
            </table>

            <div style="height:30px"></div>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Opini</th>
                </tr>

                <tr>
                    <td>
                        @if(Auth::user()->jabatan_user->nama_jabatan == 'Credit Administration Section Head')
                        <textarea class="form-control content" name="opini">{{$opini->opini ?? '' }}</textarea>
                        @else
                        <textarea class="form-control read" name="opini">{{$opini->opini ?? '' }}</textarea>
                        @endif
                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <td colspan="5">Tanggal : {{ date('d') }}-{{ bulan(date('m')) }}-{{ date('Y')}}</td>
                </tr>

                <tr>
                    <td colspan="5">Dibuat oleh</td>
                </tr>

                <tr>
                    <td colspan="2"></td>
                    <td colspan="3">Menyetujui <div style="height:30px"></div></td>
                </tr>

                <tr>
                    <td colspan="2"><input type="hidden" name="section_head" value="{{ $sectionHead->id ?? '' }}">{{ $sectionHead->name ?? '' }}</td>
                    <td colspan="3"><input type="hidden" name="division_head" value="{{ $divisionHead->id ?? '' }}">{{ $divisionHead->name ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="2">Section Head </td>
                    <td colspan="3">Division Head</td>
                </tr>

            </table>

            @if ($opini == null)
                @if($hak_akses == 'Yes')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                @endif
            @else
                @if($data->return_opini_cad == 'Yes' && $hak_akses == 'Yes')
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
                @endif
            @endif

        </form>
    </div>
</div>
</html>
@endsection

