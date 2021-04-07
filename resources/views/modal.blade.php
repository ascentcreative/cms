<div class="modal fade text-left" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    @stack('styles')

    <div class="modal-dialog @if($modalCenterVertical ?? true) modal-dialog-centered @endif {{$modalSize ?? ''}}" role="document">
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
          
            @if(!($modalShowHeader ?? false))
                <A class="bi-x" style="position: absolute; top: 10px; right: 10px; font-size: 30px; color: #777; cursor: pointer;" data-dismiss="modal"></a>
            @endif


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

    @stack('scripts')

  </div>