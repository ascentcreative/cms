@extends(config('cms.wrapper_blade')) 


{{--@section(config('cms.wrapper_blade_section'))--}}

  {{--}}  <div class="centered">--}}
        
        @section('contenthead')
        <H1>{{ $model->title }}</H1>
       @endsection

       @section('contentmain')
        {!! $model->content !!}
        @endsection

        {{--}}
        {{ $model->headerimage }}--}}

    </div>
    
{{--@endsection--}}
