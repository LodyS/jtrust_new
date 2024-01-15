<!DOCTYPE html>
@extends('tema.app')
@section('content')

<div class="card border-white" style="width: 100rem;">
    <div class="card-body">

        <div class="w-sm-100 mr-auto">
            <h4 class="mb-0">BACKUP DATABASE
                <span style="float:right;">
                <a href="{{ url('do-backup-database')}}" class="btn btn-primary btn-sm" align="right">Backup database</a>
                </span>
            </h4>
        </div>

        @include('flash-message')
        @include('error-message')

        <div class="form-group">
            <table class="table table-hover">
                <tr>
                    <th>NO</th>
                    <th>File</th>
                    <th>Aksi</th>
                </tr>

                @foreach($files as $key=> $data)
                <tr>
                    <td>{{ ++$key }}</td>
                    <td>{{ $data->getRelativePathname() }}</td>
                    <td><a href="{{ url('/protected/storage/app/Laravel/'.$data->getRelativePathname()) }}">Download</a></td>
                </tr>
                @endforeach

            </table>
            {{ $files->links() }}
        </div>
	</div>
</div>
@endsection


