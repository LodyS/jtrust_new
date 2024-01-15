@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 align="center">PROSES WORKFLOW - {{ strtoupper(Auth::user()->jabatan_user->nama_jabatan) }} </h4>

            @include('flash-message')
            <div style="height:10px"></div>

            @include('workflow/informasi-workflow')

            <div style="height:10px"></div>

            <div class="card border-white">
				<div class="card-body">
                    <form action="{{ url('proses-workflow') }}" method="POST" name="form">@csrf

                        <input type="hidden" name="level_id" value="{{ $setting_flow->level }}" readonly>
                        <input type="hidden" name="loan_applicant_id" value="{{ $variable['data']->uuid }}">
                        <input type="hidden" name="divisi" value="{{ $setting_flow->divisi }}">

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Status</label>
                                    <select name="status" class="form-control" required>
                                    <option>Pilih</option>
                                    @if($setting_flow->level > 1)
                                    
                                        @if($setting_flow->approval_status == 'Yes')
                                            <option value="Disetujui">Disetujui</option>
                                            <option value="Tidak Disetujui">Tidak Disetujui</option>
                                        @else
                                            <option value="Direkomendasi">Direkomendasikan</option>
                                            <option value="Tidak Direkomendasikan">Tidak Direkomendasikan</option>
                                        @endif
                                        
                                        <option value="Return to AO">Return To AO</option>
                                    
                                        @if($setting_flow->return_legal_opini == 'Yes')
                                            <option value="Return To Legal Opinion">Return To Legal Opinion</option>
                                        @endif
        
                                        @if($setting_flow->return_compliance_opini == 'Yes')
                                            <option value="Return To Compliance Opini">Return To Compliance Opini</option> 
                                        @endif
                                        
                                        @if($setting_flow->return_worksheet_screening == 'Yes')
                                            <option value="Return Worksheet Screening">Return Worksheet Screening</option>
                                        @endif

                                        @if($setting_flow->return_cad_opini == 'Yes')
                                            <option value="Return To CAD Opini">Return To CAD Opini</option>
                                        @endif
                                    @else
                                        <option value="Completed" selected>Completed (data sudah lengkap)</option>
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Catatan </label>
                                <textarea class="form-control" name="catatan" rows="6" required></textarea>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div> 
            </div>
	    </div>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});
</script>
@endpush