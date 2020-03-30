<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8"  name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" >    
    <title> Gesdoc - @yield('title') </title>
    <link rel="stylesheet"  href="{{ asset('../resources/extensions/fontawesome-free-5.13.0-web/css/all.css') }}" >
    <link rel="stylesheet"   href="{{ asset('../resources/extensions/bootstrap-4.3.1/css/bootstrap.min.css') }}" >
    <link rel="stylesheet"    href="css/estilos.css">
    <link rel="stylesheet"   href="{{ asset('../resources/extensions/DataTables-1.10.20/css/jquery.dataTables.min.css') }}">

    <script type="text/javascript"  src = "{{ asset('../resources/extensions/JQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('../resources/extensions/bootstrap-4.3.1/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('../resources/extensions/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
    @yield('head')
</head>

<body>

        @yield('header')

        @yield('content')
</body>  
   

</html>
