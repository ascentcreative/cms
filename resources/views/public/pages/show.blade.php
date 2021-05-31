@extends(config('cms.page_wrapper_blade')) 


{{--@section(config('cms.wrapper_blade_section'))--}}

  {{--}}  <div class="centered">--}}
        
    @section('pagehead')
        <H1>{{ $model->title }}</H1>
    @endsection

    @section('pagecontent')

        <div class="contentgrid @if($model->panels->count() > 0) has-sidebar @endif">

            <div class="content">

                @switch(config('cms.content_editor'))

                    @case('ckeditor')
                        {!! $model->content !!}
                    @break

                    @case('stack')
                            @include('cms::stack.render', ['content' => $model->content])
                    @break

                @endswitch

            </div>

            {{-- Should we really be wrapping all the panels in a div? --}}
            {{-- Might need to break out on mobile --}}
            {{-- Should we have upper and lower sidebars which break before and after content? --}}
            {{-- Would also mean the content only needs to span 2 rows?  --}}

            {{-- How do we tell a panel where it should display? --}}
            {{-- Different arrays? Flag on DB record? --}}
            <div class="sidebar" id="sidebar-top" xstyle="background: #efefef;">

                @foreach($model->panels('top')->get() as $panel)
                    {{ $panel->render() }}
                @endforeach

            </div>

            <div class="sidebar" id="sidebar-bottom" sxtyle="background: #efefef;">

                @foreach($model->panels('bottom')->get() as $panel)
                   {{ $panel->render() }}
                @endforeach

            </div>

        </div>
       
    @endsection



        {{--}}
        {{ $model->headerimage }}--}}

    {{-- </div>
     --}}
{{--@endsection--}}
