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
        <h4>EDIT DEVIASI - {{ \App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr }}</h4>
        <div style="height:20px"></div>


            @include('flash-message')
            @include('error-message')



                                    <form action="{{ url('update-deviasi') }}" method="POST">@csrf
                                    <input type="hidden" name="id" value="{{ $data->id ?? ''  }}">
                                    <input type="hidden" name="nak_id" value="{{ $nak_id ?? '' }}">

                                    <div class="form-group row">
                                        <label class="col-md-3">Ketentuan</label>
                                            <div class="col-md-7">
                                            <textarea class="form-control" name="ketentuan" rows="10" required>{{ $data->ketentuan ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3">Deviasi</label>
                                            <div class="col-md-7">
                                            <textarea class="form-control" name="deviasi" rows="10" required>{{ $data->deviasi ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3">Pertimbangan dan Mitigasi</label>
                                            <div class="col-md-7">
                                            <textarea class="form-control" name="pertimbangan_dan_mitigasi" rows="10" required>{{ $data->pertimbangan_dan_mitigasi ?? '' }}</textarea>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Save</button>

							    </div>

</html>
@endsection

@push('scripts')
<script>

</script>
@endpush
