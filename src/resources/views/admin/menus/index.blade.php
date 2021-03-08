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

            <td class="title"><a href="{{ action([controller(), 'edit'], [$modelInject => $item->id]) }}">{{$item->title}}</a></td>

          

        </tr> 
     @endforeach

@endsection