<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ headTitle()->add('Admin')->render(' :: ') }}</title>
    <link rel="alternate icon" href="/img/favicon.png">
 
    @style('/vendor/ascent/cms/css/bootstrap.min.css') 
    @style("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.0/font/bootstrap-icons.css") 
    @style('/vendor/ascent/cms/js/jquery-ui.min.css') 
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

    @script('/vendor/ascent/cms/js/jquery-3.5.1.min.js')
    @script('/vendor/ascent/cms/js/jquery-ui.min.js')
    @script('/vendor/ascent/cms/js/bootstrap.bundle.min.js')
    @script('/vendor/ascent/cms/jquery/ascent.cms.modalLink.js')
    @stack('scripts')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>

</body>
</html>