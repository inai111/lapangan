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
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Merchant</th>
                                <th>Tarik Saldo</th>
                                <th>Tanggal</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($request as $item)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$item->merchant->name_merchant}}</td>
                                <td>Tarik Saldo</td>
                                <td>Tanggal</td>
                                <td>
                                    <button class="btn btn-outline-success btn-sm">Kirim Bukti</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    {{-- modal detail --}}
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">Detail Merchant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <tr>
                            <th>Nama Merchant</th>
                            <th>:</th>
                            <td id="detailNamaMerchant"></td>
                        </tr>
                        <tr>
                            <th>Nomor Merchant</th>
                            <th>:</th>
                            <td id="detailNomorMerchant"></td>
                        </tr>
                        <tr>
                            <th>Bank Merchant</th>
                            <th>:</th>
                            <td id="detailBankMerchant"></td>
                        </tr>
                        <tr>
                            <th>Rekening Merchant</th>
                            <th>:</th>
                            <td id="detailRekeningMerchant"></td>
                        </tr>
                        <tr>
                            <th>Alamat Merchant</th>
                            <th>:</th>
                            <td id="detailAlamatMerchant"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button id="activeBtn" type="button" data-type="active"
                        class="statusBtn btn btn-success">Active</button>
                    <button id="suspendBtn" type="button" data-type="suspended"
                        class="statusBtn btn btn-danger">Suspend</button>
                    <button id="rejectBtn" type="button" data-type="rejected"
                        class="statusBtn btn btn-danger">Reject</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- modal confirmation --}}
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan ubah status merchant ini ke <span id="confirmTitle"></span> ?
                </div>
                <div class="modal-footer">
                    @csrf
                    <button id="confirmBtn" type="button" data-type="active"
                        class="statusBtn btn btn-dark">Lanjutkan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
