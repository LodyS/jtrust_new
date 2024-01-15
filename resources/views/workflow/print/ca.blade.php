<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<title>KREDITEK FINANCIAL ACCESS</title>
<!--<div class="card border-white" style="width: 100rem;">-->
    <div class="card" style="width: 1260px;">
        <div class="card-body">

            <table class="table table-bordered">
                <tr>
                    <td colspan="1" style="text-align:center;"><b>KAJIAN OPINI ATAS USULAN KREDIT <br/><i>Credit Administration Unit</i></b></td>
                </tr>
            </table>


            <table class="table table-bordered">
                <tr>
                    <td>
                        <ul>
                            <li>Rekomendasi dan mitigasi di bawah ini adalah kesimpulan dan catatan yang didapat sesuai dengan kajian atas dokumen,
                            <br/>informasi serta data yang disampaikan
                            oleh pihak pengusul kredit dalam bentuk; <br/>Dokumen NAK, Dokumen Pendukung lainnya serta
                            penjelasan lisan dalam forum RATEK.</li>

                            <br/>

                            <li>Validitas dan verifikasi atas kebenaran, keakuratan dan kekinian atas data, <br/>dokumen serta bentuk lain
                            informasi yang disampaikan sepenuhnya menjadi tanggung jawab Pengusul.</li>

                            <br/>

                            <li>Fokus Agunan <br/>

                            </li>
                        </ul>
                    </td>
                </tr>
            </table>

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
                    <td>{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr ?? ''}}</td>
                </tr>

                <tr>
                    <td width="30%">Alamat</td>
                    <td>{{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->alamat_bpr ?? '' }}</td>
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
                    <td><textarea class="form-control content" name="penjelasan_agunan_fixed_asset" readonly>{{ strip_tags($opini->penjelasan_agunan_fixed_asset ?? '' ) ?? '' }}</textarea></td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Fixed Asset Non Marketable</th>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Agunan Tidak Memiliki Akses Jalan" {{ str_contains($opini->fixed_asset_non_marketable, 'Agunan Tidak Memiliki Akses Jalan') ? 'checked' : '' }} disabled> Agunan Tidak Memiliki Akses Jalan </label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Daerah Hitam" {{ str_contains($opini->fixed_asset_non_marketable, 'Daerah Hitam') ? 'checked' : '' }} disabled> Daerah Hitam</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Dekat Kabel Terluar Tegangan Tinggi, BTS, Rel Kereta dan Pipas Gas(-/+25)" {{ str_contains($opini->fixed_asset_non_marketable, 'Dekat Kabel Terluar Tegangan Tinggi, BTS, Rel Kereta dan Pipas Gas(-/+25)') ? 'checked' : '' }} disabled> Dekat Kabel Terluar Tegangan Tinggi, BTS, Rel Kereta dan Pipas Gas(-/+25)</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Daerah Rawan Longsor" {{ str_contains($opini->fixed_asset_non_marketable, 'Daerah Rawan Longsor') ? 'checked' : '' }} disabled> Daerah Rawan Longsor</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Akses Jalan Berupa Gang" {{ str_contains($opini->fixed_asset_non_marketable, 'Akses Jalan Berupa Gang') ? 'checked' : '' }} disabled> Akses Jalan Berupa Gang</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Agunan Dipergunakan Untuk Kepentingan Umum" {{ str_contains($opini->fixed_asset_non_marketable, 'Agunan Dipergunakan Untuk Kepentingan Umum') ? 'checked' : '' }} disabled> Agunan Dipergunakan Untuk Kepentingan Umum</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Lokasi Jaminan Tidak Mendapat Ijin Mendirikan Bangunan Permanen" {{ str_contains($opini->fixed_asset_non_marketable, 'Lokasi Jaminan Tidak Mendapat Ijin Mendirikan Bangunan Permanen') ? 'checked' : '' }} disabled> Lokasi Jaminan Tidak Mendapat Ijin Mendirikan Bangunan Permanen</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Jaminan Sedang Dalam Status Sengketa" {{ str_contains($opini->fixed_asset_non_marketable, 'Jaminan Sedang Dalam Status Sengketa') ? 'checked' : '' }} disabled> Jaminan Sedang Dalam Status Sengketa</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Dekat TPA/TPU(+/- 150)" {{ str_contains($opini->fixed_asset_non_marketable, 'Dekat TPA/TPU(+/- 150)') ? 'checked' : '' }} disabled> Dekat TPA/TPU(+/- 150)</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Bukti Kepemilikan Telah Jatuh Tempo" {{ str_contains($opini->fixed_asset_non_marketable, 'Bukti Kepemilikan Telah Jatuh Tempo') ? 'checked' : '' }} disabled> Bukti Kepemilikan Telah Jatuh Tempo</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Dekat Bantaran Sungai" {{ str_contains($opini->fixed_asset_non_marketable, 'Dekat Bantaran Sungai') ? 'checked' : '' }} disabled> Dekat Bantaran Sungai</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Jaminan Terkena Proyek Peremajaan Kota Yang Menjadikan Agunan Tidak Proposional"  {{ str_contains($opini->fixed_asset_non_marketable, 'Jaminan Terkena Proyek Peremajaan Kota Yang Menjadikan Agunan Tidak Proposional') ? 'checked' : '' }} disabled> Jaminan Terkena Proyek Peremajaan Kota Yang <br/>Menjadikan Agunan Tidak Proposional</label></td>
                </tr>

                <tr>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Agunan Berada Di Tepi Laut (<20m)" {{ str_contains($opini->fixed_asset_non_marketable, 'Agunan Berada Di Tepi Laut (<20m)') ? 'checked' : '' }} disabled> Agunan Berada Di Tepi Laut (<20m)</label></td>
                    <td> <label><input type="checkbox" name="fixed_asset_non_marketable[]" value="Letak Fisik Berbeda Dengan Bukti Kepemilikan" {{ str_contains($opini->fixed_asset_non_marketable, 'Letak Fisik Berbeda Dengan Bukti Kepemilikan') ? 'checked' : '' }} disabled> Letak Fisik Berbeda Dengan Bukti Kepemilikan</label></td>
                </tr>
            </table>

            <div style="height:30px"></div>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Opini</th>
                </tr>

                <tr>
                    <td><textarea class="form-control content" name="opini" readonly>{{ strip_tags($opini->opini) ?? '' }}</textarea></td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <td colspan="5">Tanggal : {{ date('d', strtotime($opini->created_at)) }}-{{ bulan(date('m', strtotime($opini->created_at))) }}-{{ date('Y', strtotime($opini->created_at))}}</td>
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

            </table>
        </div>
    </div>
</div>

<script>
window.print();
</script>
