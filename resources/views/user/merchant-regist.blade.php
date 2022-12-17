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
                    <h1 class="mt-4">Merchant</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Registering New Merchant</li>
                    </ol>
                    <form action="/merchant-regist" method="POST">
                        @csrf
                        <div id="form-msg"></div>
                        <div class="my-3 mb-5">
                            <div class="form-floating mb-3">
                                <input value="{{old('name_merchant',$merchant?$merchant['name_merchant']:'')}}" type="text" class="form-control @error('name_merchant') is-invalid @enderror" name="name_merchant" id="name_merchant" placeholder="name">
                                <label for="name_merchant">Merchant Name</label>
                                <div class="@error('name_merchant') invalid-feedback @enderror">
                                    @error('name_merchant')
                                    {{$errors->first('name_merchant')}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input value="{{old('bank',$merchant?$merchant['bank']:'')}}" type="text" name="bank" class="form-control @error('bank') is-invalid @enderror" id="bank" placeholder="bank">
                                <label for="bank">Bank Name</label>
                                <div class="@error('bank') invalid-feedback @enderror">
                                    @error('bank')
                                    {{$errors->first('bank')}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <input value="{{old('bank_number',$merchant?$merchant['bank_number']:'')}}"  type="text" name="bank_number" class="form-control @error('bank_number') is-invalid @enderror" id="bank_number" placeholder="bank_number">
                                <label for="bank_number">Bank Number</label>
                                <div class="@error('bank_number') invalid-feedback @enderror">
                                    @error('bank_number')
                                    {{$errors->first('bank_number')}}
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-6">
                                    <div class="form-floating">
                                        <input type="time" name="open" value="{{ old('open') }}"
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
                                        <input type="time" name="close" value="{{ old('close') }}"
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
                                        <select class="form-select" id="dp" name="dp" disabled aria-label="Floating label select example">
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
                                <input  type="text" name="number" value="{{ old('number',$merchant?$merchant['number']:$user->number) }}"
                                    class="form-control @error('number') is-invalid @enderror" id="number" placeholder="number">
                                <label for="number">Nomor Telepon</label>
                                <div class="@error('number') invalid-feedback @enderror">
                                    @error('number')
                                    {{$errors->first('number')}}
                                    @enderror
                                </div>
                            </div>
                            <div class="form-floating mb-3">
                                <textarea  class="form-control @error('address') is-invalid @enderror" id="address" name="address" style="height: 100px">{{ old('address',$merchant?$merchant['address']:$user->address) }}</textarea>
                                <label for="address">Alamat</label>
                                <div class="@error('address') invalid-feedback @enderror">
                                    @error('address')
                                    {{$errors->first('address')}}
                                    @enderror
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
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/merchant.js') }}"></script> --}}

@endsection
