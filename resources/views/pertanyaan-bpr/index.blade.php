@extends('tema.app')
@section('content')

<style>
table
{
    border-collapse: collapse;
    border-spacing: 0;
    width: 100%;
    border: 1px solid #ddd;
}

th, td
{
    text-align: left;
    padding: 8px;
}

tr:nth-child(even)
{
    background-color: #f2f2f2
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
</style>

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">List Manajemen Scoring {{ $bpr->nama_bpr }}
                <span style="float:right;">
                <a href="{{ url('jawaban-pertanyaan-bpr-create', $bpr->uuid) }}" class="btn btn-primary btn-sm" align="right">Create</a>
                </span>
            </h4>
        </p>

        <div style="height:30px"></div>
        <body>

            @include('flash-message')
            <div class="table-responsive">
                <table class="table table-stripped" id="table">
                    <tr>
                        <th>No</th>
                        <th>Score Manajemen Umum</th>
                        <th>Score Manajemen Resiko</th>
                        <th>Review Date</th>
                        <th>Action</th>
                    </tr>

                    @foreach($data as $key=>$d)
                    <tr>
                        <td>{{ $key + $data->firstItem() }}</td>
                        <td>{{ $d->total_manajemen_umum }}</td>
                        <td>{{ $d->total_manajemen_resiko }}</td>
                        <td>{{ bulan($d->review_date_month) }} {{ $d->review_date_year }}</td>
                        <td>
                            <a href="{{ url('jawaban-pertanyaan-bpr-edit', [$d->sandi_bpr, $d->review_date_month, $d->review_date_year]) }}" class="btn btn-success">Edit</a>
                            <a href="javascript:void(0);" id="reject" onClick="hapus({{ $d->id }})" class="hapus btn btn-danger">Hapus</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            {{ $data->appends(request()->toArray())->links() }}
        </body>
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>

<script type="text/javascript">



function hapus(id){
    if (confirm("Are you sure want to delete this data ?") == true) {
    var id = id;
    $.ajax({
        type:"POST",
        url: "{{ url('jawaban-pertanyaan-bpr-delete') }}",
        data: {
                id: id,
                _token : "{{ csrf_token() }}",
                tabel : "jawaban_pertanyaan_bpr",
                aksi : "Delete",
            },

        dataType: 'json',
        success: function(res){
                location.reload();
            }
        });
    }
}

</script>




