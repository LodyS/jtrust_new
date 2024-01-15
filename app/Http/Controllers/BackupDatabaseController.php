<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Storage;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class BackupDatabaseController extends Controller
{
    public function index()
    {
        $path = storage_path('app\laravel');
        $files = File::allFiles($path);
        $files = $this->paginate($files);
        $files->withPath('');
      
        return view('backup-database/index', compact('files', 'path'));
    }

    public function backup()
    {
        Artisan::call('backup:run');

        return back()->with('success', 'Berhasil database terbaru');
    }

    public function paginate($items, $perPage = 20, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage ;
        $itemstoshow = array_slice($items , $offset , $perPage);
        return new LengthAwarePaginator($itemstoshow ,$total ,$perPage);
    }
}
