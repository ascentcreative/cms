@extends('cms::admin.screen')

{{-- @section('screentitle'){{ $viewTitle ?? $modelPlural }}@endsection

 --}}


@section('main')
<div class="cms-screen">

    <x-filter-view filterManager="{{ $fm }}">

        <div style="display: flex; justify-content: space-between; margin-bottom: 10px;">
            <h1>{{ $viewTitle ?? $modelPlural }} Approval Queue</h1>
        </div>

        <div class="cms-screenblock bg-white rounded shadow" style="">

            <x-filter-datatable />

            <div xclass="flex flex-between" style="display: grid; grid-template-columns: auto 1fr auto; align-items: center">
                
                <x-filter-counter class="small text-small" unit="record"/>

                <x-filter-paginator blade="bootstrap-4" class="flex flex-center small text-small"/>

                <x-filter-pagesize />
            
            </div>
        
        </div>

    </x-filter-view>

</div>

@endsection


@section('screen')

   


@endsection


