@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <h5>FORM LOAN APPLICANT</h5>
        <div style="height:30px"></div>

        <form action="{{ ($aksi == 'Create') ? url('simpan-pengajuan-pinjaman') : url('update-pengajuan-pinjaman') }}" method="POST" name="form">@csrf

            @include('flash-message')
            @include('error-message')

            <input type="hidden" name="id" value="{{ optional($data)->id }}">
            <input type="hidden" name="aksi" value="{{ $aksi }}">
            <input type="hidden" name="tabel" value="loan_applicants">

            <div class="form-group row">
		        <label class="col-md-3">Tanggal Pengajuan</label>
			        <div class="col-md-7">
                    <input type="date" class="form-control" name="tanggal_apply" value="{{ optional($data)->tanggal_apply ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Nama BPR</label>
			        <div class="col-md-7">
                        @if($data !== null)
                            <input type="text" class="form-control" value="{{ strtoupper(\App\Models\InformasiPokokBprPelapor::namaBpr($data->sandi_bpr)->nama_bpr) }}" readonly>
                        @else
                            <select class="form-control select" name="sandi_bpr" required>
                            <option value="">Silahkan Pilih</option>
                            @foreach ($bpr as  $b)
                                <option value="{{ $b->uuid }}">{{ $b->nama_bpr }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Jenis Pengajuan</label>
			        <div class="col-md-7">
                        <select class="form-control select" name="jenis_pengajuan" required onchange="show_form_perpanjangan('')" style="width:635px" id="jenis_pengajuan">
                        <option value="">Silahkan Pilih</option>
                        @foreach($jenisPengajuan as $j)
                            <option value="{{ $j->nama_pengajuan }}" {{ (optional($data)->jenis_pengajuan == $j->nama_pengajuan)?'selected':''}}>{{ $j->nama_pengajuan }}</option>
                        @endforeach
                    </select>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Produk</label>
			        <div class="col-md-7">
                        <select class="form-control select" name="produk_id" required>
                        <option value="">Silahkan Pilih</option>
                        @foreach ($produk as $b)
                            <option value="{{ $b->id }}" {{ (optional($data)->produk_id == $b->id)?'selected':''}}>{{ $b->product_title }}</option>
                        @endforeach
                    </select>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Skema Kredit</label>
			        <div class="col-md-7">
                        <select class="form-control select" name="skema_kredit" required>
                        <option value="">Silahkan Pilih</option>
                        @foreach ($skemaKredit as $b)
                            <option value="{{ $b->id }}" {{ (optional($data)->skema_kredit == $b->id)?'selected':''}}>{{ $b->skema_kredit }}</option>
                        @endforeach
                    </select>
                </div>
	        </div>

            <div class="form-group row">
                <label class="col-md-3">Plafon</label>
                <div class="col-md-7">
                    <input type="text" class="form-control nominal" name="plafond" value="{{ number_format($data->plafond ?? 0)  }}" required>
                </div>
            </div>

            <div class="form-group n-no-margin" id="perpanjangan" style="display:none">
                <div class="form-group row">
                    <label class="col-md-3">Plafon Lama</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control nominal" name="plafon_lama" value="{{ number_format($data->plafon_lama ?? 0)  }}" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-md-3">Pemakaian</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control nominal" name="pemakaian" value="{{ number_format($data->pemakaian ?? 0)  }}" required>
                    </div>
                </div>
            </div>

            <div class="form-group row">
		        <label class="col-md-3">Biaya Administrasi</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control nominal" value="{{ number_format(optional($data)->biaya_administrasi) ?? '' }}" name="biaya_administrasi" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Bunga (%)</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control bunga" name="bunga" value="{{ $data->bunga ?? '' }}" required maxlength="5">
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Biaya</label>
			    <div class="col-md-7">
                    <select class="form-control" name="label_biaya_provisi" required id="label_biaya_provisi">
                        <option value="">Silahkan Pilih</option>
                        <option value="Biaya Provisi Di Awal" {{ (optional($data)->label_biaya_provisi == 'Biaya Provisi Di Awal') ? 'selected' : '' }}>Biaya Provisi Di Awal</option>
                        <option value="Biaya Provisi Per Penarikan" {{ (optional($data)->label_biaya_provisi == 'Biaya Provisi Per Penarikan') ? 'selected' : '' }}>Biaya Provisi Per Penarikan</option>
                        <option value="Up-Front Fee Di awal" {{ (optional($data)->label_biaya_provisi == 'Up-Front Fee Di Awal') ? 'selected' : '' }}>Up-Front Fee Di Awal</option>
                        <option value="Up-Front Fee Per Penarikan" {{ (optional($data)->label_biaya_provisi == 'Up-Front Fee Per Penarikan') ? 'selected' : '' }}>Up-Front Fee Per Penarikan</option>
                    </select>
                </div>
	        </div>

            <div class="form-group row" id="form_provisi">
		        <label class="col-md-3" id="label_provisi"></label>
			    <div class="col-md-7">
                    <input type="text" class="form-control bunga" name="provisi" value="{{ $data->provisi ?? 0 }}" required maxlength="5">
                </div>
	        </div>

             <div class="form-group row">
		        <label class="col-md-3">Jenis Fasilitas Kredit</label>
			    <div class="col-md-7">
                    <select class="form-control select" name="jenis_fasilitas_kredit" required>
                        <option value="">Silahkan Pilih</option>
                        @foreach ($fasilitas_kredit as $b)
                            <option value="{{ $b->fasilitas_kredit }}" {{ (optional($data)->jenis_fasilitas_kredit == $b->fasilitas_kredit)?'selected':''}}>{{ $b->fasilitas_kredit }}</option>
                        @endforeach
                    </select>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Sifat Fasilitas Kredit</label>
			    <div class="col-md-7">
                    <select class="form-control select" name="sifat_fasilitas_kredit" required>
                        <option value="">Silahkan Pilih</option>
                        <option value="Revolving - Committed" {{ (optional($data)->sifat_fasilitas_kredit == 'Revolving - Committed') ? 'selected' : '' }}>Revolving - Committed</option>
                        <option value="Revolving - Uncommitted" {{ (optional($data)->sifat_fasilitas_kredit == 'Revolving - Uncommitted') ? 'selected' : '' }}>Revolving - Uncommited</option>
                        <option value="Non Revolving - Committed" {{ (optional($data)->sifat_fasilitas_kredit == 'Non Revolving - Commiteed') ? 'selected' : '' }}>Non Revolving - Committed</option>
                        <option value="Non Revolving - Uncommitted" {{ (optional($data)->sifat_fasilitas_kredit == 'Non Revolving - Uncommiteed') ? 'selected' : '' }}>Non Revolving - Uncommitted</option>
                    </select>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Limit Fasilitas Kredit</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control nominal" name="limit_fasilitas_kredit" value="{{ number_format(optional($data)->limit_fasilitas_kredit) ?? '' }}" >
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Tujuan Penggunaan</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="tujuan_penggunaan" value="{{ $data->tujuan_penggunaan ?? '' }}">
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Jangka Waktu Angsuran (bulan)</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="tenor" value="{{ $data->tenor ?? '' }}">
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Jangka Waktu Penarikan (bulan)</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="jangka_waktu_penarikan" value="{{ $data->jangka_waktu_penarikan ?? '' }}">
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Jangka Waktu Fasilitas Kredit (bulan)</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="jangka_waktu_fasilitas_kredit" value="{{ $data->jangka_waktu_fasilitas_kredit ?? '' }}" required>
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Grace Period (bulan)</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="grace_period" value="{{ $data->grace_period ?? '' }}">
                </div>
	        </div>

            <div class="form-group row">
		        <label class="col-md-3">Lain-lain</label>
			    <div class="col-md-7">
                    <input type="text" class="form-control" name="lain_lain" value="{{ $data->lain_lain ?? '' }}">
                </div>
	        </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

$('.select').select2({theme: 'bootstrap-5'});

$('.nominal').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
}));

