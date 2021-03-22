@extends('cms::admin.base.index')


@section('indextable-head')

  
        <tr>
            
           {{--}} <th colspan="2">Actions</th>--}}

            <th width="200">Menu Name</th>

            <th width="">Menu Items</th>

          
        </tr>

@endsection

@section('indextable-body')
  
    
    @foreach ($models as $item)
    
        <tr class="indexitem">

            <td class="title" style="vertical-align: top" valign="top">
                <div class="pt-1"><a href="{{ action([controller(), 'edit'], [$modelInject => $item->id]) }}">{{$item->title}}</a></div>
                <div class="pt-1"><a class="btn btn-secondary btn-sm" href="{{ action([AscentCreative\CMS\Controllers\Admin\MenuItemController::class, 'create'], ['menu_id' => $item->id]) }}">Add Item</a></div>
            </td>

            <td valign="top">

                @php
                
                    $tree = \AscentCreative\CMS\Models\MenuItem::scoped(['menu_id'=>$item->id])->withDepth()->defaultOrder()->get();

                @endphp

                <table class="menuitems">
                @foreach($tree as $mi)
                    <tr>
                        <td style="padding: 5px {{10 + (20 * $mi->depth)}}px">
                            <A href="{{ action([AscentCreative\CMS\Controllers\Admin\MenuItemController::class, 'edit'], ['menuitem' => $mi->id]) }}">{{ $mi->title }}</A>
                        </td>
                        <td> @if($mi->linkable) {{ $mi->linkable->url }} @else {{ $mi->url }} @endif</td>
                        <td><A class="modal-link" href="{{ action([AscentCreative\CMS\Controllers\Admin\MenuItemController::class, 'delete'], ['menuitem' => $mi->id]) }}">[x]</A></td>
                    </tr>
                @endforeach
                </table>

            </td>

        </tr> 
     @endforeach

@endsection