<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h5 align="center">AGUNAN - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($dataa->sandi_bpr)->nama_bpr) }}</h5>

        <div style="height:30px"></div>

        @include('flash-message')

        <div class="card border-white">
			<div class="card-body">
                @include('menu-lkk')
            </div> 
        </div>

        <div style="height:10px"></div>

        <form action="{{ url('save-agunan') }}" method="POST">@csrf

            <div style="height:30px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-hover" id="tambah_form">
                            <tr>
                                <th>Jenis Agunan</th>
                                <th>Nilai Pasar</th>
                                <th>Nilai Bank</th>
                                <th>Nilai Pengikat</th>
                            </tr>

                            @forelse($data as $a)
                                <tr>
                                    <td>{{ $a->jenis_agunan }}</td>
                                    <td>Rp. {{ number_format($a->nilai_pasar) }}</td>
                                    <td>Rp. {{ number_format($a->nilai_bank) }}</td>
                                    <td>{{ $a->nilai_pengikat }}</td>
                                </tr>
                            @empty

                            @endforelse
                        </table>
                    </div> 
                </div>
            </div>
             
            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">

                    <p align="justify">
                        Fasilitas {{ $jenis_fasilitas_kredit  }}
                        {{ $jenis_fasilitas_kredit  }} yang diajukan debitur sebesar Rp. {{ number_format($dataa->plafond) ?? '' }} dengan SCR
                        {{ $dataa->bunga ?? '' }} % berdasarkan RAC BJI PT.
                        {{ \App\Models\InformasiPokokBprPelapor::namaBpr($dataa->sandi_bpr)->nama_bpr ?? '' }}
                        termasuk dalam tier 1
                    </p>
                                                    
                    <p align="justify">
                        Piutang yang dijadikan jaminan ke BJI adalah piutang kepada PNS atau ASN aktif dan atau pensiunan
                        dengan sumber pembiayaan dari gaji dan atau uang pensiunan
                    </p>

                    <p align="justify">
                        Jaminan yang dapat dijaminkan harus dalam kondisi lancar dan tidak sedang dalam keadaan
                        dijaminkan atau dijadikan jaminan kepada pihak lain
                    </p>
                </div> 
            </div>
        </form>
	</div>
</div>
@endsection


