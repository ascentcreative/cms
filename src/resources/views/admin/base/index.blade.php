@extends('cms::admin.screen')

@section('screentitle'){{ $modelPlural }}@endsection


@section('headbar')

    <nav class="navbar">

        <a href="{{ action([controller(), 'create']) }}" class="btn btn-primary btn-sm">Create</a>

        <form class="form-inline" method="get">
            
            <input type"text" name="search" class="form-control" value="{{ isset($_GET['search'])?$_GET['search']:'' }}"/>
            <button>

        </form>

    </nav>

@endsection



@section('screen')

<div class="cms-screenblock bg-white rounded shadow" style="">

    @if($models->count() > 0)
        
    <table class="table table-hover">

        <thead>

        @yield('indextable-head')

        </thead>

        <tbody>

           @yield('indextable-body')

        </tbody>


    </table>

    @if($models instanceof \Illuminate\Pagination\LengthAwarePaginator && $models->lastPage() > 1 )
        
        <div class="cms-screen-paginator">
            
            <A href="{{ $models->previousPageUrl() }}"> Prev </A> | <A href="{{ $models->nextPageUrl() }}"> Next </A>

        </div>

    @endif

    @else

    <H1 style="padding: 40px; text-align: center; color: #ccc">No {{$modelPlural}} Found</H1>
    
    @endif

    </div>
    
@endsection