<div class="toast toast-primary {{ $class }}" id="{{ $id}}" role="alert" aria-live="assertive" aria-atomic="true" 
        @if($duration) data-delay="{{ $duration }}" @endif style="position: absolute"
    >
    @if($title)
    <div class="toast-header">
      <img src="..." class="rounded mr-2" alt="...">
      <strong class="mr-auto">{{ $title }}</strong>
      {{-- <small class="text-muted">11 mins ago</small> --}}
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    @endif
    <div class="toast-body">
      {{ $slot }}
    </div>
</div>