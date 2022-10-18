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
                    <h1 class="mt-4">My Lapangan</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">List My Lapangan</li>
                    </ol>
                    <a href="/add-lapangan" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Lapangan</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Lapangan</th>
                                <th>Tanggal</th>
                                <th>Jam Pesan</th>
                                <th>Harga</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Lapangan</td>
                                <td>Tanggal</td>
                                <td>Jam Pesan</td>
                                <td>Harga</td>
                                <td>
                                    <button class="btn btn-outline-dark">Bayar</button>
                                    <button class="btn btn-outline-danger">Cancel</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
