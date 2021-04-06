@extends(config('cms.wrapper_blade')) 


{{--@section(config('cms.wrapper_blade_section'))--}}

  {{--}}  <div class="centered">--}}
        
        @section('contenthead')
        <H1>{{ $model->title }}</H1>
       @endsection

       @section('contentmain')

          {{-- @renderStack( $model->content) --}}
          @include('cms::stack.render', ['content' => $model->content])
       
       @endsection

        {{--}}
        {{ $model->headerimage }}--}}

    </div>
    
{{--@endsection--}}
