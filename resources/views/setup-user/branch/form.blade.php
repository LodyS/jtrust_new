@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Form Branch</h4>
        <div style="height:30px" align="centre"></div>

        <form action="{{ (empty($branch)) ? route('branch.store') : route('branch.update',  [$branch->id]) }}" method="POST">@csrf

            @if(!empty($branch)) @method('PUT') @endif

            <input type="hidden" value="{{ $branch->id ?? '' }}" name="id">
            <input type="hidden" value="{{ (empty($branch)) ? 'Create' : 'Update' }}" name="aksi">
            <input type="hidden" value="branch" name="tabel">

            @include('error-message')

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Nama</label>
                    <div class="col-sm-12">
                        <select class="form-control" name="region_id">
                        <option value="">Pilih Region</option>
                        @foreach ($region as $id =>$p)
                            <option value="{{$id}}" {{ (empty($branch->region_id) == $id) ? 'selected' : ''}}>{{ $p }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Branch Code</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" name="branch_code" value="{{ $branch->branch_code ?? '' }}"  required>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Branch Title</label>
                    <div class="col-sm-12">
                    <input type="text" class="form-control" value="{{ $branch->branch_title ?? '' }}" name="branch_title" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>

        </form>
    </div>
</div>
@endsection
