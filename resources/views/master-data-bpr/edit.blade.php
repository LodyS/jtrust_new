@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="modal-title">Master Data BPR</h4>
        <div style="height:40px" align="centre"></div>

            <form action="{{ url('master-data-bpr-update') }}" method="POST">{{ @csrf_field() }}

            @include('flash-message')
            <ul>
                @foreach ($errors->all() as $error)
                <div class="alert alert-danger alert-dismissible show fade">
                    <div class="alert-body">
                        <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                        </button>
                        This is a danger alert.
                    </div>
                </div>
                @endforeach
            </ul>

                <input type="hidden" class="form-control" name="id" value="{{ optional($data)->id }}" required>

                <div class="form-group row">
		            <label class="col-md-3">Nama BPR<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nama_bpr" value="{{ optional($data)->nama_bpr }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Sandi BPR<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="sandi_bpr" value="{{ optional($data)->sandi_bpr }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Alamat BPR<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="alamat_bpr" value="{{ optional($data)->alamat_bpr }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Kabupaten Kota BPR<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="kabupaten_kota_bpr" value="{{ optional($data)->kabupaten_kota_bpr }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">No Telepon<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="number" class="form-control" name="no_telepon" value="{{ optional($data)->no_telepon }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">NPWP<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="npwp" value="{{ optional($data)->npwp }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Nama Penanggung Jawab <br/>Penyusunan Penyusun Laporan<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nama_penanggung_jawab_penyusun_laporan"
                        value="{{ optional($data)->nama_penanggung_jawab_penyusun_laporan }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Bagian Divisi<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="bagian_divisi" value="{{ optional($data)->bagian_divisi }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">No Telepon Penanggung Jawab <br/>Penyusun Laporan<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="no_telepon_penanggung_jawab_penyusun_laporan"
                        value="{{ optional($data)->no_telepon_penanggung_jawab_penyusun_laporan }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Email<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="email" value="{{ optional($data)->email }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Nominal Deviden Yang Dibayarkan<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nominal_deviden_yang_dibayar"
                        value="{{ optional($data)->nominal_deviden_yang_dibayar }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Tahun RPUS RAT<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="tahun_rpus_rat" value="{{ optional($data)->tahun_rpus_rat }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Bonus Tahunan Dan Tantiem<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="bonus_tahunan_dan_tantiem"
                        value="{{ optional($data)->bonus_tahunan_dan_tantiem }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Nama KAP Yang Mengaudit<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nama_kap_yang_mengaudit"
                        value="{{ optional($data)->nama_kap_yang_mengaudit }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Nama AP Yang Menandatangani <br/>Laporan Audit<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nama_ap_yang_menandatangani_laporan_audit"
                        value="{{ optional($data)->nama_ap_yang_menandatangani_laporan_audit }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Pemeriksaan Ke Kap Yang Sama<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="pemeriksaan_ke_kap_yang_sama"
                        value="{{ optional($data)->pemeriksaan_ke_kap_yang_sama }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Nilai Nominal Per Lembar Saham<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nilai_nominal_per_lembar_saham"
                        value="{{ optional($data)->nilai_nominal_per_lembar_saham }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Memiliki Izin PVA<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="memiliki_izin_pva"
                        value="{{ optional($data)->memiliki_izin_pva }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Tanggal Izin PVA<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="date" class="form-control" name="tanggal_izin_pva"
                        value="{{ optional($data)->tanggal_izin_pva }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Jumlah PVA<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="jumlah_pva"
                        value="{{ optional($data)->jumlah_pva }}" required>
                    </div>
	            </div>

                <div class="form-group row">
		            <label class="col-md-3">Nama Ultimate Shareholder<span style="color:red">*</span></label>
			            <div class="col-md-7">
                        <input type="text" class="form-control" name="nama_ultimate_shareholder"
                        value="{{ optional($data)->nama_ultimate_shareholder }}" required>
                    </div>
	            </div>

            <div>
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('list-data-bpr') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">
    $('.select').select2({  theme: 'bootstrap4'});
</script>
@endpush
