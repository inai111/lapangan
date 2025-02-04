@extends('layouts.main')

@section('navbar')
    @include('partials.main')
@endsection
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection
@section('content')
    <div class="container bg-light my-5 py-3">
        <div class="row">
            <div class="col-md-2">
                <div class="img-thumbnail mx-auto rounded-circle"
                    style="background-image:url({{ asset("assets/img/profilpic/{$user['foto']}") }});background-size: 130px;background-repeat: no-repeat;background-color: #8b8e90;background-position: center;width: 150px;height: 150px;">
                </div>
            </div>
            <div class="col-md-10">
                <div class="row align-items-center">
                    <div class="col">
                        <h4 class="display-5">{{ strtolower($merchant->nama) }}</h4>
                    </div>
                    <div class="col text-end">
                        {{-- <button class="btn btn-sm btn-success">asdas</button> --}}
                        <button class="btn btn-sm btn-danger rounded-pill"><i class="fa-solid fa-exclamation"></i> Laporkan</button>
                    </div>
                </div>
                <div>
                    <span class="text-muted me-2">Total Lapangan ({{ count($lapangan) }})</span>
                    <span class="text-muted me-2">{{$rating_data['rating_merchant']??0}} <i class="fa fa-star" style="color: gold"></i> ({{$rating_data['jumlah_booklist_merchant']??0}})</span>
                </div>
                <div class="text-muted me-2">Jam Buka {{ $merchant->buka . ' - ' . $merchant->tutup }}</div>
                <div><i class="fa fa-location-dot"></i>
                    {{ !empty($merchant->alamat) ? $merchant->alamat : $user->alamat }}
                </div>

            </div>
        </div>
        <div class="mt-4">
            <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info-tab-pane"
                        type="button" role="tab" aria-controls="info-tab-pane" aria-selected="true">Lapangan</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="alamat-tab" data-bs-toggle="tab" data-bs-target="#alamat-tab-pane"
                        type="button" role="tab" aria-controls="alamat-tab-pane" aria-selected="false">Fasilitas
                    </button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel" aria-labelledby="info-tab"
                    tabindex="0">
                    <div class="mx-auto">
                        <div class="row row-cols-auto my-2">
                            @foreach ($lapangan as $item)
                                <div class="col-md-3 my-2">
                                    <a href="/lapangan/{{$item->id}}" class="border btn btn-dark position-relative">
                                        <div class="position-relative" style="background:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.2)),url({{ asset("assets/img/{$item->lapangan_cover}/cover/$item[cover]") }});background-size: cover;background-repeat: no-repeat;background-position: center;width: 230px;height: 230px;"
                                            class="card-img-top" alt="{{ $item->nama }}">
                                            <div class="position-absolute top-0 end-0 px-4 rounded-pill text-light" style="background-color: rgba(10, 10, 10,.4);margin-top: 1.7rem;"><i class="fa fa-basketball"></i> {{$item->jenis->nama}}</div>
                                            <div class="position-absolute top-0 end-0 px-4 rounded-pill text-light" style="background-color: rgba(10, 10, 10,.4)">{{isset($rating_data[$item->id])?$rating_data[$item->id]['rating']:0}} <i class="fa fa-star" style="color: gold"></i> ({{isset($rating_data[$item->id])?$rating_data[$item->id]['jumlah_booklist']:0}})</div>
                                        </div>
                                        <div class="position-absolute bottom-0 start-0 end-0 mb-2 px-4 rounded-pill text-light" style="background-color: rgba(10, 10, 10,.4)"><i class="fa fa-tags"></i> Rp. {{number_format($item->harga,0,',','.')}}/Jam</div>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="alamat-tab-pane" role="tabpanel" aria-labelledby="alamat-tab"
                    tabindex="0">
                    <div class="row my-3">
                        @foreach ($fasilitas_merchant as $item)
                        <div class="col-2 px-1 mb-2">
                            <div class="card w-100 h-100">
                                <div class="card-body text-center">
                                    <img src="{{asset('assets/img/fasilitas foto/'.$item->foto)}}" style="width: 100%;height:8vw;object-fit:cover;object-position:center" class="img-thumbnail mb-2" alt="...">
                                  <h5 class="card-title"><i class="fas {{$item->fasilitas->fasilitas_icon}} me-2"></i>{{$item->fasilitas->fasilitas}}</h5>
                                  <p class="card-text">{{$item->deskripsi}}</p>
                                </div>
                              </div>
                        </div>
                        @endforeach
                    </div>
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
                                <input style="border: none;box-shadow:none" autocomplete="off" type="text"
                                    placeholder="Looking for a place to match" name="search"
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
                            <button data-value="most-expensive" data-sort class="btn me-1 btn-sm btn-secondary">Most
                                Expensive</button>
                            <button data-value="cheapest" data-sort
                                class="btn me-1 btn-sm btn-secondary">Cheapest</button>
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
        pesanNow.addEventListener(`click`, function(e) {
            if (!this.dataset.login) {
                loginBtn.click();
                return;
            }
            let lengthVal = Number(lengthForm.value) > 0 ? lengthForm.value : "1";
            fetch(`/add-transaction/${this.dataset.id}?length=${lengthVal}`)
                .then(ee => ee.json())
                .then(res => {
                    if (res.status) {
                        window.location.href = '/user-transactions';
                    }
                })
        })
        document.querySelector(`.adds`).addEventListener('click', function(e) {
            let length = document.querySelector(`input[name="length"]`).value;
        });

        function onlyNumericInputs(elemSelector) {
            document.querySelectorAll(elemSelector).forEach(el => {
                el.addEventListener('keydown', function(e) {
                    if (
                        // Allow: backspace, delete, tab, escape, enter, and F5
                        ([46, 8, 9, 27, 13, 110, 116].indexOf(Number(e.keyCode))) !== -1 ||
                        // Allow: Ctrl/cmd+A
                        (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl/cmd+C
                        (e.keyCode == 67 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: Ctrl/cmd+X
                        (e.keyCode == 88 && (e.ctrlKey === true || e.metaKey === true)) ||
                        // Allow: home, end, left, right
                        (e.keyCode >= 35 && e.keyCode <= 40)) {
                        // let it happen, don't do anything
                        return;
                    }
                    // Ensure that it is a number and stop the keypress
                    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode >
                            105)) {
                        e.preventDefault();
                    }
                })
                el.addEventListener('contextmenu', function(e) {
                    return false;
                });
            });
        }
        onlyNumericInputs(`[type="number"]`)
        document.querySelector(`[type="number"]`).addEventListener('change', function(e) {
            if (!this.value || this.value < 1 || isNaN(this.value)) return this.value = 1;
        })
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/home.js') }}"></script>
@endsection
