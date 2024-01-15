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
        <h4 align="center">LEMBAR OPINI LEGAL - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}</h4>
        <div style="height:30px" align="centre"></div>
            <div>
            @include('list-menu')
            </div>

            <hr/>

            <div style="height:30px"></div>

            <form action="{{ url('lembar-opini-legal') }}" method="POST">@csrf
            <input type="hidden" name="loan_applicant_id" value="{{ $id ?? '' }}">
            <input type="hidden" name="id" value="{{ $opini->id ?? '' }}">
            <input type="hidden" name="aksi" value="{{ ($opini == null) ? 'create' : 'update' }}">
            <input type="hidden" name="tanggal" value="{{ date('Y-m-d') }}">

            @include('flash-message')
            <table class="table table-bordered">
                <tr>
                    <td colspan="1" style="text-align:center;"><b>LEMBAR OPINI ATAS USULAN KREDIT <br/>Corporate Legal and Litigation Division</b></td>

                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="5" style="text-align:center;">OPINI BIDANG HUKUM</th>
                </tr>

                <tr>
                    <td><textarea class="form-control content" name="lembar_opini">{{ $opini->lembar_opini ?? '' }}</textarea></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <th colspan="5" style="text-align:center;">Catatan</th>
                </tr>

                <tr>
                    <td><textarea class="form-control content" name="catatan">{{ $opini->catatan ?? '' }} </textarea></td>
                </tr>
            </table>

            <table class="table table-bordered">
                <tr>
                    <td colspan="5">Tanggal : {{ date('d') }}-{{ bulan(date('m')) }}-{{ date('Y')}}</td>
                </tr>

                <tr>
                    <td colspan="5">No Legal Opini : <input type="text" name="no_legal_opini" class="form-control" value="{{ $opini->no_legal_opini ?? '' }}"></td>
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

            @if(Auth::user()->divisi == 'Legal' && $data->legal_section_head == null)
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            @elseif($data->return_opini_legal == 'Yes')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            @endif


        </form>
    </div>
</div>
</html>
@endsection

