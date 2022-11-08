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
                <img id="msgContImgMerchant" class="rounded-circle bg-light" src="{{ asset('assets/img/profilpic/default.png') }}"
                    style="width: 20%" alt="">
                <div class="ps-3 text-start">
                    <h5 id="msgContNameMerchant" class="offcanvas-title">Nama Pengirim</h5>
                    {{-- <small>{{ date('d-F-Y H:i:s') }}</small> --}}
                </div>
            </div>
            <button type="button" class="btn btn-outline-dark rounded-circle" data-bs-toggle="offcanvas"
                data-bs-target="#listMessage"><i class="fa fa-chevron-left"></i></button>
        </div>
        <div class="offcanvas-body">
            <div class="position-relative h-75" style="overflow-y:scroll;word-wrap:anywhere">
                <div class="rounded-pill position-sticky top-0 bg-secondary mx-auto px-3 py-1 my-2 mb-4 text-light"
                    style="width:fit-content">{{ date('d-M-Y', strtotime('-5month')) }}</div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded-pill position-sticky top-0 bg-secondary mx-auto px-3 py-1 my-2 mb-4 text-light"
                    style="width:fit-content">{{ date('d-M-Y') }}</div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light" style="width:fit-content">apa</div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">
                    'asdasdasd'
                    <div class="text-end" style="font-size: .8em;">21:00</div>
                </div>
                <div class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light" style="width:fit-content">apa</div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light" style="width:fit-content">apa</div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light" style="width:fit-content">apa</div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light" style="width:fit-content">apa</div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light" style="width:fit-content">apa
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-dark ms-auto px-3 py-1 mb-1 text-light" style="width:fit-content">asdasdasdas
                </div>
                <div class="rounded bg-secondary me-auto px-3 py-1 mb-1 text-light" style="width:fit-content">apa
                </div>
            </div>
            <div class="pt-3">
                <form class="row align-items-center">
                    <div class="col-10 pe-0">
                        <div class="input-group">
                            <input type="hidden" name="user_id">
                            <input type="hidden" name="target_id">
                            <input type="hidden" name="post_id">
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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
    @yield('js-tambahan')
</body>

</html>
