@extends('layouts.main')

@section('iseng', 'title')
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
@endsection
@section('content')
    @include('partials.admin')
    <div id="layoutSidenav">
        @include('partials.sidebarAdmin')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Dashboard</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                    <div class="row">
                        @if($user['level']!='admin')
                            {{-- <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-light mb-4">
                                    <div class="card-body">Pemesanan Lapangan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/user-booklists">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div> --}}
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Transaksi</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/user-transactions">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            @if($merchant && in_array($merchant['active'],['active','suspended']))
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Lapangan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/merchant-lapangan">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Saldo</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        @else
                        <div class="col-xl-3 col-md-6">
                            <div class="card bg-primary text-white mb-4">
                                <div class="card-body">Merchant Applicant</div>
                                <div class="card-footer d-flex align-items-center justify-content-between">
                                    <a class="small text-white stretched-link" href="/admin-merchant?status=pending">View Details</a>
                                    <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        @endif

                    </div>
                    <div class="row">
                        <div class="col-8">
                            @if ($merchant && $user['level']!='admin')
                                @switch($merchant['active'])
                                    @case('pending')
                                    <div class="alert alert-info alert-dismissible fade show" role="alert">
                                        <strong>Informasi Akun Merchant Kamu!</strong> Tunggu hingga ada informasi lebih lanjut ya di dashboard ini, admin sedang memverifikasi data kamu!!
                                        {{-- <a href="/merchant-regist" class="card-link">Daftar Jadi Merchant</a> --}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @break
                                    @case('suspended')
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Informasi Akun Merchant Kamu!</strong> Akun anda sedang dalam masa suspend oleh admin!
                                        {{-- <a href="/merchant-regist" class="card-link">Daftar Jadi Merchant</a> --}}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                        @break
                                    @case('rejected')
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Informasi Akun Merchant Kamu!</strong> Mohon maaf, akun merchant kamu ditolak admin, mohon masukkan kembali data data merchant anda!
                                        <a href="/merchant-regist" class="card-link">Daftar Jadi Merchant</a>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    
                                    @break
                                        
                                @endswitch
                            @endif
                        </div>
                    </div>
                </div>
            </main>
            {{-- <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer> --}}
        </div>
    </div>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
