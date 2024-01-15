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
        <h4 class="modal-title">LEMBAR OPINI - LEGAL</h4>

        <span style="float:right;">
            <a href="{{ url('print-opini-legal', $data->id)}}" class="btn btn-primary btn-sm" align="right"> <i data-feather="printer"></i></a>
        </span>

        <div style="height:40px" align="centre"></div>
            <form action="{{ url('lembar-opini-legal') }}" method="POST">@csrf
            <input type="hidden" name="loan_applicant_id" value="{{ $data->id }}">
            <input type="hidden" name="aksi" value="edit">

            <input type="hidden" name="section_head" value="{{ $sectionHead->id ?? '' }}">
            <input type="hidden" name="division_head" value="{{ $divisionHead->id ?? '' }}">
            <input type="hidden" name="tanggal" value="{{ $opini->tanggal ?? ''}}">
            <input type="hidden" name="no_legal_opini" value="{{ $opini->no_legal_opini ?? '' }}">

            @include('flash-message')
            <br/>
            @include('list-menu')
            <div style="height:20px"></div>

            <table class="table table-bordered">
                <tr>
                    <td colspan="1" style="text-align:center;"><b>LEMBAR OPINI ATAS USULAN KREDIT <br/>Corporate Legal and Litigation Division</b></td>
                </tr>
            </table>


            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">OPINI BIDANG HUKUM</th>
                    <th colspan="5" style="text-align:center;"></th>
                </tr>

                <tr>
                    <td>
                        @if(Auth::user()->jabatan_user->nama_jabatan == 'Legal Section Head')
                        <textarea class="form-control content" name="lembar_opini">{{ $opini->lembar_opini ?? '' }}</textarea>
                        @else
                        <textarea class="form-control read" name="lembar_opini">{{ $opini->lembar_opini ?? '' }}</textarea>
                        @endif
                    </td>
                </tr>
            </table>

            <table class="table table-bordered table-sm wrap">
                <tr>
                    <th colspan="5" style="text-align:center;">Catatan</th>
                </tr>

                <tr>
                    <td>
                        @if(Auth::user()->jabatan_user->nama_jabatan == 'Legal Section Head')
                            <textarea class="form-control content" name="catatan">{{ $opini->catatan ?? '' }}</textarea>
                        @else
                            <textarea class="form-control read" name="catatan">{{ $opini->catatan ?? '' }}</textarea>
                        @endif
                    </td>
                </tr>
            </table>

            @if(Auth::user()->jabatan_user->nama_jabatan == 'Legal Section Head' && $opini->status == 'Return To Legal Opinion')
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
            @endif


        </form>
    </div>
</div>
</html>
@endsection
