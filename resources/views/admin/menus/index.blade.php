@extends('cms::admin.base.index')

@section('screentitle') Site Structure @endsection


{{-- 
@section('screen')
    
    <div class="cms-screenblock bg-white rounded shadow">
        <div class="border p-2 rounded mb-2 ">
            <h4>Site Homepage</h4>
        </div>
    </div>

    @parent

@endsection --}}

{{-- 
@section('pre-indextable')

  

@endsection --}}

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