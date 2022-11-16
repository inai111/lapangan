<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">Pet Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <div class="position-absolute text-center start-0 end-0">
                <button class="searchBar btn ms-1 btn-outline-dark w-25">
                    <div class="d-flex align-items-baseline">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <div class="ms-3">Pencarian</div>
                    </div>
                </button>
            </div>
            @if (session()->has('username'))
            <div class="position-absolute end-0 me-2 d-flex">
                <a href="/user-transactions" class="btn mx-1">
                    <i class="far fa-list-alt"></i>
                </a>
                <button data-bs-toggle="offcanvas" data-bs-target="#listMessage" class="btn mx-1 position-relative">
                    <i class="fa-solid fa-message"></i>
                    <span id="messageBadge" class="position-absolute top-0 start-100 mt-1 translate-middle badge rounded-pill bg-danger" style="display: none;"></span>
                </button>
                <div class="dropdown">
                    <button class="btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-user"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="/dashboard" class="dropdown-item" href="#">Dashboard</a></li>
                      <li><a href="/settings" class="dropdown-item" href="#">Setting</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a href="/logout" class="dropdown-item" href="#">Logout</a></li>
                    </ul>
                </div>
                @else
                <div class="position-absolute end-0 me-3">
                    <button class="btn ms-1 loginBtn">
                        <i class="far fa-list-alt"></i>
                    </button>
                    <button class="btn ms-1 loginBtn">
                        <i class="fa-solid fa-message"></i>
                    </button>
                    <button class="btn rounded-pill btn-dark px-3 ms-2 loginBtn">Login</button>
                </div>
                @endif
            </div>
            {{-- <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                @if(session()->has('username'))
                <li class="nav-item">
                    <a class="nav-link" href="/dashboard">Dashboard</a>
                </li>
                @endif
            </ul>
            <div class="d-flex justify-content-between">
                <a class="btn-outline-dark btn rounded-circle searchBar" href="#">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </a>
                @if(session()->has('username'))
                <a href="/logout" class=" btn rounded-pill btn-dark px-3 ms-2">Logout</a>
                @else
                <button class=" btn rounded-pill btn-dark px-3 ms-2" id="loginBtn">Login</button>
                @endif
            </div> --}}
        </div>
    </div>
</nav>
