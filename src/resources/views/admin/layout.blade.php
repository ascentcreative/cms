@extends('cms::admin.base')

@push('styles')
    @style('/css/admin.css')
@endpush

@section('pagebody')
<?php /* 
    <nav class="navbar navbar-light bg-light p5">

        <a class="nav-brand" href="/admin">
            <IMG src="/img/ecs-logo.png" height="50" width="auto"/>
        </a>
    
        <button type="button" class="btn btn-primary btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </button>

          
    </nav>
*/ ?>

  
    <div class="cms-wrap">
        <div class="col cms-sidebar" id="sidebar">
            
            <div class="cms-sidebar-top">
                <a class="nav-brand" href="/admin">
                    @includeFirst(['admin.sidebar.header', 'cms::admin.sidebar.header'])
                </a>
            </div>
        
            <div class="cms-sidebar-content">

                <?php 
                /* 
                
                Hardcoded menu for now
                Planned update to use Events to allow packages to dynamically insert menu items
                
                */ ?>
               @includeFirst(['admin.sidebar.menu', 'cms::admin.sidebar.menu'])

                
                @stack('cmsmenu')


            </div>

            <div class="cms-sidebar-footer">
                <div style="text-align: center">
                    <button type="button" class="btn btn-primary btn-sm" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </button>
                </div>

                @includeFirst(['admin.sidebar.footer', 'cms::admin.sidebar.footer'])

                <div style="margin-top: 20px; color: #777; font-size: 10px; text-align: center;">Powered by Ascent CMS 3.0</div>

            </div>

        </div>

        <div class="col-auto cms-screenwrap" style="padding: 20px">

            @yield('main')

        </div>

    </div>

    
    <form id="logout-form" action="{{ route('logout') }}" method="POST">
        @csrf
    </form>
    
  @endsection