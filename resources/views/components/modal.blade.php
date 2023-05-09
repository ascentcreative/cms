<div class="modal text-left {{ $fade }} {{ $modalclass }}" id="{{ $modalid }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable @if($centered) modal-dialog-centered @endif  {{$size ?? 'modal-lg'}}" role="document">

        {{ $formstart ?? '' }}
        
        <div class="modal-content">

        @if($modalShowHeader ?? true)
          <div class="modal-header">
            @if($title)
            <h5 class="modal-title" id="exampleModalLabel">
                {{ $title }}
            </h5>
            @endif

            @if($closebutton)
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            @endif


          </div>
        @endif

        <div class="modal-body">

            {{ $slot }}

        </div>

       
        @if( $modalShowFooter ?? true )
           <div class="modal-footer">
{{--                 
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> No </button>

            <button type="submit" class="btn btn-danger"> Yes </button>
         --}}
        
                {{ $footer ?? '' }}

          </div>
        @endif
    

      </div>

      {{ $formend ?? '' }}

    </div>
  </div>
