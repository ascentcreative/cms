<div class="modal text-left" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered {{$modalSize ?? ''}}" role="document">





      <div class="modal-content">

        <form action="{{ action([controller(), 'destroy'], [$modelInject => $model->id]) }}" method="POST" class='no-ajax'>
            @csrf
            @method('DELETE')

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

    </form>
    

      </div>



    </div>
  </div>

