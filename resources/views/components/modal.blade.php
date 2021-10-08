<div class="modal text-left" id="{{ $modalid }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog @if($centered) modal-dialog-centered @endif modal-lg {{$modalSize ?? ''}}" role="document">

        <div class="modal-content">

        {{-- @if($modalShowHeader ?? false) --}}
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">
                {{ $title }}
            </h5>

            @if($closebutton)
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            @endif


          </div>
        {{-- @endif --}}

        <div class="modal-body">

            {{ $slot }}

        </div>

       
        {{-- @if( $modalShowFooter ?? false ) --}}
           <div class="modal-footer">
{{--                 
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> No </button>

            <button type="submit" class="btn btn-danger"> Yes </button>
         --}}
        
                {{ $footer }}

          </div>
        {{-- @endif --}}
    

      </div>

    

    </div>
  </div>
