@extends('cms::modal') 

@php
    $modalShowHeader = true;
    $modalShowFooter = true;
    $modalSize = 'modal-lg';
@endphp

{{--@section(config('cms.wrapper_blade_section'))--}}

  {{--}}  <div class="centered">--}}
        
        @section('modalTitle')
            <H1>{{ $model->title }}</H1>
       @endsection

       @section('modalContent')
            <div style="max-height: 50vh; overflow-y: scroll">
                {!! $model->content !!}
            </div>
        @endsection

        {{--}}
        {{ $model->headerimage }}--}}

    </div>
    
{{--@endsection--}}
