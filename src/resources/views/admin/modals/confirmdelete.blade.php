<div class="modal fade text-left" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog {{-- modal-dialog-centered --}} {{$modalSize ?? ''}}" role="document">


<form action="{{ action([controller(), 'destroy'], [$modelInject => $model->id]) }}" method="POST">
    @csrf
    @method('DELETE')


      <div class="modal-content">

        {{-- @if($modalShowHeader ?? false) --}}
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        {{-- @endif --}}

        <div class="modal-body">
          
          
    <P>Are you sure you want to delete the {{$modelName}} 
    
        @if($model->title)
            titled "<strong><em>{{ $model->title }}</em></strong>"
        @endif
    
        ?</P>
    
        <P>This action is final and cannot be undone</P>
           
        </div>

       
        {{-- @if( $modalShowFooter ?? false ) --}}
           <div class="modal-footer">
                
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> No </button>

            <button type="submit" class="btn btn-danger"> Yes </button>
        
            
          </div>
        {{-- @endif --}}
    

      </div>

</form>

    </div>
  </div>


{{-- 
@php 
$modalShowHeader = true;
$modalShowFooter = true;

@endphp

@section('modalTitle', 'Confirm Deletion')

@section('modalContent')

<form action="{{ action([controller(), 'destroy'], [$modelInject => $model->id]) }}" method="POST">
    @csrf
    @method('DELETE')

    <P>Are you sure you want to delete the {{$modelName}} 
    
    @if($model->title)
        titled "<strong><em>{{ $model->title }}</em></strong>"
    @endif

    ?</P>

    <P>This action is final and cannot be undone</P>

    
    </form> 

@endsection

@section('modalButtons')

    <button type="button" class="btn btn-secondary" data-dismiss="modal"> No </button>

    <button type="submit" class="btn btn-danger"> Yes </button>

</form>
@endsection --}}