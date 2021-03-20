<div class="modal fade text-left" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog @if($modalCenterVertical ?? false) modal-dialog-centered @endif {{$modalSize ?? ''}}" role="document">
      <div class="modal-content">

        @if($modalShowHeader ?? false)
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@yield('modalTitle')</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @endif

        <div class="modal-body {{ ($modalBodyPadded ?? true) ? 'modal-body-padded' : ''}}">
          
            @yield('modalContent')
           
        </div>

       
        @if( $modalShowFooter ?? false )
           <div class="modal-footer">
                
                @yield('modalButtons')

                @sectionMissing('modalButtons')
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                @endif
            
          </div>
        @endif
    

      </div>
    </div>
  </div>