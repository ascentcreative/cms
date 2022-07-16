@extends('cms::admin.screen')

@section('screentitle'){{ $viewTitle ?? $modelPlural }}@endsection


@section('headbar')

    @section('headfilters')
    {{-- <form class="form-inline" method="get" id="frm_filter"> --}}
    <div class="flex flex-align-center" style="white-space: nowrap">
        <div>
            <input type"text" name="search" class="form-control" placeholder="Search {{$modelPlural}}" value="{{ isset($_GET['search'])?$_GET['search']:'' }}"/>
        </div>
        @isset(request()->search)
            <div class="p-1">
                <a href="{{ action([controller(), 'index']) }}" class="bi-x-circle-fill"></a>
            </div>
        @endisset
    </div>

    @show
    {{-- </form> --}}

    <nav class="navbar">

        @section('headactions')

            <a href="{{ action([controller(), 'create']) }}" class="btn btn-primary bi-plus-circle-fill">Create</a>

        @show

    </nav>

@endsection


@section('screen-start')

    {{-- Form to submit filters / sorts etc --}}
    <form method="GET" action="{{ url()->current() }}" id="frm-indexparams">

@endsection

@section('with-selected')

    @hasSection('with-selected-actions')
        <div class="btn-group mb-2">
            <button type="button" id="with-selected" class="with-selected button btn-primary btn btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                With selected: 
            </button>
            <div class="dropdown-menu">

               @yield('with-selected-actions')

            </div>

        </div>
    @endif

@endsection


@section('screen')
{{-- 
<div class="cms-screenblock bg-white rounded shadow">
    <form class="form-inline" method="get">
        <input type"text" name="search" class="form-control" placeholder="Search {{$modelPlural}}" value="{{ isset($_GET['search'])?$_GET['search']:'' }}"/>
        <a href="{{ action([controller(), 'index']) }}" class="bi-x-circle-fill"></a>
    </form>
</div> --}}

<div class="cms-screenblock bg-white rounded shadow" style="">


    @if($models->count() > 0)
        @yield('with-selected')
    @endif
   
    {{-- @if($models->count() > 0) --}}
    <div class="cms-tablewrap">
        <table class="table table-hover">

            <thead>

            @yield('indextable-head')

            </thead>

            <tbody>

            @yield('indextable-body')

            </tbody>


        </table>
    </div>



    {{-- @else --}}
    @if($models->count() == 0)
    
        <H1 style="padding: 40px; text-align: center; color: #ccc">No {{$modelPlural}} Found</H1>
    
    @endif

    {{-- @endif --}}

    @if($models->count() > 0)
        @yield('with-selected')
    @endif
   
    
    @section('paginator')

        @if($models instanceof \Illuminate\Pagination\LengthAwarePaginator && $models->lastPage() > 1 )
            <div>{{ $models->links( 'cms::admin.pagination.bootstrap-4' ) }} </div>
        @endif

    @show
        
        

    </div>
    
@endsection


@section('screen-end')

    {{-- Close the form. --}}
    </form>

@endsection