@extends('cms::admin.screen')

{{-- FORM DIRTY CHECKS: --}}
@push('scripts')
    @script('/vendor/ascent/cms/jquery/areyousure/jquery.are-you-sure.js')
    @script('/vendor/ascent/cms/jquery/areyousure/ays-beforeunload-shim.js')

    <script language="javascript">
        $(document).ready(function() {
            $('#frm_edit').areYouSure();            
        });

        $(document).on('change', function() {
            $('#frm_edit').addClass('dirty'); // belt and braces...
        });
    </script>

    {{-- ensure first tab shows... (Might need to change this to show buried validation fails --}}
    <script>

        $(document).ready(function() {
            $('#myTab li:first-child a').tab('show');
        });

    </script>

@endpush


@section('screen-start')
        
    {{-- OPEN FORM TAG --}}
    @if (isset($model->id) && $model->id)
        <form action="{{ action([controller(), 'update'], [$modelInject => $model->id]) }}" id="frm_edit" method="POST" enctype="application/x-www-form-urlencoded" autocomplete="off">
         @method('PUT')
    @else
        <form action="{{ action([controller(), 'store']) }}" method="POST" id="frm_edit" enctype="application/x-www-form-urlencoded" autocomplete="off">
    @endif

    @csrf
    {{-- Prevent enter submitting the form --}}
    <input type="submit" disabled style="display: none"/> 

@endsection


@section('screen-end')

        <input type="hidden" name="_postsave" value="{{ old('_postsave', session('last_index')) }}" />

    {{-- ClOSE FORM TAG --}}
    </form>
    
@endsection


@section('screentitle')
   
    @if (isset($model->id) && $model->id)
        Edit {{$modelName}}
    @else
        Create {{$modelName}}
    @endif

@endsection



@section('headbar')

    <nav class="navbar">

        @section('headactions')
            <BUTTON type="submit" class="btn btn-primary bi-check-circle-fill" class="button">Save {{$modelName}}</BUTTON>
            <A href="{{ session('last_index') }}" class="btn btn-primary bi-x-circle-fill">{{-- Close {{$modelName}} --}} Exit Without Saving</A>
        @show 
        
    </nav>

@endsection


@section('screen')

    @yield('editform')

    @if(method_exists($model, 'getTraitBlades')) 
        @foreach($model->getTraitBlades() as $blade)
            <div class="cms-screenblock bg-white rounded shadow" style="">
                @includefirst($blade)
            </div>
        @endforeach
    @endif

@endsection
