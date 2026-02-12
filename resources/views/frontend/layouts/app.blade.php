<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'PICKLE')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="index, follow">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta')

    @include('frontend.layouts.header-link')
</head>

<body>

    {{-- Header --}}
    @include('frontend.layouts.navbar')

    {{-- Main Content --}}
    <main class="content-wrapper">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('frontend.layouts.footer')

    @stack('scripts')

</body>
</html>
