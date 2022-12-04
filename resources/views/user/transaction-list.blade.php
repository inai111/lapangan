@extends('layouts.main')

@section('iseng', 'title')
@section('css-tambahan')
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="SB-Mid-client-bYW2-IBZiQkLXx15"></script>
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
                            <button class="nav-link active" id="pending-tab" data-bs-toggle="tab"
                                data-bs-target="#pending-tab-pane" type="button" role="tab" aria-controls="pending-tab-pane"
                                aria-selected="true">Dipesan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="ongoing-tab" data-bs-toggle="tab"
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
                        <div class="tab-pane fade show active" id="pending-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                            tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="6">List Lapangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($booklists['pending'])
                                        @foreach ($booklists['pending'] as $booklist)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset("assets/img/lapangan/cover/{$booklist->lapangan->cover}") }}"
                                                        class="img-thumbnail" style="width:80px;height:80px"
                                                        alt="{{ $booklist->lapangan->nama }}">
                                                </td>
                                                <td>
                                                    <h5>{{ $booklist->lapangan->nama }}</h5>
                                                    <a href="/merchant/{{$booklist->id_merchant}}">{{$booklist->name_merchant}}</a></td>
                                                @if ($booklist->jadwal)
                                                    <td class="text-center">
                                                        <div>{{ date('d-M-Y', strtotime($booklist->jadwal[0]['tanggal'])) }}</div>
                                                        @foreach ($booklist->jadwal as $item)
                                                            <div class="btn btn-success btn-sm">{{$item->jam}}</div>
                                                        @endforeach
                                                        
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <div class="mb-1">
                                                            Jadwal Belum Ada
                                                        </div>
                                                        <button data-length="{{ $booklist->length }}"
                                                            data-id="{{ $booklist->id }}"
                                                            class="btn btn-sm btnPemesanan btn-outline-success">Pilih
                                                            Jadwal</button>
                                                    </td>
                                                @endif
                                                <td>{{ $booklist->length }} Jam</td>
                                                <td>Rp. {{ number_format($booklist->length * $booklist->lapangan->harga) }}
                                                </td>
                                                <td>
                                                    @if ($booklist->jadwal)
                                                        <div class="btn-group dropup">
                                                            @if($booklist->transaction)
                                                            <button type="button" data-pembayaran="{{$booklist->type_pembayaran}}" data-id="{{$booklist->id}}" class="btn btn-outline-dark bayarNow" aria-expanded="false">
                                                                Bayar <span class="text-danger">(00:00)</span>
                                                            </button>
                                                            @else
                                                            <button type="button" class="btn btn-outline-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                                Bayar
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                @if($booklist->dp == 1 && in_array($booklist->pembayaran,['both','transfer']))
                                                                <li><a data-pembayaran="dp" data-id="{{$booklist->id}}" class="dropdown-item bayarNow" href="#">Bayar DP <span class="text-danger">(Bayar 50%)</span></a></li>
                                                                @endif
                                                                @if(in_array($booklist->pembayaran,['both','transfer']))
                                                                <li><a data-pembayaran="full" data-id="{{$booklist->id}}" class="dropdown-item bayarNow" href="#">Bayar Full Transfer <span class="text-danger">(Bayar 100%)</span></a></li>
                                                                @endif
                                                                @if(in_array($booklist->pembayaran,['both','cash']))
                                                                <li><a data-pembayaran="cash" data-id="{{$booklist->id}}" class="dropdown-item bayarNow" href="#">Bayar Full Ditempat</a></li>                                                            
                                                                @endif
                                                            </ul>
                                                            @endif

                                                        </div>
                                                      
                                                        {{-- <button data-id="{{$booklist->id}}" class="btn btn-outline-dark bayarNow">Bayar</button> --}}
                                                    @endif
                                                    <button data-id="{{$booklist->id}}" class="btn btn-outline-danger deleteTrans"><i
                                                            class="fa fa-trash"></i></button>
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
                        <div class="tab-pane fade" id="ongoing-tab-pane" role="tabpanel" aria-labelledby="ongoing-tab"
                            tabindex="0">...</div>
                        <div class="tab-pane fade" id="complete-tab-pane" role="tabpanel" aria-labelledby="complete-tab"
                            tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="6">List Lapangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($booklists['complete'])
                                        @foreach ($booklists['complete'] as $booklist)
                                            <tr>
                                                <td>
                                                    <img src="{{ asset("assets/img/lapangan/cover/{$booklist->lapangan->cover}") }}"
                                                        class="img-thumbnail" style="width:80px;height:80px"
                                                        alt="{{ $booklist->lapangan->nama }}">
                                                </td>
                                                <td>{{ $booklist->lapangan->nama }}</td>
                                                @if ($booklist->jam_awal && $booklist->jam_akhir)
                                                    <td>
                                                        <div>{{ date('d-M-Y', strtotime($booklist->jam_awal)) }}</div>
                                                        <div>{{ date('H:i', strtotime($booklist->jam_awal)) }} -
                                                            {{ date('H:i', strtotime($booklist->jam_akhir)) }}</div>
                                                    </td>
                                                @else
                                                    <td class="text-center">
                                                        <div class="mb-1">
                                                            Jadwal Belum Ada
                                                        </div>
                                                        <button data-length="{{ $booklist->length }}"
                                                            data-id="{{ $booklist->id }}"
                                                            class="btn btn-sm btnPemesanan btn-outline-success">Pilih
                                                            Jadwal</button>
                                                    </td>
                                                @endif
                                                <td>{{ $booklist->length }} Jam</td>
                                                <td>Rp. {{ number_format($booklist->length * $booklist->lapangan->harga) }}
                                                </td>
                                                <td>
                                                    @if (empty($booklist->rating))
                                                    <button data-id="{{$booklist->id}}" class="btn btn-dark ratingNow"><i class="fa fa-star me-1" style="color:gold"></i>Kasih Rating</button>
                                                    @endif
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
                    </div>
                </div>
            </main>
        </div>
    </div>

    {{-- modal atur pemesanan --}}
    <div class="modal fade" id="pemesananModal" tabindex="-1" aria-labelledby="pemesananModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pemesananModalLabel">Pemesanan Lapangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="messageFormPemesanan"></div>
                    <div class="mb-3">
                        <label for="dateBook" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="dateBook" min="{{date("Y-m-d")}}">
                      </div>                      
                    <div class="row" id="jamContent"></div>
                </div>
                <div class="modal-footer">
                    <form id="formPesanJadwal" action="/book-date" method="post">
                        @csrf
                        <input type="hidden" name="id">
                        <input type="hidden" name="date">
                        <input type="hidden" name="hour">
                        <button type="submit" class="btn btn-dark">Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="alertModalHapus" tabindex="-1" aria-labelledby="pemesananModalLabel" aria-hidden="true">
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
        document.querySelector(`#dateBook`).addEventListener('change',function(e){
            let date = this.value;
            let id = document.querySelector(`#formPesanJadwal input[name="id"]`).value;
            fetch(`get-jadwal-lapangan/${id}?tanggal=${date}`)
                .then(ee => ee.json())
                .then(res => {
                    console.log(`get-jadwal-lapangan/${id}?tanggal=${date}`,res)
                    let content = (data) => {
                        let hasilTemplateContent = ``;
                        let hasilTemplateLi = ``;
                        let buttonTemplate = (jam,tanggal,harga,book) => `
                        <div class="col-md-3 p-1">
                            <button data-tanggal="${tanggal}" data-jam="${jam}" 
                            data-harga="${harga}" class="${book?"disabled btn-dark":"btn-outline-primary"} btn px-3 selectableSchedule" >
                            ${jam}
                            Rp.${new Intl.NumberFormat("id-ID").format(harga)}
                            </button>
                        </div>
                        `;
                        data.forEach(jam=>{
                            hasilTemplateContent += buttonTemplate(jam.jam,jam.tanggal,jam.harga,jam.book);
                        })
                        return hasilTemplateContent;
                    }
                    if (res.data) {
                        let temp = content(res.data);
                        jamContent.innerHTML = temp;
                        document.querySelectorAll(`.selectableSchedule`).forEach(elem=>{
                            elem.addEventListener('click',function(e){
                                if(!this.classList.contains('active') && document.querySelectorAll(`.selectableSchedule.active`).length>2){
                                    messageFormPemesanan.innerHTML = `
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>Gagal</strong> tidak dapat memesan lebih dari 3 jam.
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>`;
                                    return;
                                }
                                if(this.classList.contains('active')){
                                    this.classList.remove('active')
                                }else this.classList.add('active');
                                if(document.querySelectorAll(`.selectableSchedule.active`).length>0){
                                    document.querySelector(`#formPesanJadwal [type="submit"]`).disabled = false;
                                }else document.querySelector(`#formPesanJadwal [type="submit"]`).disabled = true;
                            })
                        })
                    }
                });
            
        })
        document.querySelector(`#formPesanJadwal`).addEventListener('submit',function(e){
            e.preventDefault();
            let myData = new FormData(this);
            let hour = new Array();
            document.querySelectorAll(`.selectableSchedule.active`).forEach(elem=>{
                hour.push(elem.dataset.jam);
            })
            myData.set('hour',hour);
            myData.set('date',document.querySelector(`.selectableSchedule.active`).dataset.tanggal);
            window.tes = myData;
            fetch(this.action,{method:"POST",body:myData})
            .then(ee=>ee.json())
            .then(res=>{
                if(res.status){
                    if(res.message){
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
                if(res.message){
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
        document.querySelectorAll(`.deleteTrans`).forEach(elem=>{
            elem.addEventListener('click',function(e){
                let modalAlert = new bootstrap.Modal(alertModalHapus);
                idTransactionDelete.value = this.dataset.id;
                modalAlert.show()
            })
        })
        
        function initSelectableDate()
        {
            document.querySelectorAll(`.selectableButton`).forEach(elem=>{
                elem.addEventListener('click',function(e){
                    if(document.querySelector(`.selectableButton.active`))document.querySelector(`.selectableButton.active`).classList.remove('active');
                    elem.classList.add('active');
                    document.querySelector(`#formPesanJadwal [type="submit"]`).disabled = false;
                    document.querySelector(`#formPesanJadwal input[name="date"]`).value = elem.dataset.date;
                    document.querySelector(`#formPesanJadwal input[name="hour"]`).value = elem.innerText;
                })
            })
        }
        document.querySelectorAll(`.ratingNow`).forEach(elem=>{
            elem.addEventListener("click",function(e){
                let modal = new bootstrap.Modal(ratingModal);
                document.querySelector('.reviewSaveButton').disabled = true;
                document.querySelector(`#formSaveReview #idTransactionReview`).value = this.dataset.id;
                document.querySelector(`#formSaveReview #ratingTransactionReview`).value = 0;
                document.querySelectorAll('#ratingModal .fa-star').forEach(elem=>{
                    elem.classList.remove('selected');
                    elem.classList.remove('toggle');
                    elem.classList.replace('text-danger','text-secondary');
                })
                modal.show();
            })
        })
        document.querySelectorAll('#ratingModal .fa-star').forEach(elem=>{
            elem.addEventListener('mouseover',function(e){
                let rating = this.dataset.val;
                elem.classList.replace('text-secondary','text-danger');
                for(let i=0;i<=rating;i++){
                    document.querySelectorAll('#ratingModal .fa-star')[i].classList.replace('text-secondary','text-danger');
                }
            })
            elem.addEventListener('mouseout',function(e){
                document.querySelectorAll('#ratingModal .fa-star').forEach(star=>{
                    if(!star.classList.contains('toggle')) star.classList.replace('text-danger','text-secondary');
                })
            })
            elem.addEventListener('click',function(e){
                let rating = this.dataset.val;
                if(document.querySelector('.fa-star.selected'))document.querySelector('.fa-star.selected').classList.remove('selected');
                this.classList.add('selected')
                elem.classList.replace('text-secondary','text-danger');
                for(let i=0;i<=4;i++){
                    document.querySelectorAll('#ratingModal .fa-star')[i].classList.replace('text-danger','text-secondary');
                    if(i<=rating){
                        document.querySelectorAll('#ratingModal .fa-star')[i].classList.add('toggle');
                        document.querySelectorAll('#ratingModal .fa-star')[i].classList.replace('text-secondary','text-danger');
                    }else document.querySelectorAll('#ratingModal .fa-star')[i].classList.remove('toggle');
                }
                document.querySelector(`#formSaveReview #ratingTransactionReview`).value = rating;
                document.querySelector(`.reviewSaveButton`).disabled = false;

            })
        })
        document.querySelector(`.reviewSaveButton`).addEventListener('click',function(e){
            if(this.disabled)return;
            document.querySelector(`form#formSaveReview`).submit();
        })
        document.querySelectorAll(`.bayarNow`).forEach(elem=>{
            elem.addEventListener(`click`,function(e){
                e.preventDefault();
                let id = this.dataset.id;
                let pembayaran = this.dataset.pembayaran;
                fetch(`/cek-transaksi?id=${id}&pembayaran=${pembayaran}`)
                .then(ee=>ee.json())
                .then(res=>{
                    console.log(res);
                    if(res.token){
                        snap.pay(res.token,{
                            onSuccess: function(result){
                                console.log(result.status_message);

                            },
                            onPending: function(result){
                                console.log(result.status_message);
                            },
                            onError: function(result){
                                console.log(result.status_message);
                            }
                        });
                    }
                })
            })
        })

    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
