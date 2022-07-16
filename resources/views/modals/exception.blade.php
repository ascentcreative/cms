<x-cms-modal modalid="ajaxModal" :centered="true" size="modal-sm">

    <x-slot name="title"><i class="bi-exclamation-triangle-fill text-danger"></i> Error</x-slot>

    {{ $exception->getMessage(); }}

    <x-slot name="footer">
        <button class="button btn btn-primary" data-dismiss="modal">OK</button>
    </x-slot>

</x-cms-modal>