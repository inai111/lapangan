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
                            <button class="nav-link active" id="home-tab" data-bs-toggle="tab"
                                data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane"
                                aria-selected="true">Dipesan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="contact-tab" data-bs-toggle="tab"
                                data-bs-target="#contact-tab-pane" type="button" role="tab"
                                aria-controls="contact-tab-pane" aria-selected="false">On Progress</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="disabled-tab" data-bs-toggle="tab"
                                data-bs-target="#disabled-tab-pane" type="button" role="tab"
                                aria-controls="disabled-tab-pane" aria-selected="false">Berhasil</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab"
                            tabindex="0">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th colspan="6">List Lapangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($booklists)
                                        @foreach ($booklists as $booklist)
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
                                                        <button class="btn btn-outline-dark">Bayar</button>
                                                    @endif
                                                    <button class="btn btn-outline-danger"><i
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
                        <div class="tab-pane fade" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab"
                            tabindex="0">...</div>
                        <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab"
                            tabindex="0">...</div>
                        <div class="tab-pane fade" id="disabled-tab-pane" role="tabpanel" aria-labelledby="disabled-tab"
                            tabindex="0">...</div>
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
                    <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Pesan</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll(".btnPemesanan").forEach(element => {
            element.addEventListener('click', function(e) {
                let lengthVal = this.dataset.length;
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
                                let temp = `<div class="list-group">`;
                                let cek = i==0;
                                val.forEach(str => temp += `  <button type="button" class="list-group-item list-group-item-action">${str}</button>`);
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
                        modal.show();
                    });
            });
        });
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
