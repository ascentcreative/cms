@extends('cms::admin.screen')

@section('screen-start')
        
    {{-- OPEN FORM TAG --}}
    {{-- @if ($model->id)
        <form action="{{ action([controller(), 'update'], [$modelInject => $model->id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
         @method('PUT')
    @else
        <form action="{{ action([controller(), 'store']) }}" method="POST" enctype="application/x-www-form-urlencoded">
    @endif --}}

    {{-- @csrf --}}

@endsection


@section('screen-end')

        {{-- <input type="hidden" name="_postsave" value="{{ old('_postsave', url()->previous()) }}" /> --}}

    {{-- ClOSE FORM TAG --}}
    {{-- </form> --}}
    
@endsection


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


@section('screen')

    @yield('showlayout')

    @if(method_exists($model, 'getTraitBlades')) 
        @foreach($model->getTraitBlades() as $blade)
            <div class="cms-screenblock bg-white rounded shadow" style="">
                @includefirst($blade)
            </div>
        @endforeach
    @endif

@endsection
