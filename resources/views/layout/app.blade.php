{{-- template home, discussion --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>

<body>

    {{-- nabar-start --}}
    @include('partials.nav')
    {{-- nabar-end --}}

    {{-- alert --}}
    @include('partials.alert')
    {{-- END- alert --}}

    {{-- content --}}
    @yield('body')
    {{-- end content --}}

    {{-- footer --}}
    @include('partials.footer')
    {{-- end footer --}}

    @yield('before-script')
    @include('partials.script')
    @yield('after-script')

</html>
