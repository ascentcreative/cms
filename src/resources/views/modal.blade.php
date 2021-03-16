

<div class="modal fade text-left" id="ajaxModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">@yield('modalTitle')</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

            @yield('modalContent')
           
        </div>
        <div class="modal-footer">
            
            @yield('modalButtons')

            @sectionMissing('modalButtons')
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            @endif
         
        </div>
      </div>
    </div>
  </div>