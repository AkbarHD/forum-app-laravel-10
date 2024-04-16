{{-- template untuk halaman login dan sign up --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body>

    {{-- nabar-start --}}
    @include('partials.nav')
    {{-- nabar-end --}}

    {{-- content --}}
    @yield('body')
    {{-- end content --}}

    @yield('before-script')
    @include('partials.script')
    @yield('after-script')

</html>
