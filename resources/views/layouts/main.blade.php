<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pet Shop @yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css"
        integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    @yield('css-tambahan')
</head>

<body>
    @yield('navbar')
    @yield('content')
    <div class="position-relative py-3 px-5 w-100 bottom-0 bg-light mt-5">
       <div class="row">
        <div class="col-4">
            <h4><strong>Sewa Lapangan</strong></h4>
            <p>asdkljasndlkajsn alskda lskdnalskdna</p>
        </div>
        <div class="col-4">
            <h4><strong>Halaman</strong></h4>
            <ul class="list-unstyled">
                <li class="mb-2"><a style="text-decoration: none;color:#495057" href="">Home</a></li>
                <li class="mb-2"><a style="text-decoration: none;color:#495057" href="">About</a></li>
                <li class="mb-2"><a style="text-decoration: none;color:#495057" href="">Lainnya</a></li>
            </ul>
        </div>
        <div class="col-3">
            <h4><strong>Payment</strong></h4>
            <div class="row m-0 p-0">
                <div class="col-4 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/ovo.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/gopay.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/kredivo.png" alt="">
                </div>
                <div class="col-4 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/shopeepay.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/dana.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/qris.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/bca.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/bni.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/bank-dki.png" alt="">
                </div>
                <div class="col-6 col-md-4">
                    <img class="my-2" style="width:100%" src="https://www.gelora.id/img/icons/payment_icons/permata.png" alt="">
                </div>
            </div>
        </div>
       </div>
    </div>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
        id="listMessage" aria-labelledby="listMessage">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="listMessageLabel"><i class="fa fa-message me-2"></i>Messages</h5>
            {{-- <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button> --}}
            <button type="button" class="btn btn-outline-dark rounded-circle" data-bs-dismiss="offcanvas"
                aria-label="Close"><i class="fa fa-chevron-left"></i></button>
        </div>
        <div class="offcanvas-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="pb-1">
                        <button data-bs-toggle="offcanvas" data-bs-target="#messageOpened" data-obj=""
                            class="btn d-flex align-items-center btn-secondary text-light rounded-pill openMessage">
                            <img class="rounded-circle bg-light" src="{{ asset('assets/img/profilpic/default.png') }}"
                                style="width: 20%" alt="">
                            <div class="ps-3 text-start">
                                <div>Nama Pengirim</div>
                                <div>asdasdasdasd</div>
                                <small>{{ date('d-F-Y H:i:s') }}</small>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1"
        id="messageOpened" aria-labelledby="messageOpenedLabel">
        <div class="offcanvas-header border-bottom">
            <div class="d-flex align-items-center">
                <img id="msgContImgMerchant" class="rounded-circle bg-light"
                    src="{{ asset('assets/img/profilpic/default.png') }}" style="width: 20%" alt="">
                <div class="ps-3 text-start">
                    <h5 id="msgContNameMerchant" class="offcanvas-title">Nama Pengirim</h5>
                    {{-- <small>{{ date('d-F-Y H:i:s') }}</small> --}}
                </div>
            </div>
            <button type="button" class="btn btn-outline-dark rounded-circle" data-bs-toggle="offcanvas"
                data-bs-target="#listMessage"><i class="fa fa-chevron-left"></i></button>
        </div>
        <div class="offcanvas-body">
            <div id="msgContBody" class="position-relative h-75" style="overflow-y:scroll;word-wrap:anywhere"></div>
            <div class="pt-3">
                <form id="messageForm" class="row align-items-center">
                    <div class="col-10 pe-0">
                        <div class="input-group">
                            @csrf
                            <input type="hidden" name="user_id">
                            <input type="hidden" name="target_id">
                            <textarea name="message" type="text" class="form-control" id="message" placeholder="Message"
                                style="resize: none"></textarea>
                        </div>
                    </div>
                    <div class="col-2">
                        <button id="sendMessage" class="btn btn-dark btn-sm"><i
                                class="fa-solid fa-paper-plane"></i></button>
                    </div>
                </form>
            </div>

        </div>
    </div>
    <script>
        if(document.querySelector(`#sendMessage`)) sendMessage.addEventListener('click',function(e){
            e.preventDefault();
            let myData = new FormData(messageForm);
            if(document.querySelector('#tagLapanganActive'))myData.append('ref_id',tagLapanganActive.dataset.refid);
            fetch('/send-message',{method:"POST",body:myData})
            .then(ee=>ee.json())
            .then(res=>{
                console.log(res);
                messageForm.querySelector('textarea[name="message"]').classList.remove('is-invalid');
                if(res.validation.message){
                    messageForm.querySelector('textarea[name="message"]').classList.add('is-invalid');
                }
                if(res.status) 
                {
                    messageForm.querySelector('textarea[name="message"]').value = '';
                    if(document.querySelector('#tagLapanganActive'))document.querySelector('#tagLapanganActive').remove();
                    updateMsgCont();
                    msgContBody.scrollTop = msgContBody.scrollHeight;
                }
            })
            
        });
        let currentTarget,messageVault;
        function updateMsgCont()
        {
            if(!document.querySelector(`#messageForm input[name="target_id"]`))return;
            let target = document.querySelector(`#messageForm input[name="target_id"]`).value;
            if(!target)return;
            fetch(`/get-message?target_id=${target}`)
            .then(ee=>ee.json())
            .then(res=>{
                // cek dulu apakah sama? kalau sama maka ambil last nya aja dan append
                let messageElem = ``;
                currentTarget = target;
                let tanggal;
                res.messages.forEach(msg=>{
                    if(tanggal != msg.tanggal){
                        tanggal = msg.tanggal;
                        messageElem +=`
                        <div class="rounded-pill position-sticky top-0 bg-secondary mx-auto px-3 py-1 my-2 mb-4 text-light"
                    style="width:fit-content">${msg.tanggal}</div>
                        `;
                    }
                    let pos = `bg-dark ms-auto`;//kanan
                    if(msg.from_id == target)pos = `bg-secondary me-auto`//kiri
                    if(msg.ref_id){
                        let pos2 = pos.indexOf('ms-auto')>=0?"ms-auto":"me-auto";
                        messageElem += `
                        <div data-href="/lapangan/${msg.ref_id}" style="cursor:pointer" class="rounded ${pos2} bg-danger px-3 py-1 mb-1 text-light w-75 clickAbleMessage">
                            <div class="row">
                                <div class="col-2">
                                    <img src="${msg.lapangan.cover}" style="width: 50px;">
                                </div>
                                <div class="col-10 text-end">
                                    <div>${msg.lapangan.nama}</div>
                                    <div>Rp. ${msg.lapangan.harga}</div>
                                </div>
                            </div>
                        </div>
                        `;
                    }
                    messageElem += `
                    <div class="rounded ${pos} px-3 py-1 mb-1 text-light" style="width:fit-content">
                        ${msg.body}
                        <div class="text-end" style="font-size: .8em;">${msg.jam}</div>
                    </div>`;
                })
                messageVault = messageElem;
                // msgContBody.insertAdjacentHTML('afterbegin',messageElem);
                msgContBody.innerHTML = messageElem;
                document.querySelectorAll(`.clickAbleMessage`).forEach(elem=>{
                    elem.addEventListener(`click`,function(e){
                        window.location.href = this.dataset.href;
                    })
                })
                // document.querySelector(`textarea#message`).value = '';
            })
        }
        let worker = new Worker('/assets/js/worker.js')
        worker.addEventListener('message',e=>{
            let data = e.data;
            if(data.status){
                if(data.unreadMessages.length > 0){
                    messageBadge.style.display = '';
                    messageBadge.innerText = data.unreadMessages.length;

                }else messageBadge.style.display = 'none';
                if(data.messages){
                    let messageElem = ``;
                    data.messages.forEach(message=>{
                        messageElem += `
                        <div class="col-md-12">
                            <div class="pb-1">
                                <button data-obj="${btoa(JSON.stringify(message.user))}"
                                    class="btn d-flex align-items-center btn-secondary text-light rounded position-relative openMessage">
                                    ${message.read?'':`<span class="badge bg-danger position-absolute end-0 mt-1 me-1">New</span>`}
                                    <img class="rounded-circle bg-light" src="${message.user.photo}"
                                        style="width: 20%" alt="">
                                    <div class="ps-3 text-start">
                                        <div>${message.user.name}</div>
                                        <div>${message.body}</div>
                                        <small>${message.tanggal}</small>
                                    </div>
                                </button>
                            </div>
                        </div>
                    `;
                    })
                    document.querySelector(`#listMessage .offcanvas-body .row`).innerHTML = messageElem;
                    document.querySelectorAll(`.openMessage`).forEach(elem=>{
                        elem.addEventListener('click',function(e){
                            let user = JSON.parse(atob(this.dataset.obj))
                            if(document.querySelector(`#messageForm input[name="target_id"]`)) document.querySelector(`#messageForm input[name="target_id"]`).value = user.id;
                            updateMsgCont();
                            msgContImgMerchant.src = user.photo;
                            msgContNameMerchant.innerText = user.name
                            let message = new bootstrap.Offcanvas(`#messageOpened`);
                            message.show();
                            msgContBody.scrollTop = msgContBody.scrollHeight;

                        })
                    })
                }
                setTimeout(() => {
                    worker.postMessage('tes');
                    updateMsgCont();
                }, 5000);
            }
        })
        if(document.querySelector(`#messageBadge`)) worker.postMessage('tes');
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
    @yield('js-tambahan')
</body>

</html>
