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
                    @if (!empty($merchant) && $merchant->status_merchant == 'pending')
                        <div class="alert alert-dismissible alert-info">
                            <h6><i class="fa-solid fa-circle-exclamation"></i> Permintaan pendaftaran merchant kamu sedang
                                kami verifikasi, mohon untuk menunggu sebentar! </h6>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true"></button>
                        </div>
                    @endif
                    <div class="row">
                        @if ($user['role'] != 'admin')
                            {{-- <div class="col-xl-3 col-md-6">
                                <div class="card bg-secondary text-light mb-4">
                                    <div class="card-body">Pemesanan Lapangan</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="/user-booklists">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div> --}}
                            @if (session('role') == 'user')
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body">Transaksi</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="/user-transactions">View
                                                Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            @if ($merchant && session('role') == 'merchant')
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-danger text-white mb-4">
                                        <div class="card-body">
                                            Penyewa
                                            @if ($ongoing_booklist)
                                                <div class="badge bg-danger ms-1">{{ count($ongoing_booklist) }}</div>
                                            @endif
                                        </div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="/merchant-transaction-list">View
                                                Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-primary text-white mb-4">
                                        <div class="card-body">Lapangan</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="/merchant-lapangan">View
                                                Details</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 col-md-6">
                                    <div class="card bg-success text-white mb-4">
                                        <div class="card-body">Saldo</div>
                                        <div class="card-footer d-flex align-items-center justify-content-between">
                                            <a class="small text-white stretched-link" href="/request-balance">Tarik
                                                Saldo</a>
                                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @else
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body d-flex">
                                        Merchant Applicant
                                        @if (count($pending_merchant)>0)
                                            <div class="badge bg-danger ms-auto rounded-pill">
                                                {{ count($pending_merchant) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link"
                                            href="/admin-merchant?status=pending">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body d-flex">
                                        Merchant Request Balance
                                        @if ($request_saldo>0)
                                            <div class="badge bg-danger ms-auto rounded-pill">
                                                {{ $request_saldo }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link"
                                            href="/admin-merchant?status=pending">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        @endif

                    </div>
                    <div class="row">
                        <div class="col-8">
                            @if ($merchant && $user['role'] != 'admin')
                                @switch($merchant['active'])
                                    @case('pending')
                                        <div class="alert alert-info alert-dismissible fade show" role="alert">
                                            <strong>Informasi Akun Merchant Kamu!</strong> Tunggu hingga ada informasi lebih lanjut
                                            ya di dashboard ini, admin sedang memverifikasi data kamu!!
                                            {{-- <a href="/merchant-regist" class="card-link">Daftar Jadi Merchant</a> --}}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @break

                                    @case('suspended')
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <strong>Informasi Akun Merchant Kamu!</strong> Akun anda sedang dalam masa suspend oleh
                                            admin!
                                            {{-- <a href="/merchant-regist" class="card-link">Daftar Jadi Merchant</a> --}}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @break

                                    @case('rejected')
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>Informasi Akun Merchant Kamu!</strong> Mohon maaf, akun merchant kamu ditolak
                                            admin, mohon masukkan kembali data data merchant anda!
                                            <a href="/merchant-regist" class="card-link">Daftar Jadi Merchant</a>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                    @break
                                @endswitch
                            @endif
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
