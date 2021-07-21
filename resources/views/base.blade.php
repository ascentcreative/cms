<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{ headTitle()->render() }}</title>
    

        <link rel="alternate icon" href="/storage/{!! AscentCreative\CMS\Models\File::find(app(AscentCreative\CMS\Settings\SiteSettings::class)->favicon)->filepath ?? '' !!}">

        {{ metadata($model ?? null) }}
    
        @style('/vendor/ascent/cms/css/ascent-cms-core.css') 
        @style("/vendor/ascent/cms/css/bootstrap.min.css") 
        @style("https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css") 
        @style("/vendor/ascent/cms/js/jquery-ui.min.css") 
        @style("/css/screen.css") 
        @style('/vendor/ascent/checkout/css/ascentcreative-checkout.css') 
        @stack('styles')

        @yield('site_head')
    
        {!! app(AscentCreative\CMS\Settings\SiteSettings::class)->custom_head_tags !!}

    </head>
    
@section('open_body_tag')
    <body>
@show

        {!! app(AscentCreative\CMS\Settings\SiteSettings::class)->custom_body_tags_start !!}

        @yield('site_layout')
        
        
        <form id="logout-form" action="{{ route('logout') }}" method="POST">
            @csrf
            <input type="hidden" name="intended" value="{{ request()->path() }}" />
         </form>

         {{ cookieManager() }}

        @script('/vendor/ascent/cms/js/jquery-3.5.1.min.js')
        @script('/vendor/ascent/cms/js/jquery-ui.min.js')
        @script('/vendor/ascent/cms/js/bootstrap.bundle.min.js')
        @script('/vendor/ascent/cms/js/jquery.ui.touch-punch.min.js')
        @script('/vendor/ascent/cms/jquery/jquery.matchHeight-min.js')
        @script('/vendor/ascent/cms/jquery/ascent.cms.modalLink.js')
        @script('/vendor/ascent/cms/jquery/ascent.cms.ajaxLink.js')
        @stack('scripts')

        {!! app(AscentCreative\CMS\Settings\SiteSettings::class)->custom_body_tags_end !!}

    </body>
</html>