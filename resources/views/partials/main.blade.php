<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold" href="/">Pet Shop</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
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
            </div>
        </div>
    </div>
</nav>
