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
                        <li class="breadcrumb-item">Setting</li>
                        <li class="breadcrumb-item active">Merchant</li>
                    </ol>
                    <a href="/settings" class="btn btn-outline-dark py-1 px-4 rounded-pill"><i
                            class="fa fa-chevron-left"></i> Back</a>
                    <form action="/settings/1" method="POST">
                        @csrf

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
                        <div class="my-3 mb-5">
                            <div class="form-floating mb-3">
                                <input type="text" value="{{ ucwords(strtolower($merchant->nama)) }}" disabled
                                    readonly class="form-control" id="name">
                                <label for="name">Name Merchant</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input value="{{ old('bank', $merchant->bank) }}" type="text" name="bank"
                                    class="form-control @error('bank') is-invalid @enderror" id="bank"
                                    placeholder="bank">
                                <label for="bank">Bank Name</label>
                                <div class="@error('bank') invalid-feedback @enderror">
                                    @error('bank')
                                        {{ $errors->first('bank') }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input value="{{ old('bank_number', $merchant['norek']) }}" type="text"
                                    name="bank_number" class="form-control @error('bank_number') is-invalid @enderror"
                                    id="bank_number" placeholder="bank_number">
                                <label for="bank_number">Bank Number</label>
                                <div class="@error('bank_number') invalid-feedback @enderror">
                                    @error('bank_number')
                                        {{ $errors->first('bank_number') }}
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="time" name="open" value="{{ old('open', $merchant['buka']) }}"
                                            class="form-control @error('open') is-invalid @enderror" id="openElem"
                                            placeholder="open">
                                        <label for="open">Jam Buka</label>
                                        <div class="@error('open') invalid-feedback @enderror">
                                            @error('open')
                                                {{ $errors->first('open') }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="time" name="close" value="{{ old('close', $merchant['tutup']) }}"
                                            class="form-control @error('close') is-invalid @enderror" id="closeElem"
                                            placeholder="close">
                                        <label for="close">Jam Tutup</label>
                                        <div class="@error('close') invalid-feedback @enderror">
                                            @error('close')
                                                {{ $errors->first('close') }}
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <div class="alert alert-info alert-dismissible fade show"><i
                                            class="fa-solid fa-circle-exclamation"></i> waktu yang akan disimpan hanya jam
                                        nya saja, menit dan detik akan dibulatkan menjadi 00:00.<br><em
                                            style="font-size: .7em;">(AM = 00:00-12:00, PM = 12:00-24:00)</em> <button
                                            type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <select class="form-select" disabled id="dp" name="dp" aria-label="Floating label select example">
                                            <option {{old('dp')=='1'?'selected':''}} value="1">Perlu DP</option>
                                            <option {{old('dp')=='0'?'selected':''}} value="0">Tidak Perlu</option>
                                        </select>
                                        <label for="dp">Down Payment (DP)</label>
                                    </div>
                                    <div class="@error('dp') invalid-feedback @enderror">
                                    @error('dp')
                                    {{$errors->first('dp')}}
                                    @enderror
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="pembayaran" disabled name="pembayaran" aria-label="Floating label select example">
                                            <option {{old('pembayaran')=='both'?'selected':''}} value="both" selected>Cash dan Transfer</option>
                                            <option {{old('pembayaran')=='cash'?'selected':''}} value="cash">Hanya Cash</option>
                                        </select>
                                        <label for="pembayaran">Menerima Pembayaran</label>
                                    </div>
                                    <div class="@error('pembayaran') invalid-feedback @enderror">
                                        @error('pembayaran')
                                        {{$errors->first('pembayaran')}}
                                        @enderror
                                    </div>
                                </div>
                            </div>
                              
                            <div class="form-floating mb-3">
                                <input type="text" name="number" value="{{ old('number', $merchant['nomor']) }}"
                                    class="form-control @error('number') is-invalid @enderror" id="number"
                                    placeholder="number">
                                <label for="number">Nomor Telepon</label>
                                <div class="@error('number') invalid-feedback @enderror">
                                    @error('number')
                                        {{ $errors->first('number') }}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address"
                                    style="height: 100px">{{ old('address', $merchant['alamat']) }}</textarea>
                                <label for="address">Alamat</label>
                                <div class="@error('address') invalid-feedback @enderror">
                                    @error('address')
                                        {{ $errors->first('address') }}
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3 form-group">
                                <h5>Fasilitas</h5>
                                <div class="row">
                                    @foreach ($fasilitas as $fasiliti)
                                    <div class="col-6 col-lg-3 text-truncate">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input fasilitasCheck" {{in_array($fasiliti->id,$merchant_facilities)?'checked':''}} value="{{$fasiliti->id}}" type="checkbox" role="switch" id="fasiliti_{{$fasiliti->id}}">
                                            <label class="form-check-label" for="fasiliti_{{$fasiliti->id}}">{{$fasiliti->fasilitas}}</label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
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
    <div class="modal fade" id="changePicModal" tabindex="-1" aria-labelledby="changePicModalLabel"
        aria-hidden="true">
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
    <div class="modal fade" id="fasilitasPicModal" tabindex="-1" aria-labelledby="changePicModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="fasilitasPicModalLabel">Foto Fasilitas</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mx-auto rounded mb-3 changeFasilitasImagePreview" style="width: 8vw;height: 8vw;border: 1px solid black !important;"></div>
                    <form id="fasilitasForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="fasilitas_id">
                        {{-- add/remove --}}
                        <p class="confirmingMsg text-danger">Yakin ingin menghapus fasilitas ini?</p>
                        <input type="hidden" name="type"> 
                        <input type="file" name="fasilitasFoto" id="changeFasilitasImage" accept="image/png,image/jpg,image/jpeg">
                        <div class="form-floating my-3 deskripsiForm">
                            <textarea class="form-control" name="deskripsi"
                                style="height: 100px"></textarea>
                            <label for="address">Deskripsi</label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-dark simpanFasilitas" data-bs-dismiss="modal">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        openElem.addEventListener("change", function() {
            closeElem.setAttribute('min', `${this.value}`);
        })
        document.querySelectorAll(`.fasilitasCheck`).forEach(element => {
            element.addEventListener("change", function(e){
                document.querySelector(`#fasilitasForm input[name="fasilitas_id"]`).value = this.value;
                if(this.checked){
                    this.checked = false;
                    document.querySelector(`.changeFasilitasImagePreview`).style.background = `linear-gradient(rgba(0,0,0,.8),rgba(0,0,0,.8)),url('/assets/img/profilpic/default.png') center/cover no-repeat`
                    document.querySelector(`#fasilitasForm`).reset();
                    let modal = new bootstrap.Modal(document.querySelector(`#fasilitasPicModal`));
                    document.querySelector(`#fasilitasForm input[name="type"]`).value = 'add';
                    document.querySelector(`#fasilitasForm textarea[name="deskripsi"]`).value = '';
                    document.querySelector(`.deskripsiForm`).classList.remove('d-none');
                    document.querySelector(`#fasilitasForm textarea[name="deskripsi"]`).removeAttribute('disabled');
                    document.querySelector(`.confirmingMsg`).classList.add('d-none');
                    document.querySelector(`#changeFasilitasImage`).classList.remove('d-none');
                    document.querySelector(`#changeFasilitasImage`).removeAttribute('disabled');
                    modal.show();
                }else{
                    this.checked = true;
                    let modal = new bootstrap.Modal(document.querySelector(`#fasilitasPicModal`));
                    document.querySelector(`#fasilitasForm input[name="type"]`).value = 'remove';
                    document.querySelector(`.confirmingMsg`).classList.remove('d-none');
                    document.querySelector(`.deskripsiForm`).classList.add('d-none');
                    document.querySelector(`#fasilitasForm textarea[name="deskripsi"]`).setAttribute('disabled',true);
                    document.querySelector(`#changeFasilitasImage`).classList.add('d-none');
                    document.querySelector(`#changeFasilitasImage`).setAttribute('disabled',true);
                    modal.show();

                }
            })
        });
        document.querySelector(`.simpanFasilitas`).addEventListener('click', function(e){
            let myData = new FormData(document.querySelector(`#fasilitasForm`));
            fetch('/fasilitas-edit',{method:"POST",body:myData})
            .then(ee=>ee.json())
            .then(res=>{
                if(res.ok){
                    if(res.type =='add'){
                        document.querySelector(`.fasilitasCheck[value="${res.fasilitas_id}"]`).checked = true;
                    }
                    if(res.type =='remove'){
                        document.querySelector(`.fasilitasCheck[value="${res.fasilitas_id}"]`).checked = false;
                    }
                }
            })
        })
        document.querySelector(`#changeFasilitasImage`).addEventListener('change', function(e){
            document.querySelector(`.changeFasilitasImagePreview`).style.background = `url(${URL.createObjectURL(this.files[0])}) center/cover no-repeat`
        })
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/setting.js') }}"></script> --}}

@endsection
