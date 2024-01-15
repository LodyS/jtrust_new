@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <p style="text-align:left;">
            <h4 class="mb-0">BWMK
                <span style="float:right;">
                <span style="float:right;"><a href="{{ route('bwmk.create') }}" class="btn btn-primary btn-sm">Create</a></span>
                </span>
            </h4>
        </p>

        <div style="height:30px"></div>
        
        <body>
            @include('flash-message')
            <div class="table-responsive">
                <table class="table " id="table">
                    <tr>
                        <th>No</th>
                        <th>Kategori</th>
                        <th>Nilai Kredit Minimum</th>
                        <th>Nilai Kredit Maksimum</th>
                        <th>Voting Member</th>
                        <th>Non Voting member</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($data as $key=>$d)
                        <tr>
                            <td>{{ $data->firstItem() + $key}}</td>
                            <td>{{ $d->karakter }}</td>
                            <td>Rp. {{ number_format($d->nilai_kredit_minimum,2) }}</td>
                            <td>Rp. {{ number_format($d->nilai_kredit_maksimum,2) }}</td>
                            <td>
                                @if(json_decode($d->voting_member) == null)
                                @else
                                    @foreach (json_decode($d->voting_member) as $v)
                                        <ul>
                                            <li>{{ $v ?? '' }}</li>
                                        </ul>
                                    @endforeach
                                @endif
                            </td>

                            <td>
                                @if(json_decode($d->non_voting_member) == null)
                                @else
                                    @foreach (json_decode($d->non_voting_member) as $v)
                                        <ul>
                                            <li>{{ $v ?? '' }}</li>
                                        </ul>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('bwmk.edit', [$d->id]) }}" class="btn btn-secondary btn-xs">Edit</a>
                            
                                <?php
                                $url = route('bwmk.destroy', [$d->id]);
                                $url = "'".$url."'"; 
                                ?>
                                <a href="javascript:void(0);"  onClick="hapus_bwmk({{ $url }})" class="hapus btn btn-danger btn-xs">Hapus</a>
                            </td>
                        </tr>
                    @endforeach

                </table>

            </div>

        </body>
        {{ $data->render() }}
    </div>
</div>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js' type='text/javascript'></script>

<script type="text/javascript">
$(document).ready(function(){

    $('.nominal').on('change click keyup input paste',(function (event) {
        $(this).val(function (index, value) {
            return value.replace(/(?!\,)\D/g, "").replace(/(?<=\,,*)\./g, "").replace(/(?<=\.\d\d).*/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
    }));

    $('.dropdown a.test').on("click", function(e){
        $(this).next('ul').toggle();
        e.stopPropagation();
        e.preventDefault();
    });

    $('#tambah').on("click",function() {
        $('#modal-create').modal('show');
    });
});

function hapus_bwmk(url)
{
    if (confirm("Are you sure want to delete this data ?") == true) {
    
        $.ajax({
            type:"DELETE",
            url: url,
            data: {
                _token : "{{ csrf_token() }}",
            },
            dataType: 'json',
            success: function(res){
                location.reload();
            }
        });
    }
}
</script>


