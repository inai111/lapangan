@extends('layouts.main')
@section('iseng', 'title')
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/setting.css') }}">
@endsection
@section('content')
    @include('partials.admin')
    <div id="layoutSidenav">
        @include('partials.sidebarAdmin')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Setting</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Setting</li>
                    </ol>
                    @if (empty($merchant))
                        <div class="alert alert-secondary alert-dismissible fade show" role="alert">
                            <strong>Ayo Jadi Merchant!</strong> Lengkapi dulu informasi akun kamu, kemudian daftarkan tempat
                            lapangan kamu di website kami, agar banyak orang yang melihat dan memesan lapangan kamu!! <a
                                href="/merchant-regist" class="card-link">Daftar Jadi Merchant</a>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @elseif(!empty($merchant) && !in_array($merchant->active,['pending','rejected']))
                        <div class="my-4 text-end">
                            <a href="/settings/1" class="btn btn-outline-dark rounded-pill py-1 px-4">Edit Merchant <i class="fa fa-chevron-right"></i></a>
                        </div>
                    @endif
                    <form action="">
                        @csrf
                        <div id="form-msg"></div>
                        @if (session('success-message'))
                            <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                                {{session('success-message')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif(session('failed-message'))
                            <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
                                {{session('failed-message')}}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <div class="mx-auto profilpic"
                            style="background-image:url({{ asset('assets/img/profilpic/default.png') }})"></div>
                        <div class="text-center"><strong>Profil Picture</strong></div>
                        <div class="my-3 mb-5">
                            <div class="form-floating mb-3">
                                <input type="text" value="{{ $userdata->username }}" disabled readonly
                                    class="form-control" id="username" placeholder="username">
                                <label for="username">Username</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" value="{{ $userdata->created_at }}" readonly
                                    disabled id="created" placeholder="created">
                                <label for="created">Di Buat Tanggal</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="nama" value="{{ $userdata->name }}" class="form-control"
                                    id="nama" placeholder="nama">
                                <label for="nama">Nama Lengkap</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="number" value="{{ $userdata->number }}" class="form-control"
                                    id="number" placeholder="number">
                                <label for="number">Nomor Telepon</label>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="address" name="address" style="height: 100px">{{ $userdata->address }}</textarea>
                                <label for="address">Alamat</label>
                            </div>
                            <div class="my-4 text-center">
                                <button type="submit" class="btn btn-dark w-75">Simpan</button>
                            </div>
                        </div>
                    </form>
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
    {{-- modal profil pic --}}
    <div class="modal fade" id="changePicModal" tabindex="-1" aria-labelledby="changePicModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePicModalLabel">Change Profil Picture</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @for ($i = 0; $i < 5; $i++)
                            <div class="col-3 profilpic mx-2 my-1 {{ $i == 0 ? 'choosen' : '' }}"
                                data-image="{{ $i == 0 ? 'default.png' : "default$i.png" }}"
                                style="background-image: url({{ asset($i == 0 ? 'assets/img/profilpic/default.png' : "assets/img/profilpic/default$i.png") }})">
                            </div>
                        @endfor
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="changeImage" class="btn btn-dark" data-bs-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/setting.js') }}"></script>

@endsection
