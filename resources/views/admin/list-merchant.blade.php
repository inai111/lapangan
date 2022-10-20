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
                                    <option value="" selected>Status :
                                        {{ ucwords(request()->get('status') ?: 'default') }}</option>
                                    <option value="all">All</option>
                                    <option value="pending">Pending</option>
                                    <option value="rejected">Rejected</option>
                                    <option value="suspended">Suspended</option>
                                    <option value="active">Active</option>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $merchant->name_merchant }}</td>
                                    <td>{{ $merchant->user->name }}</td>
                                    <td>{{ $merchant->user->username }}</td>
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
                                        <button data-obj="{{ base64_encode(json_encode($merchant)) }}"
                                            class="detailMerchant btn btn-sm btn-dark">Detail</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div>
                        {{ $merchants->links() }}
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
    <script>
        document.querySelectorAll(`.detailMerchant`).forEach(elem => {
            elem.addEventListener('click', function(e) {
                let modal = new bootstrap.Modal(detailModal);
                let data = JSON.parse(atob(elem.dataset.obj));
                rejectBtn.style.display = 'none';
                suspendBtn.style.display = 'none';
                activeBtn.style.display = 'none';
                switch (data.active) {
                    case "pending":
                        rejectBtn.dataset.id = data.id;
                        activeBtn.dataset.id = data.id;
                        rejectBtn.style.display = '';
                        activeBtn.style.display = '';
                        break
                    case "suspended":
                        activeBtn.dataset.id = data.id;
                        activeBtn.style.display = '';
                        break
                    case "active":
                        suspendBtn.dataset.id = data.id;
                        suspendBtn.style.display = '';
                        break
                }
                detailNamaMerchant.innerHTML = data.name_merchant;
                detailNomorMerchant.innerHTML = data.number;
                detailBankMerchant.innerHTML = data.bank;
                detailRekeningMerchant.innerHTML = data.bank_number;
                detailAlamatMerchant.innerHTML = data.address;
                modal.show()
            })
        });
        document.querySelectorAll(`.statusBtn`).forEach(elem => {
            elem.addEventListener('click', function(e) {
                let modal = new bootstrap.Modal(confirmModal);
                confirmTitle.innerHTML = elem.dataset.type.toUpperCase();
                confirmBtn.dataset.id = elem.dataset.id;
                confirmBtn.dataset.type = elem.dataset.type;
                modal.show();
            })
        })
        confirmBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!this.dataset.id && !this.dataset.type) return;
            let myData = new FormData();
            let csrf = document.querySelector(`[name="_token"]`);
            myData.append(csrf.name, csrf.value);
            myData.append("id_merchant", this.dataset.id);
            myData.append("status", this.dataset.type);
            fetch(`/admin-merchant-status`, {
                    method: "POST",
                    body: myData
                })
                .then(ee => ee.json())
                .then(res => {
                    console.log(res)
                    if (res == true) window.location.reload();
                })
        })
    </script>

@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
