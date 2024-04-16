@extends('layout.auth')
@section('title', 'Halaman - Login')
@section('body')
    <section class="bg-gray vh-100">
        <div class="container h-100 pt-5">
            <div class="row justify-content-center">
                <div class="col-12 col-lg-4">
                    <a href="#" class="nav-link text-center mb-5">
                        <img src="{{ asset('assets/images/logo.png') }}" alt="Laracuss-Logo">
                    </a>
                    <div class="card mb-5">
                        <form action="{{ route('auth.login.login') }}" method="POST">
                            @csrf
                            @error('errors')
                                <div class="alert alert-danger text-center">{{ $message }}</div>
                            @enderror
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror""
                                    name="email" id="email" placeholder="name@gmail.com" autocomplete="off"
                                    value="{{ old('email') }}" autofocus>
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
                                    <span class="input-group-text bg-white border-start-0 pe-auto">
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
                                <button type="submit" class="btn btn-primary rounded-2">Login</button>
                            </div>

                        </form>
                    </div>

                    <div class="text-center">
                        Don't have an account? <a href="{{ route('auth.sign-up.show') }}"><u>Sign Up</u></a>
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
