@extends('cms::admin.screen')


@section('screentitle')

    View {{$modelName}}

@endsection



@section('headbar')

    <nav class="navbar">

        @section('headactions')

            @can('update', $model)
                <A href="{{ action([controller(), 'edit'], [$modelInject => $model->id]) }}" type="button" class="btn btn-primary bi-pencil-square" onclick="" class="button">Edit {{$modelName}}</A>    
            @endcan

            <A href="{{ session('last_index') }}" type="button" class="btn btn-primary bi-x-circle-fill" onclick="" class="button">Close</A>    
        @show

    </nav>

@endsection


@section('screen-start')
        
   {{-- Nothing to show --}}

@endsection



@section('screen')
    
    @formbody($form->readonly(true))

@endsection




@section('screen-end')

    {{-- Nothing to show --}}

@endsection

