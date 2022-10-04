<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="/images/profile/pic1.jpg" width="20" alt=""/>
                    <div class="header-info ms-3">
                        <span class="font-w600 ">Hi, <b> {{ Auth::user()->name }}     </b></span>
                        <small class="text-end font-w400">{{ Auth::user()->email }} </small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="/app-profile.html" class="dropdown-item ai-icon">
                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        <span class="ms-2">Profile </span>
                    </a>
                    <a class="dropdown-item ai-icon" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                  document.getElementById('logout-form').submit();">
                     
                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                        <span class="ms-2">{{ __('Logout') }} </span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </li>
            <li><a class="ai-icon" href="/" aria-expanded="false">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li><a href="/edit_transaksi" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-013-checkmark"></i>
                    <span class="nav-text">Edit Transaksi</span>
                </a>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-072-printer"></i>
                    <span class="nav-text">Data Referensi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="/data_truk">Data Truk</a></li>
                    <li><a href="/data_ekspenditur">Data Ekspenditur</a></li>
                    <li><a href="/data_tipe_truk">Data Tipe Truk</a></li>
                    <li><a href="/data_jumlah_roda">Data Jumlah Roda</a></li>
                    <li><a href="/users">Data user</a></li>
                    <li><a href="/data_group">Data Group</a></li>
                    <li><a href="/permission">Data Permission</a></li>
                    <li><a href="/roles">Data Roles</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-022-copy"></i>
                    <span class="nav-text">Info</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="/reprint_struck">Info Truk</a></li>
                    <li><a href="/unduh_laporan">Info Ekspenditur</a></li>
                    <li><a href="/email_list">List Group</a></li>
                    <li><a href="/database_truk">Cek Absen</a></li>
                    <li><a href="/database_truk">Login History</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-022-copy"></i>
                    <span class="nav-text">Laporan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="/reprint_struck">Reprint Struck</a></li>
                    <li><a href="/unduh_laporan">Unduh Laporan</a></li>
                    <li><a href="/email_list">Email List</a></li>
                    <li><a href="/database_truk">Database Truk</a></li>
                </ul>
            </li>
            <li>
                <a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-022-copy"></i>
                    <span class="nav-text">Konsolidasi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="/reprint_struck">Timbangan masuk = keluar</a></li>
                    <li><a href="/unduh_laporan">Tambah Transaksi</a></li>
                    <li><a href="/email_list">Persentasi Berat Nett</a></li>
                    <li><a href="/database_truk">Cek Ritasi</a></li>
                    <li><a href="/database_truk">Double Ritasi (Jam)</a></li>
                    <li><a href="/database_truk">Hapus Transaksi</a></li>
                    <li><a href="/database_truk">Batch Update</a></li>
                    <li><a href="/database_truk">Import trans</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>