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
                    <h1 class="mt-4">{{$lapangan->nama}}</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Jadwal</li>
                    </ol>
                    <form action="">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <label for="search" class="col-form-label">Search</label>
                            </div>
                            <div class="col-auto">
                                <input type="date" name="search" class="form-control">
                            </div>
                            <div class="col-auto">
                                <input type="submit" value="Cari" class="form-control btn btn-primary">
                            </div>
                        </div>
                    </form>
                    <div class="container my-3">

                        <div class="row mb-5">
                            @for($i=0;$i<7;$i++)
                            <div class="col-lg-3 col-md-4 col-sm-12 px-1 py-2">
                                <div class="border p-3">
                                    <div class="row">
                                        @php
                                            $tanggal = date("d-m-Y",strtotime("+$i days {$tgl}"));
                                            $tanggal_string = date("D, d F",strtotime("+$i days {$tgl}"));
                                            $init = date("H",strtotime($merchant->buka));
                                            $close = date("H",strtotime($merchant->tutup));
                                        @endphp
                                        <div class="col-12 mb-3">
                                        <div class="d-flex justify-content-between">
                                            {{$tanggal_string}}
                                            <button class="btn rounded-pill px-1 py-0 btn-sm btn-danger">Full Book</button>
                                        </div>
                                        </div>
                                        @while ($init<($close))
                                        @php
                                        $disabled = false;
                                        if($booking_date){
                                            foreach ($booking_date as $value) {
                                                if(strtotime($value) == strtotime(date('d-m-Y ',strtotime($tanggal))."{$init}:00:00")){
                                                    $disabled = true;
                                                }
                                            }
                                        }
                                        @endphp
                                        <div class="col-lg-3 col-md-3 col-sm-3 col-3 my-1">
                                            <button class="btn btn-sm {{$disabled?'btn-dark disabled':'btn-outline-primary'}}">{{date("H:i",strtotime($init.":00"))}}</button>
                                        </div>
                                        @php
                                            $init++;
                                        @endphp
                                        @endwhile
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>    
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
