<!DOCTYPE html>
<html>

<head>
    <title>دعوة زواج@hasSection('title') - @yield('title') @endsection</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>
    @yield('content')

    @stack('js')
</body>

</html>