$('.bunga').on('change click keyup input paste',(function (event) {
    $(this).val(function (index, value) {
        return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{2})+(?!\d))/g, ".");
    });
}));

$("form[name='form']").validate({
    submitHandler: function(form) {
        form.submit();
    }
});

$('#label_biaya_provisi').on('change', function() {

    let label_biaya_provinsi = this.value;
    let persen = '(%)';
    let label_biaya_provisi = label_biaya_provinsi.concat(" ", persen);
    
    console.log(label_biaya_provinsi);
    if (this.value !== ''){
        $("#form_provisi").find("label[id=label_provisi]").html(label_biaya_provisi);      
    } else {
        $("#form_provisi").find("label[id=label_provisi]").html('');  
    }
});

let label_yang_ada = document.getElementById('label_biaya_provisi').value;
document.getElementById('label_provisi').innerHTML = label_yang_ada.concat(" ", '(%)');

function show_form_perpanjangan() {
    var jenis_pengajuan = document.getElementById("jenis_pengajuan");
    var perpanjangan = document.getElementById("perpanjangan");
    perpanjangan.style.display = jenis_pengajuan.value == "Existing" ? "block" : "none";
}

let jenis_pengajuan_edit = document.getElementById('jenis_pengajuan');
let perpanjangan_edit = document.getElementById("perpanjangan");

perpanjangan_edit.style.display = jenis_pengajuan_edit.value == "Existing" ? "block" : "none";
</script>
@endpush
