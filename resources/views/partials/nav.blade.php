{{-- nabar-start --}}
<nav class="navbar navbar-expand-lg bg-primary navbar-dark">
    <div class="container">
        <a class="navbar-link" href="{{ route('home') }}">
            <img class="h-32px" src="{{ asset('assets/images/image 1.png') }}" alt="laracuss logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mx-0 mx-lg-3">
                <li class="nav-item d-block d-lg-none d-xl-block">
                    <a class="nav-link {{ Route::currentRouteName() === 'home' ? 'active' : '' }}" aria-current="page"
                        href="{{ route('home') }}">Homee</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() === 'discussions.index' ? 'active' : '' }}"
                        href="{{ route('discussions.index') }}">Discussion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-nowrap" href="{{ route('home') }}#about-us">About Us</a>
                </li>
            </ul>

            <form action="{{ route('discussions.index') }}" method="GET" class="d-flex w-100 me-4 my-2 my-lg-0"
                role="search">
                <div class="input-group">
                    <span class="input-group-text border-white border-end-0">
                        <img src="{{ asset('assets/images/Ellipse 3.png') }}" alt="search">
                    </span>
                    <input class="form-control me-2 border-start-0 " type="text" name="search" value=""
                        placeholder="Search" aria-label="Search">
                </div>
            </form>

            <ul class="navbar-nav ms-auto my-2 my-lg-0">
                {{-- setelah login --}}
                @auth
                    <li class="nav-item my-auto dropdown">
                        <a href="javascript:;" class="nav-link p-0 d-flex align-items-center" data-bs-toggle="dropdown">
                            <div class="avatar-nav-wrapper me-2">
                                {{-- kta cek apkh user masukin foto atau tdk? jika tdk maka kita akan sediakan bawaan berdsarkan username --}}
                                {{-- jika gambarnya url maka jadikan foto, jika bukan maka ambil mnggunakan storage --}}
                                <img src="{{ filter_var(auth()->user()->picture, FILTER_VALIDATE_URL) ? auth()->user()->picture : Storage::url(auth()->user()->picture) }}"
                                    alt="{{ auth()->user()->username }}" class="avatar rounded-circle">
                            </div>
                            <span class="fw-bold text-nowrap">{{ auth()->user()->username }}</span>
                        </a>
                        <ul class="dropdown-menu mt-2">
                            <li>
                                <a class="dropdown-item" href="{{ route('users.show', auth()->user()->username) }}">My
                                    Profile</a>
                            </li>
                            <li>
                                <form action="{{ route('auth.login.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">Log out</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endauth
                {{-- sebelum login atau sudah logout --}}
                @guest
                    <li class="nav-item my-auto ">
                        <a href="{{ route('auth.login.show') }}"
                            class="nav-link text-nowrap {{ Route::currentRouteName() === 'auth.login.show' ? 'active' : '' }}">Login</a>
                    </li>
                    <li class="nav-item ps-1 pe-0">
                        <a href="{{ route('auth.sign-up.show') }}" class="btn btn-primary-white">Sign Up</a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
{{-- nabar-end --}}
