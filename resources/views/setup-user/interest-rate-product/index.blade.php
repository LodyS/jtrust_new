@extends('theme.app')
@section('content')

<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row ">
    <div class="col-12  align-self-center">
        <div class="sub-header mt-3 py-3 align-self-center d-sm-flex w-100 rounded">
            <div class="w-sm-100 mr-auto"><h4 class="mb-0">INTEREST RATE PRODUCT</h4></div>

            <a href="{{ url('interest-rate-product-form') }}" class="btn btn-primary">Create</a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        @include('flash-message')
        <table class="display table dataTable table-striped table-bordered"  id="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Bulan</th>
                    <th>Flat Per year</th>
                    <th>Biaya Asuransi</th>
                    <th>Biaya Admin</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-confirmation/1.0.5/bootstrap-confirmation.min.js"></script>

<script type="text/javascript">

$(document).ready( function () {

$('#table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ url('interest-rate-product-data') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' , orderable: false, searchable: false},
            { data: 'title', name: 't_credit_type.title'},
            { data: 'bulan', name: 'bulan' },
            { data : 'flat_rates', name : 'flat_rates' },
            { data : 'asuransi_fee', name : 'asuransi_fee' },
            { data : 'admin_fee', name : 'admin_fee'},
            { data: 'action', name: 'action', orderable: false},
        ],
        order: [[0, 'asc']]
    });
});

function hapus(id){
    if (confirm("Apakah Anda yakin akan hapus data ini ?") == true) {
    var id = id;

        $.ajax({
            type:"POST",
            url: "{{ url('hapus-interest-rate-product') }}",
            data: {
                id: id,
                _token : "{{ csrf_token() }}",
            },

            dataType: 'json',
            success: function(res){
                alert(res['success']); // pesan bahwa data berhasil disimpan
                location.reload(true);
            }
        });
    }
}
</script>
