@extends('layout.auth')

@section('title', 'Halaman - Register')
@section('body')
    <section class="bg-gray vh-100">
        <div class="container">
            <div class="row pt-5 justify-content-center">
                <div class="col-12 col-lg-6 my-auto mb-5 mb-lg-auto me-0">
                    {{-- ukuran besar akan tampil --}}
                    <div class="d-none d-lg-block">
                        <img src="{{ asset('assets/images/logo-login.png') }}" class="img-fluid" alt="Sign-up">
                    </div>
                    {{-- ukuran kecil akan tampil --}}
                    <div class="d-block d-lg-none fs-4 text-center">
                        Create your account in a minute. It's free
                    </div>
                </div>

                <div class="col-12 col-lg-4 h-100">
                    <a href="#" class="nav-link mb-5 text-center">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="laracuss-Logo">
                    </a>
                    <div class="card mb-5">
                        <form action="{{ route('auth.sign-up.sign-up') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control @error('username') is-invalid @enderror"
                                    name="username" id="username" autocomplete="off" autofocus
                                    value="{{ old('username') }}">
                                @error('username')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" id="email" placeholder="name@gmail.com" value="{{ old('email') }}"
                                    autocomplete="off">
                                @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group">
                                    <input type="password"
                                        class="form-control border-end-0 pe-0 rounded-0 rounded-start @error('password') border-danger rounded-end is-invalid @enderror"
                                        id="password" name="password" value="{{ old('password') }}">
                                    <span
                                        class="input-group-text bg-white border-start-0 pe-auto @error('password') border-danger rounded-end is-invalid @enderror">
                                        <a href="javascript:;" id="password-toggle">
                                            <img src="{{ asset('assets/images/eye-slash.png') }}" id="password-toggle-img"
                                                alt="Password toggle">
                                        </a>
                                    </span>
                                </div>
                                @error('password')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 d-grid">
                                <button type="submit" class="btn btn-primary rounded-2">Sign up</button>
                            </div>
                        </form>
                    </div>

                    <div class="text-center">
                        Already have an account <a href="{{ route('auth.login.show') }}"><u>Login</u></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('after-script')
    <script>
        var isPasswordRevealed = false;

        $('#password-toggle').on('click', function() {
            isPasswordRevealed = !isPasswordRevealed;

            if (isPasswordRevealed) {
                $('#password-toggle-img').attr('src', "{{ asset('assets/images/eye-open.png') }}");
                $('#password').attr('type', 'text');
            } else {
                $('#password-toggle-img').attr('src', "{{ url('assets/images/eye-slash.png') }}");
                $('#password').attr('type', 'password');
            }
        });
    </script>
@endsection
