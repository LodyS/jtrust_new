@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4>Form User</h4>

        <div style="height:30px" align="centre"></div>

        <form action="{{ (empty($list_user)) ? route('list-user.store') : route('list-user.update', [$list_user->id]) }}" method="POST">@csrf
        @include('flash-message')

        @if(!empty($list_user))
            @method('PUT')
        @endif

        <input type="hidden" name="tabel" value="user">
        <input type="hidden" name="aksi" value="{{ (empty($list_user)) ? 'Create' : 'Update' }}">
        <input type="hidden" name="id" value="{{ $list_user->id ?? '' }}">

        <div class="form-group row">
		    <label class="col-md-3">Name</label>
			    <div class="col-md-7">
                <input type="text" class="form-control" name="name" value="{{ $list_user->name ?? '' }}" required>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">E-mail</label>
			    <div class="col-md-7">
                <input type="email" class="form-control" name="email" value="{{ $list_user->email ?? '' }}" required>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Kode RM</label>
			    <div class="col-md-7">
                <input type="text" class="form-control" name="kode_rm" value="{{ $list_user->kode_rm ?? ''}}" >
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Atasan</label>
			    <div class="col-md-7">
                <select name="atasan_id" class="form-control select2">
                    <option value="">Pilih</option>
                    @foreach ($atasan as $j)
                        @if(empty($list_user))
                            <option value="{{ $j->id }}">{{ $j->name }} </option>
                        @else
                            <option value="{{ $j->id }}" {{ ($list_user->atasan_id == $j->id) ? 'selected' : '' }}>{{ $j->name }} </option>
                        @endif
                    @endforeach
                </select>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Relationship Manager</label>
			    <div class="col-md-7">
                <select name="relationship_manager" class="form-control select2">
                    <option value="">Pilih</option>
                    @foreach ($atasan as $j)
                        @if(empty($list_user))
                            <option value="{{ $j->id }}">{{ $j->name }} </option>
                        @else
                            <option value="{{ $j->id }}" {{ ($list_user->relationship_manager == $j->id) ? 'selected': '' }}>{{ $j->name }} </option>
                        @endif
                    @endforeach
                </select>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Jabatan</label>
			    <div class="col-md-7">
                <select name="jabatan" class="form-control select2" required>
                    <option value="">Pilih</option>
                    @foreach($jabatan as $j)
                        @if(empty($list_user))
                            <option value="{{ $j->id }}">{{ $j->nama_jabatan }}</option>
                        @else 
                            <option value="{{ $j->id }}" {{ ($list_user->jabatan == $j->id) ? 'selected' : '' }}>{{ $j->nama_jabatan }}</option>
                        @endif 
                    @endforeach
                </select>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Divisi</label>
			    <div class="col-md-7">
                <select name="divisi" class="form-control select">
                    <option value="">Pilih</option>

                    @if(empty($list_user))
                        <option value="Business Division">Business Division</option>
                        <option value="Legal">Legal</option>
                        <option value="Compliance">Compliance</option>
                        <option value="Credit Administration">Credit Administration</option>
                        <option value="Credit Risk Reviewer">Credit Risk Reviewer</option>
                    @else 
                        <option value="Business Division" {{ (!empty($list_user->divisi == 'Business Division'))?'selected':''}}>Business Division</option>
                        <option value="Legal" {{ (!empty($list_user->divisi == 'Legal'))?'selected':''}}>Legal</option>
                        <option value="Compliance" {{ (!empty($list_user->divisi == 'Compliance'))?'selected':''}}>Compliance</option>
                        <option value="Credit Administration" {{ (!empty($list_user->divisi == 'Credit Administration'))?'selected':''}}>Credit Administration</option>
                        <option value="Credit Risk Reviewer" {{ (!empty($list_user->divisi == 'Credit Risk Reviewer'))?'selected':''}}>Credit Risk Reviewer</option>
                    @endif
                </select>
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Password</label>
			    <div class="col-md-7">
                @if (empty($list_user))
                    <input type="password" class="form-control" name="password" required>
                @else
                    <input type="password" class="form-control" name="password">
                @endif
		    </div>
	    </div>

        <div class="form-group row">
		    <label class="col-md-3">Confirm Password</label>
			    <div class="col-md-7">
                @if (empty($list_user))
                    <input type="password" class="form-control" name="password_confirm" required>
                @else
                    <input type="password" class="form-control" name="password_confirm">
                @endif
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
