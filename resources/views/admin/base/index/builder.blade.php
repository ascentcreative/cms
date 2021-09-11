@extends('cms::admin.base.index')

@section('indextable-head')

    {{-- for each column, render the header --}}
    @foreach($columns as $col) 

   
        <th class="@if($col->align) text-{{$col->align}} @endif " @if(!is_null($col->width)) width="{{ $col->width }}" @endif >
            
            @if($col->sortable)
                <A href="{{ $col->buildSortUrl() }}" class="sort-link sort-link-{{ $col->sorted }} ">
            @endif

                {{ $col->title }}

            @if($col->sortable)

                @switch($col->sorted)
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
            @endif

        </th>

    @endforeach

@endsection


@section('indextable-body')

@foreach ($models as $item)

    <tr>
     {{-- for each column, render the value cell --}}
     @foreach($columns as $col) 

        <td class="@if($col->align) text-{{$col->align}} @endif ">

            @if($col->isBlade) 
                @include($col->value, $col->bladeProps)
            @else

                @if($col->isLink) 
                    <a href="{{ action([controller(), 'edit'], [$modelInject => $item->id]) }}">
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