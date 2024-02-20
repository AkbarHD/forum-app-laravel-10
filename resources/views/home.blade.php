<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        {{-- utk include css karena menggunakan sass ambil di documentasi laravel "vite" --}}
        @vite(['resources/scss/app.scss', 'resources/js/app.js']) <!-- 2 link utk mnghubungkan scss dan js -->
    </head>
    <body>
        <nav class="navbar navbar-expand-lg bg-primary navbar-dark">
            <div class="container flex justify-content-between">
              <a class="navbar-link" href="#">
                <img class="h-32px" src="{{ asset('assets/images/image 1.png') }}" alt="laracuss logo">
              </a>
              <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
              <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-0 mx-lg-3">
                  <li class="nav-item d-block d-lg-none d-xl-block">
                    <a class="nav-link active" aria-current="page" href="{{ route('home') }}">Home</a>
                  </li>
                
                  {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      Dropdown
                    </a>
                    <ul class="dropdown-menu float-end">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </li> --}}
                  <li class="nav-item">
                    <a class="nav-link" href="#">Discussion</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-nowrap" href="#">About Us</a>
                  </li>
                </ul>
                <form action="#" method="GET" class="d-flex w-100 me-4 my-2 my-lg-0" role="search">
                  <div class="input-group">
                    <span class="input-group-text border-white border-end-0"><img src="{{ asset('assets/images/Ellipse 3.png') }}" alt="search"></span>
                    <input class="form-control me-2 border-start-0 ps-0" type="text" name="" value="" placeholder="Search" aria-label="Search" >
                  </div>
                </form>
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                  <li class="nav-item my-auto">
                    <a href="#" class="nav-link text-nowrap">Login</a>
                  </li>
                  <li class="nav-item ps-1 pe-0">
                    <a href="#" class=" btn btn-primary-white">Sign Up</a>
                  </li>
                </ul>
              </div>
            </div>
          </nav>

          {{-- jquery --}}
          <script src="{{ asset('assets/jquery/jquery.js') }}"></script>
    </body>
</html>
