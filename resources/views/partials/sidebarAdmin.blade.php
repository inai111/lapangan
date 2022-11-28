<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">
                <div class="sb-sidenav-menu-heading">Core</div>
                <a class="nav-link {{Request::is('dashboard*')?'active':''}}" href="/dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Dashboard
                </a>
                @if(session('role')=='user')
                <a class="nav-link {{Request::is('dashboard*')?'active':''}}" href="/dashboard">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Transaksi
                </a>
                @endif
                @if(session('role')=='admin')
                <a class="nav-link {{Request::is('admin-merchant*')?'active':''}}" href="/admin-merchant">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Merchant
                </a>
                <a class="nav-link {{Request::is('request-saldo*')?'active':''}}" href="/request-saldo">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Request Saldo
                </a>
                @endif
                @if(session('role')=='merchant')
                <a class="nav-link {{Request::is('merchant-lapangan*')?'active':''}}" href="/merchant-lapangan">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Lapangan
                </a>
                <a class="nav-link {{Request::is('request-balance*')?'active':''}}" href="/request-balance">
                    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                    Tarik Saldo
                </a>
                @endif
            </div>
        </div>
        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            {{session('username')}}
        </div>
    </nav>
</div>