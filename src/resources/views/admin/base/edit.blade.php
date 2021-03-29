@extends('cms::admin.screen')

{{-- FORM DIRTY CHECKS: --}}
@push('scripts')
    @script('/vendor/ascent/cms/jquery/areyousure/jquery.are-you-sure.js')
    @script('/vendor/ascent/cms/jquery/areyousure/ays-beforeunload-shim.js')

    <script language="javascript">
        $(document).ready(function() {
            $('#frm_edit').areYouSure( {'message':'Your edits have not been saved!'} );
        });
        $(document).on('formDirty', function() {
            console.log('element data changed');
            $('#frm_edit').trigger('checkform.areYouSure');
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
    @if ($model->id)
        <form action="{{ action([controller(), 'update'], [$modelInject => $model->id]) }}" id="frm_edit" method="POST" enctype="application/x-www-form-urlencoded">
         @method('PUT')
    @else
        <form action="{{ action([controller(), 'store']) }}" method="POST" id="frm_edit" enctype="application/x-www-form-urlencoded">
    @endif

    @csrf

@endsection


@section('screen-end')

        <input type="hidden" name="_postsave" value="{{ old('_postsave', url()->previous()) }}" />

    {{-- ClOSE FORM TAG --}}
    </form>
    
@endsection


@section('screentitle')
   
    @if ($model->id)
        Edit {{$modelName}}
    @else
        Create {{$modelName}}
    @endif

@endsection



@section('headbar')

    <nav class="navbar">
        <BUTTON type="button" class="btn btn-primary btn-sm" onclick="$(this).parents('form')[0].submit()" class="button">Save {{$modelName}}</BUTTON>
        <A href="{{ url()->previous() }}" class="btn btn-primary btn-sm">Close {{$modelName}}</A>
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
