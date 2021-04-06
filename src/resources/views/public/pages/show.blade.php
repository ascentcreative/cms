@extends(config('cms.wrapper_blade')) 


{{--@section(config('cms.wrapper_blade_section'))--}}

  {{--}}  <div class="centered">--}}
        
        @section('contenthead')
        <H1>{{ $model->title }}</H1>
       @endsection

       @section('contentmain')

          {{-- @renderStack( $model->content) --}}

            @switch(config('cms.content_editor') == 'ckeditor')

                @case('ckeditor')
                    {!! $model->content !!}
                @break

                @case('stack')
                     @include('cms::stack.render', ['content' => $model->content])
                @break

            @endswitch
          
       
       @endsection

        {{--}}
        {{ $model->headerimage }}--}}

    </div>
    
{{--@endsection--}}
