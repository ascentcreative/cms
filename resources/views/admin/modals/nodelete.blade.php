@extends('cms::modal')

@php 

$modalShowHeader = true;
$modalShowFooter = true;

@endphp

@section('modalTitle', 'Not Possible')

@section('modalContent')

    @if($exception ?? null) 
        <P>Unable to delete the {{ $modelName}}.</P>
        <P><strong>{{ $exception->getMessage() }}</strong></P>
    @else
        <P>This application does not allow {{ $modelPlural }} to be deleted</P>
    @endif

@endsection

@section('modalButtons')

    <button type="button" class="btn btn-secondary" data-dismiss="modal"> OK </button>

</form>
@endsection 