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
                                                    @if ($booklist->jam_awal || $booklist->jam_akhir)
                                                        <button data-id="{{$booklist->id}}" class="btn btn-outline-dark bayarNow">Bayar</button>
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
                        <div class="tab-pane fade" id="pending-tab-pane" role="tabpanel" aria-labelledby="pending-tab"
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
                    <ul class="nav nav-tabs" id="tanggalTab" role="tablist"></ul>
                    <div class="tab-content" id="jamContent"></div>
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
        document.querySelectorAll(".btnPemesanan").forEach(element => {
            element.addEventListener('click', function(e) {
                let lengthVal = this.dataset.length;
                document.querySelector(`#formPesanJadwal [type="submit"]`).disabled = true;
                document.querySelector(`#formPesanJadwal input[name="id"]`).value = this.dataset.id;
                fetch(`get-jadwal-lapangan/${this.dataset.id}?length=${lengthVal}`)
                    .then(ee => ee.json())
                    .then(res => {
                        if (res.message) {

                        }
                        let content = (data) => {
                            let hasilTemplateContent = ``;
                            let hasilTemplateLi = ``;
                            let paneTemplate = (val, content,cek) => `
                            <div class="tab-pane ${cek?"pane show active":"fade"}" id="pane${val}" role="tabpanel" aria-labelledby="pane${val}"
                            tabindex="0">${content}</div>
                            `;
                            let liTemplate = (val,cek) => `
                            <li class="nav-item" role="presentation">
                                <button class="nav-link ${cek?"active":""}" id="tab${val}" data-bs-toggle="tab"
                                    data-bs-target="#pane${val}" type="button" role="tab" aria-controls="tab${val}"
                                    aria-selected="true">${val}</button>
                            </li>
                            `;
                            let i = 0;
                            for (const [index, val] of Object.entries(data)) {
                                console.log(index,val)
                                let temp = `<div class="list-group">`;
                                let cek = i==0;
                                val.forEach(str => temp += `  <button data-date="${index}" type="button" class="list-group-item list-group-item-action selectableButton">${str}</button>`);
                                temp +=`</div>`;
                                hasilTemplateContent += paneTemplate(index, temp, cek);
                                hasilTemplateLi += liTemplate(index, cek);
                                i++;
                            }
                            return [hasilTemplateContent, hasilTemplateLi];
                        }
                        if (res.data) {
                            let temp = content(res.data);
                            tanggalTab.innerHTML=temp[1];
                            jamContent.innerHTML=temp[0];
                        }
                        let modal = new bootstrap.Modal(pemesananModal);
                        initSelectableDate();
                        modal.show();
                    });
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
                fetch(`/cek-transaksi?id=${id}`)
                .then(ee=>ee.json())
                .then(res=>{
                    console.log(res);
                })
            })
        })

    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
