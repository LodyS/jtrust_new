@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="card border-white" >
            <div class="card-body">
                <h5 align="center">PIHAK TERKAIT BPR - {{ $nama_bpr = strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($sandi_bpr)->nama_bpr) }}</h5>
                <div style="height:30px"></div>
                @include('flash-message')
                @include('error-message')
                <div>
                    <ul>@include('list-menu-edit-bpr')</ul>
                </div>
            </div> 
        </div>

        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <form action="{{ route('pihak-terkait-bpr.store') }}" method="POST" name="form">@csrf
                    <input type="hidden" name="aksi" value="Create">
                    <input type="hidden" name="tabel" value="form_005">
                    <input type="hidden" name="sandi_bpr" value="{{ $sandi_bpr }}">
                    <input type="hidden" name="bagian" value="Pihak Terkait BPR {{ $nama_bpr }}">

                    <div style="height:30px"></div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nama Pihak Terkait</label>
                                <input type="text" class="form-control" name="nama_pihak_terkait" required>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Hubungan Pihak Terkait </label>
                                <input type="text" class="form-control" name="hubungan_pihak_terkait" required>
                            </div>
                        </div><!-- Col -->
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">No Identitas</label>
                                <input type="text" class="form-control" name="no_identitas" required>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Jenis Pihak Terkait</label>
                                <input type="text" class="form-control" name="jenis_pihak_terkait" required>
                            </div>
                        </div><!-- Col -->
                    </div>

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Alamat</label>
                                <textarea class="form-control" rows="3" name="alamat_pihak_terkait" required></textarea>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <button type="submit" class="btn btn-primary submit">Save</button>
                </form>
            </div>
        </div>
       
        <div style="height:10px"></div>

        <div class="card border-white">
            <div class="card-body">
                <h5 style="text-align:center">LIST PIHAK TERKAIT BPR</h5>

                <div style="height:30px"></div>

                <table class="table" id="table" width="100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th width="40%">Nama</th>
                            <th width="40%">Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
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

$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    scrollX: true,
    ajax: "{{ url('pihak-terkait-bpr', $id) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data: 'nama_pihak_terkait', name: 'nama_pihak_terkait'},
        { data: 'jenis_pihak_terkait', name:'jenis_pihak_terkait'},
        { data: 'action', name: 'action'},
    ],
    order: [[0, 'asc']]
});
</script>
@endpush
