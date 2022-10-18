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
                    <h1 class="mt-4">Merchant</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">List Merchants Data</li>
                    </ol>
                    <form action="">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                              <label for="search" class="col-form-label">Search</label>
                            </div>
                            <div class="col-auto">
                              <input type="text" name="search" class="form-control">
                            </div>
                            <div class="col-auto">
                                <select name="status" class="form-select" aria-label="Default select example">
                                    <option value="" selected>Status : Default</option>
                                    <option value="all">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="suspended">Suspended</option>
                                  </select>
                            </div>
                            <div class="col-auto">
                              <input type="submit" value="Cari" class="form-control btn btn-primary">
                            </div>
                          </div>
                    </form>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Merchant</th>
                                <th>Nama User</th>
                                <th>Username</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($merchants as $merchant)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$merchant->name_merchant}}</td>
                                <td>{{$merchant->user->name}}</td>
                                <td>{{$merchant->user->username}}</td>
                                <td>
                                    @switch($merchant->active)
                                        @case('pending')
                                            <button class="btn btn-sm btn-warning">pending</button>
                                            @break
                                        @case('rejected')
                                            <div class="btn btn-sm btn-danger">rejected</div>
                                            @break
                                        @case('suspended')
                                            <div class="btn btn-sm btn-danger">suspended</div>
                                            @break
                                        @case('active')
                                            <div class="btn btn-sm btn-success">active</div>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <button id="detailMerchant" class="btn btn-sm btn-dark">Detail</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{$merchants->links()}}
                    </div>
                </div>
            </main>
        </div>
    </div>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
