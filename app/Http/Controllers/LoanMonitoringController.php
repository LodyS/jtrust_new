<?php

namespace App\Http\Controllers;
use DB;
use DataTables;
use Auth;
use Illuminate\Http\Request;

class LoanMonitoringController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()):
            $id_user = Auth::user()->id;
            $jabatan_user = Auth::user()->jabatan;
            $atasan_id = DB::table('users')
            ->leftJoin('users as bawahan', 'bawahan.atasan_id', 'users.id')
            ->where('users.jabatan', 'Business Division Head')
            ->where('users.id', $id_user)
            ->value('bawahan.id');

            $data = DB::table('loan_applicants')
            ->selectRaw('loan_applicants.id, tanggal_apply, form_00.sandi_bpr, form_00.nama_bpr, plafond')
            ->selectRaw('users.name, tenor, loan_applicants.status, t_product_type.product_title')
            ->leftJoin('form_00', 'form_00.sandi_bpr', 'loan_applicants.sandi_bpr')
            ->leftJoin('t_product_type', 't_product_type.id', 'loan_applicants.produk_id')
            ->leftJoin('users', 'users.id', 'loan_applicants.user_id')
            ->where('loan_applicants.status', 'Approved')
            ->where(function($query) use ($jabatan_user, $id_user, $atasan_id){

                if ($jabatan_user == 'Account Officer'):
                    $query->where('loan_applicants.user_id', $id_user);
                endif;

                if ($jabatan_user == 'Account Officer Departemen Head'):
                    $query->where('atasan_id', $id_user);
                endif;

                if ($jabatan_user == 'Business Division Head'):
                    $query->where('atasan_id', $atasan_id);
                endif;
            });

            return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('tanggal_apply', function($row){
                $tanggal_apply = date('d-m-Y', strtotime($row->tanggal_apply));

                return $tanggal_apply;
            })
            ->addColumn('tenor', function($row){
                $tenor = $row->tenor. ' bulan';

                return $tenor;
            })
            ->addColumn('plafond', function($row){
                $plafond = 'Rp '.number_format($row->plafond);

                return $plafond;
            })

            ->addColumn('report', function($row){

                $report = '<div class="btn-group">
                <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">Financial Highlight </button>

                    <div class="dropdown-menu">
                        <li class="nav-item"><a class="nav-link" href="'.url('detail-laporan-posisi-keuangan', $row->sandi_bpr).'">Laporan Posisi Keuangan</a></li>
                        <li class="nav-item"><a class="nav-link" href="'.url('detail-laporan-laba-rugi', $row->sandi_bpr).'">Laporan Laba Rugi</a></li>
                        <li class="nav-item"><a class="nav-link" href="'.url('detail-laporan-aset-produktif', $row->sandi_bpr).'">Laporan Aset Produktif</a></li>
                        <li class="nav-item"><a class="nav-link" href="'.url('histori-ratio', $row->sandi_bpr).'">Histori Ratio</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">Tingkat Kesehatan Bank</a></li>
                    </div>
                </div>';

                return $report;
            })
            ->addColumn('action', function($row){

                $actionBtn = '<div class="dropdown">
                    <button class="btn btn-xs btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">


                            <li><a class="test" tabindex="-1" href="#">Upload Excel <span class="caret"></span></a>
                                <ul>
                                    <li><a tabindex="-1" href="'.url('import-laporan-posisi-keuangan', $row->sandi_bpr).'">Import Laporan Posisi Keuangan</a></li>
                                    <li><a tabindex="-1" href="'.url('import-laporan-laba-rugi', $row->sandi_bpr).'">Import Laporan Laba Rugi</a></li>
                                    <li><a tabindex="-1" href="'.url('import-laporan-aset-produktif', $row->sandi_bpr).'">Import Laporan Aset Produktif</a></li>
                                </ul>
                            </li>
                            <br/>
                            <li><a class="test" tabindex="-1" href="'.url('jawaban-pertanyaan-bpr', $row->sandi_bpr).'">Manajemen Scoring<span class="caret"></span></a>
                            <br/>
                            <li><a tabindex="-1" href="#">NAK</a></li>

                        </ul>
                    </div>';


                return $actionBtn;
            })
            ->escapeColumns([]) // untuk render tag HTML
            ->rawColumns(['report'])
            ->make(true);

        endif;

        return view('loan-monitoring/index');
    }
}
