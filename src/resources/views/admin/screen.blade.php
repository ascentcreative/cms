@extends('cms::admin.layout')


@section('main')

        <div class="cms-screen">

            @yield('screen-start')

                <h1>@yield('screentitle')</h1>

                <div class="cms-headbar " style="">{{--background: white; border-radius: 10px; box-shadow: 0, 0.125em, 2em, rgba(0,0,0,0.8); padding: 2rem; margin-bottom: 1em">--}}
                    @yield('headbar')
                </div>

                
                @yield('screen')
                

            @yield('screen-end')

        </div>

@endsection