<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">
        <h5 class="mb-0">Tambah Pertanyaan dan Jawaban</h5>

        <div style="height:30px"></div>
        <form action="{{ route('master-jawaban-pertanyaan.store') }}" method="POST">@csrf
            <input type="hidden" name="tabel" value="master_pertanyaan">
            <input type="hidden" name="aksi" value="Create">

            @include('flash-message')

            <div class="card border-white">
                <div class="card-body">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Jenis Pertanyaan</label>
                            <select class="form-control select" name="jenis_pertanyaan">
                                <option value="">Silahkan Pilih</option>
                                <option value="Compliance">Compliance</option>
                                <option value="Legal">Legal</option>
                                <option value="Credit Administration">Credit Administration</option>
                                <option value="Credit Risk Reviewer">Credit Risk Reviewer</option>
                            </select>
                        </div>
                    </div><!-- Col -->

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Sub Jenis Pertanyaan</label>
                            <input type="text" class="form-control" name="sub_jenis_pertanyaan">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Bagian</label>
                            <input type="text" class="form-control" name="bagian">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Sub Bagian</label>
                            <input type="text" class="form-control" name="sub_bagian">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">No Urut</label>
                        <input type="text" class="form-control" name="no_urut">
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">Pertanyaan</label>
                        <textarea class="form-control content" name="pertanyaan"  rows="6"></textarea>
                        </div>
                    </div>

                    <div class="col-sm-12">
                        <div class="form-group">
                        <label class="control-label">Keterangan</label>
                        <textarea class="form-control content" name="keterangan"  rows="6"></textarea>
                        </div>
                    </div>
                </div>
            </div> 

            <div style="height:10px"></div>
            
            <div class="card border-white">
                <div class="card-body">
                    <table class="table" id="tambah_form">
                        <tr>
                            <th style="width:60%">Jawaban</th>
                            <th>Profil Risiko</th>
                            <th style="text-align:right"> 
                                <button class="btn btn-danger btn-xs" type="button" id="add">Tambah</button>
                            </th>
                        </tr>

                        <tbody></tbody>
                    </table>
                </div>
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

var i = 0;

$("#add").on("click", function() {
    var newRow = $("<tr>");
    var cols = "";
    cols += '<td><input type="text" name="jawaban[]" class="form-control"></td>';
    cols += '<td><select class="form-control" name="profil_risiko[]"><option>Pilih</option><option value="Low">Low</option><option value="Medium">Medium</option><option value="High">High</option></select></td>';
    cols += '<td style="text-align:right"><button type="button"  class="btn btn-danger adRow ibtnDel" style="width:25%;">x</button></a></td>';

    newRow.append(cols);
    $("#tambah_form").append(newRow);
    i++;
});

$("#tambah_form").on("click", ".ibtnDel", function(_event) {
    $(this).closest("tr").remove();
    i -= 1
});

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
