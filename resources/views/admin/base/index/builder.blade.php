@extends('cms::admin.base.index')

@section('indextable-head')

    {{-- for each column, render the header --}}
    @foreach($columns as $col) 

   
        <th class="@if($col->align) text-{{$col->align}} @endif @if($col->filterable) filterable @endif" @if(!is_null($col->width)) width="{{ $col->width }}" @endif >
            
            <div class="flex" style="flex-wrap: nowrap;">

            @if($col->sortable)
               
            @endif

            @if($col->titleBlade)
                @include($col->titleBlade)
            @else   
                <div style="flex-grow: 1">{{ $col->title }}</div>
            @endif

            @if($col->sortable)

                <A href="{{ $col->buildSortUrl() }}" class="sort-link sort-link-{{ $col->getSortDirection() }} ml-1"">

                @switch($col->getSortDirection())
                    @case('asc')
                        <i class="bi-caret-up-fill"></i>
                        @break

                    @case('desc')
                        <i class="bi-caret-down-fill"></i>
                        @break

                    @default
                        <i class="bi-chevron-expand"></i>
                        @break
                @endswitch
             
            
                </A>

                @isset(request()->sort[$col->slug])
                    {{-- Hidden field to store the sort value so it persists on filter change --}}
                    <input type="hidden" name="sort[{{ $col->slug }}]" value="{{ request()->sort[$col->slug] }}" />
                @endisset

            @endif

            @if($col->filterable)
                {{-- <div class="filter-block">
                    
                    <div class="filter-ui">
                        OPTIONS GO HERE...
                    </div>
                </div> --}}

                <div class="filter xdropdown xdropdown-no-caret ml-1" style="display: inline-block">
                    {{-- <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      Dropdown button
                    </button> --}}
                    <A href="" class="filter-toggle xdropdown" data-toggle="filter-options" aria-haspopup="true" aria-expanded="false" xclass="badge badge-secondary"><i class="@isset(request()->cfilter[$col->slug]) bi-funnel-fill @else bi-funnel @endisset"></i></A>
                    <div class="filter-panel xdropdown-menu xdropdown-menu-right" aria-labelledby="xdropdownMenuButton">
                      
                        <div class="filter-options font-weight-normal">

                            {{-- <form method="POST" action="{{ $col->buildFilterUrl() }}" class="filter-form" name="cfilter-form-{{ $col->slug }}" id="">  --}}
                                {{-- {{ csrf_field() }}  --}} 
                                @include($col->filterBlade, $col->getFilterBladeParameters())
                              
                                <div class="flex flex-between flex-nowrap mt-2">
                                    <small><a href=" {{ $col->buildClearFilterUrl() }}" class="mr-2">Clear</a></small>
                                    <button class="btn btn-sm btn-primary ml-2">Update</button>
                                </div>

                            {{-- </form> --}}

                        </div>

                    </div>
                  </div>

            @endif

            </div>


        </th>

    @endforeach

@endsection


@section('indextable-body')

@foreach ($models as $item)

    {{-- ability to compute a class (or classes?) for the row --}}
    @php
        $classes = [];
        foreach($rowClassResolvers as $fn) {
            $classes[] = $fn($item);
        }
    @endphp
    <tr class="item-row {{ join(' ', $classes); }}">
     {{-- for each column, render the value cell --}}
     @foreach($columns as $col) 

        <td class="@if($col->align) text-{{$col->align}} @endif @if($col->noWrap) text-nowrap @endif">

            @if($col->isBlade) 
                @include($col->value, $col->bladeProps)
            @else

                @if($col->isLink) 
                    @if($col->linkAction instanceof Closure) 
                        @php 
                            $la_closure = $col->linkAction; 
                            $linkAction = $la_closure($item);
                        @endphp
                    @else
                        @php $linkAction = $col->linkAction; @endphp
                    @endif
                    @if($col->linkParam) 
                        @php
                            $param = $col->linkParam;
                        @endphp
                    @else
                        @php
                            $param = $modelInject;
                        @endphp
                    @endif
                        
                    <a href="{{ action([controller(), $linkAction], [$param => $item->id]) }}">
                @endif
            
                @if($col->value instanceof Closure) 
                    @php $closure = $col->value; @endphp
                    {{ $closure($item) }}
                @else 
                    {{ $col->value }}
                @endif
                
                @if($col->isLink)
                    </a>
                @endif

            @endif
        </td>

    @endforeach

    </tr>

