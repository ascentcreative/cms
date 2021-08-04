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
            @include('cms::admin.menus.menublock', ['item'=>$item])
     @endforeach


     @include('cms::admin.menus.menublock', ['item'=>null])

@endsection