<!DOCTYPE html>
<html lang="no">
<head>
    <title>Dashboard</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,900'
          rel='stylesheet'
          type='text/css'>
    <link href="{{ asset("css/app.css") }}" rel="stylesheet"/>
    <meta name="google" value="notranslate">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    @yield('content')

    @if(usingNodeServer())
        <script src="{{ config('app.url') }}:6001/socket.io/socket.io.js"></script>
    @endif
    <script src="{{ asset("js/app.js") }}"></script>

</body>
</html>
