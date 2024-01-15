<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        
        @include('flash-message')
        @include('error-message')
      
        <div class="card border-white">
			<div class="card-body">
                <h5 style="text-align:center">INFORMASI DEBITUR - {{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->uuid)->nama_bpr) }}</h5>
                <div style="height:30px"></div>
                @include('list-menu')
            </div>
        </div>

        <div style="height:10px"></div>

		<form action="{{ url('update-informasi-debitur') }}" method="POST">@csrf
            <input type="hidden" name="id" value="{{ $data->id ?? '' }}">
            <input type="hidden" name="sandi_bpr" value="{{ $data->sandi_bpr ?? '' }}">
            <input type="hidden" name="loan_applicant_id" value="{{ $id }}">
            <input type="hidden" name="tabel" value="loan_applicants">
            <input type="hidden" name="aksi" value="Update">
            <input type="hidden" name="bagian" value="Nak">

            <div class="card border-white">
                <div class="card-body">
                    <h5 align="center">FORM PEMEGANG SAHAM</h5>
                    <div style="height:30px"></div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Nama Debitur/Mitra Kerja Sama</label>
                                <input type="text" class="form-control" name="nama_bpr" value="{{ $data->nama_bpr ?? '' }}" readonly>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Nomor dan tanggal NPWP</label>
                                <input type="text" class="form-control" name="npwp" value="{{ $data->npwp ?? '' }}" readonly>
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label">Tahun Pendirian Usaha</label>
                                <input type="text" class="form-control" name="tahun_pendirian_usaha" value="{{ $data->tahun_pendirian_usaha ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nomor CIF</label>
                                <input type="text" class="form-control" name="nomor_cif" value="{{ $data->nomor_cif ?? '651000' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Kol</label>
                                <select class="form-control select" name="kol_di_bank_jtrust">
                                    <option value="">Silahkan Pilih</option>
                                    <option value="1" {{ ($data->kol_di_bank_jtrust == '1')?'selected':''}}>1</option>
                                    <option value="2" {{ ($data->kol_di_bank_jtrust == '2')?'selected':''}}>2</option>
                                    <option value="3" {{ ($data->kol_di_bank_jtrust == '3')?'selected':''}}>3</option>
                                    <option value="4" {{ ($data->kol_di_bank_jtrust == '4')?'selected':''}}>4</option>
                                    <option value="5" {{ ($data->kol_di_bank_jtrust == '5')?'selected':''}}>5</option>
                                </select>
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="control-label">Bulan dan tahun CIF</label>
                                <input type="month" class="form-control" name="bulan_tahun_cif" value="{{ $data->bulan_tahun_cif ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Bidang Usaha</label>
                                <input type="text" class="form-control" name="bidang_usaha" value="{{ $data->bidang_usaha ?? 'BPR' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Kode Sektor BI</label>
                                <input type="text" class="form-control"  name="kode_sektor_bi" value="{{ $data->kode_sektor_bi ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Bidang/Sektor Ekonomi</label>
                                <input type="text" class="form-control" name="bidang_ekonomi" value="{{ $data->bidang_ekonomi ?? 'Perantara Keuangan' }}" >
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Sub Bidang Ekonomi</label>
                                <input type="text" class="form-control" name="sub_bidang_ekonomi" value="{{ $data->sub_bidang_ekonomi ?? 'Perantara Moneter (Bank)' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <label class="control-label">Jenis Usaha</label>
                                <div class="form-group">
                                    <div class="radio">
                                    <label class="radio-inline control-label">
                                    <input type="radio" class="jenis_usaha" name="jenis_usaha" value="Produksi/Manufaktur" {{ ($data->jenis_usaha == "Produksi/Manufaktur")? "checked" : "" }} >
                                    Produksi/Manufaktur
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio">
                                    <label class="radio-inline control-label">
                                        <input type="radio" class="jenis_usaha" name="jenis_usaha" value="Jasa" {{ ($data->jenis_usaha == "Jasa")? "checked" : "" }}>Jasa
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio">
                                    <label class="radio-inline control-label">
                                    <input type="radio" class="jenis_usaha" name="jenis_usaha" value="Perdagangan" {{ ($data->jenis_usaha == "Perdagangan")? "checked" : "" }}>Perdagangan
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="radio">
                                    <label class="radio-inline control-label">
                                    <input type="radio" class="jenis_usaha" name="jenis_usaha" value="Lainnya" {{ ($data->jenis_usaha == "Lainnya")? "checked" : "" }}>Lainnya
                                    </label>
                                </div>
                            </div>

                            <div class="form-group">
                                <input type="text" class="form-control" name="jenis_usaha_lainnya" id="jenis_usaha_lainnya" value="{{  $data->jenis_usaha_lainnya ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                </div>
            </div>

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">

                    <h5>Manajemen Inti (Key Person)</h5>
                    <div style="height:30px"></div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control" name="manajemen_inti_nama" value="{{ $data->manajemen_inti_nama ?? '' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Jabatan</label>
                                <input type="text" class="form-control" name="manajemen_inti_jabatan" value="{{ $data->manajemen_inti_jabatan ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <h5>Contact Person</h5>
                    <div style="height:20px"></div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nama</label>
                                <input type="text" class="form-control" name="cp_nama" value="{{ $data->cp_nama ?? '' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Nomor Telepon/HP</label>
                                <input type="number" class="form-control" name="cp_no_telp" value="{{ $data->cp_no_telp ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Jabatan</label>
                                <input type="text" class="form-control" name="cp_jabatan" value="{{ $data->cp_jabatan ?? '' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">E-mail</label>
                                <input type="text" class="form-control" name="cp_email" value="{{ $data->cp_email ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Alamat Kantor</label>
                                <input type="text" class="form-control" name="alamat_bpr" value="{{ $data->alamat_bpr ?? '' }}">
                            </div>
                        </div><!-- Col -->

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label class="control-label">Group Usaha/Perusahaan Terkait</label>
                                <input type="text" class="form-control" name="group_usaha" value="{{ $data->group_usaha ?? '' }}">
                            </div>
                        </div><!-- Col -->
                    </div><!-- Row -->
                </div>
            </div>

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <div class="form-group">
                        <label>Pemegang Saham Dan Susunan Pengurus </label>
                        <textarea class="form-control {{ (Auth::user()->jabatan_user->kode == 'account_officer' && $loan->status_level_proses == 1) ? 'content' : 'read' }}" name="keterangan" value="{{ $data->keterangan ?? '' }}" rows="6">{{ $data->keterangan ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div style="height:10px"></div>

            @if (Auth::user()->jabatan_user->kode == 'account_officer' && $loan->status_level_proses == 1)
                <div class="card border-white">
                    <div class="card-body">
                        <div class="form-group">
                    
                            <table class="table table-hover" id="tambah_form">
                                <tr>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Nominal Kepemilikan (Rp)</th>
                                    <th>% Kepemilikan</th>
                                    <th style="text-align:right"><button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button></th>
                                </tr>

                                <tbody></tbody>
                            </table>
                        </div>

                        <div style="height:10px"></div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            @endif

            </form>

            <div style="height:10px"></div>

            <div class="card border-white">
                <div class="card-body">
                    <div class="form-group">
                        <table class="table table-hover" width="100%" id="table">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jabatan</th>
                                    <th>Nominal Kepemilikan (Rp)</th>
                                    <th>% Kepemilikan</th>
                                    @if(Auth::user()->jabatan_user->kode == 'account_officer')
                                        <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>

$('.jenis_usaha').click(function(){
    var status = $(this).val();

	if(status !== "Lainnya")
    {
        $('#jenis_usaha_lainnya').val('').change();
	}
});

var i = 0;

$("#add").on("click", function() {
    var newRow = $("<tr>");
    var cols = "";
    cols += '<td><input type="text" name="nama[]" class="form-control"><input type="hidden" name="aksi_satu" value="aksi" class="form-control"></td>';
    cols += '<td><input type="text" name="jabatan[]" class="form-control"></td>';
    cols += '<td><input type="text" class="form-control nominal" name="jumlah_nominal[]"/></td>';
    cols += '<td><input type="text" class="form-control" name="persentase_kepemilikan[]"/></td>';
    cols += '<td><button type="button" class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';
    newRow.append(cols);

    newRow.find('.nominal').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value) {
            return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    }));

    $("#tambah_form").append(newRow);
    i++;
});

$("#tambah_form").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
    evaluateTotal()
});

$('#table').DataTable({
    processing: true,
    serverSide: true,
    pageLength: 20,
    //scrollX: true,
    ajax: "{{ url('kepemilikan-bpr', $loan->sandi_bpr) }}",
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
        { data: 'nama', name: 'nama'},
        { data: 'jabatan', name: 'jabatan' },
        { data: 'jumlah_nominal', name: 'jumlah_nominal' },
        { data: 'persentase_kepemilikan', name: 'persentase_kepemilikan'},
        @if(Auth::user()->jabatan_user->kode == 'account_officer')
            { data: 'action', name: 'action'},
        @endif
    ],
    order: [[0, 'asc']]
});

function hapus(id){
    if (confirm("Are you sure want to delete this data ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('destroy-kepemilikan-bpr') }}",
        data: {
                id: id,
                _token : "{{ csrf_token() }}",
                tabel : "form_001",
                aksi : "Delete",
                bagian : "Master BPR",
            },

        dataType: 'json',
        success: function(res){
            var oTable = $('#table').dataTable();
                oTable.fnDraw(false);
            }
        });
    }
}

</script>
@endpush
