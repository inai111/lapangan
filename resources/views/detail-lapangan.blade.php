@extends('layouts.main')

@section('navbar')
    @include('partials.main')
@endsection
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/home.css') }}">
@endsection
@section('content')
    <div class="container bg-light my-5 py-3">
        <div class="position-relative"
            style="background-image: url({{ asset("assets/img/lapangan/cover/$lapangan->cover") }});background-size:300px;height: 200px;background-repeat: no-repeat;background-position: center;background-color: #adb5bd;">
            <div class="position-absolute px-5 py-2 text-light"
                style="top: 0;background-color: rgba(0, 0, 0, 0.6);border: none">
                <h1 class="display-3">{{ $lapangan->nama }}</h1>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-4">
                <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner border">
                        @foreach ($galeries as $galery)
                            <div class="carousel-item {{ $loop->iteration == 1 ? 'active' : '' }}">
                                <img src="{{ asset("assets/img/lapangan/$galery[photo]") }}" class="d-block w-100">
                            </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title text-success"><i class="fa fa-tags"></i> Rp.
                            {{ $lapangan->harga }}/Jam</h5>
                        <div class="d-flex">
                            <h6 class="card-subtitle me-3 text-muted"><i class="fa-solid fa-basketball"></i>
                                {{ $lapangan->jenis->nama }}</h6>
                            <h6 class="card-subtitle me-3 text-muted">Telah Dipesan({{count($booklist)}})</h6>
                            <h6 class="card-subtitle me-3 text-muted">
                                <strong>{{$rating}}</strong>
                                <i class="fa fa-star text-warning"></i>({{$jumlah}})
                            </h6>
                        </div>
                        <p class="card-text">{{ ucwords($merchant->nama) }}</p>
                        @if (session('id_user') != $merchant->user_id && session('role')=='user')
                        <div class="d-flex">
                            <button data-login="{{ session('id_user') }}" data-id="{{ $lapangan->id }}" id="pesanNow"
                                onclick="event.preventDefault()" class="mx-1 btn adds btn-success"><i
                                    class="fa-solid fa-plus"></i> Pesan Sekarang</button>
                            @if (session()->has('id_user'))
                                <button data-login="{{ session('id_user') }}"
                                    data-msgObj="{{ $objMsg }}"
                                    id="chatThis"
                                    onclick="event.preventDefault()" class="mx-1 btn btn-outline-dark"><i
                                        class="fa-solid fa-comment"></i> Kirim Pesan</button>
                            @endif
                        </div>
                        @endif
                        <ul class="nav nav-tabs mt-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab"
                                    data-bs-target="#info-tab-pane" type="button" role="tab"
                                    aria-controls="info-tab-pane" aria-selected="true">Info Lapangan</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="rating-tab" data-bs-toggle="tab"
                                    data-bs-target="#rating-tab-pane" type="button" role="tab"
                                    aria-controls="rating-tab-pane" aria-selected="false">Rating ({{$jumlah}})</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="address-tab" data-bs-toggle="tab"
                                    data-bs-target="#address-tab-pane" type="button" role="tab"
                                    aria-controls="address-tab-pane" aria-selected="false">Lokasi Lapangan</button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="info-tab-pane" role="tabpanel"
                                aria-labelledby="info-tab" tabindex="0">
                                @php
                                    echo nl2br($lapangan->deskripsi);
                                @endphp
                            </div>
                            <div class="tab-pane fade" id="rating-tab-pane" role="tabpanel" aria-labelledby="rating-tab"
                                tabindex="0">
                                <div class="row my-2 mx-1">
                                    <div class="col-md-12">
                                        <div class="py-2 px-1 border-bottom">
                                            <div class="row">
                                                <div class="col-md-2">
                                                    <img src="{{ asset('assets/img/profilpic/default.png') }}"
                                                        alt="" class="rounded-circle border" width="100%">
                                                </div>
                                                <div class="col-md-10">
                                                    <div class="ms-3 w-100" style="font-size:.8em">
                                                        <div class="row">
                                                            <div class="d-flex col-md-6 starRating">
                                                                <i class="fa fa-star text-warning"></i>
                                                                <i class="fa fa-star text-warning"></i>
                                                                <i class="fa fa-star text-warning"></i>
                                                                <i class="fa fa-star text-muted"></i>
                                                                <i class="fa fa-star text-muted"></i>
                                                            </div>
                                                            <div class="col-md-6 text-end">{{ date('d-M-Y') }}</div>
                                                        </div>
                                                        <div>
                                                            Nama reviewer
                                                        </div>
                                                        <div class="">
                                                            isi dari review nya
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="text-muted justify-content-center mt-5 d-flex align-items-center">
                                    <i class="fa fa-box-open fa-2x"></i>
                                    <div class="ms-2">Tidak ada Data</div>
                                </div> --}}
                            </div>
                            <div class="tab-pane fade" id="address-tab-pane" role="tabpanel"
                                aria-labelledby="address-tab" tabindex="0">
                                {{ $merchant->alamat }}
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

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
        if(document.querySelector("#pesanNow")) pesanNow.addEventListener(`click`, function(e) {
            if (!this.dataset.login) {
                document.querySelector('.loginBtn').click();
                return;
            }
            // let lengthVal = Number(lengthForm.value) > 0 ? lengthForm.value : "1";
            // fetch(`/add-transaction/${this.dataset.id}?length=${lengthVal}`)
            fetch(`/add-transaction/${this.dataset.id}`)
                .then(ee => ee.json())
                .then(res => {
                    console.log(res);
                    if (res.status) {
                        window.location.href = '/user-transactions';
                    }
                })
        })

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
        if(document.querySelector(`[type="number"]`))document.querySelector(`[type="number"]`).addEventListener('change', function(e) {
            if (!this.value || this.value < 1 || isNaN(this.value)) return this.value = 1;
        })
        if (document.querySelector('#chatThis')) chatThis.addEventListener(`click`, function(e) {
            let dataMsg = JSON.parse(atob(this.dataset.msgobj));
            let msgCont = new bootstrap.Offcanvas(messageOpened);
            gantiMsgCont(dataMsg);
            msgCont.show();
        })

        function gantiMsgCont(data) {
            msgContImgMerchant.src = `/assets/img/profilpic/${data.profilePic}`;
            msgContNameMerchant.innerHTML = data.merchantName;
            document.querySelector(`form [name="target_id"]`).value = data.userId;
            msgContBody.innerHTML = ``;
            updateMsgCont();
            // msgContBody.innerHTML = `
        // <div class="start-0 end-0 text-center top-0 position-absolute">
        //     <div class="spinner-border" role="status">
        //         <span class="visually-hidden">Loading...</span>
        //     </div>
        // </div>`;
            let tagElem = `
            <div id="tagLapanganActive" data-refid="${data.userId}" class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light position-sticky bottom-0">
                <div class="row">
                    <div class="col-2">
                        <img src="${data.urlCover}" style="width: 50px;">
                    </div>
                    <div class="col-9">
                        <div>${data.namaLapangan}</div>
                        <div>${data.hargaLapangan}</div>
                    </div>
                    <div class="col-1">
                        <button id="tagLapanganClose" style="font-size: .6em;vertical-align: top;"
                            class="btn-close pt-1"></button>
                    </div>
                </div>
            </div>
            `;
            if(document.querySelector('#tagLapanganActive')) document.querySelector('#tagLapanganActive').remove();
            msgContBody.insertAdjacentHTML('afterEnd', tagElem);
            if(tagLapanganClose) tagLapanganClose.addEventListener('click', function(e) {
                if(tagLapanganActive)tagLapanganActive.remove();
            })
        }
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/home.js') }}"></script>
@endsection
