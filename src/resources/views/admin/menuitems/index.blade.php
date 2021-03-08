@extends('cms::admin.base.index')


@section('indextable-head')

  
        <tr>
            
           {{--}} <th colspan="2">Actions</th>--}}

            <th width="">Menu Name</th>

          
        </tr>

@endsection

@section('indextable-body')
  
    
    @foreach ($models as $item)
    
        <tr class="indexitem">

            <td class="title"><a href="{{ action([controller(), 'edit'], [$modelInject => $item->id]) }}">{{$item->itemtitle}}</a></td>

            <td>{{ $item->depth }}</td>

            <td>

                
              
            </td>

        </tr> 
     @endforeach

@endsection

