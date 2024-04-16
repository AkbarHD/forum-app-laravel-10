<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title')</title>
{{-- cdn css summernote --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
{{-- utk include css karena menggunakan sass ambil di documentasi laravel "vite" --}}
@vite(['resources/scss/app.scss', 'resources/js/app.js']) <!-- 2 link utk mnghubungkan scss dan js -->
