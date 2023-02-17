<div class="toast toast-primary {{ $class }}" id="{{ $id}}" role="alert" aria-live="assertive" aria-atomic="true" >
    <div class="toast-header">
      <img src="..." class="rounded mr-2" alt="...">
      <strong class="mr-auto">Bootstrap</strong>
      <small class="text-muted">11 mins ago</small>
      <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="toast-body">
      {{-- {{ $slot }} --}}
      <i class="bi-check-circle-fill text-success pr-1"> </i>Email Addresses copied to clipboard
      {{-- <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button> --}}
    </div>
  </div>