<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ headTitle()->add('Admin')->render(' :: ') }}</title>
    <link rel="alternate icon" href="/storage/{!! AscentCreative\CMS\Models\File::find(app(AscentCreative\CMS\Settings\SiteSettings::class)->favicon)->filepath ?? '../vendor/ascent/cms/img/ascent-badge-trans.png' !!}">

    
 
    @style('/vendor/ascent/cms/css/bootstrap.min.css') 
    @style("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css") 


    @style('/vendor/ascent/cms/js/jquery-ui.min.css') 
    @style('/vendor/ascent/cms/css/ascentcreative-cms-admin.css') 
    @style('/vendor/ascent/cms/css/ascent-cms-core.css') 



    @script('/vendor/ascent/cms/ckeditor/ckeditor.js', false)
    @script('/vendor/ascent/cms/ckeditor/adapters/jquery.js', false)

    @style('/vendor/ascent/cms/dist/css/ascent-cms-bundle.css')
    @style('/vendor/ascent/forms/dist/css/ascent-forms-bundle.css')
    
   
    @stack('styles')
   
</head>
<body id="admin">

    {{-- <header>

        @section('header')
        @show

    </header> --}}

    <section>
        @yield('pagebody')
    </section>

    {{-- <footer>

    </footer> --}}

    @script('/vendor/ascent/cms/js/jquery-3.5.1.min.js')
    @script('/vendor/ascent/cms/js/jquery-ui.min.js')
    @script('/vendor/ascent/cms/js/bootstrap.bundle.min.js')
    {{-- @script('/vendor/ascent/cms/jquery/ascent.cms.modalLink.js') --}}
    @script('/vendor/ascent/cms/dist/js/ascent-cms-bundle.js')
    @script('/vendor/ascent/forms/dist/js/ascent-forms-bundle.js')

    @stack('lib')
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