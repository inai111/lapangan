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
                                <th>Harga</th>
                                <th>Telah Dipesan</th>
                                <th>Rating</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lapangan as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td><a href="/merchant-lapangan/{{$item->id}}" class="text-dark" style="text-decoration: none">{{$item->nama}}</a></td>
                                <td>Rp.{{number_format($item->harga,0,',','.')}}</td>
                                <td>{{$item->total_book}}</td>
                                <td>{{$item->rating}} <i class="fa fa-star text-warning"></i>({{$item->total_rating}})</td>
                                <td>
                                    <button class="btn btn-outline-dark">Edit</button>
                                </td>
                            </tr>
                            @endforeach
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
