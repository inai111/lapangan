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
                    <h1 class="mt-4">Report</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">Saldo</li>
                    </ol>
                    @if (session('success-message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success-message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @elseif(session('failed-message'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('failed-message') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h3 class="text-success">Rp. {{number_format($saldo,0,',','.')}}</h3>
                    <button data-bs-toggle="modal" data-bs-target="#penarikanModal" class="btn btn-success btn-sm">Tarik Saldo</button>
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="6">List Lapangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- @if () --}}
                            {{-- @else --}}
                                <tr>
                                    <td colspan="6">Tidak Ada Transaksi</td>
                                </tr>
                            {{-- @endif --}}
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    {{-- modal atur penarikan --}}
    <div class="modal fade" id="penarikanModal" tabindex="-1" aria-labelledby="penarikanModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="penarikanModalLabel">Penarikan Saldo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/request-balance" method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" value="{{$merchant->bank}}" id="floatingInput">
                            <label for="floatingInput">Bank Name</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" readonly class="form-control" value="{{$merchant->bank_number}}" id="floatingInput">
                            <label for="floatingInput">Bank Number</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" name="jumlah" class="form-control" id="floatingInput">
                            <label for="floatingInput">Jumlah</label>
                        </div>
                        <button type="submit" class="btn btn-dark ms-auto">Tarik Saldo</button>
                    </form>
                </div>
                <div class="modal-footer">
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="alertModalHapus" tabindex="-1" aria-labelledby="pemesananModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="alerModalHapusLabel">Hapus Transaksi Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin ingin menghapus transaksi ini?
                </div>
                <div class="modal-footer">
                    <form action="/delete-trans" method="POST">
                        @csrf
                        <input type="hidden" id="idTransactionDelete" name="id">
                        <button class="btn btn-dark deleteButton" type="submit">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="ratingModal" tabindex="-1" aria-labelledby="pemesananModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ratingModalLabel">Rating Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/save-review" id="formSaveReview" method="POST">
                        Bagaimana pengalaman lapanganmu?
                        <div class="d-flex my-3">
                            <i data-val="0" class="fa fa-star text-secondary"></i>
                            <i data-val="1" class="fa fa-star text-secondary"></i>
                            <i data-val="2" class="fa fa-star text-secondary"></i>
                            <i data-val="3" class="fa fa-star text-secondary"></i>
                            <i data-val="4" class="fa fa-star text-secondary"></i>
                        </div>
                        <textarea placeholder="Tulis pengalaman mu disini ya." name="review" class="form-control" style="resize: none"
                            id="" cols="30" rows="10"></textarea>
                        @csrf
                        <input type="hidden" id="ratingTransactionReview" name="rating">
                        <input type="hidden" id="idTransactionReview" name="id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-dark reviewSaveButton" type="button">Simpan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector(`#dateBook`).addEventListener('change', function(e) {
            let date = this.value;
            let id = document.querySelector(`#formPesanJadwal input[name="id"]`).value;
            fetch(`get-jadwal-lapangan/${id}?tanggal=${date}`)
                .then(ee => ee.json())
                .then(res => {
                    console.log(`get-jadwal-lapangan/${id}?tanggal=${date}`, res)
                    let content = (data) => {
                        let hasilTemplateContent = ``;
                        let hasilTemplateLi = ``;
                        let buttonTemplate = (jam, tanggal, harga, book) => `
                        <div class="col-md-3 p-1">
                            <button data-tanggal="${tanggal}" data-jam="${jam}" 
                            data-harga="${harga}" class="${book?"disabled btn-dark":"btn-outline-primary"} btn px-3 selectableSchedule" >
                            ${jam}
                            Rp.${new Intl.NumberFormat("id-ID").format(harga)}
                            </button>
                        </div>
                        `;
                        data.forEach(jam => {
                            hasilTemplateContent += buttonTemplate(jam.jam, jam.tanggal, jam.harga,
                                jam.book);
                        })
                        return hasilTemplateContent;
                    }
                    if (res.data) {
                        let temp = content(res.data);
                        jamContent.innerHTML = temp;
                        document.querySelectorAll(`.selectableSchedule`).forEach(elem => {
                            elem.addEventListener('click', function(e) {
                                if (!this.classList.contains('active') && document
                                    .querySelectorAll(`.selectableSchedule.active`).length > 2
                                    ) {
                                    messageFormPemesanan.innerHTML = `
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Gagal</strong> tidak dapat memesan lebih dari 3 jam.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>`;
                                    return;
                                }
                                if (this.classList.contains('active')) {
                                    this.classList.remove('active')
                                } else this.classList.add('active');
                                if (document.querySelectorAll(`.selectableSchedule.active`)
                                    .length > 0) {
                                    document.querySelector(`#formPesanJadwal [type="submit"]`)
                                        .disabled = false;
                                } else document.querySelector(
                                    `#formPesanJadwal [type="submit"]`).disabled = true;
                            })
                        })
                    }
                });

        })
        document.querySelector(`#formPesanJadwal`).addEventListener('submit', function(e) {
            e.preventDefault();
            let myData = new FormData(this);
            let hour = new Array();
            document.querySelectorAll(`.selectableSchedule.active`).forEach(elem => {
                hour.push(elem.dataset.jam);
            })
            myData.set('hour', hour);
            myData.set('date', document.querySelector(`.selectableSchedule.active`).dataset.tanggal);
            window.tes = myData;
            fetch(this.action, {
                    method: "POST",
                    body: myData
                })
                .then(ee => ee.json())
                .then(res => {
                    if (res.status) {
                        if (res.message) {
                            messageFormPemesanan.innerHTML = `
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            ${res.message}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>`;
                        }
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                        return;
                    }
                    if (res.message) {
                        messageFormPemesanan.innerHTML = `
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        ${res.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>`;
                    }
                    console.log(res)
                })
        })
        document.querySelectorAll(".btnPemesanan").forEach(element => {
            element.addEventListener('click', function(e) {
                document.querySelector(`#formPesanJadwal [type="submit"]`).disabled = true;
                document.querySelector(`#formPesanJadwal input[name="id"]`).value = this.dataset.id;
                let modal = new bootstrap.Modal(pemesananModal);
                dateBook.value = '';
                jamContent.innerHTML = '';
                modal.show();
            });
        });
        document.querySelectorAll(`.deleteTrans`).forEach(elem => {
            elem.addEventListener('click', function(e) {
                let modalAlert = new bootstrap.Modal(alertModalHapus);
                idTransactionDelete.value = this.dataset.id;
                modalAlert.show()
            })
        })

        function initSelectableDate() {
            document.querySelectorAll(`.selectableButton`).forEach(elem => {
                elem.addEventListener('click', function(e) {
                    if (document.querySelector(`.selectableButton.active`)) document.querySelector(
                        `.selectableButton.active`).classList.remove('active');
                    elem.classList.add('active');
                    document.querySelector(`#formPesanJadwal [type="submit"]`).disabled = false;
                    document.querySelector(`#formPesanJadwal input[name="date"]`).value = elem.dataset.date;
                    document.querySelector(`#formPesanJadwal input[name="hour"]`).value = elem.innerText;
                })
            })
        }
        document.querySelectorAll(`.ratingNow`).forEach(elem => {
            elem.addEventListener("click", function(e) {
                let modal = new bootstrap.Modal(ratingModal);
                document.querySelector('.reviewSaveButton').disabled = true;
                document.querySelector(`#formSaveReview #idTransactionReview`).value = this.dataset.id;
                document.querySelector(`#formSaveReview #ratingTransactionReview`).value = 0;
                document.querySelectorAll('#ratingModal .fa-star').forEach(elem => {
                    elem.classList.remove('selected');
                    elem.classList.remove('toggle');
                    elem.classList.replace('text-danger', 'text-secondary');
                })
                modal.show();
            })
        })
        document.querySelectorAll('#ratingModal .fa-star').forEach(elem => {
            elem.addEventListener('mouseover', function(e) {
                let rating = this.dataset.val;
                elem.classList.replace('text-secondary', 'text-danger');
                for (let i = 0; i <= rating; i++) {
                    document.querySelectorAll('#ratingModal .fa-star')[i].classList.replace(
                        'text-secondary', 'text-danger');
                }
            })
            elem.addEventListener('mouseout', function(e) {
                document.querySelectorAll('#ratingModal .fa-star').forEach(star => {
                    if (!star.classList.contains('toggle')) star.classList.replace('text-danger',
                        'text-secondary');
                })
            })
            elem.addEventListener('click', function(e) {
                let rating = this.dataset.val;
                if (document.querySelector('.fa-star.selected')) document.querySelector('.fa-star.selected')
                    .classList.remove('selected');
                this.classList.add('selected')
                elem.classList.replace('text-secondary', 'text-danger');
                for (let i = 0; i <= 4; i++) {
                    document.querySelectorAll('#ratingModal .fa-star')[i].classList.replace('text-danger',
                        'text-secondary');
                    if (i <= rating) {
                        document.querySelectorAll('#ratingModal .fa-star')[i].classList.add('toggle');
                        document.querySelectorAll('#ratingModal .fa-star')[i].classList.replace(
                            'text-secondary', 'text-danger');
                    } else document.querySelectorAll('#ratingModal .fa-star')[i].classList.remove('toggle');
                }
                document.querySelector(`#formSaveReview #ratingTransactionReview`).value = rating;
                document.querySelector(`.reviewSaveButton`).disabled = false;

            })
        })
        document.querySelector(`.reviewSaveButton`).addEventListener('click', function(e) {
            if (this.disabled) return;
            document.querySelector(`form#formSaveReview`).submit();
        })
        document.querySelectorAll(`.bayarNow`).forEach(elem => {
            elem.addEventListener(`click`, function(e) {
                e.preventDefault();
                let id = this.dataset.id;
                let pembayaran = this.dataset.pembayaran;
                fetch(`/cek-transaksi?id=${id}&pembayaran=${pembayaran}`)
                    .then(ee => ee.json())
                    .then(res => {
                        // console.log(res);
                        if (res.token) {
                            snap.pay(res.token);
                        }
                    })
            })
        })
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
