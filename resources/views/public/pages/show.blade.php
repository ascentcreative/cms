@extends(config('cms.page_wrapper_blade')) 


{{--@section(config('cms.wrapper_blade_section'))--}}

  {{--}}  <div class="centered">--}}
        
    @section('pagehead')
        <H1>{{ $model->title }}</H1>
    @endsection

    @section('pagecontent')

        @switch(config('cms.content_editor'))

            @case('ckeditor')
                {!! $model->content !!}
            @break

            @case('stack')
                    @include('cms::stack.render', ['content' => $model->content])
            @break

            @case('stackeditor')
                @include('stackeditor::render', ['content' => $model->content])
            @break

            @case('pagebuilder')
                @include('pagebuilder::render', ['content' => $model->content])
            @break

        @endswitch
       
    @endsection



        {{--}}
        {{ $model->headerimage }}--}}

    {{-- </div>
     --}}
{{--@endsection--}}
