<div class="btn-group dropleft">
    <A class="dropdown-toggle dropdown-toggle-dots" href="#" data-toggle="dropdown" ></A>
    <div class="dropdown-menu dropdown-menu-right" style="">
        
        @section('action-menu-buttons')
            <a class="dropdown-item text-sm btn-delete modal-link" href="{{ action([controller(), 'delete'], [$modelInject => $item->id]) }}">Delete {{ $modelName }}</a> 
        @show

    </div>
</div>