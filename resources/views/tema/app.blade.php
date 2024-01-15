<style>
form .error {
    color: #ff0000;
}

th, td {
    text-align: left;
    padding: 8px;
}

tr:nth-child(even) {
    background-color: #f2f2f2
}

.dataTable td {
    height: 3em;
}

.dropdown-submenu {
    position: relative;
}

.dropdown-submenu a::after {
    transform: rotate(-90deg);
    position: absolute;
    right: 6px;
    top: .8em;
}

.dropdown-submenu .dropdown-menu {
    top: 0;
    left: 100%;
    margin-left: .1rem;
    margin-right: .1rem;
}

.paragraf {
    text-align: justify;
    text-justify: inter-word;
    padding: 5px;
}

pre {
    width: 700px;
    //word-wrap: break-word;
}

.dataTables_scroll {
    overflow:auto;
}

table.dataTable td {
    -webkit-box-sizing: content-box;
    -moz-box-sizing: content-box;
    box-sizing: content-box;
}


</style>

<!DOCTYPE html>
<html lang="en">
@include ('tema.head')

<body>
	<div class="main-wrapper">
        @include ('tema.main-menu')
		<div class="page-wrapper">
		    <nav class="navbar bg-primary" >

				<a href="#" class="sidebar-toggler"><i data-feather="menu"></i></a>

				<div class="navbar-content bg-primary">
					<ul class="navbar-nav" >
						<li class="nav-item dropdown nav-profile">
                            <p style="color:#ffffff">{{ strtoupper(Auth::user()->name) }} | {{ strtoupper(Auth::user()->jabatan_user->nama_jabatan) }}</p>
						</li>
					</ul>
				</div>
			</nav>

			<!-- partial -->
			<div class="page-content">
                <div class="d-flex justify-content-between align-items-center flex-wrap grid-margin">
                    <div class="d-flex align-items-center flex-wrap text-nowrap"></div>
                </div>
                <!-- Main Menu -->
                <div class="row">@yield('content')</div> <!-- row -->
			</div>
        {{-- @include('tema.footer') --}}
	    </div>
    </div>
</body>
<!-- core:js -->
<script src="{{ asset('tema/assets/vendors/core/core.js') }}"></script>
<script src="{{ asset('tema/assets/js/template.js') }}"></script>
<script src="{{ asset('tema/assets/vendors/feather-icons/feather.min.js') }}"></script>

<!-- TINYMCE -->
<script src="https://cdn.tiny.cloud/1/4rz2jr6pppeuktgimrteby3pax3yz4xomhawkbjfnqji46ha/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>

<!-- DataTable -->
<link rel="stylesheet" href="{{ asset('tema/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.css') }}">
<script src="{{ asset('tema/assets/vendors/datatables.net/jquery.dataTables.js') }}"></script>
<script src="{{ asset('tema/assets/vendors/datatables.net-bs4/dataTables.bootstrap4.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>

<!-- Select2 -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- Validate -->
<!--<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>-->
<script src="{{ asset('js/validasi.js') }}"></script>

@stack('scripts')

</html>

<script>
tinymce.init({
    selector: 'textarea.read',
    readonly : 1,
    height: 500,
    //width : 900,
    menubar: false,
    toolbar : false,
});
</script>

<script>
tinymce.init({
    selector: 'textarea.content',
    plugins: ["image code", "advlist autolink lists link image charmap print preview anchor"],
    toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media | numlist bullist",
    image_title: true,
    automatic_uploads: true,
    height: 500,

    file_picker_types: 'image',
    relative_urls : false,
    height: 500,
    remove_script_host : false,
    document_base_url : 'https://http://jtrust.exlayer.id/',

    file_picker_callback: function (cb, value, meta) {
        var input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function () {
            var file = this.files[0];

            var reader = new FileReader();
            reader.onload = function () {

            var id = 'blobid' + (new Date()).getTime();
            var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
            var base64 = reader.result.split(',')[1];
            var blobInfo = blobCache.create(id, file, base64);
            blobCache.add(blobInfo);

            cb(blobInfo.blobUri(), { title: file.name });
        };
        reader.readAsDataURL(file);
    };

    input.click();
    },
    content_style: "body {  font-size: 11pt; font-family: Arial; }",
});

function readURL(input, id)
{
    id = id || '#modal-preview';
    if (input.files && input.files[0]) {

        var reader = new FileReader();
        reader.onload = function (e) {
            $(id).attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
        $('#modal-preview').removeClass('hidden');
        $('#start').hide();
    }
}

function hapus(url)
{
    if (confirm('Apakah Anda yakin akan hapus data ini ? ') == true) {
        var url = url;
     
        $.ajax({
            type:"DELETE",
            url : url,
            aksi : "Delete",
            data: {
                _token : "{{ csrf_token() }}",
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
