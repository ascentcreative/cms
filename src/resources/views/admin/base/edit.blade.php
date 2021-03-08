@extends('cms::admin.screen')


@section('screen-start')
        
    {{-- OPEN FORM TAG --}}
    @if ($model->id)
        <form action="{{ action([controller(), 'update'], [$modelInject => $model->id]) }}" method="POST" enctype="application/x-www-form-urlencoded">
         @method('PUT')
    @else
        <form action="{{ action([controller(), 'store']) }}" method="POST" enctype="application/x-www-form-urlencoded">
    @endif

    @csrf

@endsection


@section('screen-end')

        <input type="hidden" name="_postsave" value="{{ old('_postsave', url()->previous()) }}" />

    {{-- ClOSE FORM TAG --}}
    </form>
    
@endsection


@section('screentitle')
   
    @if ($model->id)
        Edit {{$modelName}}
    @else
        Create {{$modelName}}
    @endif

@endsection



@section('headbar')

    <nav class="navbar">
    <BUTTON type="button" class="btn btn-primary btn-sm" onclick="$(this).parents('form')[0].submit()" class="button">Submit</BUTTON>
    </nav>

@endsection


@section('screen')

    @yield('editform')

    @if(method_exists($model, 'getTraitBlades')) 
        @foreach($model->getTraitBlades() as $blade)
            <div class="cms-screenblock bg-white rounded shadow" style="">
                @include($blade)
            </div>
        @endforeach
    @endif

@endsection
