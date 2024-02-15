<!DOCTYPE html>
<html lang="en">

<head>
    @include('partials.header')
    @yield('cssPage')
</head>

<body>
    @yield('navbar')
    <div id="canvas" class="d-flex align-items-center justify-content-center">
        @yield('content')
    </div>
    @include('partials.footer')
    @yield('jsPage')
</body>

</html>