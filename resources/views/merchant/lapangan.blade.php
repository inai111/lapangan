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
                    <h1 class="mt-4">Lapangan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Add Lapangan</li>
                    </ol>
                    <div class="row">
                        <div class="col-5 p-3">
                            <div id="previewCover"
                                style="url({{asset('/assets/img/6mTpyFwoF0jQXa3k89oajSoIrlhHWak4PftWk0Dt.png')}}));background-color: black;background-repeat:no-repeat;background-position:center;background-size: 300px;width: 300px;height: 300px;"
                                class="m-auto img-thumbnail"></div>
                        </div>
                        <div class="col-7">

                            <form method="POST" enctype="multipart/form-data">
                                @csrf
                                <div id="form-msg"></div>
                                <div class="my-3 mb-5">
                                    <div class="mb-3">
                                        <input value="{{ old('cover_lapangan') }}" name="cover_lapangan"
                                            class="form-control @error('cover_lapangan') is-invalid @enderror"
                                            type="file" id="formFile">
                                        <div class="@error('cover_lapangan') invalid-feedback @enderror">
                                            @error('cover_lapangan')
                                                {{ $errors->first('cover_lapangan') }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class=" mb-3">
                                        <label for="nama_lapangan">Lapangan Nama</label>
                                        <input value="{{ old('nama_lapangan') }}" type="text"
                                            class="form-control @error('nama_lapangan') is-invalid @enderror"
                                            name="nama_lapangan" id="nama_lapangan" placeholder="Nama Lapangan">
                                        <div class="@error('nama_lapangan') invalid-feedback @enderror">
                                            @error('nama_lapangan')
                                                {{ $errors->first('nama_lapangan') }}
                                            @enderror
                                        </div>
                                    </div>
                                    <div class=" mb-3">
                                        <label for="harga">Harga</label>
                                        <div class="input-group mb-3">
                                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                                            <input value="{{ old('harga') }}" type="text" name="harga"
                                                class="form-control @error('harga')is-invalid @enderror" id="harga"
                                                placeholder="harga">
                                            <span class="input-group-text" id="basic-addon1">/ Jam</span>
                                            <div class="@error('harga') invalid-feedback @enderror">
                                                @error('harga')
                                                    {{ $errors->first('harga') }}
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="type_lapangan">Type Lapangan</label>
                                        <select class="form-select @error('type_lapangan') is-invalid @enderror"
                                            id="type_lapangan" name="type_lapangan">
                                            <option value="" selected>Select Type</option>
                                            @foreach ($jenis_olahraga as $jenis)
                                            <option {{ old('type_lapangan')==$jenis->id ? 'selected' : '' }} value="{{$jenis->id}}">{{$jenis->nama}}</option>
                                            @endforeach
                                            {{-- <option {{ old('futsal') ? 'selected' : '' }} value="futsal">Futsal</option>
                                            <option {{ old('badminton') ? 'selected' : '' }} value="badminton">badminton
                                            </option>
                                            <option {{ old('volley') ? 'selected' : '' }} value="volley">Volley</option> --}}
                                        </select>
                                        <div class="@error('type_lapangan') invalid-feedback @enderror">
                                            @error('type_lapangan')
                                                {{ $errors->first('type_lapangan') }}
                                            @enderror
                                        </div>
                                    </div>
                                    {{-- <div class="mb-3">
                                    <div class="row">
                                        <div class="col-6">
                                            <label for="tanggal">Tanggal</label>
                                            <input type="date" name="tanggal" value="{{ old('tanggal') }}"
                                                class="form-control @error('tanggal') is-invalid @enderror" id="tanggal"
                                                placeholder="tanggal">
                                            <div class="@error('tanggal') invalid-feedback @enderror">
                                                @error('tanggal')
                                                    {{ $errors->first('tanggal') }}
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <label for="start_time">Jam Booking</label>
                                            <div class="row">
                                                <div class="col-5">
                                                    <input type="time" name="start_time" value="{{ old('start_time') }}"
                                                        class="form-control @error('start_time') is-invalid @enderror"
                                                        id="start_time" placeholder="start_time" pattern="H:i">
                                                    <div class="@error('start_time') invalid-feedback @enderror">
                                                        @error('start_time')
                                                            {{ $errors->first('start_time') }}
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-2 text-center">Sampai</div>
                                                <div class="col-5">
                                                    <input type="time" name="end_time" value="{{ old('end_time') }}"
                                                        class="form-control @error('end_time') is-invalid @enderror"
                                                        id="end_time" pattern="H:i" placeholder="end_time">
                                                    <div class="@error('end_time') invalid-feedback @enderror">
                                                        @error('end_time')
                                                            {{ $errors->first('end_time') }}
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> --}}
                                    <div class=" mb-3">
                                        <label for="additional_info">Additional Info</label>
                                        <textarea class="form-control @error('additional_info') is-invalid @enderror" id="additional_info"
                                            name="additional_info" style="height: 100px">{{ old('additional_info') }}</textarea>
                                        {{-- <div class="@error('additional_info') invalid-feedback @enderror">
                                        @error('additional_info')
                                            {{ $errors->first('additional_info') }}
                                        @enderror
                                    </div> --}}
                                    </div>
                                    <div class="mb-3">
                                        <label for="gallery[]">Foto Dalam Lapangan</label>
                                        <input type="file" value="{{ old('gallery[]') }}" multiple name="gallery[]"
                                            class="form-control">
                                        <div id="previewGallery" class="row border mt-3"
                                            style="max-width:624px;min-height: 100px;margin-left: .1rem;border-radius: 2px">
                                            <div class="text-muted text-center my-auto">
                                                <h3>No Data Gallery</h3>
                                            </div>
                                            <div class="row" style="display:none">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="my-4 text-center">
                                        <button type="submit" class="btn btn-dark w-75">Simpan</button>
                                    </div>
                                </div>
                        </div>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <script>
        if (document.querySelector(`form [name="cover_lapangan"]`).files[0]) {
            let file = document.querySelector(`form [name="cover_lapangan"]`).files[0];
            document.querySelector(`#previewCover`).style.backgroundImage = `url(${URL.createObjectURL(file)})`;
        }
        document.querySelector(`form [name="cover_lapangan"]`).addEventListener('change', function(e) {
            let file = this.files[0];
            document.querySelector(`#previewCover`).style.backgroundImage = `url(${URL.createObjectURL(file)})`;
        })
        if (document.querySelector(`form [name="gallery"]`).files) {
            let file = document.querySelector(`form [name="gallery"]`).files;
            document.querySelector(`#previewGallery .text-muted.text-center`).style.display = 'none';
            document.querySelector(`#previewGallery .row`).style.display = '';
            for (const [idx, val] of Object.entries(file)) {
                document.querySelector(`#previewGallery .row`).insertAdjacentHTML('afterbegin', `
                <div class="col-3">
                <img src="${URL.createObjectURL(val)}" class="img-thumbnail w-100">
                </div>
                `);
            }
        }
        document.querySelector(`form [name="gallery"]`).addEventListener('change', function(e) {
            let file = document.querySelector(`form [name="gallery"]`).files;
            document.querySelector(`#previewGallery .text-muted.text-center`).style.display = 'none';
            document.querySelector(`#previewGallery .row`).style.display = '';
            document.querySelector(`#previewGallery .row`).innerHTML = '';
            for (const [idx, val] of Object.entries(file)) {
                document.querySelector(`#previewGallery .row`).insertAdjacentHTML('afterbegin', `
                <div class="col-3">
                <img src="${URL.createObjectURL(val)}" class="img-thumbnail w-100">
                </div>
                `);
            }
        })
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
