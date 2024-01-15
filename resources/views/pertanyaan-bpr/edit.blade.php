@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="modal-title">Edit Manajemen Scoring {{ $bpr->nama_bpr }}</h4>

        <div style="height:10px"></div>

        <div style="height:10px" align="centre"></div>
            <form action="{{ url('jawaban-pertanyaan-bpr-update') }}" method="POST">@csrf
            <input type="hidden" name="sandi_bpr" value="{{ $bpr->uuid ?? '' }}" >
            <input type="hidden" name="tabel" value="jawaban_pertanyaan_bpr">
            <input type="hidden" name="aksi" value="Update">

                <nav class="page-breadcrumb">
				    <ol class="breadcrumb">
					    <li class="breadcrumb-item"><a href="{{ url('jawaban-pertanyaan-bpr', $bpr->sandi_bpr) }}">List Manajemen Scoring BPR</a></li>
				    </ol>
			    </nav>

                @include('flash-message')
                @include('error-message')

                <div class="container">
            <ul class="list-inline">
                 <li class="list-inline-item col-md-4" >
		            <label class="col-md-3">Bulan</label>
			            <div class="col-md-7">
                            <select name="review_date_month" class="form-control select" required>
                            <option value="">Pilih</option>
                            <option value="1" {{ ($review_date_month == 1)?'selected':''}}>Januari</option>
                            <option value="2" {{ ($review_date_month == 2)?'selected':''}}>Februari</option>
                            <option value="3" {{ ($review_date_month == 3)?'selected':''}}>Maret</option>
                            <option value="4" {{ ($review_date_month == 4)?'selected':''}}>April</option>
                            <option value="5" {{ ($review_date_month == 5)?'selected':''}}>Mei</option>
                            <option value="6" {{ ($review_date_month == 6)?'selected':''}}>Juni</option>
                            <option value="7" {{ ($review_date_month == 7)?'selected':''}}>Juli</option>
                            <option value="8" {{ ($review_date_month == 8)?'selected':''}}>Agustus</option>
                            <option value="9" {{ ($review_date_month == 9)?'selected':''}}>September</option>
                            <option value="10" {{ ($review_date_month == 10)?'selected':''}}>Oktober</option>
                            <option value="11" {{ ($review_date_month == 11)?'selected':''}}>November</option>
                            <option value="12" {{ ($review_date_month == 12)?'selected':''}}>Desember</option>
                        </select>
		            </div>
                    </li>

                <?php $year = date('Y'); ?>
                <li class="list-inline-item col-md-4" >
		            <label class="col-md-3">Tahun</label>
			            <div class="col-md-7">
                            <select name="review_date_year" class="form-control select" required>
                            <option value="">Pilih</option>
                            @for($i=2019; $i<=$year; $i++)
                            <option value="{{ $i }}" {{ ($review_date_year == $i)?'selected':''}}>{{ $i}} </option>
                            @endfor
                        </select>
                        </div>
                    </li>
                </ul>
            </div>

                <div>
                    <ul>
                    @foreach ($jawaban_manajemen_umum_edit as $kelompok =>$pertanyaan)
                        <li><h5>{{ $kelompok }}</b></h5>
                            <br/>
                            <ul>
                                @foreach($pertanyaan as $sub=> $q)
                                <li><h6>{{ $sub }}</b></h6>
                                <ul>
                                    @foreach($q as $detail=>$a)
                                    <li>{{ $a->detail_pertanyaan }}
                                        <div style="height:10px"></div>

                                        <input type="hidden" name="id[]" value="{{ $a->id }}" >
                                        <div class="form-group form-group-sm">
                                            <label>Score</label>
                                                <div class="col-md-3">
                                                <select class="form-control hitung_umum" name="score[]" required>
                                                    <option value="0" {{ ($a->score == 0)?'selected':''}}>0</option>
                                                    <option value="1" {{ ($a->score == 1)?'selected':''}}>1</option>
                                                    <option value="2" {{ ($a->score == 2)?'selected':''}}>2</option>
                                                    <option value="3" {{ ($a->score == 3)?'selected':''}}>3</option>
                                                    <option value="4" {{ ($a->score == 4)?'selected':''}}>4</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-sm">
                                            <label>Keterangan</label>
                                                <div class="col-md-7">
                                                <textarea class="form-control" name="keterangan[]" rows="5">{{ $a->keterangan }}</textarea>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                    @endforeach

                    <div class="form-group form-group-sm">
                        <label><h5>Total Score Manajemen Umum</h5></label>
                            <div class="col-md-2">
                            <input type="text" class="form-control total_umum" value="{{ $sum_umum }}" readonly>
                        </div>
                    </div>

                    @foreach ($jawaban_manajemen_resiko_edit as $kelompok =>$pertanyaan)
                        <li><h5>{{ $kelompok }}</b></h5>
                            <br/>
                            <ul>
                                @foreach($pertanyaan as $sub=> $q)
                                <li><h6>{{ $sub }}</b></h6>
                                <ul>
                                    @foreach($q as $detail=>$a)
                                    <li>{{ $a->detail_pertanyaan }}
                                        <div style="height:10px"></div>

                                        <input type="hidden" name="id[]" value="{{ $a->id }}" >
                                        <div class="form-group form-group-sm">
                                            <label>Score</label>
                                                <div class="col-md-3">
                                                <select class="form-control hitung_resiko" name="score[]" required>
                                                    <option value="0" {{ ($a->score == 0)?'selected':''}}>0</option>
                                                    <option value="1" {{ ($a->score == 1)?'selected':''}}>1</option>
                                                    <option value="2" {{ ($a->score == 2)?'selected':''}}>2</option>
                                                    <option value="3" {{ ($a->score == 3)?'selected':''}}>3</option>
                                                    <option value="4" {{ ($a->score == 4)?'selected':''}}>4</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-group-sm">
                                            <label>Keterangan</label>
                                                <div class="col-md-7">
                                                <textarea class="form-control" name="keterangan[]" rows="5">{{ $a->keterangan }}</textarea>
                                            </div>
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                    @endforeach

                    <div class="form-group form-group-sm">
                        <label><h5>Total Score Manajemen Resiko</h5></label>
                            <div class="col-md-2">
                            <input type="text" class="form-control total_resiko" value="{{ $sum_resiko }}" readonly>
                        </div>
                    </div>

                    <div>
                        <button type="submit" align="right" class="btn btn-primary">Save</button>
                        <a href="{{ url('list-data-bpr') }}" class="btn btn-danger">Cancel</a>
                    </div>

                </ul>
            </div>

        </form>
    </div>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>
<script type="text/javascript">
$(document).ready( function () {
    $(document).on("change keyup", ".hitung_resiko", function() {
        var sum_resiko = 0;

        $(".hitung_resiko").each(function(){
            sum_resiko += +$(this).val();
            });
        $(".total_resiko").val(sum_resiko);
    });

    $(document).on("change keyup", ".hitung_umum", function() {
        var sum_umum = 0;

        $(".hitung_umum").each(function(){
            sum_umum += +$(this).val();
            });
        $(".total_umum").val(sum_umum);
    });
});
</script>
