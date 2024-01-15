@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>{{ $aksi }} Setting Flow</h4>

        <div style="height:40px" align="centre"></div>

        <form action="{{ ($aksi == 'Create') ? route('setting-flow.store') : route('setting-flow.update', [$data->id]) }}" method="POST">@csrf
        @include('flash-message')

        @if($aksi == 'Update')
            @method('PUT')
        @endif

        <input type="hidden" name="tabel" value="user">
        <input type="hidden" name="aksi" value="{{ $aksi }}">
        <input type="hidden" name="id" value="{{ optional($data)->id }}">

        <div class="form-group row">
		    <label class="col-md-3">Divisi</label>
			    <div class="col-md-7">
                <select name="divisi" class="form-control select">
                    <option value="">Pilih</option>
                    <option value="Business Division" {{ (optional($data)->divisi == 'Business Division')?'selected':''}}>Business Division</option>
                    <option value="Legal" {{ (optional($data)->divisi == 'Legal')?'selected':''}}>Legal</option>
                    <option value="Compliance" {{ (optional($data)->divisi == 'Compliance')?'selected':''}}>Compliance</option>
                    <option value="Credit Administration" {{ (optional($data)->divisi == 'Credit Administration')?'selected':''}}>Credit Administration</option>
                    <option value="Credit Risk Reviewer" {{ (optional($data)->divisi == 'Credit Risk Reviewer')?'selected':''}}>Credit Risk Reviewer</option>
                </select>
		    </div>
	    </div>
        
        <div class="form-group row">
		    <label class="col-md-3">Jabatan</label>
			    <div class="col-md-7">
                <select name="jabatan_id" class="form-control select2" required>
                    <option value="">Pilih</option>
                    @foreach($jabatan as $j)
                    <option value="{{ $j->id }}" {{ (optional($data)->jabatan_id == $j->id)?'selected':''}}>{{ $j->nama_jabatan }}</option>
                    @endforeach
                </select>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Level</label>
			    <div class="col-md-7">
                <input type="number" class="form-control" name="level" value="{{ optional($data)->level }}" required>
		    </div>
	    </div>

        <div class="form-group row">
            <label class="col-sm-3">Approval Status</label>
            <div class="col-md-7">
               
                <input type="radio" value="Yes" {{ (optional($data)->approval_status=="Yes")? "checked" : "" }} name="approval_status" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->approval_status=="No")? "checked" : "" }} name="approval_status">
                <label>No</label><br>
            </div>
        </div>
              
        <div class="form-group row">
            <label class="col-sm-3">Return Legal Opini</label>
            <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->return_legal_opini=="Yes")? "checked" : "" }} name="return_legal_opini" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->return_legal_opini=="No")? "checked" : "" }} name="return_legal_opini">
                <label>No</label><br>
            </div>
        </div>
     
        <div class="form-group row">
            <label class="col-sm-3">Isi Legal Opini</label>
            <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->status_legal_opini=="Yes")? "checked" : "" }} name="status_legal_opini" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->status_legal_opini=="No")? "checked" : "" }} name="status_legal_opini">
                <label>No</label><br>
            </div>
        </div>
 
        <div class="form-group row">
            <label class="col-sm-3">Return Compliance Opini</label>
            <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->return_legal_opini=="Yes")? "checked" : "" }} name="return_compliance_opini" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->return_legal_opini=="No")? "checked" : "" }} name="return_compliance_opini">
                <label>No</label><br>
            </div>
        </div>
      
        <div class="form-group row">
            <label class="col-sm-3">Menerima Return Compliance Opini</label>
                <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->status_compliance_opini=="Yes")? "checked" : "" }} name="status_compliance_opini" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->status_compliance_opini=="No")? "checked" : "" }} name="status_compliance_opini">
                <label>No</label><br>
            </div>
        </div>
     
        <div class="form-group row">
            <label class="col-sm-3">Return Worksheet Screening</label>
            <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->return_worksheet_screening=="Yes")? "checked" : "" }} name="return_worksheet_screening" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->return_worksheet_screening=="No")? "checked" : "" }} name="return_worksheet_screening">
                <label>No</label><br>
            </div>
        </div>
      
        <div class="form-group row">
            <label class="col-sm-3">Isi Worksheet Screening</label>
            <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->status_worksheet_screening=="Yes")? "checked" : "" }} name="status_worksheet_screening" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->status_worksheet_screening=="No")? "checked" : "" }} name="status_worksheet_screening">
                <label>No</label><br>
            </div>
        </div>
  
        <div class="form-group row">
            <label class="col-sm-3">Return CAD Opini</label>
                <div class="col-md-7">
             
                <input type="radio" value="Yes" {{ (optional($data)->return_cad_opini=="Yes")? "checked" : "" }} name="return_cad_opini" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->return_cad_opini=="No")? "checked" : "" }} name="return_cad_opini">
                <label>No</label><br>
            </div>
        </div>
   
        <div class="form-group row">
            <label class="col-sm-3">Isi CAD Opini</label>
            <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->status_cad_opini=="Yes")? "checked" : "" }} name="status_cad_opini" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->status_cad_opini=="No")? "checked" : "" }} name="status_cad_opini">
                <label>No</label><br>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-3">Status Division Head</label>
            <div class="col-md-7">
                <input type="radio" value="Yes" {{ (optional($data)->status_division_head =="Yes")? "checked" : "" }} name="status_division_head" required>
                <label>Yes</label>

                <input type="radio" value="No" {{ (optional($data)->status_division_head =="No")? "checked" : "" }} name="status_division_head">
                <label>No</label><br>  
            </div>
        </div>
      
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="{{ url('list-user') }}" class="btn btn-danger">Cancel</a>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('.select2').select2({theme: 'bootstrap-5'});
</script>
@endpush
