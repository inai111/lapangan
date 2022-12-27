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
                    <a href="/add-lapangan" class="btn btn-primary"><i class="fa-solid fa-plus"></i> Tambah Lapangan</a>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Lapangan</th>
                                <th>Harga</th>
                                <th>Telah Dipesan</th>
                                <th>Rating</th>
                                <th class="text-center">Status</th>
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
                                <td class="text-center"><button class="rounded-pill px-4 btn btn-sm {{$item->status=='ada'?"btn-success":"btn-warning"}}"><strong>{{$item->status}}</strong></button></td>
                                <td>
                                    @php
                                        $datanya = $item;
                                        $dir_name = str_replace(' ','_',$item->nama);
                                        $datanya->cover = asset("assets/img/{$dir_name}/cover/{$datanya->cover}");
                                        $obj = base64_encode(json_encode($datanya));
                                    @endphp
                                    <button data-obj="{{$obj}}" class="btn btn-outline-dark editBtn">Edit</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <div class="modal fade" id="editLapanganModal" tabindex="-1" aria-labelledby="seeMoreModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="seeMoreModalLabel">Detil Pemesanan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form name="form" action="/edit-lapangan" method="post" enctype="multipart/form-data">
                    @csrf
                <div class="modal-body">
                    <div id="messageFormSeeMore" class="w-100 badge bg-secondary text-center d-none">
                        <i class="fa fa-spin fa-spinner me-2"></i>
                        Memuat Informasi
                    </div>
                    <div class="mx-auto rounded mb-3 changeImagePreview" style="width: 8vw;height: 8vw;border: 1px solid black !important;"></div>
                        
                        <input type="hidden" class="form-control mb-3" name="id" id="idLapangan">
                        <input type="file" class="form-control mb-3" name="cover_lapangan">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" disabled readonly id="editNama">
                            <label for="floatingInput">Nama Lapangan</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="harga" id="editHarga">
                            <label for="floatingInput">Harga Sewa/Jam</label>
                        </div>
                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="deskripsi" name="deskripsi" style="width: 100%;height: 150px;"></textarea>
                            <label for="deskripsi" >Deskripsi</label>
                        </div>
                        <input type="hidden" value="" name="status" id="status" autocomplete="off">
                        <div class="form-group mb-3">
                            <input type="checkbox" class="btn-check" id="statusLapangan" autocomplete="off">
                            <label class="btn btn-outline-primary" for="statusLapangan">Aktif</label><br>
                        </div>

                          
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-dark">Selesaikan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function ubahEditModal(data){
            let elemModal = document.querySelector(`#editLapanganModal`);
            elemModal.querySelector(`#editNama`).value = data.nama?data.nama:'';
            elemModal.querySelector(`#editHarga`).value = data.harga?data.harga:'';
            elemModal.querySelector(`#deskripsi`).value = data.deskripsi?data.deskripsi:'';
            elemModal.querySelector(`#idLapangan`).value = data.id?data.id:'';
            if(data.cover){
                document.querySelector(`.changeImagePreview`).style.background = `url(${data.cover}) center/cover no-repeat`;
            }
            let statusCheck = false;
            let statusLabel = "Tidak Aktif";
            elemModal.querySelector(`#status`).value = "tidak_ada";
            if(data.status == 'ada'){
                statusCheck = true;
                statusLabel = "Aktif";
                elemModal.querySelector(`#status`).value = 'ada';
            }
            elemModal.querySelector(`#statusLapangan`).checked = statusCheck;
            elemModal.querySelector(`label[for="statusLapangan"]`).innerText = statusLabel;
        }
        document.querySelectorAll(`.editBtn`).forEach(elem=>{
            elem.addEventListener("click", function(e){
                let elemModal = document.querySelector(`#editLapanganModal`);
                let modal = new bootstrap.Modal(elemModal);
                let object = JSON.parse(atob(this.dataset.obj))
                ubahEditModal(object);
                modal.show();
            })
            
        })
        document.querySelector(`#editLapanganModal #statusLapangan`).addEventListener('change',function(e){
            let elemModal = document.querySelector(`#editLapanganModal`);
            let statusCheck = false;
            let statusLabel = "Tidak Aktif";
            elemModal.querySelector(`#status`).value = "tidak_ada";
            if(this.checked){
                statusCheck = true;
                statusLabel = "Aktif";
                elemModal.querySelector(`#status`).value = 'ada';
            }
            elemModal.querySelector(`#statusLapangan`).checked = statusCheck;
            elemModal.querySelector(`label[for="statusLapangan"]`).innerText = statusLabel;
        })
        document.querySelector(`form [name="cover_lapangan"]`).addEventListener('change', function(e) {
            document.querySelector(`.changeImagePreview`).style.background = `url(${URL.createObjectURL(this.files[0])}) center/cover no-repeat`;
        })
    </script>
@endsection
@section('js-tambahan')
    <script src="{{ asset('assets/js/scripts.js') }}"></script>

@endsection
