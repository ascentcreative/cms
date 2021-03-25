@extends('cms::modal')

@php 

$modalShowHeader = true;
$modalShowFooter = true;

@endphp

@section('modalTitle', 'Not Possible')

@section('modalContent')

    <P>This application does not allow {{ $modelPlural }} to be deleted</P>

@endsection

@section('modalButtons')

    <button type="button" class="btn btn-secondary" data-dismiss="modal"> OK </button>

</form>
@endsection 