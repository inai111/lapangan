@extends('layouts.main')

@section('navbar')
    @include('partials.main')
@endsection
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection
@section('content')
    <div class="banner-1 py-3 px-5 mt-2 shadow">
        <div class="mx-3 my-4">
            {{-- <h1>Jenis Olahraga</h1> --}}
            <div class="row justify-content-center">
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-solid fa-basketball fa-3x"></i>
                        </div>
                        <h3 class="my-2">Bola Basket</h3>
                    </button>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-regular fa-futbol fa-3x"></i>
                        </div>
                        <h3 class="my-2">Sepak Bola</h3>
                    </button>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-regular fa-futbol fa-3x"></i>
                        </div>
                        <h3 class="my-2">Mini Soccer</h3>
                    </button>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-regular fa-futbol fa-3x"></i>
                        </div>
                        <h3 class="my-2">Futsal</h3>
                    </button>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-solid fa-baseball fa-3x"></i>
                        </div>
                        <h3 class="my-2">Tennis</h3>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="py-3 px-5 mt-2">
        <div class="me-3 my-4">
            {{-- <h1>Jenis Olahraga</h1> --}}
            <div class="row justify-content-center align-items-center">
                <div class="col-3 text-center">
                    <div class="card">
                        <div class="card-body">
                          <h5 class="card-title">Lapangan</h5>
                          <h6 class="card-subtitle mb-2 text-muted">Rekomendasi</h6>
                        </div>
                    </div>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-solid fa-basketball fa-3x"></i>
                        </div>
                        <h3 class="my-2">Bola Basket</h3>
                    </button>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-solid fa-basketball fa-3x"></i>
                        </div>
                        <h3 class="my-2">Bola Basket</h3>
                    </button>
                </div>
                <div class="col-2 text-center">
                    <button class="btn btn-outline-dark w-100">
                        <div class="p-3 py-5">
                            <i class="fa-solid fa-basketball fa-3x"></i>
                        </div>
                        <h3 class="my-2">Bola Basket</h3>
                    </button>
                </div>
                <div class="col-1 text-center">
                    <button class="btn btn-outline-dark w-100">
                            <i class="fa-solid fa-chevron-right fa-3x"></i>
                    </button>
                </div>
            </div>
            
        </div>
    </div>
    {{-- modal regis&login --}}
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Login Form</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="loginForm">
                        <div id="loginFormMessage" class="alert alert-success" style="display: none"></div>
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" name="username" class="form-control" id="username">
                            <div id="username-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <div id="password-msg"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-dark" id="toRegistForm">Register Here</a>
                            <button type="submit" class="btn btn-dark w-50">Login</button>
                        </div>
                    </form>
                    <form id="registForm" style="display:none;">
                        <div id="registFormMessage" class="alert alert-success" style="display:none"></div>
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="col-form-label">Username:</label>
                            <input type="text" name="username" class="form-control" id="username">
                            <div id="username-regist-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="col-form-label">Name:</label>
                            <input type="text" name="name" class="form-control" id="name">
                            <div id="name-regist-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="number" class="col-form-label">Phone Number:</label>
                            <input type="text" name="number" class="form-control" id="number">
                            <div id="number-regist-msg"></div>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="col-form-label">Password:</label>
                            <input type="password" class="form-control" name="password" id="password">
                            <div id="password-regist-msg"></div>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-dark" id="toLoginForm"><i
                                    class="fa-solid fa-arrow-left text-light"></i></button>
                            <button type="submit" class="btn btn-dark w-75">Register Now</button>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal search --}}
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                {{-- <div class="modal-header my-0">
                    <button type="button" class="btn-close btn-sm" data-bs-dismiss="modal" aria-label="Close"></button>
                </div> --}}
                <div class="modal-body">
                    <form id="autoCompleteSearch" method="get">
                        <div class="input-group input-group-sm p-3">
                            <div class="d-flex align-items-center text-muted border w-100 px-3 rounded searchBarDiv">
                                <span id="icon"><i class="fa-solid fa-magnifying-glass"></i></span>
                                <input style="border: none;box-shadow:none" autocomplete="off" type="text" placeholder="Looking for a place to match" name="search"
                                class="form-control form-control-lg" aria-label="Search Here"
                                aria-describedby="inputGroup-sizing-default">
                                <button class="btn" id="resetSearchBar"><i class="fa fa-times"></i></button>
                            </div>
                        </div>
                    </form>
                    <div id="nullHasilSearch">
                        <div class="text-center text-muted py-3">
                            <h3><i class="fa-solid fa-question fa-4x"></i></h3>
                            <h3>Mau Main Dimana Nih</h3>
                        </div>
                    </div>
                    <div id="sortHasilSearch">
                        <div class="mx-3 py-2 border-bottom d-flex">
                            <button data-value="newest" data-sort class="btn me-1 btn-sm btn-secondary">Newest</button>
                            <button data-value="oldest" data-sort class="btn me-1 btn-sm btn-secondary">Oldest</button>
                            <button data-value="most-expensive" data-sort class="btn me-1 btn-sm btn-secondary">Most Expensive</button>
                            <button data-value="cheapest" data-sort class="btn me-1 btn-sm btn-secondary">Cheapest</button>
                        </div>
                    </div>
                    <div id="hasilSearch" class="list-group">
                        <a href="#" class="list-group-item list-group-item-action" aria-current="true">
                            <div class="row">
                                <div class="col-3 autocomplete-img"
                                    style="background-image:url(https://akcdn.detik.net.id/community/media/visual/2021/06/13/lapangan-galuh-pakuan-lapangan-bola-desa-3_169.jpeg?w=700&q=90)">
                                </div>
                                <div class="col-9">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">List group item heading</h5>
                                        <small>3 days ago</small>
                                    </div>
                                    <p class="mb-1">Some placeholder content in a paragraph.</p>
                                    <small>And some small print.</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/home.js') }}"></script>
@endsection
