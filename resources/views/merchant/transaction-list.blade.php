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
                    <h1 class="mt-4">Transaction</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item active">List Transaction</li>
                    </ol>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="ongoing-tab" data-bs-toggle="tab"
                                data-bs-target="#ongoing-tab-pane" type="button" role="tab"
                                aria-controls="ongoing-tab-pane" aria-selected="false">On Progress</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="complete-tab" data-bs-toggle="tab"
                                data-bs-target="#complete-tab-pane" type="button" role="tab"
                                aria-controls="complete-tab-pane" aria-selected="false">Berhasil</button>
                        </li>
                    </ul>
                    @if (session('success-message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{session('success-message')}}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                      </div>
                      @elseif(session('failed-message'))
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                          {{session('failed-message')}}
                          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        
                    @endif
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="ongoing-tab-pane" role="tabpanel" aria-labelledby="ongoing-tab"
                            tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="6">List Lapangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($booklists['on_going']))
                                        @foreach ($booklists['on_going'] as $booklist)
                                            <tr style="vertical-align: middle;">
                                                <td>
                                                    <img src="{{ asset("assets/img/profilpic/{$booklist->user->foto}") }}"
                                                        class="img-thumbnail" style="width:80px;height:80px"
                                                        alt="{{ $booklist->lapangan->nama }}">
                                                </td>
                                                <td>
                                                    <h5>{{ $booklist->lapangan->nama }}</h5>
                                                    <i class="me-2 fas fa-user"></i>{{$booklist->user->nama}}
                                                </td>
                                                    <td class="text-center">
                                                        <div>{{ date('d-F-Y', strtotime($booklist->booking_date[0]->tanggal)) }}</div>
                                                        @foreach ($booklist->booking_date as $item)
                                                            <div class="btn btn-success btn-sm">{{date("H:i",strtotime($item->jam))}}</div>
                                                        @endforeach
                                                        
                                                    </td>
                                                </td>
                                                <td>
                                                    <button data-id="{{$booklist->id}}" class="btn btn-outline-dark seeMore"><i class="fas fa-bars"></i></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6">Tidak Ada Transaksi</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="complete-tab-pane" role="tabpanel" aria-labelledby="complete-tab"
                            tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="6">List Lapangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (isset($booklists['complete']))
                                    @foreach ($booklists['complete'] as $booklist)
                                        <tr style="vertical-align: middle;">
                                            <td>
                                                <img src="{{ asset("assets/img/profilpic/{$booklist->user->foto}") }}"
                                                    class="img-thumbnail" style="width:80px;height:80px"
                                                    alt="{{ $booklist->lapangan->nama }}">
                                            </td>
                                            <td>
                                                <h5>{{ $booklist->lapangan->nama }}</h5>
                                                <i class="me-2 fas fa-user"></i>{{$booklist->user->nama}}
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success px-3 rounded-pill">Lunas</button>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success px-3 rounded-pill">Rp. {{number_format($booklist->total_biaya,0,',','.')}}</button>
                                            </td>
                                            <td>
                                                <button data-id="{{$booklist->id}}" class="btn btn-outline-dark seeMore">
                                                    <i class="fas fa-bars"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @else
                                        <tr >
                                            <td colspan="6">Tidak Ada Transaksi</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- modal atur pemesanan --}}
    <div class="modal fade" id="seeMoreModal" tabindex="-1" aria-labelledby="seeMoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seeMoreModalLabel">Detil Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="messageFormSeeMore" class="w-100 badge bg-secondary text-center d-none">
                        <i class="fa fa-spin fa-spinner me-2"></i>
                        Memuat Informasi
                    </div>
                    <table class="table mt-3">
                        <tr class="table-info">
                            <th>Nama Pemesan</th>
                            <td id="pemesanNama"></td>
                        </tr>
                        <tr class="table-info">
                            <th>Tanggal Bayar</th>
                            <td id="pemesanTanggalBayar"></td>
                        </tr>
                        <tr class="table-info">
                            <th>Status Pemesanan</th>
                            <td id="pemesanStatus"></td>
                        </tr>
                        <tr class="table-info">
                            <th>Kasir Penanggung Jawab</th>
                            <td id="pemesanKasir"></td>
                        </tr>
                        <tr class="table-info">
                            <th>Tanggal yang di Pesan</th>
                            <td id="pemesanTanggal"></td>
                        </tr>
                        <tr class="table-info">
                            <th>Jam yang di Pesan</th>
                            <td id="pemesanJam" class="d-flex gap-1 flex-wrap"></td>
                        </tr>
                        <tr class="table-success">
                            <th>Telah di Bayar</th>
                            <td id="pemesanDP"></td>
                        </tr>
                        <tr class="table-warning">
                            <th>Kurangan Bayar</th>
                            <td id="pemesanKuranganBayar"></td>
                        </tr>
                        <tr class="table-danger">
                            <th>Total Bayar</th>
                            <td id="pemesanTotalBayar"></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-id="" class="btn btn-dark seeAction" data-bs-dismiss="modal">Selesaikan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="completeModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="completeModal">Menyelesaikan Booking Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="/merchant-transaction-list" method="POST">
                <div class="modal-body">
                    <div class="form-floating">
                        <input type="text" id="kasir" name="kasir" class="form-control">
                        <label for="kasir">Nama Penanggung Jawab (Kasir)</label>
                    </div>
                </div>
                <div class="modal-footer">
                        @csrf
                        <input type="hidden" id="idBooklist" name="id">
                        <button class="btn btn-dark deleteButton" type="submit">Simpan</button>
                    </div>
                </form>
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
                        <textarea placeholder="Tulis pengalaman mu disini ya." name="review" class="form-control" style="resize: none" id="" cols="30" rows="10"></textarea>
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
        function updateTable(data=[]){
            let toBtn = (datanya,warnanya)=>`<button class="btn btn-${warnanya} btn-sm">${datanya}</button>`;
            let btnJamElem = '';
            if(data.jam){
                data.jam.forEach(jam=>btnJamElem+=toBtn(jam.jam,'success'));
            }
            let warnaStatus = data.status == 'complete'?'success':'warning';
            let status = 'On Going';
            if(data.status == 'complete'){
                document.querySelector(`.seeAction`).classList.add('d-none');
                status ='Completed';
            }else{
                document.querySelector(`.seeAction`).classList.remove('d-none');
            }
            document.querySelector(`#pemesanNama`).innerText = data.nama?data.nama:'';
            document.querySelector(`#pemesanTanggalBayar`).innerText = data.tanggal_bayar?data.tanggal_bayar:'';
            document.querySelector(`#pemesanStatus`).innerHTML = data.status?toBtn(status,warnaStatus):'';
            document.querySelector(`#pemesanKasir`).innerText = data.kasir||'';
            document.querySelector(`#pemesanTanggal`).innerText = data.tanggal||'';
            document.querySelector(`#pemesanJam`).innerHTML = data.jam?btnJamElem:'';
            document.querySelector(`#pemesanDP`).innerText = data.telah_dibayar||'';
            document.querySelector(`#pemesanKuranganBayar`).innerText = data.kurangan||'';
            document.querySelector(`#pemesanTotalBayar`).innerText = data.total||'';
        }
        document.querySelectorAll(`.seeMore`).forEach(elem=>{
            elem.addEventListener("click",function(e){
                document.querySelector(`#messageFormSeeMore`).classList.toggle('d-none');
                let elemModal = document.querySelector(`#seeMoreModal`);
                let modal = new bootstrap.Modal(elemModal);
                updateTable();
                document.querySelector(`.seeAction`).dataset.id = this.dataset.id;
                modal.show();
                fetch(`/merchant-transaction-list?id=${this.dataset.id}`)
                .then(ee=>ee.json())
                .then(res=>{
                    document.querySelector(`#messageFormSeeMore`).classList.toggle('d-none');
                    
                    updateTable(res);
                })
            });
        })
        document.querySelector(`.seeAction`).addEventListener('click', function(e){
            let elemModal = document.querySelector(`#completeModal`);
            document.querySelector(`#completeModal input#idBooklist`).value = this.dataset.id;
            let modal = new bootstrap.Modal(elemModal);
            modal.show();
        })
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
