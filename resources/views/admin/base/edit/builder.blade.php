@extends('cms::admin.screen')

@section('screentitle')
   
    @if (isset($model->id) && $model->id)
        Edit {{$modelName}}
    @else
        Create {{$modelName}}
    @endif

@endsection



@section('headbar')

    <nav class="navbar">

        @section('headactions')
            <BUTTON type="submit" class="btn btn-primary bi-check-circle-fill" class="button">Save {{$modelName}}</BUTTON>
            <A href="{{ getReturnUrl() }}" class="btn btn-primary bi-x-circle-fill">{{-- Close {{$modelName}} --}} Exit Without Saving</A>
        @show 
    
    </nav>

@endsection



@section('screen-start')
        
    @formstart($form)

@endsection



@section('screen')

    @if($errors->any())
    <div class="alert alert-danger">
        Please correct the following issues:
        <ul class="m-0">
        {!! implode('', $errors->all('<li>:message</li>')) !!}
        </ul>
    </div>
    @endif

    @formbody($form)

@endsection




@section('screen-end')

    @formend($form)

@endsection

