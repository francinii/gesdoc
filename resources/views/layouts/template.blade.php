<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  style = "height: 100vh;   " >

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> Gesdoc - @yield('title') </title>
    <link rel="stylesheet"  href="{{ asset('../resources/extensions/fontawesome-free-5.13.0-web/css/all.css') }}" >
    <link rel="stylesheet"   href="{{ asset('../resources/extensions/bootstrap-4.3.1/css/bootstrap.min.css') }}" >
    <link rel="stylesheet"    href="{{ asset('../resources/css/app.css') }}">
    <link rel="stylesheet"   href="{{ asset('../resources/extensions/DataTables-1.10.20/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('../resources/extensions/bootstrap-select-1.13.9/dist/css/bootstrap-select.min.css') }}">
    
    <script type="text/javascript"  src = "{{ asset('../resources/extensions/JQuery-3.3.1/jquery-3.3.1.min.js') }}"></script>
    <script type="text/javascript"  src="{{ asset('../resources/extensions/bootstrap-4.3.1/js/bootstrap.bundle.min.js') }}"></script>

    <script type="text/javascript"  src="{{ asset('../resources/extensions/DataTables-1.10.20/js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('../resources/extensions/bootstrap-select-1.13.9/dist/js/bootstrap-select.min.js') }}"></script>



    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.4.1/css/buttons.dataTables.min.css">
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.flash.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.html5.min.js"></script>
    <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/buttons/1.4.1/js/buttons.print.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>

    
    @yield('head')
</head>

<body  style="">    
        @yield('header')
        <div class="container-fluid">
            <div class="row staticPositionDiv">
                <div class="col-11" style= "height:60px"></div>
                <div id="cargandoDiv" style="display:none" class="col-1 justify-content-right">
                    <img   src="../storage/app/cargando.gif" class="justify-content-right" alt="Cargando" width="60px">
                </div>
            </div>
        </div>     
         @yield('content')  
        
        
        
</body>  
   

</html>
