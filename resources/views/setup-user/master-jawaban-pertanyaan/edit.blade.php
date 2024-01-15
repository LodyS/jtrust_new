<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h4 class="mb-0">Edit Pertanyaan dan Jawaban</h4>

        <div style="height:30px"></div>
        <form action="{{ route('master-jawaban-pertanyaan.update', [$master_jawaban_pertanyaan->id]) }}" method="POST">@csrf
            <input type="hidden" name="id" value="{{ $master_jawaban_pertanyaan->id ?? '' }}">
            <input type="hidden" name="tabel" value="master_pertanyaan">
            <input type="hidden" name="aksi" value="Update">

            @method('PUT')
            @include('flash-message')

            <div class="col-sm-12">
				<div class="form-group">
					<label class="control-label">Jenis Pertanyaan</label>
                    <select class="form-control select" name="jenis_pertanyaan">
                        <option value="">Silahkan Pilih</option>
                        <option value="Compliance" {{ ($master_jawaban_pertanyaan->jenis_pertanyaan == 'Compliance')?'selected':''}}>Compliance</option>
                        <option value="Legal" {{ ($master_jawaban_pertanyaan->jenis_pertanyaan == 'Legal')?'selected':''}}>Legal</option>
                        <option value="Credit Administration" {{ ($master_jawaban_pertanyaan->jenis_pertanyaan == 'Credit Administration')?'selected':''}}>Credit Administration</option>
                        <option value="Credit Risk Reviewer" {{ ($master_jawaban_pertanyaan->jenis_pertanyaan == 'Credit Risk Reviewer')?'selected':''}}>Credit Risk Reviewer</option>
                    </select>
				</div>
			</div><!-- Col -->

            <div class="col-sm-12">
                <div class="form-group">
                <label class="control-label">Sub Jenis Pertanyaan</label>
                <input type="text" class="form-control" name="sub_jenis_pertanyaan"  value="{{ $master_jawaban_pertanyaan->sub_jenis_pertanyaan ?? '' }}">
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label class="control-label">Bagian</label>
                <input type="text" class="form-control" name="bagian"  value="{{ $master_jawaban_pertanyaan->bagian ?? '' }}">
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label class="control-label">Sub Bagian</label>
                <input type="text" class="form-control" name="sub_bagian"  value="{{ $master_jawaban_pertanyaan->sub_bagian ?? '' }}">
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label class="control-label">No Urut</label>
                <input type="text" class="form-control" name="no_urut"  value="{{ $master_jawaban_pertanyaan->no_urut ?? '' }}">
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label class="control-label">Pertanyaan</label>
                <textarea class="form-control content" name="pertanyaan"  rows="6">{{ $master_jawaban_pertanyaan->pertanyaan ?? '' }}</textarea>
                </div>
            </div>

            <div class="col-sm-12">
                <div class="form-group">
                <label class="control-label">Keterangan</label>
                <textarea class="form-control content" name="keterangan"  rows="6">{{ $master_jawaban_pertanyaan->keterangan ?? '' }}</textarea>
                </div>
            </div>

            <div class="form-group">

                <table class="table table-hover" id="tambah_form">
                    <tr>
                        <th>Jawaban</th>
                        <th>Profil Risiko</th>
                    </tr>

                    @foreach($jawaban as $d)
                    <tr>
                        <td><input type="text" name="jawaban[]" value="{{ $d->jawaban }}" class="form-control">
                        <input type="hidden" name="jawaban_id[]" value="{{ $d->id }}"></td>
                        <td>
                            <select class="form-control" name="profil_risiko[]">
                                <option>Pilih</option>
                                <option value="Low" {{ ($d->profil_risiko == 'Low') ? 'selected':''}}>Low</option>
                                <option value="Medium" {{ ($d->profil_risiko == 'Medium') ? 'selected':''}}>Medium</option>
                                <option value="High" {{ ($d->profil_risiko == 'High') ? 'selected':''}}>High</option>
                            </select>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>


            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ url('master-jawaban-pertanyaan') }}" class="btn btn-danger">Cancel</a>
            </div>

        </form>
    </div>
</div>

@endsection

<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>

@push('scripts')
<script>



var editor_config = {
    selector: "textarea.content",
    plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        relative_urls : false,
        remove_script_host : false,
        document_base_url : 'https://http://jtrust.exlayer.id/',
        content_style: "body {  font-size: 11pt; font-family: Arial; }",
 };

tinymce.init(editor_config);

</script>
@endpush
