<style>
.sidebar-body {
    overflow-y: auto;
    height: auto;
    width: auto;
}
</style>

<nav class="sidebar bg-primary">
    <div class="sidebar-header">
    <a href="#" class="sidebar-brand"><img src="{{ url('logo/jterush-mania.png') }}" width="150px"></a>
        <div class="sidebar-toggler not-active">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>

    <div class="sidebar-body">
        <ul class="nav">
            <li class="nav-item nav-category">Main Menu</li>

            @if(Auth::user()->jabatan_user->nama_jabatan == 'Superadmin')
           
            <li class="nav-item">
                <a href="{{ url('list-user')}}" class="nav-link">
                    <i class="link-icon" data-feather="user"></i>
                    <span class="link-title">User</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#setup-product" role="button" aria-expanded="false" aria-controls="setup-product">
                    <i class="link-icon" data-feather="layout"></i><span class="link-title">Setup Product</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="setup-product">
                    <ul class="nav sub-menu">
                        <li class="nav-item">
                            <a href="{{ url('product')}}" style="font-size: 14px;" class="nav-link">Product</a>
                        </li>
                    </ul>
                </div>
            </li>
            @endif

            @if(Auth::user()->divisi == 'Business Division')
            <li class="nav-item">
                <a href="{{ url('list-data-bpr')}}" class="nav-link">
                    <i class="link-icon" data-feather="archive"></i>
                    <span class="link-title">Master Data BPR</span>
                </a>
            </li>
            @endif

            @php $divisi = array('Credit Risk Reviewer', 'Compliance', 'Legal', 'Credit Administration', 'Business Division') @endphp
            @if(in_array(Auth::user()->divisi, $divisi))
            {{-- <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#workflow" role="button" aria-expanded="false" aria-controls="financial">
                    <i class="link-icon" data-feather="activity"></i><span class="link-title">Loan Application</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="workflow">
                    <ul class="nav sub-menu">
                        <li class="nav-item" style="font-size: 14px;"><a href="{{ url('proses-workflow')}}" class="nav-link">Proses Data</a></li>
                    </ul>
                </div>
            </li>--}}

            <li class="nav-item">
                <a href="{{ url('proses-workflow')}}" class="nav-link">
                    <i class="link-icon" data-feather="activity"></i>
                    <span class="link-title">Loan Applicant</span>
                </a>
            </li>

            @endif

            @if(Auth::user()->jabatan_user->nama_jabatan == 'Superadmin')
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#config" role="button" aria-expanded="false" aria-controls="tks">
                    <i class="link-icon" data-feather="settings"></i><span class="link-title">Config</span>
                    <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="config">
                    <ul class="nav sub-menu">

                        <li class="nav-item">
                            <a href="{{ url('coa')}}" style="font-size: 13px;" class="nav-link">COA</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('branch')}}" style="font-size: 13px;" class="nav-link">Branch</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('region')}}" style="font-size: 13px;" class="nav-link">Region</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('manajemen-pertanyaan')}}" style="font-size: 13px;" class="nav-link">Manajemen Scoring</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('jabatan')}}" style="font-size: 13px;" class="nav-link">Jabatan</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('jabatan-bpr')}}" style="font-size: 13px;" class="nav-link">Jabatan BPR</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('jenis-pengajuan')}}" style="font-size: 13px;" class="nav-link">Jenis Pengajuan</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('bwmk')}}" style="font-size: 13px;" class="nav-link">BWMK</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('informasi-grup-usaha')}}" style="font-size: 13px;" class="nav-link">Grup Usaha</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('master-jawaban-pertanyaan')}}" style="font-size: 11px;" class="nav-link">Master Pertanyaan & Jawaban</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('skema-kredit')}}" style="font-size: 14px;" class="nav-link">Skema Kredit</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ url('fasilitas-kredit')}}" style="font-size: 14px;" class="nav-link">Fasilitas Kredit</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#tks" role="button" aria-expanded="false" aria-controls="tks">
                    <i class="link-icon" data-feather="activity"></i><span class="link-title" style="font-size: 13px;">Tingkat Kesehatan Bank</span>
                     <i class="link-arrow" data-feather="chevron-down"></i>
                </a>

                <div class="collapse" id="tks">
                    <ul class="nav sub-menu">

                        <li class="nav-item">
                            <a class="nav-link" style="font-size: 13px;" href="{{ url('komponen-tks') }}" class="nav-link">Komponen TKS</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" style="font-size: 13px;" href="{{ url('nilai-komponen-tks') }}" class="nav-link">Nilai Komponen TKS</a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link" style="font-size: 13px;" href="{{ url('predikat-tks') }}" class="nav-link">Predikat TKS</a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="nav-item">
                <a href="{{ url('logs')}}" class="nav-link">
                    <i class="link-icon" data-feather="archive"></i>
                    <span class="link-title">Log Histori</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('backup-database')}}" class="nav-link">
                    <i class="link-icon" data-feather="database"></i>
                    <span class="link-title">Backup Database</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ url('setting-flow') }}" class="nav-link">
                    <i class="link-icon" data-feather="chevrons-up"></i>
                    <span class="link-title">Setting Flow</span>
                </a>
            </li>
             @endif

            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="{{ route('logout') }}" role="button" aria-controls="logout" aria-expanded="false"
                aria-controls="logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="link-icon" data-feather="log-out" ></i><span class="link-title">Log Out</span>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    </form>
                </a>
            </li>
        </ul>
    </div>
</nav>
