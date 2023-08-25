<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>{{ headTitle()->render() }}</title>
    
        @if(env('APP_ENV') != 'production')
            <meta name="robots" content="noindex,nofollow">
        @endif

        <link rel="alternate icon" href="/storage/{!! AscentCreative\CMS\Models\File::find(app(AscentCreative\CMS\Settings\SiteSettings::class)->favicon)->filepath ?? '../vendor/ascent/cms/img/ascent-badge-trans.png' !!}">

        {{ metadata($model ?? null) }}
    
        @style('/vendor/ascent/cms/css/ascent-cms-core.css') 

        @foreach(packageAssets()->getStylesheets() as $style)
            @style($style)
        @endforeach

       {{-- // need to put these in the config: --}}
       @foreach(config('cms.theme_stylesheets') as $style)
            @style($style)
       @endforeach

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
        
        @if(!Agent::isMobile() && !Agent::isTablet())
            {{-- Parallax is a bit buggy on mobiles... --}}
            @script('/vendor/ascent/cms/js/parallax.min.js')
        @endif

        {{-- @script('/vendor/ascent/cms/jquery/ascent.cms.modalLink.js') --}}
        {{-- @script('/vendor/ascent/cms/jquery/ascent.cms.ajaxLink.js') --}}

        @script('/vendor/ascent/cms/dist/js/ascent-cms-bundle.js')
        @script('/vendor/ascent/forms/dist/js/ascent-forms-bundle.js')

        @foreach(packageAssets()->getScripts() as $script)
            @script($script)
        @endforeach

        @stack('scripts')

        <script>
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        </script>

        {!! app(AscentCreative\CMS\Settings\SiteSettings::class)->custom_body_tags_end !!}

    </body>
</html>