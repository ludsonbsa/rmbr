<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" ng-app="AlgoliaApp">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'MBR') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nprogress.css') }}" rel="stylesheet">
<!-- <link href="{{ asset('css/style.css') }}" rel="stylesheet"> -->
</head>
<body>
<div id="app">

    <?php
       $checar = \Auth::check();
       if($checar == true):
    ?>
        @include('layouts.inc.header');
        @include('layouts.inc.menu');

    <?php endif; //Checar se está logado ?>
    @yield('content')
</div>
<script>
    /* Progress Bar */
    function fnProgressBarLoading(){
        NProgress.start();
        window.addEventListener("load",function(event){
            NProgress.done();
        });
    }

</script>
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/custom.js') }}"></script>
<script src="{{ asset('js/nprogress.js') }}"></script>
</body>
</html>
