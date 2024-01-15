<?php $model = \App\Models\InformasiPokokBprPelapor::namaBpr($variable['data']->sandi_bpr); ?>

<div class="card border-white">
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th colspan="4" style="text-align:center">INFORMASI NASABAH</th>
            </tr>

            <tr>
                <td>Nama BPR</td>
                <td width="70%">{{ $model->nama_bpr ?? '' }}</td>
            </tr>
            <tr>
                <td>No. Telepon</td>
                <td>{{ $model->no_telepon ?? '' }}</td>
            </tr>

            <tr>
                <td>Alamat</td>
                <td>{{ $model->alamat_bpr ?? '' }}<br/> {{ $model->kabupaten_kota_bpr ?? '' }}</td>
            </tr>

            <tr>
                <td>Plafond</td>
                <td>{{ ($variable['data']->pengajuan_induk_id == null) ? number_format($variable['data']->plafond) : number_format($variable['data']->baki_debet)  }}</td>
            </tr>

            <tr>
                <td>Tenor</td>
                <td>{{ $variable['data']->tenor ?? $variable['data']->tenor_perpanjang  }} bulan</td>
            </tr>

            <tr>
                <td>Account Officer</td>
                <td>{{ \App\Models\User::username($variable['data']->user_id)->name ?? '' }}</td>
            </tr>
        </table>

        <div style="height:30px"></div>

        <table class="table table-hover">
            <tr>
                <th colspan="4" style="text-align:center">HISTORI APPROVAL</th>
            </tr>

            <tr>
                <th>Tanggal Proses</th>
                <th>PIC</th>
                <th>Catatan</th>
                <th>Status</th>
            </tr>

            @foreach($variable['statusApplicant'] as $d)
                <tr>
                    <td width="10%">{{ \Carbon\Carbon::parse($d->tanggal_proses)->format('d-m-Y | H:i') }}</td>
                    <td width="10%">{{ $d->userProses->name }} <div style="height:10px"></div> {{ $d->userr->jabatan_user->nama_jabatan }}</td>
                    <td>{{ $d->catatan }}</td>
                    <td width="10%">
                        @if($d->status == 'Direkomendasi' or $d->status == 'Completed' or $d->status == 'Disetujui')
                            <div class="alert alert-icon-success" role="alert">{{ $d->status }}</div>
                        @elseif($d->status == 'Tidak Direkomendasikan' || $d->status == 'Tidak Disetujui')
                            <div class="alert alert-icon-danger" role="alert">{{ $d->status }}</div>
                        @else
                            <div class="alert alert-icon-warning" role="alert">{{ $d->status }}</div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>

        <div style="height:30px"></div>
    </div> 
</div>