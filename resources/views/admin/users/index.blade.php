@extends('cms::admin.base.index')


@section('indextable-head')

  
        <tr>
            
            <th width="">Name</th>

            <th></th>

           
          
        </tr>

@endsection

@section('indextable-body')
  
    
    @foreach ($models as $item)
    
        <tr class="indexitem">

            <td class="title"><a href="{{ action([controller(), 'edit'], [$modelInject => $item->id]) }}">{{$item->name}}</a></td>

            <td class="title">{{ obscure($item->email) }}</td>

            <td>
                {!! $item->getRoleNames() !!}
            </td>

            <td>
                {!! $item->getPermissionNames() !!}
            </td>

            <td width="0"> 
                <div class="btn-group dropleft">
                    <A class="dropdown-toggle dropdown-toggle-dots" href="#" data-toggle="dropdown" ></A>
                    <div class="dropdown-menu dropdown-menu-right" style="">
                        <a class="dropdown-item text-sm btn-delete modal-link" href="{{ action([controller(), 'delete'], [$modelInject => $item->id]) }}">Delete</a> 
                    </div>
              </div>
            </td>

        </tr> 
     @endforeach

@endsection