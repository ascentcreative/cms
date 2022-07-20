@extends('cms::admin.base.edit')



@section('screen-start')
        
    {{-- OPEN FORM TAG --}}
    {{-- @if (isset($model->id) && $model->id)
        <form action="{{ action([controller(), 'update'], [$modelInject => $model->id]) }}" id="frm_edit" method="POST" enctype="application/x-www-form-urlencoded" autocomplete="off">
         @method('PUT')
    @else
        <form action="{{ action([controller(), 'store']) }}" method="POST" id="frm_edit" enctype="application/x-www-form-urlencoded" autocomplete="off">
    @endif --}}

    {{-- @csrf --}}
    {{-- Prevent enter submitting the form --}}
    {{-- <input type="submit" disabled style="display: none"/>  --}}
 {{-- @dd($form) --}}
    @formstart($form)

@endsection



@section('screen')
{{-- 
    @yield('editform')

    @if(method_exists($model, 'getTraitBlades')) 
        @foreach($model->getTraitBlades() as $blade)
            <div class="cms-screenblock bg-white rounded shadow" style="">
                @includefirst($blade)
            </div>
        @endforeach
    @endif --}}
    {{-- @dd($form) --}}
    
    @formbody($form)

@endsection




@section('screen-end')

    {{-- @dd($form) --}}
    @formend($form)

        {{-- <input type="hidden" name="_postsave" value="{{ old('_postsave', session('last_index')) }}" /> --}}

    {{-- ClOSE FORM TAG --}}
    {{-- </form> --}}
    
@endsection

