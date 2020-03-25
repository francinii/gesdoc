<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title> Gesdoc - @yield('title') </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">    
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/extencions/fontawesome-free-5.13.0-web/css/all.css') }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/extencions/Bootstrap-4-4.1.1/css/bootstrap.min.css') }}" >
    <link rel="stylesheet"  type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/extencions/DataTables-1.10.20/css/jquery.dataTables.min.css') }}">
    
    
    <script type="text/javascript" src = "{{ asset('../resources/extencions/JQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('../resources/extencions/Bootstrap-4-4.1.1/js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" charset="utf8" src="{{ asset('../resources/extencions/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
    @yield('head')
</head>

<body>

        @yield('header')

        @yield('content')
</body>  
   

</html>
