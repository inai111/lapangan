@extends('layouts.main')

@section('navbar')
    @include('partials.main')
@endsection
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection
@section('content')
    <div class="container bg-light my-4">
        <h4 class="display-4">Pencarian</h4>
        <form method="get" class="mb-3">
            <div class="border d-flex align-items-center shadow-md">
                <div class="d-none d-lg-block d-md-block px-2 border-end">
                    Pencarian
                </div>
                <div class="d-block d-lg-none d-md-none px-2 border-end">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </div>
                <input type="text" name="search" class="w-100 form-control border-0 shadow-none" value="{{Request::get('search')}}">
                <select name="type" class="form-control border-0 shadow-none" style="width: fit-content;" id="typeSearch">
                    <option value="all" selected>All</option>
                    <option value="merchant" {{Request::get('type') == 'merchant'?"selected":''}}>Merchant</option>
                    <option value="lapangan" {{Request::get('type') == 'lapangan'?"selected":''}}>Lapangan</option>
                </select>
                <select name="jenis" class="form-control border-0 shadow-none d-none" style="width: fit-content;" id="jenisSearch">
                    <option value="" selected>Pilih Jenis Olahraga</option>
                    @foreach ($jenis as $item)
                    <option value="{{strtolower($item->nama)}}" {{strtolower(Request::get('jenis')) == strtolower($item->nama)?"selected":''}}>{{$item->nama}}</option>
                    @endforeach
                </select>
            </div>
        </form>
        <small class="text-muted">Menampilkan data: <strong>{{count($queries)>10?10:count($queries)}}</strong> dari <strong>{{count($queries)}}</strong> data{{in_array(Request::get('type'),['merchant','lapangan'])?' '.Request::get('type'):''}}.</small>
        <div class="row mt-3">
            @foreach (array_slice($queries,0,10) as $key=>$query)
            <div class="col-lg-6 col-12 mb-2">
                <div class="card h-100">
                    @if (!empty($query->merchant_id))
                    @php
                        # untuk aset lapangan
                        $dir_name = str_replace(' ', '_', $query->nama);
                        $assets_image = asset('/assets/img/'.$dir_name.'/cover/'.$query->cover);
                    @endphp                       
                    <div class="row g-0 align-items-center my-auto" style="background:linear-gradient(rgba(0,0,0,.5),rgba(0,0,0,.3)),url({{$assets_image}}) center/cover no-repeat">
                        <div class="col-md-4">
                            <img style="object-fit: cover;width: 100%;height: 5vw;" src="{{$assets_image}}" class="img-fluid rounded-end" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-light"><a class="nav-link" href="/lapangan/{{$query->id}}">{{$query->nama}}</a></h5>
                                <p class="card-text text-truncate text-light" style="width: fit-content"><a class="nav-link" href="/merchant/{{$query->merchant_id}}"><i class="fas fa-user me-2"></i>{{$query->merchant->nama}}</a></p>
                            </div>
                        </div>
                    </div>
                    @if (isset($rating_lapangan[$query->id]))
                    <div class="position-absolute align-items-center gap-2 me-2 mt-2 top-0 end-0 d-flex">
                        <div class="rounded-pill badge bg-danger px-2 py-1">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i<=$rating_lapangan[$query->id]['rating'])
                                <i class="fas fa-star text-warning"></i>
                                @else
                                <div class="fas fa-star text-muted"></div>
                                @endif
                                @endfor
                                (<strong>{{$rating_lapangan[$query->id]['jumlah_booklist']}}</strong>)
                        </div>
                    </div>
                    @endif
                    <div class="position-absolute align-items-center mb-2 bottom-0 end-0">
                        <div class="badge bg-danger py-2 px-4" style="border-radius: 20px 0 0 20px;"><strong>Rp.{{number_format($query->harga,0,',','.')}}</strong>/Jam</div>
                    </div>
                    @else
                    @php
                        # untuk aset merchant
                        $assets_image = asset('/assets/img/profilpic/'.$query->user->foto);
                    @endphp
                    <div class="row g-0 align-items-center my-auto" style="background:linear-gradient(rgba(220,53,69,.9),rgba(220,53,69,.9)),url({{$assets_image}}) center/cover no-repeat">
                        <div class="col-md-4 text-center">
                            <img style="object-fit: cover;width:5vw;height: 5vw;" src="{{$assets_image}}" class="img-fluid rounded-circle" alt="...">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title text-light"><a class="nav-link" href="/merchant/{{$query->id}}">{{$query->nama}}</a></h5>
                                <p class="card-text text-truncate w-50 text-light"><i class="fas fa-restroom me-2"></i>{{!empty($fasilitas_merchant[$query->id])?$fasilitas_merchant[$query->id]:'Tidak ada Fasilitas'}}</p>
                            </div>
                        </div>
                    </div>
                    @if (isset($rating_merchant[$query->id]))
                    <div class="position-absolute align-items-center gap-2 me-2 mt-2 top-0 end-0 d-flex">
                        <div class="rounded-pill badge bg-danger px-2 py-1">
                            @for ($i = 1; $i <= 5; $i++)
                            @if ($i<=$rating_merchant[$query->id]['rating_merchant'])
                            <i class="fas fa-star text-warning"></i>
                            @else
                            <div class="fas fa-star text-muted"></div>
                            @endif
                            @endfor
                            (<strong>{{$rating_merchant[$query->id]['jumlah_booklist_merchant']}}</strong>)
                        </div>
                    </div>
                    @endif
                    <div class="position-absolute align-items-center mb-2 bottom-0 end-0">
                        <div class="badge bg-danger py-2 px-4" style="border-radius: 20px 0 0 20px;">{{count($query->lapangan)}} Lapangan</div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @if (!empty($queries))
    @endif


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
    <script>
        document.querySelector(`#typeSearch`).addEventListener('change', function(e){
            if(this.value == 'lapangan'){
                document.querySelector(`#jenisSearch`).classList.remove('d-none');
            }else{
                document.querySelector(`#jenisSearch`).classList.add('d-none');
                document.querySelector(`#jenisSearch`).value = '';
            }
        })
        document.querySelector(`#typeSearch`).dispatchEvent(new Event('change'));
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/home.js') }}"></script>
@endsection