@endforeach

@endsection


@section('paginator')

        {{-- <div class="cms-screen-paginator">
                
                <A href="{{ $models->previousPageUrl() }}"> Prev </A> | <A href="{{ $models->nextPageUrl() }}"> Next </A>

            </div> --}}

            <div class="flex flex-between flex-align-center mt-3 border-top pt-3">

                <div><small>Showing {{ $models->firstItem() }}-{{ $models->lastItem() }} of {{ $models->total() }} {{ $modelPlural }}</small></div>
    
                @if($models instanceof \Illuminate\Pagination\LengthAwarePaginator && $models->lastPage() > 1 )
                <div class="small">{{ $models->links( 'cms::admin.pagination.bootstrap-4' ) }} </div>
                @endif
    
    
                <div class="flex flex-center">
                    
                    <div class="small">Show&nbsp;</div>
                    <div class="small">
                        <select class="form-control form-control-sm" name="pageSize" id="pageSize">
                            <option value="15" @if(request()->pageSize == 15) selected @endif>15</option>
                            <option value="25" @if(request()->pageSize == 25) selected @endif>25</option>
                            <option value="50" @if(request()->pageSize == 50) selected @endif>50</option>
                            <option value="100" @if(request()->pageSize == 100) selected @endif>100</option>
                            <option value="500" @if(request()->pageSize == 500) selected @endif>500</option>
                            <option value="1000" @if(request()->pageSize == 1000) selected @endif>1000</option>
                            {{-- <option value="all">All</option> --}}
                        </select>
                    </div>
                    <div class="small">&nbsp; Rows</div>
                </div>
    
            </div>
    
            @if(env('LOG_QUERIES'))
            <div>
                Index Load Start = {{ session('index_load_start') }}
                Index Load End = {{ $end = microtime(true )}}
                Duration = {{ $end - session('index_load_start')}}
            </div>
            @endif 
            
@endsection



@push('scripts')

<script>

    function selectRow(row) {
        console.log(row);
        row.addClass('item-row-selected');
        row.find('.item-select').prop('checked', true);
    }

    function deselectRow(row) {
        row.removeClass('item-row-selected');
        row.find('.item-select').prop('checked', false);
    }

    $(document).on('click', '.item-row td', function(e) {
        // console.log(e.target);
        // toggle select of row:
        let row = $(e.target).parents('.item-row');
        let cb = $(e.target).parents('.item-row').find('.item-select');
        if($(cb).is(':checked')) {
            console.log('unchecking');
            deselectRow(row);
        } else {
            console.log('checking');
            selectRow(row);
        }
    });

    $(document).on('click', '.item-row td a, .item-row .item-select', function(e) {
        e.stopPropagation();
    });

    $(document).on('change', '.item-row .item-select', function(e) {
        let row = $(this).parents('.item-row');
        if($(this).is(':checked')) {
            selectRow(row);
        } else {
            deselectRow(row);
        }
    });


    //$('form#frm-indexparams .filter, #pageSize').on('change', function(e) {
    $('#pageSize').on('change', function(e) {
        //console.log(e.target);
        $('form#frm-indexparams').submit();
    });

    $('.filter-panel').on('click', function(e) {
        e.stopPropagation();
    });

    $('.filter').on('click', '.filter-toggle', function(e) {
        e.preventDefault();
      
        console.log(this);

        $(this).parents('.filter').find('.filter-panel').slideDown(100, function() {
           
            panel = this;

            $('body').on('click', function(e) {
                
              //  console.log(e.target);
                $(panel).slideUp(100, function() {
                    
                });

                $('body').unbind('click');
                 //, this);
            });

        });

        

       // e.stopPropagation();

    });

</script>

@endpush