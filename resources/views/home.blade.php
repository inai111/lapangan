@extends('layouts.main')

@section('navbar')
    @include('partials.main')
@endsection
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection
@section('content')
    @if (!empty($rekomendasi))
        <div class="banner-1 py-3 px-5 mt-2 shadow">
            <div class="mx-3 my-4">
                {{-- <h1>Jenis Olahraga</h1> --}}
                <div class="row justify-content-center">
                    @foreach ($rekomendasi as $key=>$rate)
                    @if ($loop->iteration == 1)
                    <div class="col-8 col-lg-5 col-sm-7 col-md-5 text-center">
                        <div class="card mb-3 h-100">
                            <div class="row g-0 align-items-center my-auto">
                                <div class="col-md-4">
                                    <img style="object-fit: cover;width: 100%;height: 15vw;" src="/assets/img/lapangan/cover/default.png" class="img-fluid rounded-end" alt="...">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><a class="nav-link" href="/lapangan/{{$key}}">{{$lapangan_rekomendasi[$key]['nama']}}</a></h5>
                                        <p class="card-text text-truncate"><a class="nav-link" href="/merchant/{{$lapangan_rekomendasi[$key]['merchant_id']}}"><i class="fas fa-user me-2"></i>{{$lapangan_rekomendasi[$key]->merchant['nama']}}</a></p>
                                        <p class="card-text">
                                            <div class="d-flex justify-content-center align-items-baseline">
                                                @if ($rating_almanak[$key])
                                                @for ($i = 1; $i <= 5; $i++)
                                                @if ($rating_almanak[$key]['rating']>=$i)
                                                <div class="fas fa-star text-warning"></div>
                                                @else
                                                <div class="far fa-star text-muted"></div>
                                                @endif
                                                @endfor
                                                <strong>
                                                    ({{$rating_almanak[$key]['jumlah_booklist']}})
                                                </strong>
                                                @endif
                                            </div>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="position-absolute align-items-center gap-2 me-2 mt-2 top-0 end-0 d-flex">
                                <div class="rounded-pill badge bg-danger px-2 py-1"><strong>{{$rate}}%</strong></div>
                                <i class="fa-solid fa-circle-exclamation text-secondary fs-4"></i>
                            </div>
                            <div class="position-absolute align-items-center mb-2 bottom-0 end-0">
                                <div class="badge bg-danger fs-4 py-2 px-4" style="border-radius: 20px 0 0 20px;"><strong>Rp.{{number_format($lapangan_rekomendasi[$key]['harga'],0,',','.')}}</strong>/Jam</div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    <div class="col-4 col-md-7 col-sm-5 col-lg-7 text-center">
                        <div class="row">
                            @foreach ($rekomendasi as $key=>$rate)
                            @if($loop->iteration > 1 && $loop->iteration <=3)
                            <div class="col-6 d-none d-lg-block">
                                <div class="card h-100 justify-content-center align-items-center">
                                    <img style="object-fit: cover;width: 100%;height: 15vw;" src="/assets/img/lapangan/cover/default.png" class="card-img-top" alt="...">
                                    <div class="position-absolute text-start start-0 bottom-0 mb-2 ms-2">
                                        <div class="fs-4">
                                            <strong class="text-light" style="text-shadow: 0 0 8px black"><a class="nav-link" href="/lapangan/{{$key}}">{{$lapangan_rekomendasi[$key]['nama']}}</a></strong>
                                        </div>
                                    </div>
                                    <div class="position-absolute align-items-center gap-2 ms-2 mt-2 top-0 start-0">
                                        <div class="rounded-pill badge bg-danger px-2 py-1"><strong>Rp.{{number_format($lapangan_rekomendasi[$key]['harga'],0,',','.')}}</strong>/Jam</div>
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-center align-items-baseline rounded-pill badge bg-danger">
                                                @if ($rating_almanak[$key])
                                                @for ($i = 1; $i <= 5; $i++)
                                                @if ($rating_almanak[$key]['rating']>=$i)
                                                <div class="fas fa-star text-warning"></div>
                                                @else
                                                <div class="far fa-star"></div>
                                                @endif
                                                @endfor
                                                <strong>
                                                    ({{$rating_almanak[$key]['jumlah_booklist']}})
                                                </strong>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="position-absolute align-items-center gap-2 me-2 mt-2 top-0 end-0 d-flex">
                                        <div class="rounded-pill badge bg-danger px-2 py-1"><strong>{{$rate}}%</strong></div>
                                        <i class="fa-solid fa-circle-exclamation text-secondary fs-4"></i>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endforeach
                            {{-- <div class="col-6 d-none d-lg-block">
                                <div class="card h-100 justify-content-center align-items-center">
                                    <img style="object-fit: cover;width: 100%;height: 15vw;" src="/assets/img/lapangan/cover/default.png" class="card-img-top" alt="...">
                                    <div class="position-absolute text-start start-0 bottom-0 mb-2 ms-2">
                                        <div class="fs-4">
                                            <h5 class="card-title"><a class="nav-link" href="/lapangan/{{$key}}">{{$lapangan_rekomendasi[$key]['nama']}}</a></h5> --}}

                                            {{-- <strong class="text-light" style="text-shadow: 0 0 8px black">Rp.200000</strong> --}}
                                        {{-- </div>
                                    </div>
                                    <div class="position-absolute align-items-center gap-2 ms-2 mt-2 top-0 start-0 d-flex">
                                        <div class="rounded-pill badge bg-danger px-2 py-1"><strong>Rp.2.000.000</strong>/Jam</div>
                                    </div>
                                    <div class="position-absolute align-items-center gap-2 me-2 mt-2 top-0 end-0 d-flex">
                                        <div class="rounded-pill badge bg-danger px-2 py-1"><strong>75%</strong></div>
                                        <i class="fa-solid fa-circle-exclamation text-secondary fs-4"></i>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    @endif

        <div class="banner-1 py-3 px-5 mt-2 shadow">
            <div class="mx-3 my-4">
                {{-- <h1>Jenis Olahraga</h1> --}}
                <div class="row">
                    <div class="col-2 d-none d-lg-block">
                        <div class="card h-100 justify-content-center align-items-center">
                            <div class="w-100" style="height: 15vw;background:linear-gradient(rgba(255,255,255,.9),rgba(255,255,255,.9)),url({{asset("/assets/img/lapangan/cover/default.png")}}) center/cover no-repeat"></div>
                            <div class="position-absolute fs-3 text-center">
                                <strong>DARI YANG ANDA CARI</strong>
                                <a class="btn btn-danger rounded-pill btn-sm">Lihat Semua</a>
                            </div>
                            
                        </div>
                    </div>
                    @foreach ($lapangan_where as $item)
                        
                    <div class="col-2 d-none d-lg-block">
                        <div class="card overflow-hidden h-100 justify-content-center align-items-center" style="background: linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.5));">
                            <img style="object-fit: cover;width: 100%;height: 15vw;" src="/assets/img/lapangan/cover/default.png" class="card-img-top" alt="...">
                            <div class="position-absolute text-start start-0 bottom-0 mb-2 ms-2">
                                <a href="/lapangan/{{$item->id}}" style="text-decoration: none">
                                    <div class="fs-5">
                                        <strong class="text-light" style="text-shadow: 0 0 8px black">{{$item->nama}}</strong>
                                    </div>
                                </a>
                            </div>
                            <div class="position-absolute ms-2 mt-2 top-0 start-0">
                                <div class="rounded-pill badge bg-danger px-2 py-1"><strong>Rp.{{number_format($item->harga,0,',','.')}}</strong>/Jam</div>
                                <div>
                                    <div class="rounded-pill badge bg-danger px-2 py-1">
                                        <strong>5</strong>
                                        <span class="fas fa-star text-warning"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
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
