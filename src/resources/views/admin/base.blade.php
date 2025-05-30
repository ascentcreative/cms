<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{config('app.name')}}</title>
 
    @style('/css/bootstrap.min.css') 
    @style("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css") 
    @style('/js/jquery-ui.min.css') 
    @style('/vendor/ascent/cms/css/ascentcreative-cms-admin.css') 

    @style('/css/admin.css') 
   
    @stack('styles')
   
</head>
<body>

    <header>

        @section('header')
        @show

    </header>

    <section>
        @yield('pagebody')
    </section>

    <footer>

    </footer>

    @script('/js/jquery-3.5.1.min.js')
    @script('/js/jquery-ui.min.js')
    @script('/js/bootstrap.bundle.min.js')
    @stack('scripts')

</body>
</html>